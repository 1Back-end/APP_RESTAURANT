
<?php
session_start(); // Démarre la session

if (isset($_GET['token'])) {
    $decoded = base64_decode($_GET['token']);
    list($user_uuid, $username) = explode(':', $decoded); // Récupère les données
    
    // Vérifiez si l'utilisateur est connecté (optionnel)
    if ($user_uuid !== $_SESSION['user_uuid'] || $username !== $_SESSION['user_name']) {
        header('Location: ../users/login.php'); // Redirige vers la page de connexion si non connecté
        exit;
    }

    // Votre code pour afficher le tableau de bord
} else {
    header('Location: ../users/login.php'); // Redirige vers la page de connexion si le token est manquant
    exit;
}
