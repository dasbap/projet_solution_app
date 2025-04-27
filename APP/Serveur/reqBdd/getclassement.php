<?php
require_once '../config.php';
session_start();

// Log du démarrage de la requête
logMessage('Début traitement leaderboard', ['session_id' => session_id()], 'detail');

try {
    $sql = "
        SELECT u.user_name, SUM(sc.score) AS score
        FROM table_score_carbon sc
        INNER JOIN table_user u ON u.id_user = sc.id_user
        GROUP BY u.user_name
        HAVING SUM(sc.score) > 0  -- Facultatif: Filtrer les utilisateurs sans score
        ORDER BY score DESC
    ";

    // Log avant exécution de la requête
    logMessage('Exécution requête leaderboard', ['query' => $sql], 'detail');

    // Exécution de la requête
    $stmt = $pdo->query($sql);
    $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Log des résultats
    logMessage('Résultats requête leaderboard', [
        'count_results' => count($scores),
        'first_3_users' => array_slice(array_column($scores, 'user_name'), 0, 3)
    ], 'detail');

    // Si aucune donnée n'est trouvée
    if (empty($scores)) {
        logMessage('Aucun résultat trouvé pour leaderboard', null, 'application');
        echo json_encode(['users' => [], 'companies' => []]);
    } else {
        // Log avant envoi des résultats
        logMessage('Envoi résultats leaderboard', [
            'total_users' => count($scores),
            'top_score' => $scores[0]['score'] ?? 0
        ], 'application');
        
        // Envoi des données
        echo json_encode(['users' => $scores, 'companies' => []]);
    }

} catch (PDOException $e) {
    // Log d'erreur détaillé
    logMessage('ERREUR PDO leaderboard', [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'trace' => $e->getTraceAsString()
    ], 'error');
    
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
    
    // Log supplémentaire pour le client
    logMessage('Réponse erreur envoyée au client', [
        'status_code' => 500,
        'error_message' => $e->getMessage()
    ], 'application');
}

// Log de fin de traitement
logMessage('Fin traitement leaderboard', [
    'duration' => microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']
], 'detail');
?>