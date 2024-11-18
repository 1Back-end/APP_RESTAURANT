<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<div class="main-container mt-3 pb-5">

    <div class="col-md-12 col-sm-12  mb-3">
      <div class="card-box text-center text-uppercase p-3">
            <h4>Ajouter un livreur</h4>
      </div>
    </div>
    <div class="col-md-12 col-sm-12 mb-3">
    <?php include ("process_create_delivery.php"); ?>  
    <?php if (!empty($erreur)): ?>
    <div id="error-message" class="alert alert-danger text-center" role="alert">
        <?= htmlspecialchars($erreur) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div id="success-message" class="alert alert-success text-center" role="alert">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

</div>
<div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" name="nom" value="<?= (empty($erreur) && !empty($success)) ? '' : (isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '') ?>">
                        <?php if (isset($erreur_champ) && empty($_POST['nom'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" name="prenom" value="<?= (empty($erreur) && !empty($success)) ? '' : (isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '') ?>">
                        <?php if (isset($erreur_champ) && empty($_POST['prenom'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control shadow-none" name="email" value="<?= (empty($erreur) && !empty($success)) ? '' : (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '') ?>">
                        <?php if (isset($erreur_champ) && empty($_POST['email'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control shadow-none" name="telephone" value="<?= (empty($erreur) && !empty($success)) ? '' : (isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : '') ?>">
                        <?php if (isset($erreur_champ) && empty($_POST['telephone'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="cni" class="form-label">Numéro CNI <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" name="cni" value="<?= (empty($erreur) && !empty($success)) ? '' : (isset($_POST['cni']) ? htmlspecialchars($_POST['cni']) : '') ?>">
                        <?php if (isset($erreur_champ) && empty($_POST['cni'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="disponibilite" class="form-label">Disponible <span class="text-danger">*</span></label>
                        <select name="disponibilite" id="disponibilite" class="form-control shadow-none select-custom">
                            <option disabled selected>Choisir sa disponibilité</option>
                            <?php 
                                // Passez la valeur soumise si elle existe
                                $selectedAvailability = isset($_POST['disponibilite']) ? $_POST['disponibilite'] : null;
                                echo generateAvailabilityOptions($selectedAvailability); 
                            ?>
                        </select>
                        <?php if (isset($erreur_champ) && empty($_POST['disponibilite'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                        <label for="photo" class="form-label">Photo (JPEG/PNG, max 5MB)</label>
                        <input type="file" class="form-control shadow-none" name="photo" accept="image/*">
                
            </div>
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                <button type="submit" name="submit" class="btn btn-customize text-white shadow-none text-uppercase mb-3 btn-responsive">
                    <i class="fas fa-plus"></i>
                    Ajouter
                </button>
                <a href="liste_livreurs.php" class="btn btn-secondary shadow-none text-uppercase mb-3 btn-responsive">
                    <i class="fas fa-backward"></i>
                    Retour
                </a>
            </div>
        </form>
    </div>
</div>


<script>
    // Attendre que le document soit prêt
    document.addEventListener("DOMContentLoaded", function() {
        // Masquer le message d'erreur après 2 secondes
        const errorMessage = document.getElementById('error-message');
        const successsMessage = document.getElementById('successs-message');

        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 2000); // 2000 ms = 2 secondes
        }

        if (successsMessage) {
            setTimeout(() => {
                successsMessage.style.display = 'none';
            }, 2000); // 2000 ms = 2 secondes
        }
    });
</script>