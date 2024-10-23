
<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<?php               // Initialiser la page actuelle
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 5;

// Récupérer les catégories et le total
$categories = get_category_meals($connexion, $currentPage, $itemsPerPage);
$totalCategories = get_category_count($connexion);
$totalPages = ceil($totalCategories / $itemsPerPage);
?>
<?php
// Vérifiez si un message de succès ou d'erreur est présent dans l'URL
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>

<div class="main-container mt-3 pb-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="row">
            <div class="col-md-6 col-sm-12 mb-3"> 
            <?php include ("process_create_category.php")?>  
            <?php if (!empty($erreur)) : ?>
                <div id="error-message" class="alert alert-danger text-center" role="alert">
                    <?= $erreur ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)) : ?>
                <div id="success-message" class="alert alert-success text-center" role="alert">
                    <?= $success ?>
                </div>
            <?php endif; ?>
                <div class="card-box p-3">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="">Nom de la catégorie <span class="text-danger">*</span></label>
                            <input type="text" class="form-control shadow-none" name="nom_categorie" value="<?= (empty($erreur) && !empty($success)) ? '' : (isset($_POST['nom_categorie']) ? htmlspecialchars($_POST['nom_categorie']) : '') ?>">
                            <?php if(isset($erreur_champ) && empty($_POST['nom_categorie'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="">Description de la catégorie</label>
                            <textarea class="form-control shadow-none" name="description_categorie" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="submit" class="btn btn-customize text-white shadow-none">Ajouter la catégorie</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 mb-3">
            <?php
                // Vérifiez si un message de succès ou d'erreur est présent dans l'URL
                $succes = isset($_GET['succes']) ? htmlspecialchars($_GET['succes']) : '';
                $error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';

                // Affichage des messages
                if (!empty($succes)): ?>
                    <div id="alertMsg" class="alert alert-success alert-dismissible text-center">
                        <?= $succes; ?>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            setTimeout(function() {
                                var alertMsg = document.getElementById("alertMsg");
                                if (alertMsg) {
                                    alertMsg.style.display = "none"; // Masquer le message
                                }
                            }, 2500); // Délai de 2,5 secondes
                        });
                    </script>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div id="alertError" class="alert alert-danger alert-dismissible text-center">
                        <?= $error; ?>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            setTimeout(function() {
                                var alertError = document.getElementById("alertError");
                                if (alertError) {
                                    alertError.style.display = "none"; // Masquer le message
                                }
                            }, 2500); // Délai de 2,5 secondes
                        });
                    </script>
                <?php endif; ?>

                <div class="card-box p-3">
                    <div class="table-responsive">
                <table class="table text-center table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Catégorie</th>
                            <th>Ajouté le</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($categories) > 0): ?>
                            <?php foreach ($categories as $index => $category): ?>
                                <tr>
                                    <td><?= ($currentPage - 1) * $itemsPerPage + $index + 1 ?></td>
                                    <td><?= htmlspecialchars($category['name']) ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($category['created_at'])) ?></td>
                                    <td>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm btn-xs" onclick="openDeletionModal('<?= $category['category_uuid'] ?>')">Supprimer</a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">Aucun élément trouvé</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                    </div>
                </div><br>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>

<script>
    // Attendre que le document soit prêt
    document.addEventListener("DOMContentLoaded", function() {
        // Masquer le message d'erreur après 2 secondes
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');

        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 2000); // 2000 ms = 2 secondes
        }

        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 2000); // 2000 ms = 2 secondes
        }
    });
</script>
<!-- Modal for deletion confirmation -->
<div class="modal fade" id="confirmDeletionModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeletionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeletionModalLabel">Confirmer la suppression</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm btn-xs" data-dismiss="modal">Annuler</button>
        <a id="confirmDeleteButton" class="btn btn-danger btn-sm btn-xs text-white" href="#">Supprimer</a>
      </div>
    </div>
  </div>
</div>


<script>
let categoryToDelete;

function openDeletionModal(categoryUuid) {
    categoryToDelete = categoryUuid;
    $('#confirmDeletionModal').modal('show');
}

$('#confirmDeleteButton').on('click', function () {
    if (categoryToDelete) {
        window.location.href = 'process_delete_category.php?id=' + categoryToDelete; // Remplacez par votre fichier de suppression
    }
});
</script>

