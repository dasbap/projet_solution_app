<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Utilisateur non connecté']);
    exit;
}

try {
    $userId = $_SESSION['user_id'];

    // Calculer le score total de l'utilisateur
    $sql = "
        SELECT SUM(score_question) AS total_score
            FROM Table_reponses r
        JOIN Table_score_carbon sc ON r.id_user = sc.id_user
            WHERE r.id_user = :user_id
                AND r.date_reponse = (
                    SELECT MAX(date_reponse)
                        FROM Table_reponses
                    WHERE id_user = :user_id
                )
            ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si le résultat existe
    if ($result && isset($result['total_score'])) {
        echo json_encode([ 'score' => $result['total_score'] ]);
    } else {
        echo json_encode([ 'score' => 0 ]);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
}
?>
