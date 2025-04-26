<?php
require_once '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

try {
    $userId = $_SESSION['user_id'];

    $sql = "
        SELECT u.user_name, SUM(sc.score) AS score
        FROM table_score_carbon sc
        INNER JOIN table_user u ON u.id_user = sc.id_user
        WHERE sc.id_user = :userId
        GROUP BY u.user_name
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId]);
    $score = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($score);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
}
?>
