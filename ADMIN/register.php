<?php
require_once '../APP/Serveur/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email_user'] ?? '';
    $password = $_POST['user_password'] ?? '';

    // Extraire le nom de domaine
    $email_parts = explode('@', $email);
    $domain = $email_parts[1] ?? '';
    $company_raw = explode('.', $domain)[0] ?? '';
    $company_name = str_replace(['_', '-'], ' ', $company_raw);

    try {
        // Vérifie si l'email est déjà utilisé
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM Table_User WHERE email_user = :email");
        $checkStmt->execute([':email' => $email]);
        if ($checkStmt->fetchColumn() > 0) {
            echo "Cet email est déjà utilisé.";
            exit;
        }

        // Vérifie si l'entreprise existe
        $stmt = $pdo->prepare("SELECT siret_company FROM Table_company WHERE name_company = :company");
        $stmt->execute([':company' => $company_name]);
        $company = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$company) {
            echo "Entreprise inconnue.";
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert = $pdo->prepare("INSERT INTO Table_User (email_user, user_password_hash, role, siret_company) VALUES (:email, :pass, 0, :siret)");
        $insert->execute([
            ':email' => $email,
            ':pass' => $hashed_password,
            ':siret' => $company['siret_company']
        ]);

        echo "Inscription réussie.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
