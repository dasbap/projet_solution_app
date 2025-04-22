<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}
if (!isset($_SESSION['compconnexion_complete'])){
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM Table_users WHERE id_user = :id_user";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: ../Client/view/connexion.php');
    exit;
}

$_SESSION['username'] = $user['username'];
$_SESSION['company'] = $user['company'];
$_SESSION['compconnexion_complete'] = true;

header('Location: ../Client/view/index.php');
exit;
?>
