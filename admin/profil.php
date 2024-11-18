<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>
<style>
    
  .img-account-profile {
    width: 150px; /* Taille de l'image */
    height: 150px; /* Taille de l'image */
    border-radius: 50%; /* Pour arrondir l'image */
    object-fit: cover; /* Pour que l'image conserve ses proportions et remplisse le conteneur */
    cursor: pointer; /* Curseur pointer pour indiquer que l'image est cliquable */
}
</style>
<div class="main-container mt-3 pb-5">
    <div class="col-md-10 col-sm-12 mb-3">
        <div class="card-box p-3">
            <h5 class="text-center text-uppercase">Mon profil</h5>
        </div>
    </div>
    <?php
    // Supposons que $connexion est votre connexion PDO et que $_SESSION['admin_uuid'] est défini
    $admin_info = get_info_users($connexion, $_SESSION['admin_uuid']);
    ?>
    <?php include_once('process_update_profil.php'); ?>
    <div class="col-md-10 col-sm-12 mb-3">
            <?php if (!empty($erreur)) : ?>
                <div id="error-message" class="alert alert-danger text-center" role="alert">
                    <?= $erreur ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)) : ?>
                <div id="success-message" class="alert alert-success text-center" role="alert">
                    <?= $success ?>
                </div>
            <?php endif; ?>
    </div>
   <div class="col-md-12 col-sm-12 mb-3">
    <form action=""  method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-4 col-sm-12 mb-3">
                <div class="card-box p-3 text-center rounded-2">
                    <!-- Affichage de l'image actuelle -->
                    <?php if (!empty($admin_info['photo'])): ?>
                        <img id="profile-img" src="../uploads/<?php echo htmlspecialchars($admin_info['photo']); ?>" 
                            alt="Photo de <?php echo htmlspecialchars($admin_info['username']); ?>" 
                            class="rounded-circle img-thumbnail img-account-profile">
                    <?php else: ?>
                        <img id="profile-img" src="https://i.pinimg.com/564x/07/01/e5/0701e5a1cd4f91681f76cf3691176680.jpg" 
                            alt="Photo de <?php echo htmlspecialchars($admin_info['username']); ?>" 
                            class="rounded-circle img-thumbnail img-account-profile">
                    <?php endif; ?>

                    <!-- Champ de saisie pour télécharger une nouvelle photo -->
                    <input type="file" class="form-control mt-2 text-center" name="new_photo" accept="image/*" onchange="previewImage(event)" id="file-input" style="display: block;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-box p-3">
                    <!-- Formulaire pour les autres informations de l'utilisateur -->
                    <div class="col-md-12 col-sm-12 mb-3">
                        <label for="nom">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="nom" value="<?php echo htmlspecialchars($admin_info['username']); ?>" name="username">
                    </div>
                    <input type="hidden" class="form-control shadow-none" id="admin_uuid" value="<?php echo htmlspecialchars($admin_info['admin_uuid']); ?>" name="admin_uuid">
                    <div class="col-md-12 col-sm-12 mb-3">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control shadow-none" id="email" name="email" value="<?php echo htmlspecialchars($admin_info['email']); ?>">
                    </div>
                    <div class="col-md-12 col-sm-12 mb-3">
                        <label for="adresse">Adresse <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="address" name="address" value="<?php echo htmlspecialchars($admin_info['address']); ?>">
                    </div>
                    <div class="col-md-12 col-sm-12 mb-3">
                        <label for="telephone">Numéro de téléphone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($admin_info['phone_number']); ?>">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" name="submit" class="btn btn-customize btn-responsive text-white">Enregistrer les modifications</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Fonction JavaScript pour afficher l'image sélectionnée
    function previewImage(event) {
        // Récupérer le fichier sélectionné
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Afficher l'image dans le tag img une fois qu'elle est chargée
                document.getElementById('profile-img').src = e.target.result;
            };
            reader.readAsDataURL(file);  // Lire l'image en tant que Data URL (base64)
        }
    }
</script>
<script>
    if (window.location.search.includes('success') || window.location.search.includes('error')) {
        // Retirer les paramètres de l'URL après chargement
        const url = new URL(window.location.href);
        url.searchParams.delete('success');
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url.toString());
    }
</script>


