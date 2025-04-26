<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT MAX(date_reponse) AS last_date FROM Table_reponses WHERE id_user = :id_user");
    $stmt->execute(['id_user' => $userId]);
    $lastDate = $stmt->fetchColumn();

    if (!$lastDate) {
        echo json_encode([]);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT q.id_question, q.question_text, q.categorie, r.reponse, r.score_question
        FROM Table_reponses r
        JOIN Table_questions q ON r.id_question = q.id_question
        WHERE r.id_user = :id_user AND r.date_reponse = :last_date
    ");
    $stmt->execute(['id_user' => $userId, 'last_date' => $lastDate]);
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $labels = [];
    $scores = [];
    $categories = [];
    $userResponses = [];

    foreach ($responses as $row) {
        $labels[] = $row['question_text'];
        $scores[] = (int) $row['score_question'];
        $categories[$row['categorie']] = ($categories[$row['categorie']] ?? 0) + (int) $row['score_question'];
        $userResponses[$row['id_question']] = [
            'question' => $row['question_text'],
            'response' => $row['reponse'],
            'score' => (int) $row['score_question']
        ];
    }

    $impact_categories = [
        'Transport' => 'Emissions liées au transport',
        'Energie' => 'Consommation d\'énergie',
        'Alimentation' => 'Impact de l\'alimentation',
        'Déchets' => 'Gestion des déchets',
        'Autres' => 'Autres facteurs'
    ];

    echo json_encode([
        'form' => array_column($responses, 'reponse', 'id_question'),
        'user_responses' => $userResponses, 
        'line' => [
            'labels' => $labels, 
            'data' => $scores
        ],
        'bar' => [
            'labels' => array_keys($categories),
            'data' => array_values($categories)
        ],
        'pie' => [
            'labels' => array_keys($impact_categories),
            'data' => array_values($categories) 
        ]
    ]);

} catch (PDOException $e) {
    error_log("Erreur SQL: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([]);
}
?>
