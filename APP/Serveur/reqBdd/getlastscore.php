<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    // Récupérer la dernière date de réponse de l'utilisateur
    $stmt = $pdo->prepare("SELECT MAX(date_reponse) AS last_date FROM Table_reponses WHERE id_user = :id_user");
    $stmt->execute(['id_user' => $userId]);
    $lastDate = $stmt->fetchColumn();

    if (!$lastDate) {
        echo json_encode([]);
        exit;
    }

    // Récupérer uniquement les scores des dernières réponses
    $stmt = $pdo->prepare("
        SELECT q.id_question, q.question_text, r.score_question
        FROM Table_reponses r
        JOIN Table_questions q ON r.id_question = q.id_question
        WHERE r.id_user = :id_user AND r.date_reponse = :last_date
    ");
    $stmt->execute([
        'id_user' => $userId,
        'last_date' => $lastDate
    ]);

    $scores = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $scores[] = [
            'id_question' => $row['id_question'],
            'question' => $row['question_text'],
            'score' => (int)$row['score_question']
        ];
    }

    echo json_encode($scores);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur.']);
}
?>
