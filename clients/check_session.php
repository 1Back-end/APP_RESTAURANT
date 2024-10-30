<?php
session_start(); // Démarre la session

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_uuid']) || !isset($_SESSION['user_name'])) {
    // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
    header('Location: ../users/login.php'); // Remplacez "login.php" par l'URL de votre page de connexion
    exit; // Arrête l'exécution du script après la redirection
}
?>
