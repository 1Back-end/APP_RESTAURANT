<?php
session_start();
include_once("../database/connexion.php");

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        // Vérifier si l'utilisateur existe
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Démarrer la session et stocker le nom de l'utilisateur
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_uuid'] = $user['user_uuid'];
            
            // Redirection vers la page menu.php après connexion réussie
            header("Location: ../menu.php");
            exit();
        } else {
            $erreur = "Email ou mot de passe incorrect.";
        }
    }
}
?>
