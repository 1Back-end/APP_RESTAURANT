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

        <!-- Vérifier si l'utilisateur est connecté -->
        <?php if (isset($_SESSION['user_name'])): ?>
            <span class="nav-item nav-link text-white">Hello, <?= htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="users/logout.php" class="btn btn-primary py-2 px-4 shadow-none">Se déconnecter</a>
        <?php else: ?>
            <a href="#" class="btn btn-primary py-2 px-4 shadow-none" data-bs-toggle="modal" data-bs-target="#loginModal">Mon compte</a>
            
        <?php endif; ?>
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
