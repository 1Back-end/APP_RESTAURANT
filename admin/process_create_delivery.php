<?php
// session_start(); // Assurez-vous que la session est démarrée
include_once("../database/connexion.php"); // Connexion à la base de données
include_once("../fonction/fonction.php");
    
$erreur_champ = "";
$erreur = "";
$success = "";

if (isset($_POST['submit'])) {
    // Récupération des valeurs du formulaire
    $nom = $_POST['nom'] ?? null;
    $prenom = $_POST['prenom'] ?? null;
    $email = $_POST['email'] ?? null;
    $adresse = $_POST['adresse'] ?? null;
    $telephone = $_POST['telephone'] ?? null;
    $cni = $_POST['cni'] ?? null;
    $disponibilite = $_POST['disponibilite'] ?? null;

    // Gestion de l'upload d'image
    $max_image_size = 5242880; // 5MB
    $allowed_image_types = ['image/jpeg', 'image/png'];
    $photo = $_FILES['photo'] ?? null;
    $agent_uuid = generateUUID();
    $agent_code = generateAgentCode();
    $date_creation = date('Y-m-d H:i:s');
    $added_by = $_SESSION['admin_uuid'];

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($cni) || empty($disponibilite)) {
        $erreur_champ = "Tous les champs sont obligatoires";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Veuillez entrer une adresse email valide";
    } else {
        // Vérifier si l'email est déjà utilisé
        $stmt = $connexion->prepare("SELECT COUNT(*) FROM delivery_agents WHERE email = ?");
        $stmt->bindValue(1, $email);
        $stmt->execute();
        $email_exists = $stmt->fetchColumn() > 0;

        if ($email_exists) {
            $erreur = "L'email est déjà utilisé. Veuillez en choisir un autre.";
        } else {
            // Validation et traitement de l'image
            $photo_path = null;
            if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
                // Vérifier le type et la taille de l'image
                if (in_array($photo['type'], $allowed_image_types) && $photo['size'] <= $max_image_size) {
                    $photo_path = '../uploads/' . uniqid() . '-' . basename($photo['name']);
                    move_uploaded_file($photo['tmp_name'], $photo_path);
                } else {
                    $erreur = "La photo doit être au format PNG ou JPEG et ne pas dépasser 5 Mo.";
                }
            }

            // Enregistrer les informations dans la base de données
            $stmt = $connexion->prepare("
                INSERT INTO delivery_agents 
                (agent_uuid, agent_code, firstname, lastname, email, phone, cni_number, photo, availability_schedule, added_by) 
                VALUES (:agent_uuid, :agent_code, :firstname, :lastname, :email, :phone, :cni_number, :photo, :availability_schedule, :added_by)
            ");

            // Liaison des valeurs
            $stmt->bindValue(':agent_uuid', $agent_uuid);
            $stmt->bindValue(':agent_code', $agent_code);
            $stmt->bindValue(':firstname', $prenom);
            $stmt->bindValue(':lastname', $nom);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':phone', $telephone);
            $stmt->bindValue(':cni_number', $cni);
            $stmt->bindValue(':photo', $photo_path);
            $stmt->bindValue(':availability_schedule', $disponibilite); // Lier la disponibilité
            $stmt->bindValue(':added_by', $added_by); // Lier l'UUID de l'admin

            // Exécuter la requête
            if ($stmt->execute()) {
                $success = "Agent de livraison enregistré avec succès !";
                // header("Refresh:2; url=liste_livreurs.php");
                // exit; // Assurez-vous d'ajouter un exit après header
            } else {
                $erreur = "Erreur lors de l'enregistrement des données : " . implode(", ", $stmt->errorInfo());
            }
        }
    }
}
?>
