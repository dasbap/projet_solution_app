<?php
session_start();
require_once 'config.php';

// Configuration du logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/log/serveur_errors.log');

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
function logDebug($message, $data = null, $type = 'detail') {
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

if (!isset($_SESSION['user_id'])) {
    logDebug('ERREUR: Tentative d\'accès non authentifié', $_SERVER, 'error');
    http_response_code(401);
    die(json_encode(['error' => 'Authentification requise']));
}

$userId = $_SESSION['user_id'];
logDebug('Session démarrée pour utilisateur', ['user_id' => $userId, 'ip' => $_SERVER['REMOTE_ADDR']], 'application');

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    logDebug('Connexion PDO établie', ['dsn' => $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS)], 'detail');

    $jsonPath = realpath(__DIR__ . '/../Client/res/data/questions.json');
    if (!$jsonPath) {
        logDebug('ERREUR: Fichier JSON introuvable', ['path' => __DIR__ . '/../Client/res/data/questions.json'], 'error');
        throw new Exception("Fichier JSON introuvable");
    }

    $questionsJson = file_get_contents($jsonPath);
    if ($questionsJson === false) {
        logDebug('ERREUR: Impossible de lire le fichier JSON', ['path' => $jsonPath, 'error' => error_get_last()], 'error');
        throw new Exception("Erreur de lecture du fichier JSON");
    }

    $questions = json_decode($questionsJson, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        logDebug('ERREUR: JSON invalide', ['error' => json_last_error_msg(), 'content_sample' => substr($questionsJson, 0, 100)], 'error');
        throw new Exception("Erreur de format JSON: " . json_last_error_msg());
    }

    $questionMap = array_column($questions, null, 'id');
    logDebug('Questions chargées', ['count' => count($questionMap), 'sample_ids' => array_slice(array_keys($questionMap), 0, 3)], 'detail');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rawInput = file_get_contents('php://input');
        logDebug('Données POST brutes reçues', ['length' => strlen($rawInput), 'content_type' => $_SERVER['CONTENT_TYPE']], 'application');

        $data = json_decode($rawInput, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            logDebug('ERREUR: Données POST JSON invalides', ['error' => json_last_error_msg(), 'input_sample' => substr($rawInput, 0, 100)], 'error');
            throw new Exception("Données JSON invalides");
        }

        if (empty($data)) {
            logDebug('AVERTISSEMENT: Données POST vides reçues', $_SERVER, 'application');
            throw new Exception("Aucune donnée reçue");
        }

        logDebug('Traitement des réponses', ['user_id' => $userId, 'response_count' => count($data)], 'detail');
        $pdo->beginTransaction();
        logDebug('Transaction démarrée', null, 'detail');

        $responsesToSave = [];
        $emptyResponses = 0;

        foreach ($data as $index => $response) {
            if (!isset($response['id'], $response['reponse'])) {
                logDebug('AVERTISSEMENT: Format de réponse invalide', ['index' => $index, 'response' => $response], 'application');
                continue;
            }

            $questionId = $response['id'];
            if (empty($response['reponse'])) {
                $emptyResponses++;
                logDebug('Réponse vide détectée', ['question_id' => $questionId], 'detail');
            }

            if (!isset($questionMap[$questionId])) {
                logDebug('AVERTISSEMENT: Question ID non trouvée', ['question_id' => $questionId, 'available_ids' => array_keys($questionMap)], 'detail');
                continue;
            }

            $questionExists = doesQuestionExist($questionId);
            logDebug('Vérification existence question', ['question_id' => $questionId, 'exists' => $questionExists], 'detail');

            if (!$questionExists) {
                $creationSuccess = createQuestion($questionMap[$questionId]);
                logDebug('Création question', ['question_id' => $questionId, 'success' => $creationSuccess], 'detail');
                
                if (!$creationSuccess) {
                    throw new Exception("Erreur création question ID $questionId");
                }
            }

            $responsesToSave[] = [
                'user_id' => $userId,
                'question_id' => $questionId,
                'reponse' => $response['reponse']
            ];
        }

        logDebug('Résumé des réponses', [
            'total_received' => count($data),
            'valid_responses' => count($responsesToSave),
            'empty_responses' => $emptyResponses,
            'invalid_questions' => count($data) - count($responsesToSave) - $emptyResponses
        ], 'detail');
        $totalscore = 0;

        foreach ($responsesToSave as $response) {
            // 1. Trouver la question correspondante
            $question = null;
            foreach ($questionMap as $q) {
                if ($q['id'] == $response['question_id']) {
                    $question = $q;
                    break;
                }
            }
            
            // 2. Calculer le score si la question existe
            if ($question) {
                $score = getScoreWithReponse($question, $response['reponse']);
                $totalscore += $score;
            } else {
                $score = 0;
                logDebug('Question non trouvée pour calcul du score', [
                    'question_id' => $response['question_id']
                ], 'detail');
            }

            // 3. Sauvegarder la réponse (seulement si non vide)
            if (!empty(trim($response['reponse']))) {
                $saveResult = saveResponse(
                    $response['user_id'], 
                    $response['question_id'], 
                    $response['reponse'],
                    $score
                );
                
                logDebug('Sauvegarde réponse avec score', [
                    'user_id' => $response['user_id'],
                    'question_id' => $response['question_id'],
                    'reponse' => substr($response['reponse'], 0, 50) . (strlen($response['reponse']) > 50 ? '...' : ''),
                    'score' => $score,
                    'cumul_score' => $totalscore,
                    'success' => $saveResult ?? null
                ], 'detail');
            } else {
                logDebug('Réponse vide - non sauvegardée', [
                    'user_id' => $response['user_id'],
                    'question_id' => $response['question_id']
                ], 'detail');
                $saveResult = true; 
            }

            // 4. Logger les détails
            logDebug('Sauvegarde réponse avec score', [
                'user_id' => $response['user_id'],
                'question_id' => $response['question_id'],
                'reponse' => substr($response['reponse'], 0, 50) . (strlen($response['reponse']) > 50 ? '...' : ''),
                'score' => $score,
                'cumul_score' => $totalscore,
                'success' => $saveResult
            ], 'detail');

        }

        $saveTotalResult = saveTotalScore($userId, $totalscore);

        if ($saveTotalResult) {
            logDebug('Score carbon total sauvegardé avec succès', [
                'user_id' => $userId,
                'score' => $totalscore
            ], 'application');
        } else {
            logDebug('ERREUR: Échec sauvegarde score carbon total', [
                'user_id' => $userId
            ], 'error');
        }

        $pdo->commit();

        logDebug('Transaction confirmée', [
            'responses_saved' => count($responsesToSave),
            'total_score' => $totalscore
        ], 'detail');

        echo json_encode([
            "success" => true,
            "score" => $totalscore
        ]);

        logDebug('Réponse envoyée avec succès', [
            'total_score' => $totalscore,
            'user_id' => $userId
        ], 'application');}
else {
        logDebug('ERREUR: Méthode non supportée', ['method' => $_SERVER['REQUEST_METHOD']], 'error');
        throw new Exception("Méthode non supportée: " . $_SERVER['REQUEST_METHOD']);
    }
} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
        logDebug('ERREUR: Rollback transaction', ['error' => $e->getMessage()], 'error');
    }
    logDebug('ERREUR PDO', [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'trace' => $e->getTraceAsString()
    ], 'error');
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de base de données']);
} catch (Exception $e) {
    logDebug('ERREUR Application', [
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], 'application');
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}

/**
 * Vérifie si une question existe dans la base de données
 * @param int $questionId ID de la question
 * @return bool True si la question existe, false sinon
 */
function doesQuestionExist($questionId) {
    global $pdo;
    try {
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM table_questions WHERE id_question = :id');
        $stmt->execute([':id' => $questionId]);
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        logDebug('ERREUR: Échec vérification question', [
            'question_id' => $questionId,
            'error' => $e->getMessage()
        ], 'error');
        return false;
    }
}

/**
 * Crée une nouvelle question dans la base de données
 * @param array $questionData Données de la question
 * @return bool True si la création a réussi, false sinon
 */
function createQuestion($questionData) {
    global $pdo;
    try {
        $stmt = $pdo->prepare('INSERT INTO table_questions (id_question, question_text, categorie, type_question) VALUES (:id, :text, :cat, :type)');
        return $stmt->execute([
            ':id' => $questionData['id'],
            ':text' => $questionData['question_text'],
            ':cat' => $questionData['categorie'],
            ':type' => $questionData['type']
        ]);
    } catch (PDOException $e) {
        logDebug('ERREUR: Échec création question', [
            'question_data' => $questionData,
            'error' => $e->getMessage(),
            'code' => $e->getCode()
        ], 'error');
        return false;
    }
}

/**
 * Sauvegarde une réponse avec son score dans la base de données
 * @param int $userId ID de l'utilisateur
 * @param int $questionId ID de la question
 * @param string $reponse Réponse textuelle
 * @param int $score Score calculé
 * @return bool True si l'insertion a réussi, false sinon
 */
function saveResponse($userId, $questionId, $reponse, $score) {
    global $pdo;
    
    if (empty(trim($reponse))) {
        return false;
    }
    
    try {
        $stmt = $pdo->prepare('INSERT INTO table_reponses 
                                (id_user, id_question, reponse, score_question, date_reponse) 
                                VALUES (:user, :qid, :rep, :score, NOW())');
        
        return $stmt->execute([
            ':user' => $userId,
            ':qid' => $questionId,
            ':rep' => $reponse,
            ':score' => $score
        ]);
        
    } catch (PDOException $e) {
        logDebug('ERREUR: Échec insertion réponse', [
            'user_id' => $userId,
            'question_id' => $questionId,
            'error' => $e->getMessage()
        ], 'error');
        return false;
    }
}

/**
 * Calcule le score pour une réponse à une question
 * @param array $question La question avec ses options et scores
 * @param string|array $reponse La réponse de l'utilisateur
 * @return int Le score calculé (score de l'option * coefficient)
 */
function getScoreWithReponse($question, $reponse) {
    $score = 0;
    $coef = $question['coef'] ?? 1;

    if ($question['type'] === 'select' || $question['type'] === 'radio') {
        foreach ($question['options'] as $option) {
            if ($reponse === $option['label']) {
                $score = $option['score'];
                break;
            }
        }
    }
    else if ($question['type'] === 'checkbox' && is_array($reponse)) {
        foreach ($question['options'] as $option) {
            if (in_array($option['label'], $reponse)) {
                $score += $option['score'];
            }
        }
    }

    return $score * $coef;
}

/**
 * Enregistre le score total dans table_score_carbon
 * @param int $userId ID de l'utilisateur
 * @param int $totalScore Score total à enregistrer
 * @return bool True si l'insertion a réussi, false sinon
 */
function saveTotalScore($userId, $totalScore) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare('INSERT INTO table_score_carbon 
                                (id_user, score, date_assigned) 
                                VALUES (:user, :score, CURDATE())');
        
        $result = $stmt->execute([
            ':user' => $userId,
            ':score' => $totalScore
        ]);
        
        logDebug('Score total enregistré', [
            'user_id' => $userId,
            'total_score' => $totalScore,
            'success' => $result,
            'last_insert_id' => $pdo->lastInsertId()
        ], 'detail');
        
        return $result;
        
    } catch (PDOException $e) {
        logDebug('ERREUR: Échec enregistrement score total', [
            'user_id' => $userId,
            'error' => $e->getMessage(),
            'error_code' => $e->getCode()
        ], 'error');
        return false;
    }
}

?>