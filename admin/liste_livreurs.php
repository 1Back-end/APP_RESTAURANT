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
                                            class='rounded-circle me-2 img-thumbnail' width='40' height='40' style='object-fit: cover; width: 40px; height: 40px; max-width: 40px; max-height: 40px;'>
                                    <?php else: ?>
                                        <img src="https://i.pinimg.com/736x/77/44/9b/77449b6a5b56eafbfb2166b2b67516a8.jpg" 
                                            alt="Photo par défaut" 
                                            class='rounded-circle  me-2 img-thumbnail' width='40' height='40' style='object-fit: cover; width: 40px; height: 40px; max-width: 40px; max-height: 40px;'>
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
                                        <button class="btn btn-customize text-white btn-rounded btn-sm dropdown-toggle" type="button" 
                                                id="dropdownMenuButton<?php echo $livreur['agent_uuid']; ?>" 
                                                data-toggle="dropdown" 
                                                aria-haspopup="true" 
                                                aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $livreur['agent_uuid']; ?>">
                                        <li>
                                                <a class="dropdown-item text-danger" href="#" 
                                                data-toggle="modal" 
                                                data-target="#modalSupprimerLivreur" 
                                                data-meal-id="<?php echo $livreur['agent_uuid']; ?>">
                                                    <i class="fa fa-trash-o"></i> Supprimer
                                                </a>
                                            </li>
                                            <?php if ($livreur['available'] == 1): ?>
                                                <a class="dropdown-item text-success" 
                                                    href="#" 
                                                    data-toggle="modal" 
                                                    data-target="#assignDeliveryModal" 
                                                    data-agent-uuid="<?php echo $livreur['agent_uuid']; ?>"> <!-- Vérifiez ici -->
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


<!-- Boîte modale pour la suppression du repas -->
<div class="modal fade" id="modalSupprimerRepas" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Supprimer le livreur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce livreur ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs btn-sm shadow-none" data-dismiss="modal">Annuler</button>
                <!-- Lien de confirmation de la suppression -->
                <a href="#" id="confirmDelete" class="btn btn-danger btn-xs btn-sm shadow-none">Confirmer</a>
            </div>
        </div>
    </div>
</div>
<!-- Boîte Modale -->
<div class="modal fade" id="assignDeliveryModal" tabindex="-1" role="dialog" aria-labelledby="assignDeliveryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignDeliveryModalLabel">Sélectionnez une commande</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="assignDeliveryForm" method="POST" action="assign_delivery.php">
                    <!-- Champ caché pour agent_uuid -->
                    <input type="hidden" name="agent_uuid" id="hidden_agent_uuid" value="">
                    <div class="form-group">
                        <label for="order_uuid">Choisissez une commande :</label>
                        <select class="form-control select-custom shadow-none" name="order_uuid" id="order_uuid" required>
                            <option value="" disabled selected>Sélectionnez une commande</option>
                            <?php
                                $i = 1; // Compteur pour le numéro auto-incrémenté
                                foreach ($orders as $order) {
                                    // Afficher les informations nécessaires dans l'option
                                    echo '<option value="' . $order['order_uuid'] . '">' . 
                                        $i . '. ' . $order['username'] . ' - ' . $order['order_date'] . ' - ' . 
                                        $order['total_amount'] . ' FCFA</option>';
                                    $i++; // Incrémenter le compteur
                                }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm btn-xs shadow-none" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-customize text-white btn-sm btn-xs shadow-none">Assigner Livraison</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Script pour mettre à jour l'agent_uuid caché lorsque le modal s'ouvre
        $('#assignDeliveryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var agentUuid = button.data('agent-uuid'); // Assurez-vous que cet attribut est correct
            $('#hidden_agent_uuid').val(agentUuid); // Mettre à jour le champ caché
        });
    });
</script>
<script>
    // Script pour mettre à jour l'agent_uuid caché lorsque le modal s'ouvre
    $('#assignDeliveryModal').on('show.bs.modal', function (event) {
        // Récupérer l'élément qui a déclenché le modal (ex: un bouton)
        var button = $(event.relatedTarget); 
        var agentUuid = button.data('agent-uuid'); // Assurez-vous d'avoir cet attribut dans votre bouton

        // Mettre à jour la valeur du champ caché
        $('#hidden_agent_uuid').val(agentUuid);
    });
</script>


<script>
    $(document).ready(function() {
        // Événement d'ouverture de la modale
        $('#modalSupprimerLivreur').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Bouton qui a déclenché la modale
            var mealId = button.data('meal-id'); // Récupérer l'ID du repas

            // Mettre à jour le lien de confirmation de suppression
            var deleteUrl = 'process_delete_delivery.php?id=' + mealId;
            $('#confirmDelete').attr('href', deleteUrl);
        });
    });
</script>






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
