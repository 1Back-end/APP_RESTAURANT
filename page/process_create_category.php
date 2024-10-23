<?php
include_once("../database/connexion.php"); // Assurez-vous d'utiliser une connexion PDO
include_once("../fonction/fonction.php");

$erreur_champ = "";
$erreur = "";
$success = "";

if (isset($_POST["submit"])) {
    $nom_categorie = htmlspecialchars($_POST['nom_categorie']);
    $description_categorie = htmlspecialchars($_POST['description_categorie']);
    
    // Rendre le champ 'nom_categorie' obligatoire
    if (empty($nom_categorie)) {
        $erreur_champ = "Le champ catégorie est obligatoire.";
    } else {
        $category_uuid = generateUUID(); // Générer un UUID pour la catégorie
        $added_by = $_SESSION['admin_uuid'];

        // Vérification si la catégorie existe déjà avec is_deleted = 1
        $checkSql = "SELECT * FROM meal_categories WHERE name = :name AND is_deleted = 0";
        $stmt = $connexion->prepare($checkSql);
        $stmt->bindValue(':name', $nom_categorie, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            // La catégorie existe et est marquée comme supprimée
            $erreur = "Une catégorie avec ce nom a déjà été supprimée. Veuillez utiliser un nom différent.";
        } else {
            // Si aucune description n'est fournie, en définir une par défaut
            if (empty($description_categorie)) {
                $description_categorie = "Description par défaut pour la catégorie."; // Description par défaut
            }
            
            // Insérer la nouvelle catégorie
            $insertSql = "INSERT INTO meal_categories (category_uuid, name, description, added_by) VALUES (:category_uuid, :name, :description, :added_by)";
            $insertStmt = $connexion->prepare($insertSql);
            $insertStmt->bindValue(':category_uuid', $category_uuid, PDO::PARAM_STR);
            $insertStmt->bindValue(':name', $nom_categorie, PDO::PARAM_STR);
            $insertStmt->bindValue(':description', $description_categorie, PDO::PARAM_STR);
            $insertStmt->bindValue(':added_by', $added_by, PDO::PARAM_STR);

            if ($insertStmt->execute()) {
                $success = "Catégorie créée avec succès!";
            } else {
                $erreur = "Erreur lors de la création de la catégorie: " . implode(", ", $insertStmt->errorInfo());
            }
        }
    }
}

// Afficher les messages d'erreur ou de succès
?>
