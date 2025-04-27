<?php
require_once 'config.php';

// Log de début de traitement
logMessage('Tentative de connexion initiée', [
    'client_ip' => $_SERVER['REMOTE_ADDR'],
    'method' => $_SERVER['REQUEST_METHOD']
], 'detail');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    logMessage('Méthode non autorisée', [
        'method_used' => $_SERVER['REQUEST_METHOD']
    ], 'error');
    http_response_code(405);
    exit('Méthode non autorisée');
}

// Récupération et validation des inputs
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    logMessage('Champs manquants', [
        'email_provided' => !empty($email),
        'password_provided' => !empty($password)
    ], 'application');
    exit('Email et mot de passe requis');
}

try {
    // Requête utilisateur
    logMessage('Recherche utilisateur en base', ['email' => $email], 'detail');
    $stmt = $pdo->prepare("SELECT id_user, email_user, user_password_hash FROM Table_User WHERE email_user = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

    if (!$user) {
        logMessage('Tentative de connexion échouée - email inconnu', ['email' => $email], 'application');
        exit('Identifiants incorrects');
    }

    // Vérification mot de passe
    if (password_verify($password, $user['user_password_hash'])) {
        // Démarrer la session sécurisée
        session_start([
            'cookie_httponly' => true,
            'cookie_samesite' => 'Strict'
        ]);
        
        // Régénération ID de session pour prévenir les fixation attacks
        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['email_user'] = $user['email_user'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];

        logMessage('Connexion réussie', [
            'user_id' => $user['id_user'],
            'session_id' => session_id()
        ], 'application');

        header("Location: ../Client/views/index.php");
        exit;
    } else {
        logMessage('Tentative de connexion échouée - mot de passe incorrect', [
            'user_id' => $user['id_user'],
            'email' => $email
        ], 'application');
        exit('Identifiants incorrects');
    }
} catch (PDOException $e) {
    logMessage('ERREUR SQL lors de la connexion', [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'trace' => substr($e->getTraceAsString(), 0, 200) // Limité pour sécurité
    ], 'error');
    exit('Une erreur est survenue');
} finally {
    logMessage('Fin traitement connexion', [
        'duration' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 3) . 's'
    ], 'detail');
}