<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<div class="main-container mt-3 pb-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box p-3 text-center">
            <div class="text-center">
                <h6 class="text-uppercase font-18">Liste des commandes payées</h6>
            </div>
        </div>
    
    </div>

    <?php
// Initialisation de la page et du nombre d'éléments par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Nombre d'éléments par page

// Appel de la fonction pour obtenir tous les paiements
$payments = getAllPayments($page, $limit);

// Calcul du nombre total de paiements pour la pagination
$totalPayments = getTotalPayments();
$totalPages = ceil($totalPayments / $limit);
?>

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Numéro Commande</th>
                        <th>Montant</th>
                        <th>Méthode</th>
                        <th>Statut</th>
                        <th>Date Paiement</th>
                        <th>Client</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($payments) > 0): ?>
                        <?php foreach ($payments as $index => $payment): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($payment['num_order']) ?></td>
                                <td><?= number_format(round($payment['amount'], -2), 0) ?> FCFA</td>

                                <td><?= htmlspecialchars($payment['payment_method']) ?></td>
                                <td>
                                    <?php 
                                        if ($payment['payment_status'] == 'payé') {
                                            echo '<span class="badge badge-success">Payé</span>';
                                        } elseif ($payment['payment_status'] == 'échec') {
                                            echo '<span class="badge badge-danger">Échoué</span>';
                                        } else {
                                            echo '<span class="badge badge-warning">' . htmlspecialchars($payment['payment_status']) . '</span>';
                                        }
                                    ?>
                                </td>
                                <td><?= date('d-m-Y H:i', strtotime($payment['payment_date'])) ?></td>
                                <td><?= htmlspecialchars($payment['username']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Aucun élément trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="col-md-12">
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
