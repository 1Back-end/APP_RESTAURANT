<?php
session_start();
session_unset(); // Supprimer toutes les variables de session
session_destroy(); // Détruire la session

// Rediriger vers la page d'accueil ou la page de connexion
header("Location: ../index.php");
exit();
