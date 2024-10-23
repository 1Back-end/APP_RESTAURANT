<?php

include_once("../database/connexion.php"); // Assurez-vous d'utiliser une connexion PDO


function get_category_meals($connexion, $currentPage = 1, $itemsPerPage = 5) {
    // Calculer l'offset
    $offset = ($currentPage - 1) * $itemsPerPage;

    // Récupérer la liste des catégories de repas avec pagination
    $query = "SELECT * FROM meal_categories WHERE is_deleted = 0 LIMIT :offset, :itemsPerPage";
    $stmt = $connexion->prepare($query);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Compter le total des catégories pour la pagination
function get_category_count($connexion) {
    $query = "SELECT COUNT(*) as total FROM meal_categories WHERE is_deleted = 0";
    $result = $connexion->query($query);
    return $result->fetch(PDO::FETCH_ASSOC)['total'];
}


function generateUUID() {
    // Générer un UUID v4
    $data = random_bytes(16);
    // Modifier certains bits selon la spécification UUID
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant DCE 1.1
    return vsprintf('%s-%s-%s-%s-%s', str_split(bin2hex($data), 4));
}

function generateOrderReference() {
    // Générer un UUID pour garantir l'unicité
    $uuid = generateUUID();
    // Obtenir la date et l'heure actuelles pour la référence
    $dateTime = date('YmdHis'); // Format : AAAAMMJJHHMMSS
    // Combiner le tout pour créer une référence de commande unique
    return 'CMD-' . $dateTime . '-' . substr($uuid, 0, 8); // Exemple : CMD-20231022123000-123e4567
}

function generateDeliveryReference() {
    // Générer un UUID pour garantir l'unicité
    $uuid = generateUUID();
    // Obtenir la date et l'heure actuelles pour la référence
    $dateTime = date('YmdHis'); // Format : AAAAMMJJHHMMSS
    // Combiner le tout pour créer une référence de livraison unique
    return 'LIV-' . $dateTime . '-' . substr($uuid, 0, 8); // Exemple : LIV-20231022123000-123e4567
}

function generatePassword($length = 12) {
    // Définir les caractères utilisés dans le mot de passe
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+-=';
    // Initialiser une variable pour stocker le mot de passe généré
    $password = '';
    
    // Boucle pour construire le mot de passe
    for ($i = 0; $i < $length; $i++) {
        // Choisir un caractère aléatoire
        $password .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $password;
}

function generateCode($length = 4) {
    // Définir les caractères utilisables dans le code
    $characters = '0123456789'; // Chiffres et lettres majuscules
    $code = '';
    
    // Boucle pour construire le code
    for ($i = 0; $i < $length; $i++) {
        // Choisir un caractère aléatoire
        $code .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return $code;
}

// fonction.php

function getCurrentPageName() {
    // Récupérer le nom du fichier PHP actuel sans extension
    $pageName = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
    
    // Remplacer les soulignements par des espaces
    $pageName = str_replace('_', ' ', $pageName);
    
    // Capitaliser chaque mot
    $pageName = ucwords($pageName);
    
    return $pageName;
}

function getCurrentYear() {
    return date("Y"); // Renvoie l'année actuelle au format 4 chiffres (ex. 2024)
}

function getCurrentDateTime() {
    return date("d-m-Y H:i:s"); // Renvoie la date et l'heure actuelles au format "AAAA-MM-JJ HH:MM:SS"
}
function getCurrentDateTimeInFrench() {
    // Définir la locale en français
    setlocale(LC_TIME, 'fr_FR.UTF-8'); // Pour Linux/Mac
    // setlocale(LC_TIME, 'fr_FR'); // Pour Windows

    // Obtenir la date et l'heure actuelles
    return strftime("%A %d %B %Y, %H:%M:%S"); // Ex : "lundi 22 octobre 2024, 14:30:45"
}
