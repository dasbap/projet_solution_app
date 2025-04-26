<?php
require_once '../config.php';
session_start();

try {
    $sql = "
        SELECT u.user_name, SUM(sc.score) AS score
        FROM table_score_carbon sc
        INNER JOIN table_user u ON u.id_user = sc.id_user
        GROUP BY u.user_name
        ORDER BY score DESC
    ";

    $stmt = $pdo->query($sql);
    $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($scores);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
}
?>
