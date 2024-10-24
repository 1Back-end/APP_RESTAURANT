<?php
// Inclure la connexion à la base de données
include_once("../database/connexion.php"); // Assure-toi que $connexion est défini dans ce fichier

// Vérifier que les paramètres 'id' (meal_uuid) et 'new_status' sont bien passés
if (isset($_GET['id']) && isset($_GET['new_status'])) {
    $meal_uuid = $_GET['id'];
    $new_status = (int)$_GET['new_status']; // Convertir le statut en entier (0 ou 1)

    // Préparer la requête SQL pour mettre à jour le statut de disponibilité du repas
    $sql = "UPDATE meals SET available = :new_status WHERE meal_uuid = :meal_uuid AND is_deleted = 0";
    
    // Utiliser $connexion pour préparer la requête
    $stmt = $connexion->prepare($sql);
    
    // Exécuter la requête avec les paramètres sécurisés
    if ($stmt->execute([':new_status' => $new_status, ':meal_uuid' => $meal_uuid])) {
        // Redirection avec message de succès après la mise à jour
        header('Location: liste_repas.php?status=success');
        exit;
    } else {
        // Redirection avec message d'erreur en cas de problème
        header('Location: liste_repas.php?status=error');
        exit;
    }
} else {
    // Redirection si les paramètres sont manquants ou invalides
    header('Location: liste_repas.php?status=invalid');
    exit;
}
