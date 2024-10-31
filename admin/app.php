<?php
include_once("database/connexion.php"); // Assurez-vous d'utiliser une connexion PDO

try {
    // Vérifie si le formulaire a été soumis
    if (isset($_POST["submit"])) {
        // Préparation de la requête
        $stmt = $connexion->prepare("INSERT INTO contacts (nom, prenom, age, telephone, profession, email) VALUES (:nom, :prenom, :age, :telephone, :profession, :email)");

        // Récupère les données du formulaire
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $age = $_POST["age"];
        $telephone = $_POST["telephone"];
        $profession = $_POST["profession"];
        $email = $_POST["email"];

        // Exécution de la requête avec les données du formulaire
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':age' => $age,
            ':telephone' => $telephone,
            ':profession' => $profession,
            ':email' => $email
        ]);

        echo "Contact ajouté avec succès.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Ajouter un Contact</title>
</head>
<body>
    <div class="container mt-4">
        <h1>Ajouter un Contact</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" name="nom" class="form-control" id="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" name="prenom" class="form-control" id="prenom" required>
            </div>
            <div class="form-group">
                <label for="age">Âge:</label>
                <input type="number" name="age" class="form-control" id="age" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone:</label>
                <input type="text" name="telephone" class="form-control" id="telephone" required>
            </div>
            <div class="form-group">
                <label for="profession">Profession:</label>
                <input type="text" name="profession" class="form-control" id="profession" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
        </form>
        <a href="index2.php" class="btn btn-secondary mt-3">Retour</a>
    </div>
</body>
</html>
