<?php
include_once("../database/connexion.php"); 

$erreur_champ = "";
$erreur = "";
$success = "";

if (isset($_POST["submit"])) {
    $username = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Vérifier les champs vides
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $erreur_champ = "Tous les champs doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "L'email est invalide.";
    } elseif ($password !== $confirm_password) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email est unique
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            $erreur = "Cet email est déjà utilisé.";
        } else {
            // Générer un UUID pour l'utilisateur
            $user_uuid = bin2hex(random_bytes(16)); // Générer un UUID

            // Hacher le mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insérer l'utilisateur dans la base de données
            $insertQuery = "INSERT INTO users (user_uuid, username, email, password) VALUES (:user_uuid, :username, :email, :password)";
            $stmt = $connexion->prepare($insertQuery);
            $stmt->bindParam(":user_uuid", $user_uuid);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashed_password);

            if ($stmt->execute()) {
                // Message de succès
                $success = "Votre compte a été créé avec succès.";
                
                // Redirection vers la page de connexion après 2 secondes
                header("Refresh:2; url=login.php");
            } else {
                $erreur = "Erreur lors de la création de l'utilisateur.";
            }
        }
    }
}
?>
