<?php
header('Content-Type: application/json');
require_once '../config.php';
session_start();

// Log de début de traitement
logMessage('Début traitement statistiques entreprise', [
    'session_id' => session_id(),
    'client_ip' => $_SERVER['REMOTE_ADDR']
], 'detail');

// Vérification authentification
if (!isset($_SESSION['user_id'])) {
    logMessage('Accès refusé - utilisateur non authentifié', [], 'application');
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non authentifié']);
    exit;
}

$userId = $_SESSION['user_id'];
logMessage('Utilisateur authentifié', ['user_id' => $userId], 'application');

try {
    // Récupération SIRET entreprise
    logMessage('Récupération SIRET entreprise', ['user_id' => $userId], 'detail');
    $stmt = $pdo->prepare("SELECT siret_company FROM table_user WHERE id_user = :userId");
    $stmt->execute(['userId' => $userId]);
    $siretCompany = $stmt->fetchColumn();

    if (!$siretCompany) {
        logMessage('Aucun SIRET trouvé pour l\'utilisateur', ['user_id' => $userId], 'application');
        echo json_encode(['error' => 'Aucun SIRET trouvé']);
        exit;
    }

    logMessage('SIRET entreprise trouvé', ['siret_company' => substr($siretCompany, 0, 6).'...'], 'detail'); // Masquage partiel pour sécurité

    // Requête des réponses des employés
    $query = "
        SELECT r.id_user, r.id_question, r.score_question, q.question_text, r.date_reponse
        FROM Table_reponses r
        JOIN Table_questions q ON r.id_question = q.id_question
        WHERE r.id_user IN (
            SELECT id_user FROM table_user WHERE siret_company = :siretCompany
        ) AND r.date_reponse = (
            SELECT MAX(r2.date_reponse)
            FROM Table_reponses r2
            WHERE r2.id_user = r.id_user
        )
    ";
    
    logMessage('Exécution requête réponses employés', [
        'query' => preg_replace('/\s+/', ' ', trim($query)),
        'params' => ['siretCompany' => substr($siretCompany, 0, 6).'...']
    ], 'detail');

    $stmt = $pdo->prepare($query);
    $stmt->execute(['siretCompany' => $siretCompany]);
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($responses)) {
        logMessage('Aucune réponse trouvée pour l\'entreprise', [
            'siret_company' => substr($siretCompany, 0, 6).'...',
            'nb_employes' => 0
        ], 'application');
        echo json_encode(['message' => 'Aucune donnée disponible']);
        exit;
    }

    logMessage('Réponses trouvées', [
        'nb_reponses' => count($responses),
        'nb_employes_distincts' => count(array_unique(array_column($responses, 'id_user')))
    ], 'detail');

    // Calcul des statistiques
    $userTotalScores = [];
    $questionScores = [];
    $questionCount = [];

    foreach ($responses as $row) {
        $score = (float)$row['score_question'];
        
        if (!isset($userTotalScores[$row['id_user']])) {
            $userTotalScores[$row['id_user']] = 0;
        }
        $userTotalScores[$row['id_user']] += $score;
        
        if (!isset($questionScores[$row['id_question']])) {
            $questionScores[$row['id_question']] = 0;
            $questionCount[$row['id_question']] = 0;
        }
        $questionScores[$row['id_question']] += $score;
        $questionCount[$row['id_question']]++;
    }

    $companyAvgScore = !empty($userTotalScores) ? array_sum($userTotalScores) / count($userTotalScores) : 0;
    logMessage('Calcul score moyen entreprise', ['score_moyen' => $companyAvgScore], 'detail');

    $questionAvgScores = [];
    foreach ($questionScores as $questionId => $totalScore) {
        $questionAvgScores[$questionId] = $totalScore / $questionCount[$questionId];
    }

    // Préparation réponse finale
    $finalResponse = [
        'avg_total_score' => round($companyAvgScore, 2),
        'user_count' => count($userTotalScores),
        'questions' => []
    ];

    logMessage('Construction réponse finale', [
        'nb_questions' => count($questionAvgScores),
        'nb_employes' => count($userTotalScores)
    ], 'detail');

    foreach ($questionAvgScores as $questionId => $avgScore) {
        $stmt = $pdo->prepare("SELECT question_text FROM Table_questions WHERE id_question = :questionId");
        $stmt->execute(['questionId' => $questionId]);
        $question = $stmt->fetch(PDO::FETCH_ASSOC);

        $finalResponse['questions'][] = [
            'id_question' => $questionId,
            'question_text' => $question['question_text'] ?? 'Question inconnue',
            'average_score' => round($avgScore, 2)
        ];
    }

    // Envoi réponse
    logMessage('Envoi réponse statistiques entreprise', [
        'taille_reponse' => strlen(json_encode($finalResponse)),
        'http_status' => 200
    ], 'application');
    
    echo json_encode($finalResponse);

} catch (PDOException $e) {
    logMessage('ERREUR SQL statistiques entreprise', [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'fichier' => $e->getFile(),
        'ligne' => $e->getLine(),
        'trace' => substr($e->getTraceAsString(), 0, 300) // Limité pour sécurité
    ], 'error');

    logMessage('Envoi réponse erreur au client', [
        'status_code' => 500,
        'error_message' => 'Erreur de base de données'
    ], 'application');
    
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données']);
} finally {
    logMessage('Fin traitement statistiques entreprise', [
        'duree' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 3) . 's'
    ], 'detail');
}
?>