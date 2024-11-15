<?php
session_start(); // S'assurer que la session est démarrée
?>

<!-- Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
    <a href="index.php" class="navbar-brand p-0">
        <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>QuickMeal</h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0 pe-4">
            <a href="index.php" class="nav-item nav-link">Accueil</a>
            <a href="about.php" class="nav-item nav-link">À propos</a>
            <a href="menu.php" class="nav-item nav-link active">Menu</a>
            <a href="contact.php" class="nav-item nav-link">Contact</a>
        </div>
                <?php 
                    // Vérifier si les variables de session existent
                    if (isset($_SESSION['user_uuid']) && isset($_SESSION['user_name'])) {
                        // Lors de la création du lien
                        $token = base64_encode($_SESSION['user_uuid'] . ':' . $_SESSION['user_name']); // Encode les données
                ?>

            <div class="d-flex align-items-center">
                <button class="btn btn-primary dropdown-toggle py-2 px-4 shadow-none" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Salut , <?= htmlspecialchars($_SESSION['user_name']); ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="clients/menu.php?token=<?= urlencode($token); ?>"> <!-- Lien avec token -->
                            <i class="fas fa-tachometer"></i> Tableau de Bord
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="my_orders.php">
                            <i class="fa fa-shopping-cart"></i> Mon panier
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="profile.php">
                            <i class="fas fa-user"></i> Mon profil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="users/logout.php">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>

        <?php 
        } else {
        ?>

            <a href="#" class="btn btn-primary py-2 px-4 shadow-none" data-bs-toggle="modal" data-bs-target="#loginModal">Mon compte</a>

        <?php 
        }
        ?>





    </div>
</nav>
<!-- Boîte Modale pour connexion -->
<div class="modal fade text-center" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Connexion requise</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Vous devez être connecté pour passer une commande.
                <br><br>
                <a href="users/login.php" class="btn btn-primary shadow-none">Se connecter</a> <!-- Redirige vers page login -->
                <a href="users/register.php" class="btn btn-secondary shadow-none">Créer un compte</a> <!-- Redirige vers page inscription -->
            </div>
        </div>
    </div>
</div>
