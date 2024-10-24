<?php
include_once("database/connexion.php"); // Assurez-vous d'utiliser une connexion PDO


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
            meals.description,
            meal_categories.name AS category_name,
            admin_users.username AS added_by
        FROM meals
        JOIN meal_categories ON meals.category_uuid = meal_categories.category_uuid
        JOIN admin_users ON meals.added_by = admin_users.admin_uuid
        WHERE meals.is_deleted = 0 AND meals.available = 1
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