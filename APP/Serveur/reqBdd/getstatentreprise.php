<?php
require_once '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non authentifié']);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    // Récupérer le SIRET de l'entreprise de l'utilisateur connecté
    $stmt = $pdo->prepare("SELECT siret_company FROM table_user WHERE id_user = :userId");
    $stmt->execute(['userId' => $userId]);
    $siretCompany = $stmt->fetchColumn();

    if (!$siretCompany) {
        echo json_encode([]);
        exit;
    }

    // Récupérer les réponses des utilisateurs de l'entreprise
    $stmt = $pdo->prepare("
        SELECT q.id_question, q.question_text, r.score_question, q.categorie
        FROM Table_reponses r
        JOIN Table_questions q ON r.id_question = q.id_question
        JOIN table_user u ON r.id_user = u.id_user
        WHERE u.siret_company = :siretCompany
    ");
    $stmt->execute(['siretCompany' => $siretCompany]);
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
            'response' => $row['reponse'] ?? '', // Assurez-vous que 'reponse' existe
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

    // Calcul du score moyen
    $avg_score = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;

    echo json_encode([
        'avg_score' => $avg_score,
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
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
}
?>
