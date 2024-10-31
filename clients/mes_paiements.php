<?php include ('menu.php');?>
<?php
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_uuid']) || !isset($_SESSION['user_name'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../users/login.php");
    exit();
}
?>
<div class="main-container mt-5 pb-2">
    <h1><?php echo $_SESSION['user_uuid']?></h1>

</div>