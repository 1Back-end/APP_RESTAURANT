<?php include ('menu.php');?>
<?php include('fonction.php');?>
<?php
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_uuid']) || !isset($_SESSION['user_name'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../users/login.php");
    exit();
}
?>
<link rel="stylesheet" href="style.css">



<div class="main-container mt-3 pb-5">
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box p-3">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="mb-2 mb-md-0 mr-md-auto w-100">
                <h6 class="text-uppercase font-14">
                   les informations de  Mon compte
                </h6>
            </div>
            <div class="ml-md-auto w-100">
                <h6 class="font-14"><?php echo $today;?></h6>       
            </div>
        </div>
        </div>
</div>
<?php
// Supposons que $connexion est votre connexion PDO et que $user_uuid est l'UUID du user connecté
$user_info = get_info_users($connexion, $user_uuid);
?>
<div class="col-md-12 col-sm-12 mb-3">
    <!-- Affichage des messages de succès et d'erreur -->
    <?php include_once("process_update_profil.php");?>
    <?php if (!empty($succes)) : ?>
        <div id="alert-success" class="alert alert-success text-center"><?php echo $succes; ?></div>
    <?php elseif (!empty($erreur)) : ?>
        <div id="alert-danger" class="alert alert-danger text-center"><?php echo $erreur; ?></div>
    <?php endif; ?>
</div>

<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3">
        <!-- Formulaire de mise à jour du profil -->
        <form action="" method="post">
            <div class="row">
                <div class="col-md-12 col-sm-12 mb-3">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control shadow-none" id="nom" value="<?php echo htmlspecialchars($user_info['username']); ?>" name="nom">
                </div>
                    <input type="hidden" class="form-control shadow-none" id="user_uuid" value="<?php echo htmlspecialchars($user_info['user_uuid']); ?>" name="user_uuid">
            
                <div class="col-md-12 col-sm-12 mb-3">
                    <label for="prenom">Email</label>
                    <input type="email" class="form-control shadow-none" id="email" name="email" value="<?php echo htmlspecialchars($user_info['email']); ?>">
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <label for="adresse">Adresse</label>
                    <input type="text" class="form-control shadow-none" id="adresse" name="adresse" value="<?php echo htmlspecialchars($user_info['address']); ?>">
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <label for="">Numéro de téléphone</label>
                    <input type="tel" class="form-control shadow-none" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user_info['phone_number']); ?>">
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <button class="btn btn-customize text-white text-uppercase font-14 btn-responsive">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                        Modifier les informations
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Masque les messages d'alerte après 2 secondes
    setTimeout(function() {
        const successAlert = document.getElementById('alert-success');
        const errorAlert = document.getElementById('alert-danger');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 2000);
</script>