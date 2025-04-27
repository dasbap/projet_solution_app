<?php
header('Content-Type: application/json');
require_once '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non authentifié']);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT siret_company FROM table_user WHERE id_user = :userId");
    $stmt->execute(['userId' => $userId]);
    $siretCompany = $stmt->fetchColumn();

    if (!$siretCompany) {
        echo json_encode(['error' => 'Aucun SIRET trouvé']);
        exit;
    }

    $stmt = $pdo->prepare("
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
    ");
    $stmt->execute(['siretCompany' => $siretCompany]);
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($responses)) {
        echo json_encode(['message' => 'Aucune donnée disponible']);
        exit;
    }

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

    $questionAvgScores = [];
    foreach ($questionScores as $questionId => $totalScore) {
        $questionAvgScores[$questionId] = $totalScore / $questionCount[$questionId];
    }

    $finalResponse = [
        'avg_total_score' => round($companyAvgScore, 2),
        'user_count' => count($userTotalScores),
        'questions' => []
    ];

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

    echo json_encode($finalResponse);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données']);
}
?>