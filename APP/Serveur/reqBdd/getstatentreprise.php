<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    // Trouver la siret_company de l'utilisateur connecté
    $stmt = $pdo->prepare("SELECT siret_company FROM table_user WHERE id_user = :id_user");
    $stmt->execute(['id_user' => $userId]);
    $siretCompany = $stmt->fetchColumn();

    if (!$siretCompany) {
        echo json_encode([]);
        exit;
    }

    // Récupérer toutes les réponses des utilisateurs de cette entreprise
    $stmt = $pdo->prepare("
        SELECT q.id_question, q.question_text, q.categorie, r.reponse, r.score_question
        FROM Table_reponses r
        JOIN Table_questions q ON r.id_question = q.id_question
        JOIN table_user u ON r.id_user = u.id_user
        WHERE u.siret_company = :siret_company
    ");
    $stmt->execute(['siret_company' => $siretCompany]);
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$responses) {
        echo json_encode([]);
        exit;
    }

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
            'data' => array_map(fn($cat) => $categories[$cat] ?? 0, array_keys($impact_categories))
        ]
    ]);

} catch (PDOException $e) {
    error_log("Erreur SQL: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([]);
}
?>
