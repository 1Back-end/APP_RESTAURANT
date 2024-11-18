<?php
ob_start(); // Démarrer le tampon de sortie

// Inclusion du fichier de connexion à la base de données
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
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES['new_photo']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES['new_photo']['tmp_name'], $target_file)) {
                $photo = basename($_FILES['new_photo']['name']);
            } else {
                $photo = null;
                $erreur = "Erreur lors du téléchargement de la photo.";
            }
        } else {
            $photo = null;
            $erreur = "L'extension de la photo est invalide.";
        }
    } else {
        $photo = null;
    }

    // Mettre à jour les informations si aucune erreur
    if ($erreur == "") {
        $update_query = "UPDATE admin_users SET ";
        $params = [];

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

        $update_query = rtrim($update_query, ', ');
        $update_query .= " WHERE admin_uuid = ?";
        $params[] = $admin_uuid;

        $stmt = $connexion->prepare($update_query);
        if ($stmt->execute($params)) {
            $success ="Profil mis à jour";
        } else {
            // Redirection après erreur
           $erreur = "Erreur lors de la mise à jour du profil";
        }
    }
}

ob_end_flush(); // Libérer le tampon
?>
