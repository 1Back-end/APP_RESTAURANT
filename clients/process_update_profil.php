<?php
include_once("../database/connexion.php"); // Assurez-vous d'utiliser une connexion PDO

$erreur = '';
$succes = '';
$userData = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $user_uuid = $_POST['user_uuid'];

    // Validation des données
    if (empty($nom) || empty($email)) {
        $erreur = 'Le nom et l\'email sont obligatoires.';
    } else {
        try {
            $query = "UPDATE users SET username = :nom, email = :email, address = :adresse, phone_number = :telephone WHERE user_uuid = :user_uuid";
            $stmt = $connexion->prepare($query);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':user_uuid', $user_uuid);

            if ($stmt->execute()) {
                $succes = 'Profil mis à jour avec succès.';

                // Mettez à jour la session avec le nouveau nom
                $_SESSION['user_name'] = $nom;

                // Récupération des informations mises à jour
                $query = "SELECT username, email, address, phone_number FROM users WHERE user_uuid = :user_uuid";
                $stmt = $connexion->prepare($query);
                $stmt->bindParam(':user_uuid', $user_uuid);
                $stmt->execute();
                $userData = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $erreur = 'Une erreur est survenue lors de la mise à jour du profil.';
            }
        } catch (PDOException $e) {
            $erreur = 'Erreur de base de données : ' . $e->getMessage();
        }
    }
}
?>
