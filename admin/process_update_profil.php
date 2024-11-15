<?php
include_once("../database/connexion.php");

$erreur = ""; // Initialiser la variable pour les erreurs
$success = ""; // Initialiser la variable pour le succès

// Traitement du formulaire
if (isset($_POST["submit"])) {
    // Récupérer les informations du formulaire
    $admin_uuid = $_POST['admin_uuid'] ?? null;
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;
    $address = $_POST['address'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    
    // Vérification pour la mise à jour de la photo
    if (isset($_FILES['new_photo']) && $_FILES['new_photo']['error'] == 0) {
        // Définir le dossier où stocker les images
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES['new_photo']['name']);
        
        // Vérifier l'extension de l'image (vous pouvez ajouter d'autres extensions si nécessaire)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            // Déplacer l'image téléchargée vers le dossier de destination
            if (move_uploaded_file($_FILES['new_photo']['tmp_name'], $target_file)) {
                // Mettre à jour le nom du fichier de la photo dans la base de données
                $photo = basename($_FILES['new_photo']['name']);
            } else {
                $photo = null;
                $erreur = "Erreur lors du téléchargement de la photo.";
            }
        } else {
            $photo = null;
            $erreur = "L'extension de la photo est invalide. Seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
        }
    } else {
        $photo = null; // Pas de photo téléchargée
    }

    // Mettre à jour les informations de l'utilisateur dans la base de données
    if ($erreur == "") { // Si aucune erreur, on effectue la mise à jour
        // Préparation de la requête de mise à jour
        $update_query = "UPDATE admin_users SET ";
        $params = [];

        // Ajouter les champs à mettre à jour en fonction des valeurs modifiées
        if (!empty($username)) {
            $update_query .= "username = ?, ";
            $params[] = $username;
        }

        if (!empty($email)) {
            $update_query .= "email = ?, ";
            $params[] = $email;
        }

        if (!empty($address)) {
            $update_query .= "address = ?, ";
            $params[] = $address;
        }

        if (!empty($phone_number)) {
            $update_query .= "phone_number = ?, ";
            $params[] = $phone_number;
        }

        if ($photo) {
            $update_query .= "photo = ?, ";
            $params[] = $photo;
        }

        // Supprimer la dernière virgule de la requête SQL
        $update_query = rtrim($update_query, ', ');

        // Ajouter la condition WHERE
        $update_query .= " WHERE admin_uuid = ?";
        $params[] = $admin_uuid;

        // Exécuter la requête de mise à jour
        $stmt = $connexion->prepare($update_query);
        
        // Vérifier l'exécution de la requête
        if ($stmt->execute($params)) {
            // Si la mise à jour a réussi
            $success = "Profil mis à jour avec succès!";
        } else {
            // Si l'exécution échoue
            $erreur = "Une erreur est survenue lors de la mise à jour. Veuillez réessayer.";
        }
    }
}
?>
