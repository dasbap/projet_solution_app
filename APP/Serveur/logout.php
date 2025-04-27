<?php
session_start([
    'cookie_httponly' => true,  // Protège contre les attaques XSS
    'cookie_samesite' => 'Lax'  // Protection CSRF (plus flexible que 'Strict')
]);

// Destruction propre de la session
$_SESSION = [];
session_unset();

// Suppression du cookie côté client
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 3600,  // Expiration dans le passé
        $params["path"],
        $params["domain"],
        false,  // Désactivé car pas de HTTPS
        $params["httponly"]
    );
}

session_destroy();

header("Location: ../Client/views/connexion.php");
exit;
?>