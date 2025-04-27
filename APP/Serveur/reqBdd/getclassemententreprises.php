<?php
require_once '../config.php';
session_start();

// Log du démarrage du traitement
logMessage('Début récupération leaderboard entreprises', [
    'session_id' => session_id(),
    'client_ip' => $_SERVER['REMOTE_ADDR']
], 'detail');

try {
    // Requête pour récupérer les scores des entreprises
    $sql = "
        SELECT 
            c.name_company,
            COALESCE(SUM(sc.score), 0) AS total_score
        FROM table_company c
        LEFT JOIN table_user u ON c.siret_company = u.siret_company
        LEFT JOIN table_score_carbone sc ON u.id_user = sc.id_user
        GROUP BY c.name_company
        ORDER BY total_score DESC
    ";

    // Log avant exécution
    logMessage('Exécution requête leaderboard entreprises', [
        'query' => preg_replace('/\s+/', ' ', trim($sql)) // Formatage pour le log
    ], 'detail');

    // Exécution de la requête
    $stmt = $pdo->query($sql);
    $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Log des résultats
    logMessage('Résultats requête entreprises', [
        'nb_entreprises' => count($companies),
        'top_3' => array_slice(array_column($companies, 'name_company'), 0, 3),
        'score_max' => $companies[0]['total_score'] ?? 0
    ], 'detail');

    // Log avant envoi réponse
    logMessage('Envoi réponse JSON entreprises', [
        'taille_reponse' => strlen(json_encode($companies))
    ], 'application');

    // Retour des données en JSON
    echo json_encode($companies);

} catch (PDOException $e) {
    // Log d'erreur complet
    logMessage('ERREUR PDO leaderboard entreprises', [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'fichier' => $e->getFile(),
        'ligne' => $e->getLine()
    ], 'error');

    // Log de la réponse d'erreur
    logMessage('Envoi réponse erreur au client', [
        'status_code' => 500,
        'erreur_client' => 'Erreur serveur'
    ], 'application');

    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
} finally {
    // Log de fin de traitement
    logMessage('Fin traitement leaderboard entreprises', [
        'duree' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 4) . 's'
    ], 'detail');
}
?>