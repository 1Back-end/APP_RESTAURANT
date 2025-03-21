<?php include ('menu.php');?>
<?php include('fonction.php');?>

<?php

// Récupérer les livraisons de l'utilisateur
$deliveries = getDeliveries($connexion, $user_uuid);
?>
<?php
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_uuid']) || !isset($_SESSION['user_name'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../users/login.php");
    exit();
}
?>



<div class="main-container mt-3 pb-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box p-3">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <div class="mb-2 mb-md-0 mr-md-auto w-100">
                    <h6 class="text-uppercase font-14">
                        Mes commandes (<?= count($deliveries); ?>)
                    </h6>
                </div>
                
            </div>
        </div>
    </div>
<div class="col-md-12 col-sm-12 mb-3">
<?php
if (isset($_GET['status']) && isset($_GET['message'])) {
    $status = htmlspecialchars($_GET['status']);
    $message = htmlspecialchars($_GET['message']);
    $alertType = $status === 'success' ? 'alert-success' : 'alert-danger';

    echo "<div class='alert text-center $alertType' role='alert'>$message</div>";
}
?>

</div>

    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box p-3">
            <div class="table-responsive">
                <table id="commandeTable" class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date Commande</th>
                            <th>Livreur</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php if (count($deliveries) > 0): ?>
        <?php foreach ($deliveries as $index => $delivery): ?>
            <tr>
                <td><?= $index + 1; ?></td>
                <td><?= htmlspecialchars((new DateTime($delivery['order_date']))->format('d/m/Y H:i')); ?></td>
                <td>
                    <?php if (!empty($delivery['firstname']) || !empty($delivery['lastname'])): ?>
                        <?= htmlspecialchars($delivery['firstname'] . ' ' . $delivery['lastname']); ?>
                    <?php else: ?>
                        Aucun livreur
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($delivery['total_amount']); ?> FCFA</td>
                <td>
                    <?php if ($delivery['delivery_status'] === 'pending'): ?>
                        <span class="badge badge-warning text-white">En attente</span>
                    <?php elseif ($delivery['delivery_status'] === 'Canceled'): ?>
                        <span class="badge badge-danger">Annulé</span>
                    <?php elseif ($delivery['delivery_status'] === 'Delivered'): ?>
                        <span class="badge badge-success">Livré</span>
                    <?php elseif ($delivery['delivery_status'] === 'in_progress'): ?> <!-- Modifié le statut "en cours" -->
                        <span class="badge badge-info">En Cours</span>
                    <?php elseif ($delivery['delivery_status'] === 'paid'): ?> <!-- Ajout du statut "Payé" -->
                        <span class="badge badge-primary">Payé</span>
                    <?php else: ?>
                        <span class="badge badge-light">Inconnu</span>
                    <?php endif; ?>
                </td>

                <td>
    <div class="d-flex align-items-center justify-content-center">
        <div class="dropdown">
            <button class="btn btn-customize text-white btn-rounded dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-cogs mr-2"></i> Actions
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <!-- Détails -->
                <li>
                    <a href="info_order.php?order_uuid=<?= htmlspecialchars($delivery['order_uuid']); ?>" class="dropdown-item text-info text-white">
                        <i class="fas fa-info-circle mr-2"></i> Détails
                    </a>
                </li>

                <?php if (empty($delivery['firstname']) || empty($delivery['lastname'])): ?>
                    <!-- Si pas de livreur -->
                    <li><span class="dropdown-item disabled"> <i class="fas fa-times mr-2"></i> Paiement indisponible</span></li>
                <?php elseif ($delivery['delivery_status'] === 'pending' || $delivery['delivery_status'] === 'Canceled' || $delivery['delivery_status'] === 'in_progress'): ?>
                    <!-- Si la commande est en attente, annulée, ou en cours -->
                    <?php if ($delivery['delivery_status'] !== 'paid'): ?>
                        <li>
                            <a href="pay_order.php?order_uuid=<?= htmlspecialchars($delivery['order_uuid']); ?>" class="dropdown-item text-success">
                                <i class="fas fa-credit-card mr-2"></i> Payé
                            </a>
                        </li>
                    <?php else: ?>
                        <!-- Si la commande a déjà été payée -->
                        <li><span class="dropdown-item disabled text-muted"> <i class="fas fa-check-circle mr-2"></i> Commande déjà payée</span></li>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Si la commande n'est ni en attente, annulée, ni en cours -->
                    <li><span class="dropdown-item disabled text-muted"> <i class="fas fa-times mr-2"></i> Paiement indisponible</span></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</td>


            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="10">Aucune commande trouvée</td>
        </tr>
    <?php endif; ?>
</tbody>

                </table>
            </div>
        </div>
    </div>
</div>
