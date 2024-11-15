<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>
<style>
    input[type="datetime-local"]{
    font-family: "Rubik", system-ui;
    font-size: 12px;
}
</style>

<div class="main-container mt-3 pb-5">

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box text-center text-uppercase p-2 d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="mr-auto mb-3">
                <h6 class="text-uppercase">Liste des commandes (<?php echo $total_orders;?>)</h6>
            </div>
            <div class="ml-auto mb-3">
                <div class="form-inline">
                    <input type="text" class="form-control shadow-none mr-2" id="searchLivreur" placeholder="Rechercher une commande...">
                    <button type="button" class="btn btn-customize text-white shadow-none" onclick="rechercherLivreur()">
                        Rechercher
                    </button>
                </div>
            </div>
        </div>
</div>
<div class="col-md-12 col-sm-12 mb-3">
<?php
if (isset($_GET['success']) && !empty($_GET['success'])) {
    echo '<div class="alert alert-success text-center">' . htmlspecialchars($_GET['success']) . '</div>';
}

if (isset($_GET['error']) && !empty($_GET['error'])) {
    echo '<div class="alert alert-danger text-center">' . htmlspecialchars($_GET['error']) . '</div>';
}
?>

</div>
<?php
// Inclure votre fichier de connexion à la base de données
include_once("../database/connexion.php");

// Définir le nombre d'ordres par page
$ordersPerPage = 10; // Par exemple, vous pouvez définir cela à 10

// Récupérer le nombre total de commandes
$totalOrders = count_total_orders($connexion);

// Éviter la division par zéro
if ($ordersPerPage > 0) {
    $totalPages = ceil($totalOrders / $ordersPerPage);
} else {
    $totalPages = 1; // Définit le nombre de pages à 1 si $ordersPerPage est 0
}

// Calculer l'offset pour la pagination
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages)); // S'assurer que la page actuelle est valide
$offset = ($currentPage - 1) * $ordersPerPage;

// Récupérer les commandes avec pagination
$orders = get_orders_with_usernames($connexion, $offset, $ordersPerPage);
?>

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3">
        <div class="table-responsive">
            <?php
            // Vérifier si des commandes existent
            if (!empty($orders)): ?>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>N° Commande</th>
                            <th>Client</th>
                            <th>Date de Commande</th>
                            <th>Montant Total</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $index => $order): ?>
                            <tr>
                                <td><?php echo ($offset + $index + 1); ?></td>
                                <td><?= htmlspecialchars($order['num_order']); ?></td>
                                <td><?= htmlspecialchars($order['username']); ?></td>
                                <td><?= date('d/m/Y H:i:s',strtotime($order['order_date'])); ?></td>
                                <td><?= htmlspecialchars($order['total_amount']); ?> FCFA</td>
                                <td>
                                            <?php if ($order['status'] === 'pending'): ?>
                                                <span class="badge badge-warning text-white disabled">En attente</span>
                                            <?php elseif ($order['status'] === 'Canceled'): ?>
                                                <span class="badge badge-danger disabled">Annulée</span>
                                            <?php elseif ($order['status'] === 'Delivered'): ?>
                                                <span class="badge badge-success disabled">Livrée</span>
                                            <?php elseif ($order['status'] === 'in_progress'): ?> <!-- Modifié le statut "en cours" -->
                                                <span class="badge badge-info disabled">En cours</span>
                                            <?php elseif ($order['status'] === 'paid'): ?> <!-- Ajout du statut "Payé" -->
                                                <span class="badge badge-primary disabled">Payé</span>
                                            <?php else: ?>
                                                <span class="badge badge-light disabled">Inconnu</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                        <div class="dropdown">
                                            <button class="btn btn-customize text-white btn-rounded btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?= htmlspecialchars($order['order_uuid']); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= htmlspecialchars($order['order_uuid']); ?>">
                                                <a class="dropdown-item text-info" href="details_commande.php?order_id=<?= htmlspecialchars($order['order_uuid']); ?>">
                                                    <i class="fas fa-eye"></i> Détails
                                                </a>
                                                <?php if ($order["status"] === 'Canceled'): ?>
                                                    <a class="dropdown-item text-secondary disabled" href="cancel_order.php?order_id=<?= htmlspecialchars($order['order_uuid']); ?>">
                                                        <i class="fas fa-check-circle"></i> Commande annulée
                                                    </a>
                                                <?php elseif ($order["status"] === 'paid'): ?>
                                                    <a class="dropdown-item text-secondary disabled" href="cancel_order.php?order_id=<?= htmlspecialchars($order['order_uuid']); ?>">
                                                        <i class="fas fa-check-circle"></i> Commande payée
                                                    </a>
                                                <?php else: ?>
                                                    <a class="dropdown-item text-warning" href="cancel_order.php?order_id=<?= htmlspecialchars($order['order_uuid']); ?>">
                                                        <i class="fas fa-ban"></i> Annuler
                                                    </a>
                                                <?php endif; ?>


                                                <a class="dropdown-item text-danger" href="delete_order.php?order_id=<?= htmlspecialchars($order['order_uuid']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">
                                                    <i class="fas fa-trash-alt"></i> Supprimer
                                                </a>
                                                <!-- Option pour affecter un livreur -->
                                                <?php if ($order['status'] === 'pending'): ?>
                                                    <a class="dropdown-item text-success" href="#" data-toggle="modal" data-target="#assignDeliveryModal" data-order="<?= htmlspecialchars($order['order_uuid']); ?>">
                                                        <i class="fas fa-share"></i> Affecter à un livreur
                                                    </a>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </td>



                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $currentPage - 1; ?>">Précédent</a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($i === $currentPage) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $currentPage + 1; ?>">Suivant</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">Aucune commande trouvée.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="assignDeliveryModal" tabindex="-1" role="dialog" aria-labelledby="assignDeliveryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignDeliveryModalLabel">Affecter un livreur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="assign_delivery.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="order_uuid" class="form-control" id="modalOrderUuid">
                    <div class="form-group">    
                        <select class="form-control form-control select-custom shadow-none" name="agent_uuid" id="agent_uuid" required>
                            <option value="" disabled selected>-- Choisissez un livreur --</option>
                            <?php foreach ($agents as $agent): ?>
                                <option value="<?= htmlspecialchars($agent['agent_uuid']); ?>">
                                    <?= htmlspecialchars($agent['firstname'] . ' ' . $agent['lastname']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="">Entrer la date de livraison</label>
                        <input type="date" name="delivery_time" class="form-control shadow-none">
                        
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm btn-xs" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-customize text-white btn-sm btn-xs">Affecter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.dropdown-item[data-target="#assignDeliveryModal"]').on('click', function() {
            var orderUuid = $(this).data('order');
            $('#modalOrderUuid').val(orderUuid);
        });
    });
</script>
