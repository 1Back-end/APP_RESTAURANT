<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<div class="main-container mt-3 pb-5">

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box text-center text-uppercase p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h3 class="text-uppercase">Liste des Livraisons</h3>
            </div>
            <div class="ml-auto">
                <div class="form-inline">
                    <input type="text" class="form-control shadow-none mr-2" id="searchLivreur" placeholder="Rechercher un livraison...">
                    <button type="button" class="btn btn-customize text-white shadow-none" onclick="rechercherLivreur()">
                        Rechercher
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 mb-3">
<?php if (!empty($_GET['erreur'])): ?>
    <div id="alert-error" class="alert alert-danger text-center">
        <?php echo htmlspecialchars($_GET['erreur']); ?>
    </div>
<?php endif; ?>

<?php if (!empty($_GET['succes'])): ?>
    <div id="alert-success" class="alert alert-success text-center">
        <?php echo htmlspecialchars($_GET['succes']); ?>
    </div>
<?php endif; ?>
</div>

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3">
        <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
    <thead>
        <tr>
            <th>#</th>
            <th>Date Commande</th>
            <th>Date Livraison</th>
            <th>Montant Total</th>
            <th>Livreur</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($deliveries as $index => $delivery): ?>
            <tr>
                <td><?php echo ($index + 1); ?></td>
                <td><?php echo date('d-m-Y H:i:s',strtotime($delivery['order_date'])); ?></td>
                <td><?php echo date('d-m-Y H:i:s',strtotime($delivery['delivery_time'])); ?></td>
                <td><?php echo htmlspecialchars($delivery['total_amount']); ?> FCFA</td>
                <td><?php echo htmlspecialchars($delivery['firstname'] . ' ' . $delivery['lastname']); ?></td>
                <td>
                    <?php if ($delivery['delivery_status'] == 'pending'): ?>
                        <span class="badge bg-warning text-white">
                            <i class="fas fa-clock"></i> En attente
                        </span>
                    <?php elseif ($delivery['delivery_status'] == 'in_progress'): ?>
                        <span class="badge bg-info text-white">
                            <i class="fas fa-truck"></i> En route
                        </span>
                    <?php elseif ($delivery['delivery_status'] == 'Delivered'): ?>
                        <span class="badge bg-success text-white">
                            <i class="fas fa-check-circle"></i> Livré
                        </span>
                    <?php else: ?>
                        <span class="badge bg-secondary text-white">
                            <i class="fas fa-question-circle"></i> Statut inconnu
                        </span>
                    <?php endif; ?>
            </td>

            <td>
            <div class="dropdown">
            <button class="btn btn-customize text-white btn-rounded dropdown-toggle btn-sm" type="button" id="dropdownMenuButton<?= $delivery['delivery_uuid']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $delivery['delivery_uuid']; ?>">
                <?php if ($delivery['delivery_status'] == 'pending'): ?>
                    <li>
                        <a class="dropdown-item text-warning" href="update_delivery_status.php?delivery_uuid=<?php echo htmlspecialchars($delivery['delivery_uuid']); ?>&delivery_status=in_progress">
                            <i class="fas fa-truck"></i> En route
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-success" href="update_delivery_status.php?delivery_uuid=<?php echo htmlspecialchars($delivery['delivery_uuid']); ?>&delivery_status=Delivered">
                            <i class="fas fa-check-circle"></i> Livré
                        </a>
                    </li>
                <?php elseif ($delivery['delivery_status'] == 'in_progress'): ?>
                    <li>
                        <a class="dropdown-item text-success" href="update_delivery_status.php?delivery_uuid=<?php echo htmlspecialchars($delivery['delivery_uuid']); ?>&delivery_status=Delivered">
                            <i class="fas fa-check-circle"></i> Livré
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <span class="dropdown-item text-muted disabled">
                            <i class="fas fa-times-circle"></i> Déjà livré
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        </td>  
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        </div>
    </div>
</div>
<!-- Affichage des livraisons dans un tableau -->
<script>
    // Disparition automatique des messages après 2 secondes
    setTimeout(function() {
        const errorAlert = document.getElementById('alert-error');
        const successAlert = document.getElementById('alert-success');
        
        if (errorAlert) errorAlert.style.display = 'none';
        if (successAlert) successAlert.style.display = 'none';
    }, 2000); // 2000 ms = 2 secondes
</script>