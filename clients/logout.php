<?php
session_start(); // Démarre la session

// Détruire toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou la page d'accueil
header('Location: ../menu.php'); // Changez ceci pour la page appropriée
exit; // Arrête l'exécution du script
?>
