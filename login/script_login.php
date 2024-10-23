<?php 
session_start();
include_once("../database/connexion.php");

$erreur = "";
$erreur_champ = "";

if (isset($_POST["submit"])) {
    $emailOrUsername = htmlspecialchars($_POST['email']); // Peut être email ou nom d'utilisateur
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
                // Créer des sessions pour l'utilisateur connexionecté
                $_SESSION['admin_uuid'] = $user['admin_uuid'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['photo'] = $user['photo'];

                // Rediriger vers le tableau de bord
                header("Location: ../page/tableau_de_bord.php");
                exit;
            } else {
                $erreur = "Mot de passe incorrect";
            }
        } else {
            $erreur = "L'utilisateur n'existe pas ou a été supprimé";
        }
    }
}

?>
