
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
    <link rel="stylesheet" href="style.css">
</head>

<body>
        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
        <?php include("menu/navbar.php");?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Passez votre commande.</h1>
                    
                </div>
            </div>
        </div>

        
       <div class="container-xxl py-5">
        <div class="col-md-6 card shadow-sm border-light h-100 text-center p-3 mx-auto text-center">
        <h1 class="text-center">Mon Panier</h1>
        <ul class="list-group" id="cartItemsList"></ul>
        <div class="mt-3 text-right">
            <strong>Total : <span id="totalPrice">0</span> FCFA</strong>
        </div>
        <button class="btn btn-primary mt-3" id="checkoutButton">Passer à la commande</button>
        </div>
        </div>
        <!-- Menu End -->
        <?php include_once("menu/footer.php");?>
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cartItemsList = document.getElementById('cartItemsList');
        const totalPriceElement = document.getElementById('totalPrice');

        function displayCartItems() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cartItemsList.innerHTML = '';
            let totalPrice = 0;

            cart.forEach((item, index) => {
                const itemPrice = parseInt(item.price); // Récupère le prix sans symbole et comme entier

                const listItem = document.createElement('li');
                listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');

                listItem.innerHTML = `
                    <span>${item.name}</span>
                    <input type="number" class="form-control shadow-none w-25 mx-2" min="1" value="1" data-price="${itemPrice}" data-meal-index="${index}" onchange="updateTotalPrice()">
                    <span class="item-price" data-meal-index="${index}">${itemPrice} FCFA</span>
                    <button class="btn btn-danger btn-sm removeItemButton" data-meal-index="${index}" style="margin-left: 10px;">Supprimer</button>
                `;
                cartItemsList.appendChild(listItem);
                totalPrice += itemPrice; // Calcule le prix total initial
            });

            totalPriceElement.textContent = totalPrice + ' FCFA'; // Met à jour le prix total
        }

        window.updateTotalPrice = function() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            let totalPrice = 0;

            cart.forEach((item, index) => {
                const quantityInput = document.querySelector(`input[data-meal-index="${index}"]`);
                const quantity = parseInt(quantityInput.value);
                const itemPrice = parseInt(item.price); // Utilise le prix sans symbole
                const totalItemPrice = itemPrice * quantity; // Calcule le prix total pour cet article

                // Met à jour l'affichage du prix de l'article
                document.querySelector(`.item-price[data-meal-index="${index}"]`).textContent = totalItemPrice + ' FCFA';

                totalPrice += totalItemPrice; // Calcule le prix total
            });

            totalPriceElement.textContent = totalPrice + ' FCFA'; // Met à jour le prix total
        }

        cartItemsList.addEventListener('click', (event) => {
            if (event.target.classList.contains('removeItemButton')) {
                const itemIndex = event.target.getAttribute('data-meal-index');
                removeItemFromCart(itemIndex);
            }
        });

        function removeItemFromCart(index) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            displayCartItems();
        }

        document.getElementById('checkoutButton').addEventListener('click', () => {
            if (JSON.parse(localStorage.getItem('cart')).length === 0) {
                alert('Votre panier est vide.');
            } else {
                // Rediriger vers une page de commande (ajustez l'URL si nécessaire)
                window.location.href = 'checkout.php';
            }
        });

        displayCartItems();
    });
</script>
