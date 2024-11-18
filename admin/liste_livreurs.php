<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<div class="main-container mt-3 pb-5">

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box text-center text-uppercase p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h5 class="text-uppercase">Liste des Livreurs (<?php echo $total_delivery;?>)</h5>
            </div>
            <div class="ml-auto">
                <div class="form-inline">
                    <input type="text" class="form-control shadow-none mr-2" id="searchLivreur" placeholder="Rechercher un livreur...">
                    <button type="button" class="btn btn-customize text-white shadow-none" onclick="rechercherLivreur()">
                        Rechercher
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="col-md-12 col-sm-12 mb-3">
    <?php if (!empty($_GET["msg"])): ?>
        <?php $msg = htmlspecialchars($_GET["msg"], ENT_QUOTES, 'UTF-8'); ?>
        <?php if (!empty($msg)): ?>
            <div id="alertMsg" class="alert alert-info alert-dismissible text-center">
                <?= $msg; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($_GET["message"])): ?>
        <?php $message = htmlspecialchars($_GET["message"], ENT_QUOTES, 'UTF-8'); ?>
        <?php if (!empty($message)): ?>
            <div id="alertMsg" class="alert alert-info alert-dismissible text-center">
                <?= $message; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php
// Nombre d'éléments à afficher par page
$limit = 5;

// Calcul de l'offset basé sur le numéro de page actuel
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Récupération des livreurs avec pagination
$livreurs = get_agency_delivery($connexion, $limit, $offset);

// Compter le total des livreurs pour la pagination
$total_livreurs = count_agency_delivery($connexion);
$total_pages = ceil($total_livreurs / $limit);
?>
<?php
// Inclure votre connexion à la base de données
include_once("../database/connexion.php");
// Récupérer les commandes en attente
$orders = get_order_pending($connexion); // Appel de la fonction

?>
<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3">
        <div class="table-responsive">
            <table id="livreurTable" class="table text-center table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Téléphone</th>
                        <th>CNI</th>
                        <th>Statut</th>
                        <th>Disponibilité</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($livreurs) > 0): ?>
                        <?php foreach ($livreurs as $index => $livreur): ?>
                            <tr>
                                <td><?php echo ($offset + $index + 1); ?></td>
                                <td><?php echo htmlspecialchars($livreur['agent_code']); ?></td>
                                <td>
                                    <?php if (!empty($livreur['photo'])): ?>
                                        <img src="../uploads/<?php echo htmlspecialchars($livreur['photo']); ?>" 
                                            alt="Photo de <?php echo htmlspecialchars($livreur['firstname'] . ' ' . $livreur['lastname']); ?>" 
                                            class='rounded-circle me-2 img-thumbnail' width='50' height='50' style='object-fit: cover; width: 50px; height: 50px; max-width: 50px; max-height: 50px;'>
                                    <?php else: ?>
                                        <img src="https://i.pinimg.com/564x/07/01/e5/0701e5a1cd4f91681f76cf3691176680.jpg" 
                                            alt="Photo de <?php echo htmlspecialchars($livreur['firstname'] . ' ' . $livreur['lastname']); ?>" 
                                            class='rounded-circle  me-2 img-thumbnail' width='50' height='50' style='object-fit: cover; width:50px; height: 50px; max-width: 50px; max-height: 50px;'>
                                    <?php endif; ?>
                                </td>

                                <td><?php echo htmlspecialchars($livreur['firstname'] . ' ' . $livreur['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($livreur['phone']); ?></td>
                                <td><?php echo htmlspecialchars($livreur['cni_number']); ?></td>
                                <td>
                                    <span class="badge <?php echo $livreur['available'] ? 'badge-success' : 'badge-danger'; ?>">
                                        <?php echo $livreur['available'] ? 'Libre' : 'Occupé'; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($livreur['availability_schedule']); ?></td>
                                <td>
                                <div class="dropdown">
                                <button class="btn btn-customize text-white btn-rounded dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <!-- Détails -->
                                        <li>
                                            <a class="dropdown-item text-danger" href="process_delete_delivery.php?agent_uuid=<?php echo htmlspecialchars($livreur['agent_uuid']); ?>">
                                                <i class="fa fa-trash-o"></i> Supprimer
                                            </a>
                                        </li>
                                        <?php if ($livreur['available'] == 0): ?>
                                            <a class="dropdown-item text-success" href="process_mark_available.php?agent_uuid=<?php echo $livreur['agent_uuid']; ?>">
                                                <i class="fas fa-check-circle"></i> Marquer comme disponible
                                            </a>
                                        <?php endif; ?>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">Aucun élément trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item mx-2 <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>




<script>
function rechercherLivreur() {
    // Récupérer la valeur de recherche
    const searchInput = document.getElementById('searchLivreur').value.toLowerCase();
    const table = document.getElementById('livreurTable');
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
