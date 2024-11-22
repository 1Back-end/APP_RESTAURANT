<?php
include_once("../database/connexion.php"); // Assurez-vous d'utiliser une connexion PDO


function getCurrentDateTime() {
    return date("d/m/Y H:i:s"); // Renvoie la date et l'heure actuelles au format "AAAA-MM-JJ HH:MM:SS"
}
$today = getCurrentDateTime();

$user_uuid = $_SESSION['user_uuid'];
function getDeliveries($connexion, $user_uuid) {
    $query = "
        SELECT 
            d.delivery_uuid,
            d.delivery_status,
            d.delivery_time,
            o.order_uuid,  -- Ajouté pour référencer l'UUID de la commande
            o.order_date,
            o.status as delivery_status,
            o.total_amount,
            u.firstname,
            u.lastname
        FROM 
            orders o
        LEFT JOIN 
            deliveries d ON d.order_uuid = o.order_uuid
        LEFT JOIN 
            delivery_agents u ON d.agent_uuid = u.agent_uuid 
        WHERE 
            o.is_deleted = 0 AND
            o.user_uuid = :user_uuid ORDER BY o.order_date DESC
    ";

    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':user_uuid', $user_uuid);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function get_info_users($connexion,$user_uuid){
    $query = "SELECT * FROM users WHERE user_uuid = :user_uuid";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':user_uuid', $user_uuid);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_count_payments_by_user_uuid($connexion,$user_uuid){
    $query = "SELECT COUNT(*)  as payment FROM payments where added_by = :user_uuid";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':user_uuid', $user_uuid);
    $stmt->execute();
    return $stmt->fetchColumn();
    
}
$total_payment_by_user_uuid = get_count_payments_by_user_uuid($connexion,$user_uuid);


function get_all_payments_by_user_uuid($connexion, $user_uuid) {
    $query = "
        SELECT 
            p.payment_uuid, p.added_by, p.amount, p.payment_method, p.payment_status, 
            p.num_payments, p.payment_date, o.num_order, o.order_uuid, o.order_date, 
            u.user_uuid
        FROM 
            payments p
        INNER JOIN 
            orders o ON p.order_uuid = o.order_uuid
        INNER JOIN 
            users u ON p.added_by = u.user_uuid
        WHERE 
            p.added_by = :user_uuid 
        ORDER BY 
            p.payment_date DESC
    ";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':user_uuid', $user_uuid);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourner un tableau associatif
}
$all_payments_by_user_uuid = get_all_payments_by_user_uuid($connexion, $user_uuid);

?>
