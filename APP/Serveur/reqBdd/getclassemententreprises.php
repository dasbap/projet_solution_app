<?php
require_once 'config.php';

try {
    // Sous-requête pour les dernières réponses de chaque utilisateur
    $subquery = "
        SELECT id_user, MAX(date_reponse) AS last_date
        FROM Table_reponses
        GROUP BY id_user
    ";

    // Scores récents par utilisateur
    $scoresRecents = "
        SELECT r.id_user, u.siret_company, r.score_question
        FROM Table_reponses r
        JOIN ($subquery) AS last 
            ON r.id_user = last.id_user AND r.date_reponse = last.last_date
        JOIN Table_User u ON r.id_user = u.id_user
    ";

    // Classement par entreprise
    $sql = "
        SELECT c.name_company, c.siret_company, COALESCE(SUM(s.score_question), 0) AS total_score
        FROM Table_company c
        LEFT JOIN ($scoresRecents) AS s ON c.siret_company = s.siret_company
        GROUP BY c.siret_company
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
