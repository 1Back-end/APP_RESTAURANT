
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
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Une Sélection Exquise de Plats</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Acceuil</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Menu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->
        <?php include_once("controllers.php");?>
        <!-- Menu Start -->
        <div class="container-xxl py-5">
        <div class="container">
    <div class="row">
        <?php
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;

        $meals = getMealsWithPagination($page, $limit);
        foreach ($meals as $meal): ?>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card shadow-sm border-light h-100 text-center p-3">
                    <?php if (!empty($meal['image'])): ?>
                        <?php
                        $images = explode(',', $meal['image']);
                        $firstImage = $images[0];
                        ?>
                        <img src="uploads/<?= htmlspecialchars($firstImage); ?>" alt="Image du repas" class="img-fluid img-thumbnail card-img-top">
                    <?php else: ?>
                        <img src="../uploads/default.jpg" alt="Aucune image disponible" class="img-fluid img-thumbnail card-img-top">
                    <?php endif; ?>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0"><?= htmlspecialchars($meal['meal_name']); ?></h6>
                            <p class="card-text mb-0"><?= htmlspecialchars($meal['price']); ?></p>
                        </div>
                        <p class="card-text text-truncate"><?= htmlspecialchars($meal['description']); ?></p>
                        <a href="#" class="btn btn-primary shadow-none orderButton" data-meal-id="<?= htmlspecialchars($meal['meal_uuid']); ?>">
                            <i class="fa fa-shopping-cart mx-1" aria-hidden="true"></i>
                            Commander
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php
            $totalMeals = countMeals();
            $totalPages = ceil($totalMeals / $limit);
            for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i === $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <!-- Icone panier en bas de la pagination -->
    <div id="cartIcon" class="cart-icon" data-bs-toggle="modal" data-bs-target="#cartModal">
        <i class="fa fa-shopping-cart"></i>
        <span id="cartCount">0</span>
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
<!-- Modal de panier -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Votre Panier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="cartItemsList" class="list-group mb-3"></ul>
                <p id="emptyCartMessage" class="text-center">Votre panier est vide.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <a href="cart.php" class="btn btn-primary">Aller au panier</a>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cartCountElement = document.getElementById('cartCount');
        const cartItemsList = document.getElementById('cartItemsList');
        const emptyCartMessage = document.getElementById('emptyCartMessage');

        function updateCartCount() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cartCountElement.textContent = cart.length;
        }

        // Affichage des articles dans le panier
        function displayCartItems() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cartItemsList.innerHTML = '';
            if (cart.length === 0) {
                emptyCartMessage.style.display = 'block';
                cartItemsList.style.display = 'none';
            } else {
                emptyCartMessage.style.display = 'none';
                cartItemsList.style.display = 'block';
                cart.forEach((item, index) => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                    listItem.innerHTML = `
                        ${item.name} - <span class="item-price">${parseInt(item.price)} FCFA</span>
                        <button class="btn btn-danger btn-sm removeItemButton" data-meal-index="${index}" style="margin-left: 10px;">
                            Supprimer
                        </button>
                    `;
                    cartItemsList.appendChild(listItem);
                });
            }
        }

        function removeItemFromCart(index) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1); // Retirer l'article du tableau
            localStorage.setItem('cart', JSON.stringify(cart)); // Sauvegarder le panier mis à jour
            updateCartCount();
            displayCartItems();
        }

        document.querySelectorAll('.orderButton').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                <?php if (!isset($_SESSION['user_name'])): ?>
                    $('#loginModal').modal('show');
                <?php else: ?>
                    const mealId = this.getAttribute('data-meal-id');
                    const mealName = this.parentElement.querySelector('.card-title').textContent;
                    const mealPrice = parseInt(this.parentElement.querySelector('.card-text').textContent); // Convertir en entier

                    let cart = JSON.parse(localStorage.getItem('cart')) || [];
                    cart.push({ id: mealId, name: mealName, price: mealPrice });
                    localStorage.setItem('cart', JSON.stringify(cart));

                    updateCartCount();
                    alert(`${mealName} a été ajouté au panier.`);
                <?php endif; ?>
            });
        });

        // Afficher le contenu du panier en cliquant sur l'icône
        const cartIcon = document.getElementById('cartIcon');
        cartIcon.addEventListener('click', displayCartItems);

        // Suppression d'un article dans le panier en cliquant sur le bouton
        cartItemsList.addEventListener('click', (event) => {
            if (event.target.classList.contains('removeItemButton')) {
                const itemIndex = event.target.getAttribute('data-meal-index');
                removeItemFromCart(itemIndex);
            }
        });

        updateCartCount();
    });
</script>



<style>
.cart-icon {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 50%;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
    cursor: pointer;
}

.cart-icon i {
    font-size: 20px;
}

.cart-icon span {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    width: 20px;
    height:20px;
    text-align:center;
    font-weight:700;
}
</style>