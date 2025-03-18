<?php
// Paramètres de connexion
$host = 'localhost';
$dbname = 'app_restaurant_system';
$username = 'root';
$password = '';

try {
    // Créer une nouvelle instance de connexion
    $connexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configurer connexion pour afficher les erreurs sous forme d'exceptions
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connexion réussie à la base de données!";
} catch (connexionException $e) {
    // En cas d'erreur de connexion, afficher un message d'erreur
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
