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
        SELECT 
            u.user_name, 
            latest_scores.score,
            c.name_company AS company,
            latest_scores.date_assigned
        FROM table_user u
        INNER JOIN table_company c ON c.siret_company = u.siret_company
        INNER JOIN (
            SELECT 
                sc.id_user,
                sc.score,
                sc.date_assigned,
                ROW_NUMBER() OVER (
                    PARTITION BY sc.id_user 
                    ORDER BY sc.date_assigned DESC, sc.score DESC
                ) AS rn
            FROM table_score_carbone sc
        ) latest_scores ON latest_scores.id_user = u.id_user AND latest_scores.rn = 1
        WHERE u.user_name IS NOT NULL
        ORDER BY latest_scores.date_assigned DESC, latest_scores.score DESC
        LIMIT 100;
    ";


    logMessage('Exécution requête utilisateurs', ['query' => preg_replace('/\s+/', ' ', trim($sql_users))], 'detail');

    $stmt = $pdo->prepare($sql_users);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql_companies = "
        SELECT 
            c.name_company,
            AVG(latest_scores.score) AS average_score,
            MAX(latest_scores.date_assigned) AS latest_date,
            COUNT(DISTINCT latest_scores.id_user) AS user_count
        FROM table_company c
        JOIN table_user u ON c.siret_company = u.siret_company
        JOIN (
            SELECT 
                sc.id_user,
                sc.score,
                sc.date_assigned,
                ROW_NUMBER() OVER (PARTITION BY sc.id_user ORDER BY sc.date_assigned DESC, sc.score DESC) AS rn
            FROM table_score_carbone sc
        ) latest_scores ON latest_scores.id_user = u.id_user AND latest_scores.rn = 1
        GROUP BY c.siret_company, c.name_company
        ORDER BY latest_date DESC, average_score DESC
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