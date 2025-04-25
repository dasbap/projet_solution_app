<?php
session_start();
require_once 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

function logDebug($message) {
    file_put_contents(__DIR__ . '/log/serveur_erreur.log', date('[Y-m-d H:i:s] ') . $message . "\n", FILE_APPEND);
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    logDebug("Erreur : utilisateur non authentifié");
    die(json_encode(['error' => 'Authentification requise']));
}

$userId = $_SESSION['user_id'];
logDebug("Utilisateur connecté : $userId");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$jsonPath = realpath(__DIR__ . '/../Client/res/data/questions.json');
if (!$jsonPath || !file_exists($jsonPath)) {
    http_response_code(500);
    logDebug("Erreur : Fichier JSON introuvable");
    die(json_encode(['error' => 'Fichier de questions introuvable']));
}

$questionsJson = file_get_contents($jsonPath);
$questions = json_decode($questionsJson, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    logDebug("Erreur JSON : " . json_last_error_msg());
    die(json_encode(['error' => 'Erreur de format JSON']));
}

$questionMap = array_column($questions, null, 'id');
logDebug("Questions chargées : " . count($questionMap));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data)) {
        http_response_code(400);
        logDebug("Erreur : Aucune donnée reçue");
        die(json_encode(['error' => 'Aucune donnée reçue']));
    }

    logDebug("Données POST reçues : " . print_r($data, true));

    try {
        $pdo->beginTransaction();

        foreach ($data as $questionId => $reponse) {
            if (!isset($questionMap[$questionId])) {
                logDebug("⚠️ ID non reconnu dans JSON : $questionId");
                continue;
            }

            logDebug("Sauvegarde réponse : Q=$questionId, R=$reponse");
            saveOrUpdateResponse($userId, $questionId, $reponse);
        }

        $pdo->commit();
        logDebug("✅ Transaction validée");
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $pdo->rollBack();
        logDebug("❌ Exception : " . $e->getMessage());
        http_response_code(500);
        die(json_encode(['error' => 'Erreur serveur']));
    }
} else {
    logDebug("Méthode non supportée : " . $_SERVER['REQUEST_METHOD']);
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

function doesQuestionExist($questionId) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM Table_questions WHERE id_question = :id');
    $stmt->execute([':id' => $questionId]);
    return $stmt->fetchColumn() > 0;
}

function createQuestion($question) {
    global $pdo;
    $categorie = isset($question['categorie']) ? $question['categorie'] : 'inconnue';
    $type = isset($question['type_question']) ? $question['type_question'] : 'texte';

    $stmt = $pdo->prepare('
        INSERT INTO Table_questions (id_question, question_text, categorie, type_question) 
        VALUES (:id, :text, :cat, :type)
    ');
    $stmt->execute([ 
        ':id' => $question['id'], 
        ':text' => $question['question_text'], 
        ':cat' => $categorie, 
        ':type' => $type
    ]);
}

function saveOrUpdateResponse($userId, $questionId, $reponse) {
    global $pdo;
    $stmt = $pdo->prepare('
        SELECT COUNT(*) FROM Table_reponses 
        WHERE id_user = :user AND id_question = :qid
    ');
    $stmt->execute([':user' => $userId, ':qid' => $questionId]);

    if ($stmt->fetchColumn() > 0) {
        $stmt = $pdo->prepare('
            UPDATE Table_reponses 
            SET reponse = :rep 
            WHERE id_user = :user AND id_question = :qid
        ');
    } else {
        $stmt = $pdo->prepare('
            INSERT INTO Table_reponses (id_user, id_question, reponse) 
            VALUES (:user, :qid, :rep)
        ');
    }

    $stmt->execute([
        ':user' => $userId,
        ':qid' => $questionId,
        ':rep' => $reponse
    ]);
}
?>
