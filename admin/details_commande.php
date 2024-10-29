<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>
<?php
// Inclure votre fichier de connexion à la base de données
include_once("../database/connexion.php");

// Vérifier si order_id est passé dans l'URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Récupérer les détails de la commande et les repas associés
    $orderDetails = get_order_details($connexion, $order_id);
} else {
    // Gérer le cas où order_id n'est pas fourni
    die("ID de commande non fourni.");
}

// Fonction pour récupérer les détails de la commande
function get_order_details($connexion, $order_id) {
    $query = "SELECT o.order_uuid, o.user_uuid, o.order_date, o.total_amount, o.status,o.order_date,
                     m.meal_uuid, m.name, m.price, oi.quantity,m.image
              FROM orders o
              JOIN order_items oi ON o.order_uuid = oi.order_uuid
              JOIN meals m ON oi.meal_uuid = m.meal_uuid
              WHERE o.order_uuid = :order_id";

    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>


<div class="main-container mt-5 pb-5">
    <div class="card-box p-3">
    <?php if (!empty($orderDetails)): ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Repas</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Prix Total</th>
                    <th>Date Commande</th>
                    <th>Staut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $index =>$detail): ?>
                    <tr>
                        <td><?php echo ($index + 1); ?></td>
                        <td>
                        <div class="d-flex align-items-center">
                            <?php 
                            if (!empty($detail['image'])): 
                                $images = explode(',', $detail['image']);
                                $firstImage = $images[0]; 
                            ?>
                                <img src="../uploads/<?= htmlspecialchars($firstImage); ?>" alt="Image du repas" class='rounded-circle img-fluid me-2' width='50' height='50' style='object-fit: cover; width: 50px; height: 50px; max-width: 50px; max-height: 50px;'>
                            <?php else: ?>
                                <img src="uploads/default.jpg" alt="Aucune image disponible" class="img-fluid img-thumbnail me-2" style="width: 50px; height: auto;">
                            <?php endif; ?>
                            <div style="margin-left: 10px;"><?= htmlspecialchars($detail['name']); ?></div>
                        </div>
                    </td>


                        <td><?= htmlspecialchars($detail['quantity']); ?></td>
                        <td><?= htmlspecialchars($detail['price']); ?> FCFA</td>
                        <td><?= htmlspecialchars($detail['quantity'] * $detail['price']); ?> FCFA</td>
                        <td><?= htmlspecialchars($detail['order_date']); ?></td>
                        <td>
                                    <?php if ($detail['status'] === 'pending'): ?>
                                        <span class="badge badge-warning text-white">En Attente</span>
                                    <?php elseif ($detail['status'] === 'Canceled'): ?>
                                        <span class="badge badge-danger">Annulé</span>
                                    <?php elseif ($detail['status'] === 'Delivered'): ?>
                                        <span class="badge badge-success">Livré</span>
                                    <?php elseif ($detail['status'] === 'en cours'): ?> <!-- Ajout du statut "En cours" -->
                                        <span class="badge badge-info">En Cours</span>
                                    <?php else: ?>
                                        <span class="badge badge-light">Inconnu</span>
                                    <?php endif; ?>
                                </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="card-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h6 class="text-uppercase font-18">Montant Total : </h6>
                </div>
                <div class="ml-auto">
                    <h6><?= htmlspecialchars($orderDetails[0]['total_amount']); ?> FCFA</h6>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">Aucun détail de commande trouvé.</div>
    <?php endif; ?>
</div>

</div>