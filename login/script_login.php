<?php
session_start();
include_once("../database/connexion.php");

$erreur = "";
$erreur_champ = "";

if (isset($_POST["submit"])) {
    $emailOrUsername = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Vérifier si les champs sont vides
    if (empty($emailOrUsername) || empty($password)) {
        $erreur_champ = "Tous les champs doivent être remplis";
    } else {
        // Préparer la requête pour récupérer les informations de l'utilisateur
        $query = "SELECT * FROM admin_users WHERE (email = :emailOrUsername OR username = :emailOrUsername) AND is_deleted = 0";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':emailOrUsername', $emailOrUsername);
        $stmt->execute();

        // Vérifier si un utilisateur existe
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifier le mot de passe
            if (password_verify($password, $user['password'])) {
                // Créer des sessions pour l'utilisateur connecté
                $_SESSION['admin_uuid'] = $user['admin_uuid'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['photo'] = $user['photo'];

                // Gérer la fonctionnalité "Remember Me"
                if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
                    // Créer un identifiant unique pour l'utilisateur
                    $rememberToken = bin2hex(random_bytes(16));

                    // Stocker ce token dans la base de données pour cet utilisateur
                    $updateQuery = "UPDATE admin_users SET remember_token = :remember_token WHERE admin_uuid = :admin_uuid";
                    $stmt = $connexion->prepare($updateQuery);
                    $stmt->bindParam(':remember_token', $rememberToken);
                    $stmt->bindParam(':admin_uuid', $user['admin_uuid']);
                    $stmt->execute();

                    // Créer un cookie pour mémoriser l'utilisateur
                    setcookie('remember_me', $rememberToken, time() + (86400 * 30), "/"); // 30 jours de validité
                }
                header("Location: ../admin/tableau_de_bord.php");
                exit;
            } else {
                $erreur = "Mot de passe incorrect";
            }
        } else {
            $erreur = "L'utilisateur n'existe pas ou a été supprimé";
        }
    }
}

// Vérifier si un cookie "remember_me" existe et si l'utilisateur est authentifié avec ce token
if (isset($_COOKIE['remember_me'])) {
    $rememberToken = $_COOKIE['remember_me'];

    // Vérifier si le token existe dans la base de données
    $query = "SELECT * FROM admin_users WHERE remember_token = :remember_token";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':remember_token', $rememberToken);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Reconnecter l'utilisateur
        $_SESSION['admin_uuid'] = $user['admin_uuid'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['photo'] = $user['photo'];
        header("Location: ../admin/tableau_de_bord.php");
        exit;
    }
}
?>