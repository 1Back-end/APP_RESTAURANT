<?php
ob_start(); // Start output buffering
include_once("../database/connexion.php"); // Ensure the use of PDO connection
include_once("../fonction/fonction.php");

$erreur_champ = "";
$erreur = "";
$success = "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    $address = $_POST['address'] ?? null;
    $admin_uuid = generateUUID();
    $password = generatePassword();
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Image upload parameters
    $max_image_size = 5242880; // 5MB
    $allowed_image_types = ['image/jpeg', 'image/png'];
    $photo = $_FILES['photo'] ?? null;

    if (empty($username) || empty($email) || empty($phone_number) || empty($address)) {
        $erreur_champ = "Tous les champs sont requis !";
    } else {
        // Check if email already exists
        $sqlCheck = "SELECT COUNT(*) FROM admin_users WHERE email = :email";
        $stmt = $connexion->prepare($sqlCheck);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $email_exists = $stmt->fetchColumn() > 0;

        if ($email_exists) {
            $erreur = "L'email est déjà utilisé. Veuillez en choisir un autre.";
        } else {
            // Image validation and processing
            $photo_path = null;
            if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
                if (in_array($photo['type'], $allowed_image_types) && $photo['size'] <= $max_image_size) {
                    $photo_path = '../uploads/' . uniqid() . '-' . basename($photo['name']);
                    move_uploaded_file($photo['tmp_name'], $photo_path);
                } else {
                    $erreur = "La photo doit être au format PNG ou JPEG et ne pas dépasser 5 Mo.";
                }
            }

            // Insert into database
            $stmt = $connexion->prepare("
                INSERT INTO admin_users (admin_uuid, username, email, password, photo, address, phone_number) 
                VALUES (:admin_uuid, :username, :email, :password, :photo, :address, :phone_number)
            ");
            $stmt->bindValue(':admin_uuid', $admin_uuid, PDO::PARAM_STR); // Removed extra space here
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':photo', $photo_path, PDO::PARAM_STR);
            $stmt->bindValue(':address', $address, PDO::PARAM_STR);
            $stmt->bindValue(':phone_number', $phone_number, PDO::PARAM_STR);

            // Execute the query
            if ($stmt->execute()) {
                $success = "Utilisateur enregistré avec succès !";
                // header("Refresh:2; url=liste_users.php");
               
            } else {
                $erreur = "Erreur lors de l'enregistrement des données : " . implode(", ", $stmt->errorInfo());
            }
        }
    }
}
ob_end_flush(); // Send the output at the end
?>
