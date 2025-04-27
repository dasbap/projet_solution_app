<?php
require_once '../config.php';
header('Content-Type: application/json');

// Démarrage simple de la session
session_start();

// Log du début du traitement
logMessage('Début traitement leaderboard', [
    'session_id' => session_id(),
    'client_ip' => $_SERVER['REMOTE_ADDR']
], 'detail');

try {
    // Requête sécurisée pour les utilisateurs avec le nom de l'entreprise
    $sql_users = "
    SELECT u.user_name, MAX(sc.score) AS score, c.name_company AS company
    FROM table_score_carbon sc
    INNER JOIN table_user u ON u.id_user = sc.id_user
    INNER JOIN table_company c ON c.siret_company = u.siret_company
    WHERE u.user_name IS NOT NULL
    GROUP BY u.user_name, c.name_company
    HAVING MAX(sc.score) > 0
    ORDER BY score DESC
    LIMIT 100;
    ";


    logMessage('Exécution requête utilisateurs', ['query' => preg_replace('/\s+/', ' ', trim($sql_users))], 'detail');

    $stmt = $pdo->prepare($sql_users);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Requête sécurisée pour les entreprises
    $sql_companies = "
        SELECT 
            c.name_company,
            AVG(sc.score) AS average_score
        FROM table_score_carbon sc
        INNER JOIN table_user u ON u.id_user = sc.id_user
        INNER JOIN table_company c ON c.siret_company = u.siret_company
        GROUP BY c.siret_company, c.name_company
        HAVING AVG(sc.score) > 0
        ORDER BY average_score DESC
        LIMIT 100;
    ";


    logMessage('Exécution requête entreprises', ['query' => preg_replace('/\s+/', ' ', trim($sql_companies))], 'detail');

    $stmt_companies = $pdo->prepare($sql_companies);
    $stmt_companies->execute();
    $companies = $stmt_companies->fetchAll(PDO::FETCH_ASSOC);

    // Formatage des résultats
    $response = [
        'users' => $users,
        'companies' => $companies
    ];

    logMessage('Préparation réponse', [
        'users_count' => count($users),
        'companies_count' => count($companies)
    ], 'application');

    echo json_encode($response);

} catch (PDOException $e) {
    $errorInfo = [
        'message' => $e->getMessage(),
        'code' => $e->getCode()
    ];
    
    logMessage('ERREUR PDO', $errorInfo, 'error');
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de traitement']);
} finally {
    logMessage('Fin traitement leaderboard', [
        'duration' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 3) . 's'
    ], 'detail');
}
?>