<?php
ini_set('display_errors', 1);

// Démarrer la session
session_start();

// Inclure la configuration de la base de données
require_once 'config.php';

// Vérifier si l'utilisateur est bien connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Récupérer l'ID de l'utilisateur depuis la session
$userId = $_SESSION['user_id'];

// Préparer et exécuter la requête pour récupérer les informations de l'utilisateur
try {
    
    $sql = "SELECT * FROM Table_user WHERE id_user = :id_user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        // Si l'utilisateur n'existe pas, détruire la session et rediriger
        session_destroy();
        header('Location: ../Client/view/connexion.php');
        exit;
    }

    // Mettre à jour les informations de la session
    $_SESSION['email_user'] = $user['email_user'];
    $_SESSION['user_name'] = $user['user_name'];
    $_SESSION['id_user'] = $user['id_user'];

} catch (PDOException $e) {
    // Gérer les erreurs de requête SQL
    error_log("Erreur SQL: " . $e->getMessage());  // Log de l'erreur pour le débogage
    exit("Erreur de connexion à la base de données. Veuillez réessayer plus tard.");
}
?>
