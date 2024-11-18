<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<div class="main-container mt-3 pb-5">

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box text-center text-uppercase p-3">
        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between">
            <div class="mr-auto mb-3 mb-sm-0">
                <h5 class="text-uppercase">Liste des repas (<?php echo $total_meals; // Récupération du nombre de repas?>)</h5>
            </div>
            <div class="ml-auto d-flex flex-column flex-sm-row align-items-center">
                <div class="form-inline mb-3 mb-sm-0">
                    <input type="text" class="form-control shadow-none mr-2" id="searchRepas" placeholder="Rechercher un repas...">
                    <button type="button" class="btn btn-customize text-white shadow-none" onclick="rechercherRepas()">
                        Rechercher
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php
// Récupérer la page courante depuis l'URL ou définir à 1 par défaut
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Nombre d'éléments par page

// Récupérer les repas avec pagination
$meals = getMealsWithPagination($page, $limit);

// Récupérer le nombre total de repas pour la pagination
$totalMeals = countMeals();

// Calculer le nombre total de pages
$totalPages = ceil($totalMeals / $limit);
?>

<!-- Affichage de la table des repas -->

<div class="col-md-12 col-sm-12 mb-3">
<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            Le statut du repas a été mis à jour avec succès !
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif ($_GET['status'] == 'error'): ?>
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            Une erreur s'est produite lors de la mise à jour du statut du repas.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif ($_GET['status'] == 'invalid'): ?>
        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            Paramètres invalides pour la mise à jour du statut.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
<?php endif; ?>


<?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        Le repas a été supprimé avec succès !
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


</div>

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3">
        <div class="table-responsive">
            <table id="repasTable" class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Catégorie</th>
                        <th>Repas</th>
                        <th>Prix</th>
                        <th>Ajouté le</th>
                        <th>Ajouté par</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($meals) > 0): ?>
                        <?php foreach ($meals as $index => $meal): ?>
                            <tr>
                                <td><?= ($index + 1) + ($page - 1) * $limit ?></td>
                                
                                <!-- Affichage de l'image -->
                                <td>
                                    <?php if (!empty($meal['image'])): ?>
                                        <?php
                                        // Diviser la chaîne contenant les images en un tableau
                                        $images = explode(',', $meal['image']);
                                        $firstImage = $images[0]; // Sélectionner la première image
                                        ?>
                                        <img src="../uploads/<?= htmlspecialchars($firstImage) ?>" alt="Image du repas" width="80" height="80" class="img-thumbnail">
                                    <?php else: ?>
                                        <img src="../uploads/default.jpg" alt="Aucune image disponible" width="80" height="80" class="img-thumbnail">
                                    <?php endif; ?>
                                </td>


                                <td><?= htmlspecialchars($meal['category_name']) ?></td>
                                <td><?= htmlspecialchars($meal['meal_name']) ?></td>
                                <td><?= htmlspecialchars($meal['price']) ?> FCFA</td>
                                <td><?= htmlspecialchars($meal['added_at']) ?></td>
                                <td><?= htmlspecialchars($meal['added_by']) ?></td>
                                                                <!-- Affichage du statut avec une badge -->
                                    <td>
                                        <?php if ($meal['available'] == 1): ?>
                                            <span class="badge badge-success">Disponible</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Non disponible</span>
                                        <?php endif; ?>
                                    </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-customize text-white btn-rounded dropdown-toggle btn-sm" type="button" id="dropdownMenuButton<?= $meal['meal_uuid']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $meal['meal_uuid']; ?>">
                                            <li>
                                                <a class="dropdown-item text-warning" href="modifier_repas.php?id=<?= htmlspecialchars($meal['meal_uuid']); ?>">
                                                    <i class="fa fa-pencil-square"></i> Modifier
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" 
                                                data-toggle="modal" 
                                                data-target="#modalSupprimerRepas" 
                                                data-meal-id="<?= htmlspecialchars($meal['meal_uuid']); ?>">
                                                    <i class="fa fa-trash-o"></i> Supprimer
                                                </a>
                                            </li>
                                            <!-- Dropdown Item -->
                                            <li>
                                                <a class="dropdown-item text-success" href="#" 
                                                data-toggle="modal" 
                                                data-target="#modalToggleDisponibilite" 
                                                data-meal-id="<?= htmlspecialchars($meal['meal_uuid']); ?>" 
                                                data-current-status="<?= $meal['available']; ?>">
                                                    <i class="fa fa-check-circle"></i> Marquer comme <?= ($meal['available'] == 1) ? 'indisponible' : 'disponible'; ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">Aucun élément trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item mx-2">
                        <a class="page-link w-100" href="?page=<?= $page - 1 ?>">Précédent</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item mx-2 <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item mx-2">
                        <a class="page-link w-100" href="?page=<?= $page + 1 ?>">Suivant</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>

<!-- Boîte modale pour la suppression du repas -->
<div class="modal fade" id="modalSupprimerRepas" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Supprimer le repas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce repas ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs btn-sm shadow-none" data-dismiss="modal">Annuler</button>
                <!-- Lien de confirmation de la suppression -->
                <a href="#" id="confirmDelete" class="btn btn-danger btn-xs btn-sm shadow-none">Confirmer</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Événement d'ouverture de la modale
        $('#modalSupprimerRepas').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Bouton qui a déclenché la modale
            var mealId = button.data('meal-id'); // Récupérer l'ID du repas

            // Mettre à jour le lien de confirmation de suppression
            var deleteUrl = 'process_delete_meals.php?id=' + mealId;
            $('#confirmDelete').attr('href', deleteUrl);
        });
    });
</script>









<!-- Boîte Modale -->
<div class="modal fade" id="modalToggleDisponibilite" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Changer la disponibilité</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir marquer ce repas comme <span id="statusText"></span> ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm btn-xs shadow-none" data-dismiss="modal">Annuler</button>
                <a href="#" id="confirmToggle" class="btn btn-customize btn-sm btn-xs shadow-none text-white">Confirmer</a>
            </div>
        </div>
    </div>
</div>

<!-- Script pour mettre à jour la modale -->
<script>
    $(document).ready(function() {
        // Écouteur d'événements pour l'ouverture de la modale
        $('#modalToggleDisponibilite').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Le lien qui a déclenché la modale
            var mealId = button.data('meal-id'); // Récupérer l'ID du repas
            var currentStatus = button.data('current-status'); // Récupérer le statut actuel

            // Mettre à jour le texte de la modal
            var statusText = (currentStatus == 1) ? 'indisponible' : 'disponible';
            $('#statusText').text(statusText);

            // Configurer l'URL de confirmation
            var newStatus = (currentStatus == 1) ? 0 : 1; // Inverser le statut
            $('#confirmToggle').attr('href', 'process_status_meals.php?id=' + mealId + '&new_status=' + newStatus);
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Faire disparaître les alertes après 2 secondes (2000 millisecondes)
        setTimeout(function() {
            $(".alert").alert('close');
        }, 2000); // 2000 millisecondes = 2 secondes
    });
</script>


<script>
function rechercherRepas() {
    // Récupérer la valeur de recherche
    const searchInput = document.getElementById('searchRepas').value.toLowerCase();
    const table = document.getElementById('repasTable');
    const rows = table.getElementsByTagName('tr');

    // Boucle à travers toutes les lignes du tableau
    for (let i = 1; i < rows.length; i++) { // commencer à 1 pour ignorer l'en-tête
        const cells = rows[i].getElementsByTagName('td');
        let match = false;

        // Vérifier si une cellule correspond à la valeur de recherche
        for (let j = 1; j < cells.length; j++) { // commencer à 1 pour ignorer le numéro
            if (cells[j].textContent.toLowerCase().includes(searchInput)) {
                match = true;
                break;
            }
        }

        // Afficher ou masquer la ligne en fonction de la correspondance
        rows[i].style.display = match ? '' : 'none';
    }
}
</script>
