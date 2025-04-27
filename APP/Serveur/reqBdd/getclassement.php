<?php
require_once '../config.php';
session_start();

try {
    $sql = "
        SELECT u.user_name, SUM(sc.score) AS score
        FROM table_score_carbon sc
        INNER JOIN table_user u ON u.id_user = sc.id_user
        GROUP BY u.user_name
        HAVING SUM(sc.score) > 0  -- Facultatif: Filtrer les utilisateurs sans score
        ORDER BY score DESC
    ";

    // Exécution de la requête
    $stmt = $pdo->query($sql);
    $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si aucune donnée n'est trouvée, on renvoie une réponse vide
    if (empty($scores)) {
        echo json_encode(['users' => [], 'companies' => []]);
    } else {
        // Sinon, on renvoie les données sous forme de JSON
        echo json_encode(['users' => $scores, 'companies' => []]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
}
?>
