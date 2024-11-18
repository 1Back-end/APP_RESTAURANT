<?php
include_once("database/connexion.php"); // Inclut la connexion PDO

// Variables pour les messages
$erreur_champ = "";
$erreur = "";
$success = "";

// Vérification si le formulaire est soumis
if (isset($_POST["submit"])) {
    // Récupération des données du formulaire
    $commentaire = $_POST['commentaire'] ?? null;

    // Validation des champs
    if (empty($commentaire)) {
        $erreur_champ = "Ce champ est requis !";
    } else {
        // Génération de l'UUID
        $uuid = bin2hex(random_bytes(16));

        try {
            // Insertion dans la base de données
            $sql = "INSERT INTO commentaires (uuid, commentaire, created_at, updated_at, is_deleted)
                    VALUES (:uuid, :commentaire, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, FALSE)";

            $stmt = $connexion->prepare($sql);
            $stmt->execute([
                ':uuid' => $uuid,
                ':commentaire' => $commentaire,
            ]);

            $success = "Commentaire ajouté avec succès.";
        } catch (PDOException $e) {
            $erreur = "Erreur lors de l'enregistrement du commentaire : " . $e->getMessage();
        }
    }
}
?>