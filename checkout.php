
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
<style>
    #card-element {
        border: 1px solid #ccc; /* Bordure légère */
        border-radius: 4px; /* Coins arrondis */
        padding: 10px; /* Espacement interne */
        margin-top: 10px; /* Espacement supérieur */
        height: 40px; /* Hauteur fixe pour uniformité */
        font-size: 16px; /* Taille de police plus grande */
        color: #333; /* Couleur du texte */
        transition: border-color 0.3s; /* Transition pour un effet doux */
    }

    /* Style lorsque le champ de carte est au focus */
    #card-element:focus {
        border-color: #1F4283; /* Changer la couleur de la bordure au focus */
        outline: none; /* Supprimer le contour par défaut */
    }

    /* Style pour les messages d'erreur */
    .error-message {
        color: #d9534f; /* Couleur rouge pour les messages d'erreur */
        font-size: 14px; /* Taille de police pour le message */
        margin-top: 5px; /* Espacement supérieur */
    }
</style>

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

if (!isset($_SESSION['user_uuid'])) {
    header("Location: login.php"); // Rediriger si l'utilisateur n'est pas connecté
    exit;
}

$user_uuid = $_SESSION['user_uuid'];

// Récupérer les informations de l'utilisateur
$user_stmt = $connexion->prepare("
    SELECT username, email
    FROM users
    WHERE user_uuid = :user_uuid 
    AND is_deleted = 0
");
$user_stmt->bindValue(':user_uuid', $user_uuid);
$user_stmt->execute();
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

$username = htmlspecialchars($user['username'] ?? '');
$email = htmlspecialchars($user['email'] ?? '');

// Récupérer les informations de la commande de l'utilisateur
$order_stmt = $connexion->prepare("
    SELECT 
        o.order_uuid, 
        m.name, 
        m.price, 
        m.image, 
        o.order_date, 
        o.quantity
    FROM 
        orders o
    JOIN 
        meals m ON o.meal_uuid = m.meal_uuid
    WHERE 
        o.user_uuid = :user_uuid 
        AND o.is_deleted = 0 ORDER BY order_date DESC
");
$order_stmt->bindValue(':user_uuid', $user_uuid);
$order_stmt->execute();
$orders = $order_stmt->fetchAll(PDO::FETCH_ASSOC);
$grandTotal = 0;
?>

<div class="container-xxl position-relative p-0">
    <div class="container">
        <div class="row">
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
                            <input type="text" class="form-control shadow-none" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Numéro de Téléphone</label>
                            <input type="tel" class="form-control shadow-none" id="phone" name="phone" required>
                        </div>

                        <div id="card-element"><!-- Un élément de carte Stripe sera inséré ici --></div>
                        <button type="submit" class="btn btn-primary mt-3">Payer</button>
                        <div id="payment-result"></div>
                    </form>
               </div>
            </div>

            <div class="col-lg-6 col-sm-12 mb-3">
               <div class="card shadow-sm border-light h-100 p-3">
               <h3 class="my-2">Commandes</h3>
               <?php if (empty($orders)): ?>
                   <p>Aucune commande trouvée.</p>
               <?php else: ?>
                   <table class="table table-striped table-bordered">
                       <thead>
                           <tr>
                               <th>Repas</th>
                               <th>Prix</th>
                               <th>Quantité</th>
                               <th>Total</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php foreach ($orders as $order): 
                               $total = $order['price'] * $order['quantity'];
                               $grandTotal += $total; // Calculer le total général
                           ?>
                               <tr>
                               <td>
                                    <?php 
                                    if (!empty($order['image'])): 
                                        $images = explode(',', $order['image']);
                                        $firstImage = $images[0]; 
                                    ?>
                                        <img src="uploads/<?= htmlspecialchars($firstImage); ?>" alt="Image du repas" class="img-fluid img-thumbnail me-2" style="width: 50px; height: auto;">
                                    <?php else: ?>
                                        <img src="uploads/default.jpg" alt="Aucune image disponible" class="img-fluid img-thumbnail me-2" style="width: 50px; height: auto;">
                                    <?php endif; ?>
                                    <?= htmlspecialchars($order['name']); ?>
                                </td>

                                   <td><?= htmlspecialchars(number_format($order['price'])); ?> FCFA</td>
                                   <td><?= htmlspecialchars($order['quantity']); ?></td>
                                   <td><?= htmlspecialchars(number_format($total));?> FCFA</td>
                               </tr>
                           <?php endforeach; ?>
                           <tr>
                               <td colspan="2" class="text-end fw-bold">Total:</td>
                               <td colspan="2" class="fw-bold"><?= htmlspecialchars(number_format($grandTotal)); ?> FCFA</td>
                           </tr>
                       </tbody>
                   </table>
               <?php endif; ?>
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
<script>
    const stripe = Stripe('pk_test_51PvK3l08QILWwY1zAFbfSZ4SwTFbJJH0aAVsDZVIFZZyO5q2qIuwsY7I1Vbyfw1kq6pyrNivuy9DKpALw9L1bDWV00Cc2dxiGT'); // Remplacez par votre clé publique Stripe
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        });

        if (error) {
            document.getElementById('payment-result').innerText = error.message;
        } else {
            console.log("Payment Method ID:", paymentMethod.id); // Affichez l'ID pour déboguer

            // Appel AJAX pour soumettre le formulaire avec le paymentMethod.id
            const formData = new FormData(form);
            formData.append('paymentMethodId', paymentMethod.id); // Vérifiez que cette ligne est bien exécutée

            const response = await fetch('process_checkout.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();
            document.getElementById('payment-result').innerText = result.message;
        }
    });
</script>
