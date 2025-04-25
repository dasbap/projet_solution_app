<?php
require_once '../config.php';

try {
    // Sous-requête pour récupérer la dernière date de réponse de chaque utilisateur
    $subquery = "
        SELECT id_user, MAX(date_reponse) AS last_date
        FROM Table_reponses
        GROUP BY id_user
    ";

    // Requête principale pour additionner les scores de la dernière réponse par utilisateur
    $sql = "
        SELECT u.user_name, SUM(r.score_question) AS total_score
        FROM Table_reponses r
        JOIN ($subquery) AS last ON r.id_user = last.id_user AND r.date_reponse = last.last_date
        JOIN Table_User u ON r.id_user = u.id_user
        GROUP BY r.id_user
        ORDER BY total_score DESC
    ";

    $stmt = $pdo->query($sql);
    $classement = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($classement);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
}
?>
