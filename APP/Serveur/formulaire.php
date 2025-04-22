<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour soumettre ce formulaire.";
    exit;
}

$userId = $_SESSION['user_id'];

// Charger les questions JSON
$questionsJson = file_get_contents('../Client/res/data/questions.json');
if ($questionsJson === false) {
    echo "Erreur de lecture du fichier JSON.";
    exit;
}

$questions = json_decode($questionsJson, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Erreur de décodage JSON : " . json_last_error_msg();
    exit;
}

// Indexer les questions par ID
$questionMap = [];
foreach ($questions as $q) {
    $questionMap[$q['id']] = $q;
}

// Étape 1 : Vérification / création de toutes les questions de base
try {
    foreach ($questionMap as $questionId => $question) {
        if (!doesQuestionExist($questionId)) {
            createQuestion($question);
            echo "Question $questionId ajoutée à la BDD.<br>";
        }
    }
} catch (Exception $e) {
    echo "Erreur pendant la vérification/ajout des questions : " . $e->getMessage();
    exit;
}

// Étape 2 : Traitement des réponses
$responses = ($_SERVER['REQUEST_METHOD'] === 'POST') ? $_POST : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($responses)) {
    try {
        $pdo->beginTransaction();

        foreach ($responses as $questionId => $reponse) {
            if (!isset($questionMap[$questionId])) {
                echo "Question $questionId inconnue dans le JSON, ignorée.<br>";
                continue;
            }

            $question = $questionMap[$questionId];
            $score = calculateScore($question, $reponse);
            saveResponse($userId, $questionId, $reponse, $score);
            echo "Réponse pour $questionId enregistrée avec score $score.<br>";
        }

        $pdo->commit();
        echo "Réponses enregistrées avec succès.";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Erreur lors de l'enregistrement des réponses : " . $e->getMessage();
    }
} else {
    echo "Aucune donnée reçue ou méthode incorrecte.";
    exit;
}

// Vérifie si une question existe déjà
function doesQuestionExist($questionId) {
    global $pdo;
    $sql = "SELECT COUNT(*) FROM Table_questions WHERE id_question = :id_question";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_question', $questionId, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

// Crée une question à partir du JSON
function createQuestion($question) {
    global $pdo;
    $sql = "INSERT INTO Table_questions (id_question, question_text, categorie, type_question) 
            VALUES (:id_question, :question_text, :categorie, :type_question)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_question', $question['id'], PDO::PARAM_STR);
    $stmt->bindParam(':question_text', $question['question_text'], PDO::PARAM_STR);
    $stmt->bindParam(':categorie', $question['categorie'], PDO::PARAM_STR);
    $stmt->bindParam(':type_question', $question['type'], PDO::PARAM_STR);
    if (!$stmt->execute()) {
        throw new Exception("Erreur lors de l'ajout de la question $question[id].");
    }
}

// Calcule le score
function calculateScore($question, $reponse) {
    $score = 0;
    switch ($question['type']) {
        case 'select':
            foreach ($question['options'] as $option) {
                if ($option['label'] === $reponse) {
                    $score = $option['score'];
                    break;
                }
            }
            break;
        case 'number':
            if (isset($question['scorePerKm']) && is_numeric($reponse)) {
                $score = $reponse * $question['scorePerKm'];
            }
            break;
    }
    if (isset($question['coef'])) {
        $score *= $question['coef'];
    }
    return (int)$score;
}

// Enregistre la réponse
function saveResponse($userId, $questionId, $reponse, $score) {
    global $pdo;
    $sql = "INSERT INTO Table_reponses (id_user, id_question, reponse, score_question) 
            VALUES (:id_user, :id_question, :reponse, :score_question)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':id_question', $questionId, PDO::PARAM_STR);
    $stmt->bindParam(':reponse', $reponse, PDO::PARAM_STR);
    $stmt->bindParam(':score_question', $score, PDO::PARAM_INT);
    if (!$stmt->execute()) {
        throw new Exception("Erreur lors de l'enregistrement de la réponse.");
    }
}
?>
