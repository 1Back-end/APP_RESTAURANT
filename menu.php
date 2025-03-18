<?php include("menu/link_css.php");?>
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
        <div class="container-xxl position-relative p-0">
            <div class="container">
                <!-- Affichage des messages d'erreur -->
                <?php if (isset($_GET['error'])): ?>
                    <div id="error-message" class="alert alert-danger text-center" role="alert">
                        <?= htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>

                <!-- Affichage des messages de succès -->
                <?php if (isset($_GET['message'])): ?>
                    <div id="success-message" class="alert alert-success text-center" role="alert">
                        <?= htmlspecialchars($_GET['message']); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        </div>
        
        <!-- Navbar & Hero End -->
        <?php include_once("controllers.php");?>
        <!-- Menu Start -->
        <div class="container-xxl position-relative p-0">
        <div class="container">
         <div class="row">
        <?php
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 8;

        $meals = getMealsWithPagination($page, $limit);
        foreach ($meals as $meal): ?>
            <div class="col-lg-3 col-sm-6 mb-4">
                <div class="card shadow-sm border-light h-100 text-center p-2">
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
                            <h6 class="card-title mb-0 fw-bold"><?= htmlspecialchars($meal['meal_name']); ?></h6>
                            <p class="card-text mb-0 fw-bold"><?= htmlspecialchars($meal['price']); ?> FCFA</p>
                        </div>
                        <p class="card-text text-truncate"><?= htmlspecialchars($meal['description']); ?></p>
                        <div class="d-flex align-items-center justify-content-between">
                        <div class="mr-auto">
                            <input type="number" class="form-control shadow-none quantity-input" min="1" value="1" size="2">
                        </div>
                        <div class="ml-auto">
                            <a href="#" class="btn btn-primary w-100 shadow-none orderButton" data-meal-id="<?= htmlspecialchars($meal['meal_uuid']); ?>">
                                <i class="fa fa-shopping-bag" aria-hidden="true"></i>

                                </a>
                            </div>
                    </div>



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
                    <a class="page-link shadow-none mx-2" href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
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
<script>
    
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.orderButton').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            // Vérifiez si l'utilisateur est connecté
            <?php if (!isset($_SESSION['user_name'])): ?>
                // Ouvrir la modale si l'utilisateur n'est pas connecté
                $('#loginModal').modal('show');
            <?php else: ?>
                const mealId = this.getAttribute('data-meal-id');
                const userId = '<?= $_SESSION['user_uuid']; ?>'; // ID utilisateur
                const quantityInput = this.closest('.d-flex').querySelector('.quantity-input');
                const quantity = quantityInput ? quantityInput.value : 1; // Valeur par défaut à 1 si non spécifiée
                
                // Récupérer le prix affiché dans la carte
                const priceElement = this.closest('.card-body').querySelector('.card-text.mb-0'); // Ajustez le sélecteur si nécessaire
                const price = priceElement ? priceElement.textContent.replace(' FCFA', '').trim() : 0; // Extraire le prix, en enlevant ' FCFA' et les espaces

                // Redirection vers le script de traitement de commande avec la quantité et le prix
                window.location.href = `process_order.php?user_uuid=${userId}&meal_uuid=${mealId}&quantity=${quantity}&price=${price}`;
            <?php endif; ?>
        });
    });
});
</script>




<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Faire disparaître les messages après 2 secondes
        setTimeout(() => {
            const errorMessage = document.getElementById('error-message');
            const successMessage = document.getElementById('success-message');
            if (errorMessage) {
                errorMessage.style.display = 'none'; // Cacher le message d'erreur
            }
            if (successMessage) {
                successMessage.style.display = 'none'; // Cacher le message de succès
            }
        }, 2000); // 2000 ms = 2 secondes
    });
</script>
