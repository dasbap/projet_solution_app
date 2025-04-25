<?php
header('Content-Type: application/json');
require_once("../config.php");

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des utilisateurs et de leurs scores (en faisant une jointure entre les tables utilisateurs et scores)
    $stmtUsers = $pdo->prepare(
        "SELECT u.user_name, u.email_user, SUM(s.score) AS total_score
            FROM Table_User u
            LEFT JOIN Table_score_carbon s ON u.id_user = s.id_user
            GROUP BY u.id_user
            ORDER BY total_score DESC"
    );
    $stmtUsers->execute();
    $users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    // Récupération des entreprises et de leurs scores totaux (en faisant une jointure avec les utilisateurs)
    $stmtCompanies = $pdo->prepare(
        "SELECT c.name_company, SUM(s.score) AS total_score
            FROM Table_company c
            LEFT JOIN Table_User u ON c.siret_company = u.siret_company
            LEFT JOIN Table_score_carbon s ON u.id_user = s.id_user
            GROUP BY c.siret_company
            ORDER BY total_score DESC"
    );
    $stmtCompanies->execute();
    $companies = $stmtCompanies->fetchAll(PDO::FETCH_ASSOC);

    // Réponse JSON contenant les utilisateurs et les entreprises
    echo json_encode([
        'users' => $users,
        'companies' => $companies
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'error' => 'Erreur de connexion à la base de données : ' . $e->getMessage()
    ]);
}
?>
