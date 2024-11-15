<?php
// Connexion à la base de données
include_once("../database/connexion.php"); // Connexion à la base de données

$erreur = "";
$succes = "";

if (isset($_GET['user_uuid'])) {
    $user_uuid = trim($_GET['user_uuid']);
    
    if ($user_uuid) {
        // Si l'Utilisateur existe et n'a pas déjà été supprimé, on le supprime
        $stmt = $connexion->prepare("UPDATE admin_users SET is_deleted = 1 WHERE admin_uuid= ? ");
        if ($stmt->execute([$user_uuid])) {
            header("Location: liste_users.php?msg=Utilisateur supprimé avec succès.");
            exit(); // Arrêter le script après la redirection
        } else {
            header("Location: liste_users.php?msg=Erreur lors de la suppression de l'Utilisateur.");
            exit(); // Arrêter le script après la redirection
        }
    } else {
        header("Location: liste_users.php?msg=Cet Utilisateur n'existe pas ou a déjà été supprimé.");
        exit(); // Arrêter le script après la redirection
    }
} else {
    header("Location: liste_users.php?msg=Impossible de supprimer cet Utilisateur.");
    exit(); // Arrêter le script après la redirection
}