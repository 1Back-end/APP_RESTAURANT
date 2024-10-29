<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<div class="main-container mt-3 pb-5">

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box text-center text-uppercase p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h3 class="text-uppercase">Liste des commandes</h3>
            </div>
            <div class="ml-auto">
                <div class="form-inline">
                    <input type="text" class="form-control shadow-none mr-2" id="searchLivreur" placeholder="Rechercher une commande...">
                    <button type="button" class="btn btn-customize text-white shadow-none" onclick="rechercherLivreur()">
                        Rechercher
                    </button>
                </div>
            </div>
        </div>
    </div>
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
            <?php
            // Vérifier si des commandes existent
            if (!empty($orders)): ?>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
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
                                <td><?= htmlspecialchars($order['username']); ?></td>
                                <td><?= htmlspecialchars($order['order_date']); ?></td>
                                <td><?= htmlspecialchars($order['total_amount']); ?> FCFA</td>
                                <td>
                                    <?php if ($order['status'] === 'pending'): ?>
                                        <span class="badge badge-warning text-white">En Attente</span>
                                    <?php elseif ($order['status'] === 'Canceled'): ?>
                                        <span class="badge badge-danger">Annulé</span>
                                    <?php elseif ($order['status'] === 'Delivered'): ?>
                                        <span class="badge badge-success">Livré</span>
                                    <?php else: ?>
                                        <span class="badge badge-light">Inconnu</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?= htmlspecialchars($order['order_uuid']); ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= htmlspecialchars($order['order_uuid']); ?>">
                                            <a class="dropdown-item text-success" href="details_commande.php?order_id=<?= htmlspecialchars($order['order_uuid']); ?>">
                                                <i class="fas fa-eye"></i> Voir Détails
                                            </a>
                                            <a class="dropdown-item text-warning text-white" href="cancel.php?order_id=<?= htmlspecialchars($order['order_uuid']); ?>">
                                                <i class="fas fa-ban"></i> Annuler
                                            </a>
                                            <a class="dropdown-item text-danger" href="delete.php?order_id=<?= htmlspecialchars($order['order_uuid']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');">
                                                <i class="fas fa-trash-alt"></i> Supprimer
                                            </a>
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
