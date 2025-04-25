<?php
session_start();
require_once 'config.php';

// Activer le reporting d'erreurs en développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die(json_encode(['error' => 'Authentification requise']));
}

// Chemin absolu pour le JSON
$jsonPath = realpath(__DIR__ . '/../Client/res/data/questions.json');
if (!$jsonPath || !file_exists($jsonPath)) {
    http_response_code(500);
    die(json_encode(['error' => 'Fichier de questions introuvable']));

}

$questionsJson = file_get_contents($jsonPath);
$questions = json_decode($questionsJson, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    die(json_encode(['error' => 'Erreur de format JSON']));
}

// Indexation des questions
$questionMap = array_column($questions, null, 'id');

try {
    // Traitement transactionnel
    $pdo->beginTransaction();

    foreach ($questionMap as $questionId => $question) {
        if (!doesQuestionExist($questionId)) {
            createQuestion($question);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($_POST as $questionId => $reponse) {
            if (!isset($questionMap[$questionId])) continue;
            
            $question = $questionMap[$questionId];
            saveResponse($_SESSION['user_id'], $questionId, $reponse);
        }
        
        $pdo->commit();
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    die(json_encode(['error' => $e->getMessage()]));
}
?>
