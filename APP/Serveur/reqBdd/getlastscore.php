<?php
session_start();
require_once '../config.php';

// Log de début de traitement
logMessage('Début récupération score utilisateur', [
    'session_id' => session_id(),
    'client_ip' => $_SERVER['REMOTE_ADDR']
], 'detail');

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    logMessage('Tentative accès non autorisé - utilisateur non connecté', [], 'application');
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

$userId = $_SESSION['user_id'];
logMessage('Utilisateur authentifié', ['user_id' => $userId], 'application');

try {
    // Requête pour récupérer le dernier score à partir de table_score_carbone
    $sql = "
        SELECT score
        FROM table_score_carbone
        WHERE id_user = :user_id
        AND date_assigned = (
            SELECT MAX(date_assigned)
            FROM table_score_carbone
            WHERE id_user = :user_id
        )
        LIMIT 1
    ";

    // Log avant exécution
    logMessage('Exécution requête score utilisateur', [
        'query' => preg_replace('/\s+/', ' ', trim($sql)),
        'params' => ['user_id' => $userId]
    ], 'detail');

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Traitement du résultat
    if ($result && isset($result['score'])) {
        $score = (int)$result['score'];  // Utilisation du score récupéré
        logMessage('Score trouvé pour utilisateur', [
            'user_id' => $userId,
            'score' => $score
        ], 'application');
        
        echo json_encode(['score' => $score]);
    } else {
        logMessage('Aucun score trouvé - retour valeur par défaut', [
            'user_id' => $userId
        ], 'application');
        echo json_encode(['score' => 0]);  // Valeur par défaut en cas d'absence de score
    }

    // Log de confirmation
    logMessage('Score envoyé avec succès', [
        'user_id' => $userId,
        'http_status' => 200
    ], 'detail');

} catch (PDOException $e) {
    // Log d'erreur détaillé
    logMessage('ERREUR SQL récupération score', [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'fichier' => $e->getFile(),
        'ligne' => $e->getLine(),
        'trace' => substr($e->getTraceAsString(), 0, 200) 
    ], 'error');

    // Log pour l'application
    logMessage('Envoi réponse erreur au client', [
        'status_code' => 500,
        'user_id' => $userId,
        'error_message' => 'Erreur serveur'
    ], 'application');

    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
} finally {
    // Log de fin de traitement
    logMessage('Fin traitement score utilisateur', [
        'user_id' => $userId,
        'duree' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 3) . 's'
    ], 'detail');
}
?>
