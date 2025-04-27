<?php
// Charge les variables d'environnement depuis le .env
$envPath = __DIR__ . '/.env'; 

if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        putenv(trim($key) . '=' . trim($value));
    }
}

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

// Vérifier si le répertoire de logs existe, sinon le créer
$logDirectory = __DIR__ . '/log';
if (!is_dir($logDirectory)) {
    mkdir($logDirectory, 0755, true); // Création du répertoire avec les permissions appropriées
}

// Configuration du logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', $logDirectory . '/serveur_errors.log');

// Définition des fichiers de log
$destination_log = [
    'error' => '/log/serveur_errors.log',
    'detail' => '/log/serveur_detail.log',
    'application' => '/log/serveur_application.log'
];

/**
 * Fonction de logging
 * @param string $message Message à logger
 * @param mixed $data Données supplémentaires à logger
 * @param string $type Type de log ('error', 'detail', 'application')
 */
function logMessage($message, $data = null, $type = 'detail') {
    global $destination_log;
    
    if (!array_key_exists($type, $destination_log)) {
        $type = 'detail';
    }
    
    $logMessage = date('[Y-m-d H:i:s] ') . $message;
    if ($data !== null) {
        $logMessage .= ' | ' . (is_array($data) ? json_encode($data) : $data);
    }
    
    $logFile = __DIR__ . $destination_log[$type];
    file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND);
}

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    logMessage("Erreur de connexion à la base de données", $e->getMessage(), 'error');
    die("Erreur de connexion : " . $e->getMessage());
}
?>
