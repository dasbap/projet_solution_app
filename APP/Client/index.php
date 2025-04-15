<?php
// Démarrer la session pour récupérer les données de l'utilisateur connecté
session_start();

// Vérifier si l'utilisateur est bien connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: connexion.html");
    exit;
}

// Charger les variables de connexion depuis le fichier config.php
require_once '..\Serveur\config.php';

// Récupérer l'ID de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

try {
    // Connexion à la base de données
    $stmt = $pdo->prepare("SELECT u.user_name, c.name_company
                            FROM Table_User u
                            JOIN Table_company c ON u.siret_company = c.siret_company
                            WHERE u.id_user = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe dans la base de données
    if ($user) {
        $user_name = $user['user_name'];
        $company_name = $user['name_company'];
    } else {
        echo "Erreur : utilisateur non trouvé.";
        exit;
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($user_name); ?>!</h1>
    <p>Nom de l'entreprise : <?php echo htmlspecialchars($company_name); ?></p>

    <p><a href="..\Serveur\logout.php">Se déconnecter</a></p>
</body>
</html>
