<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<div class="main-container mt-3 pb-5">

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box text-center text-uppercase p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h3 class="text-uppercase">Liste des Livreurs</h3>
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
                                            class='rounded-circle img-fluid me-2' width='40' height='40' style='object-fit: cover; width: 40px; height: 40px; max-width: 40px; max-height: 40px;'>
                                    <?php else: ?>
                                        <img src="https://i.pinimg.com/736x/77/44/9b/77449b6a5b56eafbfb2166b2b67516a8.jpg" 
                                            alt="Photo par défaut" 
                                            class='rounded-circle img-fluid me-2' width='40' height='40' style='object-fit: cover; width: 40px; height: 40px; max-width: 40px; max-height: 40px;'>
                                    <?php endif; ?>
                                </td>

                                <td><?php echo htmlspecialchars($livreur['firstname'] . ' ' . $livreur['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($livreur['phone']); ?></td>
                                <td><?php echo htmlspecialchars($livreur['cni_number']); ?></td>
                                <td>
                                    <span class="badge <?php echo $livreur['available'] ? 'badge-success' : 'badge-danger'; ?>">
                                        <?php echo $livreur['available'] ? 'Actif' : 'Inactif'; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($livreur['availability_schedule']); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" 
                                                id="dropdownMenuButton<?php echo $livreur['agent_uuid']; ?>" 
                                                data-toggle="dropdown" 
                                                aria-haspopup="true" 
                                                aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $livreur['agent_uuid']; ?>">
                                            <a class="dropdown-item text-danger" 
                                               href="delete.php?id=<?php echo $livreur['agent_uuid']; ?>" 
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livreur ?');">
                                                <i class="fas fa-trash-alt"></i> Supprimer
                                            </a>
                                            <?php if ($livreur['available'] == 1): ?>
                                                <a class="dropdown-item text-success" 
                                                   href="assign_delivery.php?id=<?php echo $livreur['agent_uuid']; ?>">
                                                    <i class="fas fa-truck"></i> Affecter à une livraison
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($livreur['available'] == 0): ?>
                                                <a class="dropdown-item text-success" 
                                                   href="mark_available.php?id=<?php echo $livreur['agent_uuid']; ?>">
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
