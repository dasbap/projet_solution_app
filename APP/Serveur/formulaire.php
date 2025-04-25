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
    logDebug("Erreur : utilisateur non authentifie");
    die(json_encode(['error' => 'Authentification requise']));
}

$userId = $_SESSION['user_id'];
logDebug("Utilisateur connecte : $userId");

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $jsonPath = realpath(__DIR__ . '/../Client/res/data/questions.json');
    if (!$jsonPath || !file_exists($jsonPath)) {
        throw new Exception("Fichier JSON introuvable");
    }

    $questionsJson = file_get_contents($jsonPath);
    $questions = json_decode($questionsJson, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Erreur de format JSON: " . json_last_error_msg());
    }

    // Creer un mapping des questions par ID et par categorie
    $questionMap = array_column($questions, null, 'id');
    $questionsByCategory = [];
    foreach ($questions as $q) {
        if (!isset($questionsByCategory[$q['categorie']])) {
            $questionsByCategory[$q['categorie']] = [];
        }
        $questionsByCategory[$q['categorie']][] = $q;
    }

    logDebug("Questions chargees : " . count($questionMap));

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data)) {
            throw new Exception("Aucune donnee reçue");
        }

        logDebug("Donnees POST reçues : " . print_r($data, true));

        $pdo->beginTransaction();

        $totalScore = 0;
        $responses = [];

        // Première passe: sauvegarde des reponses
        foreach ($data as $response) {
            if (!isset($response['id']) || !isset($response['reponse'])) {
                continue;
            }

            $questionId = $response['id'];
            $reponse = $response['reponse'];

            // Verifier si la question existe
            if (!isset($questionMap[$questionId])) {
                logDebug("Question avec ID $questionId non trouvee, creation...");
                createQuestion([
                    'id' => $questionId,
                    'question_text' => isset($response['question_text']) ? $response['question_text'] : 'Question inconnue',
                    'categorie' => 'inconnue',
                    'type_question' => 'texte'
                ]);
            }

            saveOrUpdateResponse($userId, $questionId, $reponse);
            $responses[$questionId] = $reponse;
        }

        // Deuxième passe: calcul des scores avec prise en compte des coefficients
        foreach ($responses as $questionId => $reponse) {
            if (!isset($questionMap[$questionId])) continue;

            $question = $questionMap[$questionId];
            $score = calculateQuestionScore($question, $reponse, $responses);
            $coef = isset($question['coef']) ? (float)$question['coef'] : 1.0;
            $totalScore += $score * $coef;
        }

        // Sauvegarde du score final
        saveScore($userId, $totalScore);

        $pdo->commit();
        logDebug("✅ Transaction validee - Score total: $totalScore");
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'score' => $totalScore,
            'message' => 'Reponses enregistrees avec succès'
        ]);
    } else {
        throw new Exception("Methode non supportee: " . $_SERVER['REQUEST_METHOD']);
    }
} catch (PDOException $e) {
    if (isset($pdo)) {$pdo->rollBack();}

    logDebug("❌ Erreur PDO : " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de donnees']);
} catch (Exception $e) {
    logDebug("❌ Exception : " . $e->getMessage());
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}

function doesQuestionExist($questionId) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM Table_questions WHERE id_question = :id');
    $stmt->execute([':id' => $questionId]);
    return $stmt->fetchColumn() > 0;
}

function createQuestion($question) {
    global $pdo;
    $stmt = $pdo->prepare('
        INSERT INTO Table_questions (id_question, question_text, categorie, type_question) 
        VALUES (:id, :text, :cat, :type)
    ');
    $stmt->execute([ 
        ':id' => $question['id'], 
        ':text' => $question['question_text'], 
        ':cat' => $question['categorie'], 
        ':type' => $question['type_question']
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

function calculateQuestionScore($question, $reponse, $allResponses) {
    if (!isset($question['type'])) {
        return 0;
    }

    switch ($question['type']) {
        case 'select':
            foreach ($question['options'] as $option) {
                if ($option['label'] === $reponse) {
                    return (int)$option['score'];
                }
            }
            return 0;
            
        case 'number':
            if (isset($question['scorePerKm']) && is_numeric($reponse)) {
                return (int)$reponse * (int)$question['scorePerKm'];
            }
            if (isset($question['scorePerDay']) && is_numeric($reponse)) {
                return (int)$reponse * (int)$question['scorePerDay'];
            }
            if (isset($question['scorePerMeal']) && is_numeric($reponse)) {
                return (int)$reponse * (int)$question['scorePerMeal'];
            }
            return 0;
            
        default:
            return 0;
    }
}

function saveScore($userId, $totalScore) {
    global $pdo;
    
    $stmt = $pdo->prepare('
        INSERT INTO Table_score_carbon (id_user, score, date_assigned) 
        VALUES (:user, :score, NOW())
        ON DUPLICATE KEY UPDATE score = VALUES(score), date_assigned = NOW()
    ');
    
    $stmt->execute([
        ':user' => $userId,
        ':score' => $totalScore
    ]);
    
    logDebug("Score sauvegarde pour l'utilisateur $userId: $totalScore");
}
?>