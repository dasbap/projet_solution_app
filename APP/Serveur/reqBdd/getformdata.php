<?php
session_start();
require_once '../config.php';

// Log de début de session
logMessage('Début traitement historique utilisateur', [
    'session_id' => session_id(),
    'client_ip' => $_SERVER['REMOTE_ADDR']
], 'detail');

if (!isset($_SESSION['user_id'])) {
    logMessage('Accès non autorisé - utilisateur non connecté', [], 'application');
    http_response_code(401);
    exit;
}

$userId = $_SESSION['user_id'];
logMessage('Utilisateur identifié', ['user_id' => $userId], 'application');

try {
    // Requête date dernière réponse
    $dateQuery = "SELECT MAX(date_reponse) AS last_date FROM Table_reponses WHERE id_user = :id_user";
    logMessage('Exécution requête date dernière réponse', ['query' => $dateQuery], 'detail');
    
    $stmt = $pdo->prepare($dateQuery);
    $stmt->execute(['id_user' => $userId]);
    $lastDate = $stmt->fetchColumn();

    if (!$lastDate) {
        logMessage('Aucune réponse trouvée pour l\'utilisateur', ['user_id' => $userId], 'application');
        echo json_encode([]);
        exit;
    }

    logMessage('Dernière date de réponse trouvée', ['last_date' => $lastDate], 'detail');

    // Requête réponses utilisateur
    $responsesQuery = "
        SELECT q.id_question, q.question_text, q.categorie, r.reponse, r.score_question
        FROM Table_reponses r
        JOIN Table_questions q ON r.id_question = q.id_question
        WHERE r.id_user = :id_user AND r.date_reponse = :last_date
    ";
    
    logMessage('Exécution requête réponses utilisateur', [
        'query' => preg_replace('/\s+/', ' ', trim($responsesQuery)),
        'params' => ['id_user' => $userId, 'last_date' => $lastDate]
    ], 'detail');

    $stmt = $pdo->prepare($responsesQuery);
    $stmt->execute(['id_user' => $userId, 'last_date' => $lastDate]);
    $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    logMessage('Résultats réponses utilisateur', [
        'nb_reponses' => count($responses),
        'exemple' => count($responses) > 0 ? $responses[0] : null
    ], 'detail');

    // Préparation des données
    $labels = [];
    $scores = [];
    $categories = [];
    $userResponses = [];

    foreach ($responses as $row) {
        $labels[] = $row['question_text'];
        $scores[] = (int) $row['score_question'];
        $categories[$row['categorie']] = ($categories[$row['categorie']] ?? 0) + (int) $row['score_question'];
        $userResponses[$row['id_question']] = [
            'question' => $row['question_text'],
            'response' => $row['reponse'],
            'score' => (int) $row['score_question']
        ];
    }

    $impact_categories = [
        'Transport' => 'Emissions liées au transport',
        'Energie' => 'Consommation d\'énergie',
        'Alimentation' => 'Impact de l\'alimentation',
        'Déchets' => 'Gestion des déchets',
        'Autres' => 'Autres facteurs'
    ];

    // Log avant envoi réponse
    logMessage('Préparation réponse JSON', [
        'nb_categories' => count($categories),
        'nb_reponses' => count($userResponses),
        'structure_donnees' => [
            'form' => 'array[id_question => reponse]',
            'line' => ['labels', 'data'],
            'bar' => ['labels', 'data'],
            'pie' => ['labels', 'data']
        ]
    ], 'application');

    echo json_encode([
        'form' => array_column($responses, 'reponse', 'id_question'),
        'user_responses' => $userResponses, 
        'line' => [
            'labels' => $labels, 
            'data' => $scores
        ],
        'bar' => [
            'labels' => array_keys($categories),
            'data' => array_values($categories)
        ],
        'pie' => [
            'labels' => array_keys($impact_categories),
            'data' => array_values($categories) 
        ]
    ]);

    logMessage('Réponse envoyée avec succès', ['taille_reponse' => strlen(json_encode($responses))], 'application');

} catch (PDOException $e) {
    logMessage('ERREUR SQL historique utilisateur', [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'fichier' => $e->getFile(),
        'ligne' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ], 'error');

    logMessage('Envoi réponse erreur au client', [
        'status_code' => 500,
        'erreur_client' => 'Erreur serveur'
    ], 'application');

    http_response_code(500);
    echo json_encode([]);
} finally {
    logMessage('Fin traitement historique utilisateur', [
        'duree' => round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 3) . 's'
    ], 'detail');
}
?>