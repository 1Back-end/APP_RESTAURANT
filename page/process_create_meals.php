<?php
include_once("../database/connexion.php"); // Connexion à la base de données
include_once("../fonction/fonction.php");

// Initialisation des variables
$erreur_champ = "";
$erreur = "";
$success = "";
$nom = ""; 
$date = ""; 
$description = ""; 
$prix = ""; 
$categorie = "";

// Vérifier si le formulaire a été soumis
if (isset($_POST["submit"])) {
    // Récupérer les données du formulaire
    $nom = htmlspecialchars(trim($_POST['nom']));
    $date = htmlspecialchars(trim($_POST['date']));
    $description = htmlspecialchars(trim($_POST['description']));
    $prix = htmlspecialchars(trim($_POST['prix']));
    $categorie = $_POST['categorie'] ?? null;
    $added_by = $_SESSION['admin_uuid'];
    $meal_uuid = generateUUID(); // Générer un UUID pour le repas

    // Vérifier si les champs requis sont remplis
    if (empty($nom) || empty($date) || empty($description) || empty($prix) || empty($categorie)) {
        $erreur_champ = "Tous les champs doivent être remplis.";
    } else {
        // Configuration pour le téléchargement des photos
        $photos = $_FILES['photos'];
        $taille_max = 2097152; // 2 Mo
        $extensions_valides = ['jpg', 'jpeg', 'png'];
        $images_path = [];

        // Vérification de chaque photo
        for ($i = 0; $i < count($photos['name']); $i++) {
            $extension = pathinfo($photos['name'][$i], PATHINFO_EXTENSION);
            $taille_fichier = $photos['size'][$i];

            // Validation de l'extension et de la taille
            if (in_array($extension, $extensions_valides) && $taille_fichier <= $taille_max) {
                $nom_fichier = uniqid() . '.' . $extension; // Nom unique pour éviter les collisions
                $chemin_dossier = '../uploads/'; // Dossier où les fichiers seront stockés

                // Déplacer le fichier téléchargé vers le dossier
                if (move_uploaded_file($photos['tmp_name'][$i], $chemin_dossier . $nom_fichier)) {
                    $images_path[] = $nom_fichier; // Ajouter le chemin de l'image au tableau
                } else {
                    $erreur = "Erreur lors du téléchargement de l'image : " . $photos['name'][$i];
                    break; // Sortir de la boucle si une erreur survient
                }
            } else {
                $erreur = "Type de fichier invalide ou taille excessive pour l'image : " . $photos['name'][$i];
                break; // Sortir de la boucle si une erreur survient
            }
        }

        // Si aucune erreur n'est survenue, enregistrer le repas dans la base de données
        if (empty($erreur)) {
            // Convertir le tableau des chemins d'images en chaîne pour l'enregistrement
            $images_string = implode(',', $images_path);
            $query = "INSERT INTO meals (meal_uuid, name, description, price, image, added_at, category_uuid, created_at, added_by, is_deleted) 
                      VALUES (:meal_uuid, :name, :description, :price, :image, :added_at, :category_uuid, NOW(), :added_by, 0)";
            
            $stmt = $connexion->prepare($query);
            $stmt->bindParam(':meal_uuid', $meal_uuid);
            $stmt->bindParam(':name', $nom);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $prix);
            $stmt->bindParam(':image', $images_string); // Enregistrer les chemins des images
            $stmt->bindParam(':added_at', $date);
            $stmt->bindParam(':category_uuid', $categorie);
            $stmt->bindParam(':added_by', $added_by);

            if ($stmt->execute()) {
                $success = "Repas enregistré avec succès!";
                // Vider les champs après succès
                $nom = ""; 
                $date = ""; 
                $description = ""; 
                $prix = ""; 
                $categorie = "";
            } else {
                $erreur = "Erreur lors de l'enregistrement du repas.";
            }
        }
    }
}
?>
