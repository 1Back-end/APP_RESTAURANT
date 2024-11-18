<?php
include_once("../database/connexion.php");

$admin_uuid = $_GET['admin_uuid']; // Récupérer l'admin_uuid depuis l'URL
$erreur = "";
$success = "";

// Vérifier si le formulaire a été soumis
if (isset($_POST["submit"])) {
    // Récupérer les mots de passe saisis
    $password = $_POST["password"] ?? null;
    $confirm_password = $_POST["confirm_password"] ?? null;

    // Vérifier si les champs de mot de passe sont remplis
    if (empty($password) || empty($confirm_password)) {
        $erreur_champ = "Tous les champs sont obligatoires.";
    } else {
        // Vérifier si les mots de passe sont identiques
        if ($password !== $confirm_password) {
            $erreur = "Les mots de passe ne correspondent pas.";
        } else {
                // Hacher le mot de passe avant de le stocker
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Mettre à jour le mot de passe dans la table admin_users
                $update_query = $connexion->prepare("UPDATE admin_users SET password = :password WHERE admin_uuid = :admin_uuid AND is_deleted = 0 AND is_active = 1");
                $update_query->execute([
                    'password' => $hashed_password,
                    'admin_uuid' => $admin_uuid
                ]);

                if ($update_query->rowCount() > 0) {
                    $success = "Votre mot de passe a été mis à jour avec succès.";
                    header("Refresh:2; url=login.php");
                } else {
                    $erreur = "Une erreur est survenue. Veuillez réessayer.";
                }
            }
        }
    }


?>
