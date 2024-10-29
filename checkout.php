
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <title>QuickMeal</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    <!-- Icon Font Stylesheet -->
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
    <script src="https://js.stripe.com/v3/"></script>
    
</head>

<body>

<!-- Navbar & Hero Start -->
<div class="container-xxl position-relative p-0">
    <?php include("menu/navbar.php"); ?>

    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container text-center my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Commandé maintenant</h1>
        </div>
    </div>
</div>

<?php
include_once("database/connexion.php");

// Redirige l'utilisateur s'il n'est pas connecté
if (!isset($_SESSION['user_uuid'])) {
    header("Location: login.php");
    exit;
}

$user_uuid = $_SESSION['user_uuid'];

// Récupération des informations utilisateur
$user_stmt = $connexion->prepare("
    SELECT username, email, address, phone_number
    FROM users
    WHERE user_uuid = :user_uuid 
    AND is_deleted = 0
");
$user_stmt->bindValue(':user_uuid', $user_uuid);
$user_stmt->execute();
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

$username = htmlspecialchars($user['username'] ?? '');
$email = htmlspecialchars($user['email'] ?? '');
$address = htmlspecialchars($user['address'] ?? '');
$phone_number = htmlspecialchars($user['phone_number'] ?? '');

// Vérifie si le panier existe dans la session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $meal_uuids = array_column($_SESSION['cart'], 'meal_uuid');
    $placeholders = implode(',', array_fill(0, count($meal_uuids), '?'));

    // Prépare la requête pour récupérer les détails des repas
    $stmt = $connexion->prepare("
        SELECT meal_uuid, name, price, image 
        FROM meals 
        WHERE meal_uuid IN ($placeholders)
    ");
    $stmt->execute($meal_uuids);
    $meals = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $meals = []; // Panier vide
}
$grandTotal = 0;
?>

<div class="container-xxl position-relative p-0">
    <div class="container">
        <div class="row">
            <!-- Section Informations Personnelles -->
            <div class="col-lg-6 col-sm-12 mb-3">
               <div class="card shadow-sm border-light h-100 p-3">
                    <h3 class="my-2">Informations Personnelles</h3>
                    <form action="process_checkout.php" method="POST" id="payment-form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom Complet</label>
                            <input type="text" class="form-control shadow-none" id="name" name="name" value="<?= $username; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control shadow-none" id="email" name="email" value="<?= $email; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse</label>
                            <input type="text" class="form-control shadow-none" id="address" name="address" value="<?= $address; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Numéro de Téléphone</label>
                            <input type="tel" class="form-control shadow-none" id="phone" name="phone" value="<?= $phone_number; ?>" required>
                        </div>
                        <!-- Hidden field for grand total -->
                        <input type="hidden" name="total_amount" value="<?= $grandTotal; ?>">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Valider la commande</button> 
                        </div>
                    </form>
               </div>
            </div>

            <!-- Section Panier -->
            <div class="col-lg-6 col-sm-12 mb-3">
                <div class="card shadow-sm border-light p-3">
                    <div class="table-responsive">
                        <?php if (!empty($meals)): ?>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Repas</th>
                                        <th>Prix (FCFA)</th>
                                        <th>Quantité</th>
                                        <th>Total (FCFA)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $grandTotal = 0; // Initialisation du total général
                                    foreach ($meals as $meal):
                                        // Trouver la quantité du repas dans le panier
                                        $mealInCart = array_filter($_SESSION['cart'], function($item) use ($meal) {
                                            return $item['meal_uuid'] === $meal['meal_uuid'];
                                        });
                                        $quantity = !empty($mealInCart) ? reset($mealInCart)['quantity'] : 0;
                                        $totalPrice = $meal['price'] * $quantity;
                                        $grandTotal += $totalPrice;
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
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="3"><strong>Total Général :</strong></td>
                                        <td><?= $grandTotal; ?> FCFA</td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>Aucun article dans le panier.</p>
                        <?php endif; ?>
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
    <script src="assets/js/main.js"></script>
</body>

</html>
