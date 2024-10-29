<?php

include_once("../database/connexion.php"); // Assurez-vous d'utiliser une connexion PDO


function get_category_meals($connexion, $currentPage = 1, $itemsPerPage = 3) {
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
function get_categories($connexion) {
    $query = "SELECT * FROM meal_categories WHERE is_deleted = 0"; // Récupérer les catégories non supprimées
    $stmt = $connexion->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourner les résultats sous forme de tableau associatif
}

// Récupérer les catégories
$categories = get_categories($connexion);


function getMealsWithPagination($page = 1, $limit = 10) {
    global $connexion;

    $offset = ($page - 1) * $limit;

    // Requête SQL pour récupérer les repas qui ne sont pas supprimés (is_deleted = 0) avec jointures
    $query = "
        SELECT 
            meals.meal_uuid,
            meals.name AS meal_name,
            meals.price,
            meals.added_at,
            meals.image,  -- Inclure le champ image
            meals.available,
            meal_categories.name AS category_name,
            admin_users.username AS added_by
        FROM meals
        JOIN meal_categories ON meals.category_uuid = meal_categories.category_uuid
        JOIN admin_users ON meals.added_by = admin_users.admin_uuid
        WHERE meals.is_deleted = 0
        ORDER BY meals.created_at DESC
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countMeals() {
    global $connexion;

    $query = "SELECT COUNT(*) as total FROM meals WHERE is_deleted = 0";
    $stmt = $connexion->prepare($query);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

function get_agency_delivery($connexion, $limit, $offset) {
    $query = "SELECT * FROM delivery_agents WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
    $stmt = $connexion->prepare($query);
    
    // Liaison des valeurs pour la pagination
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function count_agency_delivery($connexion) {
    $query = "SELECT COUNT(*) FROM delivery_agents WHERE is_deleted = 0";
    $stmt = $connexion->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
function search_delivery_agents($connexion, $searchTerm) {
    $query = "SELECT * FROM delivery_agents WHERE is_deleted = 0 
              AND (firstname LIKE :searchTerm OR 
                   lastname LIKE :searchTerm OR 
                   phone LIKE :searchTerm OR 
                   cni_number LIKE :searchTerm) 
              ORDER BY created_at DESC";

    $stmt = $connexion->prepare($query);
    $stmt->execute([':searchTerm' => '%' . $searchTerm . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_count_meals($connexion){
    $query = "SELECT COUNT(*) as total FROM meals WHERE is_deleted = 0";
    $stmt = $connexion->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
$total_meals = get_count_meals($connexion);


function get_count_meals_categories($connexion){
    $query = "SELECT COUNT(*) as total FROM meal_categories WHERE is_deleted = 0";
    $stmt = $connexion->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
$total_category = get_count_meals_categories($connexion);

function get_count_delivery($connexion){
    $query = "SELECT COUNT(*) as total FROM delivery_agents WHERE is_deleted = 0";
    $stmt = $connexion->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
$total_delivery = get_count_delivery($connexion);


function get_count_customer($connexion){
    $query = "SELECT COUNT(*) as total FROM users WHERE is_deleted = 0";
    $stmt = $connexion->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}
$total_customer = get_count_customer($connexion);


function get_orders_with_usernames($connexion, $offset, $limit) {
    // Préparer la requête pour récupérer toutes les commandes avec les noms d'utilisateur
    $stmt = $connexion->prepare("
        SELECT o.order_uuid , o.user_uuid , o.order_date, o.total_amount, o.status, u.username
        FROM orders o
        JOIN users u ON o.user_uuid = u.user_uuid ORDER BY o.order_date DESC
        LIMIT :limit OFFSET :offset 
    ");

    // Lier les paramètres de pagination
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    
    // Exécuter la requête
    $stmt->execute();
    
    // Récupérer toutes les commandes
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function count_total_orders($connexion) {
    $stmt = $connexion->prepare("SELECT COUNT(*) FROM orders");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function get_order_pending($connexion) {
    // Récupérer les commandes en attente
    $query = "SELECT o.order_uuid, o.order_date, o.total_amount, u.username 
              FROM orders o
              JOIN users u ON o.user_uuid = u.user_uuid
              WHERE o.status = 'pending' 
              ORDER BY o.order_date DESC"; // Vous pouvez ajouter la pagination ici si nécessaire
              
    $stmt = $connexion->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourner les résultats
}
function getDeliveries($connexion) {
    $query = "
        SELECT 
            d.delivery_uuid,
            d.delivery_status,
            d.delivery_time,
            o.order_date,
            o.total_amount,
            u.firstname,
            u.lastname
        FROM 
            deliveries d
        JOIN 
            orders o ON d.order_uuid = o.order_uuid
        JOIN 
            delivery_agents u ON d.agent_uuid = u.agent_uuid 
        WHERE 
            d.is_deleted = 0
    ";

    $stmt = $connexion->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Appel de la fonction pour récupérer les livraisons
$deliveries = getDeliveries($connexion);


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
// function generateAgentCode() {
//     // Obtient la date et l'heure actuelles pour le code
//     $dateTime = date('YmdHis'); // Format : AAAAMMJJHHMMSS
    
//     // Génère une partie aléatoire de 4 chiffres
//     $randomPart = rand(1000, 9999); // Génère un nombre aléatoire entre 1000 et 9999
    
//     // Construit le code unique de livreur
//     return 'AGT-' . $dateTime . '-' . $randomPart; // Exemple : AGT-20231025123000-1234
// }

function generateAvailabilityOptions($selectedValue = null) {
    $options = [
        '24h/24',
        '12h/24',
        '8h/24',
        '6h/24',
        '4h/24',
        '2h/24',
        '1h/24',
    ];
    
    $output = '';
    foreach ($options as $option) {
        $selected = ($option === $selectedValue) ? 'selected' : '';
        $output .= "<option value=\"{$option}\" {$selected}>{$option}</option>";
    }
    return $output;
}
function generateAgentCode() {
    // Récupérer l'année actuelle
    $year = date('Y'); // Obtenir l'année en cours (ex: 2024)
    
    // Générer un nombre aléatoire à deux chiffres
    $randomNumber = mt_rand(0, 99); // Générer un nombre aléatoire entre 0 et 99
    $formattedRandomNumber = str_pad($randomNumber, 2, '0', STR_PAD_LEFT); // Formater le nombre pour qu'il ait toujours deux chiffres
    
    // Combiner le préfixe, l'année, et le nombre aléatoire
    $AgencyCode = 'AGT-' . $year . $formattedRandomNumber;
    
    return $AgencyCode;
}

