<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();

// Inclut les fichiers nécessaires pour la connexion à la base de données et les fonctions personnalisées
include_once("database/connexion.php");
include_once("fonction/fonction.php");

// Vérifie si les paramètres requis sont présents dans l'URL
if (isset($_GET['user_uuid'], $_GET['meal_uuid'], $_GET['quantity'], $_GET['price'])) {
    // Récupère les paramètres de l'URL et les assigne à des variables
    $user_uuid = $_GET['user_uuid'];
    $meal_uuid = $_GET['meal_uuid'];
    $quantity = (int)$_GET['quantity']; // Convertit la quantité en entier
    $price = (int)$_GET['price']; // Convertit le prix en entier

    // Initialise le panier dans la session s'il n'existe pas déjà
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Crée un tableau vide pour le panier
    }

    // Ajoute l'élément au panier
    $_SESSION['cart'][] = [
        'meal_uuid' => $meal_uuid, // UUID du repas
        'quantity' => $quantity, // Quantité du repas
        'price' => $price, // Prix unitaire du repas
        'subtotal' => $quantity * $price, // Sous-total calculé (quantité * prix)
    ];
    
    // Redirige l'utilisateur vers la page du menu avec un message de succès
    header('Location: menu.php?message=' . urlencode('Repas ajouté au panier !'));
    exit(); // Termine l'exécution du script
} else {
    // Redirige l'utilisateur vers le menu avec un message d'erreur si les données sont manquantes
    header('Location: menu.php?error=' . urlencode('Données manquantes.'));
    exit(); // Termine l'exécution du script
}
?>
