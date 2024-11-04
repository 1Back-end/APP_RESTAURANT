<?php include("menu/link_css.php");?>

<body>

<!-- Navbar & Hero Start -->
<div class="container-xxl position-relative p-0">
    <?php include("menu/navbar.php"); ?>

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Mon panier</h1>
        </div>
    </div>
</div>
<?php
include_once("database/connexion.php");

// Gérer la suppression d'un article
if (isset($_GET['remove'])) {
    $remove_uuid = $_GET['remove'];

    // Filtrer le panier pour exclure l'article supprimé
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($remove_uuid) {
        return $item['meal_uuid'] !== $remove_uuid; // Garder les articles qui ne correspondent pas à l'UUID supprimé
    });
    
}

// Vérifiez si le panier existe dans la session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Récupérer les identifiants des repas du panier
    $meal_uuids = array_column($_SESSION['cart'], 'meal_uuid');
    
    // Créer une chaîne d'identifiants pour la requête SQL
    $placeholders = implode(',', array_fill(0, count($meal_uuids), '?'));
    
    // Préparer la requête pour récupérer les détails des repas
    $stmt = $connexion->prepare("
        SELECT meal_uuid, name, price, image 
        FROM meals 
        WHERE meal_uuid IN ($placeholders)
    ");
    
    // Exécuter la requête avec les identifiants des repas
    $stmt->execute($meal_uuids);
    
    // Récupérer les résultats
    $meals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $meals = []; // Panier vide
}
?>

<!-- Affichage du panier -->
<div class="container-xxl position-relative p-0">
    <div class="card shadow-sm border-light h-100 p-3">
        <div class="table-responsive">
    <?php if (!empty($meals)): ?>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Repas</th>
                    <th>Prix (FCFA)</th>
                    <th>Quantité</th>
                    <th>Total (FCFA)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grandTotal = 0; // Initialiser le prix total général
                foreach ($meals as $meal):
                    // Trouver la quantité correspondante dans le panier
                    $mealInCart = array_filter($_SESSION['cart'], function($item) use ($meal) {
                        return $item['meal_uuid'] === $meal['meal_uuid'];
                    });
                    
                    // Vérifiez si $mealInCart n'est pas vide avant d'utiliser reset()
                    $quantity = !empty($mealInCart) ? reset($mealInCart)['quantity'] : 0; // Récupérer la quantité, ou 0 si vide
                    $totalPrice = $meal['price'] * $quantity; // Calcul du prix total
                    $grandTotal += $totalPrice; // Ajouter au prix total général
                ?>
                    <tr>
                        <td>
                            <?php 
                            if (!empty($meal['image'])): 
                                $images = explode(',', $meal['image']);
                                $firstImage = $images[0]; 
                            ?>
                                <img src="uploads/<?= htmlspecialchars($firstImage); ?>" alt="Image du repas" class="img-fluid img-thumbnail me-2" style="width: 50px; height: auto;">
                            <?php else: ?>
                                <img src="uploads/default.jpg" alt="Aucune image disponible" class="img-fluid img-thumbnail me-2" style="width: 50px; height: auto;">
                            <?php endif; ?>
                            <?= htmlspecialchars($meal['name']); ?>
                        </td>
                        <td><?= htmlspecialchars($meal['price']); ?> FCFA</td>
                        <td><?= htmlspecialchars($quantity); ?></td>
                        <td><?= $totalPrice; ?> FCFA</td>
                        <td>
                            <a href="?remove=<?= htmlspecialchars($meal['meal_uuid']); ?>" class="btn btn-danger btn-sm btn-xs">
                            <i class="bi bi-trash3-fill"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total Général :</strong></td>
                    <td><?= $grandTotal; ?> FCFA</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            <!-- Bouton Aller à la caisse -->
            <a href="checkout.php" class="btn btn-success shadow-none">Aller à la caisse</a>
        </div>
        </div>
        </div>
    <?php else: ?>
        <p>Aucun article dans le panier.</p>
    <?php endif; ?>
</div>
</div>


        <!-- Menu End -->
        <?php include_once("menu/footer.php");?>
</div>
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/counterup/counterup.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>
</body>

</html>

<!-- JavaScript pour le calcul dynamique du prix -->
<script>
    // Fonction pour mettre à jour le prix total lors du changement de la quantité
    document.querySelectorAll('.quantity').forEach(input => {
        input.addEventListener('change', function() {
            const unitPrice = parseInt(this.getAttribute('data-price'));
            const quantity = parseInt(this.value);
            const totalPriceCell = this.closest('tr').querySelector('.total-price');

            // Calculer le nouveau prix total pour cette ligne
            const totalPrice = unitPrice * quantity;
            totalPriceCell.innerText = totalPrice + ' FCFA';

            // Calculer le prix total général
            let grandTotal = 0;
            document.querySelectorAll('.total-price').forEach(cell => {
                grandTotal += parseInt(cell.innerText);
            });
            document.getElementById('grand-total').innerText = grandTotal + ' FCFA';
        });
    });
</script>

<script>
    // Faire disparaître le message après 2 secondes
    setTimeout(function() {
        var messageDiv = document.getElementById('message');
        if (messageDiv) {
            messageDiv.style.display = 'none'; // Cache le message
        }
    }, 2000);
</script>