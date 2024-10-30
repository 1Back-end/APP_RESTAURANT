<?php include ('menu.php');?>
<?php include('fonction.php');?>

<?php

// Récupérer les livraisons de l'utilisateur
$deliveries = getDeliveries($connexion, $user_uuid);
?>


<div class="main-container mt-3 pb-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h6 class="text-uppercase font-16">
                        Mes commandes (<?= count($deliveries); ?>)
                    </h6>
                </div>
                <div class="ml-auto">
                    <h6 class="font-16"><?php echo $today; ?></h6>       
                </div>
            </div>
        </div>
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
                            <th>Action</th>
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
                                                <span class="badge badge-warning text-white">En Attente</span>
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
                                        <a href="view_order.php?pay_order.php?order_uuid=<?= htmlspecialchars($delivery['order_uuid']); ?>" class="btn btn-success btn-sm btn-xs">
                                            <i class="fas fa-credit-card mr-1"></i> Payé
                                        </a>
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