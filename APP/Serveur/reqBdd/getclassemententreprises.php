<?php
require_once '../config.php';
session_start();

try {
    $sql = "
        SELECT 
            c.name_company,
            COALESCE(SUM(sc.score), 0) AS total_score
        FROM table_company c
        LEFT JOIN table_user u ON c.siret_company = u.siret_company
        LEFT JOIN table_score_carbon sc ON u.id_user = sc.id_user
        GROUP BY c.name_company
        ORDER BY total_score DESC
    ";

    $stmt = $pdo->query($sql);
    $companies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($companies);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
}
?>
