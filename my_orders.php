
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <title>QuickMeal</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
</head>
<style>
    * {
  font-family: "Rubik", system-ui;

}
.btn{
    font-family: "Rubik", system-ui;

}
</style>

<body>


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
        <?php include("menu/navbar.php");?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Commandé maintenant</h1>
                </div>
            </div>
        </div>

        <div class="container-xxl">
            <div class="container">
                <?php
                // Vérifiez si un message est présent dans l'URL
                if (isset($_GET['message'])): ?>
                    <div id="message" class="alert alert-success text-center" role="alert">
                        <?= htmlspecialchars($_GET['message']); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Votre code pour afficher les commandes ici -->

            </div>
        </div>

        <div class="container-xxl position-relative p-0">
    <div class="container">
        <?php
        include_once("database/connexion.php");
        
        if (isset($_SESSION['user_uuid'])) {
            $user_uuid = $_SESSION['user_uuid'];
        
            // Requête pour récupérer les commandes de l'utilisateur passées aujourd'hui
            $stmt = $connexion->prepare("
            SELECT 
                o.order_uuid, 
                m.name, 
                m.price, 
                m.image, 
                o.order_date
            FROM 
                orders o
            JOIN 
                meals m ON o.meal_uuid = m.meal_uuid
            WHERE 
                o.user_uuid = :user_uuid 
                AND DATE(o.order_date) = CURDATE() 
                AND o.is_deleted = 0
        ");
        
            
            $stmt->bindValue(':user_uuid', $user_uuid);
            $stmt->execute();
        
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        ?>
            <div class="table-responsive">
                <div class="card shadow-sm border-light h-100 text-center p-3">
                    <table class="table table-striped text-center table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Repas</th>
                                <th>Prix Unitaire (FCFA)</th>
                                <th>Quantité</th>
                                <th>Prix Total (FCFA)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php $counter = 1; // Compteur pour les numéros ?>
                                <?php $grandTotal = 0; // Initialiser le prix total général ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= $counter++; ?></td> <!-- Affiche le numéro de la commande -->
                                        <td>
                                            <?php 
                                            // Récupérer la première image
                                            if (!empty($order['image'])): 
                                                $images = explode(',', $order['image']);
                                                $firstImage = $images[0]; 
                                            ?>
                                                <img src="uploads/<?= htmlspecialchars($firstImage); ?>" alt="Image du repas" class="img-fluid img-thumbnail" style="width: 50px; height: auto;">
                                            <?php else: ?>
                                                <img src="../uploads/default.jpg" alt="Aucune image disponible" class="img-fluid img-thumbnail" style="width: 50px; height: auto;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($order['name']); ?></td>
                                        <td class="unit-price"><?= htmlspecialchars($order['price']); ?></td>
                                        <td>
                                            <input type="number" class="form-control shadow-none quantity" value="1" min="1" size="2" data-price="<?= htmlspecialchars($order['price']); ?>">
                                        </td>
                                        <td class="total-price"><?= htmlspecialchars($order['price']); ?> FCFA</td>
                                        <td>
                                            <a href="delete_meal.php?order_uuid=<?= htmlspecialchars($order['order_uuid']); ?>" class="btn btn-danger btn-sm shadow-none" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce repas ?');">Supprimer</a>
                                        </td>


                                    </tr>
                                    <?php 
                                    // Calculer le prix total général
                                    $grandTotal += htmlspecialchars($order['price']); 
                                    ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Aucune commande trouvée.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <strong>Prix Total : </strong>
                        <span id="grand-total"><?= $grandTotal; ?> FCFA</span>
                    </div>
                </div>
            </div>
        </div>

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