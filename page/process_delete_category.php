<?php
include_once("../database/connexion.php"); // Incluez votre fichier de connexion à la base de données
include_once("../fonction/fonction.php");

if (isset($_GET['id'])) {
    $category_uuid = htmlspecialchars($_GET['id']);
    
    // Préparer la requête de mise à jour
    $updateSql = "UPDATE meal_categories SET is_deleted = 1 WHERE category_uuid = :category_uuid";
    $stmt = $connexion->prepare($updateSql);
    $stmt->bindValue(':category_uuid', $category_uuid, PDO::PARAM_STR);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Redirection avec un message de succès
        header("Location: categorie_repas.php?succes=Catégorie supprimée avec succès.");
        exit();
    } else {
        // Redirection avec un message d'erreur
        header("Location: categorie_repas.php?error=Erreur lors de la suppression de la catégorie.");
        exit();
    }
} else {
    // Redirection si l'ID n'est pas fourni
    header("Location: categorie_repas.php?error=ID de catégorie non fourni.");
    exit();
}
?>
