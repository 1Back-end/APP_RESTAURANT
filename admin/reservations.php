<?php
include_once('../fonction/fonction.php');
include_once('../include/menu.php');

// Obtenir la page actuelle
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = $page > 0 ? $page : 1; // Assurer que la page est au moins 1

// Récupérer les données
$reservationData = get_reservation($connexion, 10, $page); // Limite de 10 par page
$reservations = $reservationData['reservations'];
$totalPages = $reservationData['total_pages'];
$currentPage = $reservationData['current_page'];
?>

<div class="main-container mt-3 pb-3">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box p-3 text-center">
            <div class="text-center">
                <h6 class="text-uppercase font-16">Liste des réservations (<?php echo $total_reservations;?>)</h6>
            </div>
        </div>
        </div>

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3">
    <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Téléphone</th>
                        <th>Date</th>
                        <th>Personnes</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reservations)): ?>
                        <?php foreach ($reservations as $index => $reservation): ?>
                            <tr>
                                <td><?php echo ($index + 1); ?></td>
                                <td><?= htmlspecialchars($reservation['customer_name']) ?></td>
                                <td><?= htmlspecialchars($reservation['customer_phone']) ?></td>
                                <td><?= htmlspecialchars($reservation['reservation_date']) ?></td>
                                <td><?= htmlspecialchars($reservation['number_of_people']) ?></td>
                                <td>
                                    <?php if ($reservation['status'] == 'pending'): ?>
                                        <span class="badge badge-warning text-white disabled"><i class="fa fa-clock"></i> En attente</span>
                                    <?php elseif ($reservation['status'] == 'confirmed'): ?>
                                        <span class="badge badge-success text-white disabled"><i class="fa fa-check"></i> Confirmé</span>
                                    <?php elseif ($reservation['status'] == 'canceled'): ?>
                                        <span class="badge badge-danger text-white disabled"><i class="fa fa-times"></i> Annulé</span>
                                    <?php elseif ($reservation['status'] == 'completed'): ?>
                                        <span class="badge badge-primary text-white disabled"><i class="fa fa-check-circle"></i> Complété</span>
                                    <?php endif; ?>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Aucune réservation trouvée</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Précédent</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Suivant</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    </div>
</div>
</div>
