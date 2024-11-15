<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>
<div class="main-container mt-3 pb-5">

    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box text-center text-uppercase p-3">
            <h6>Ajouter un menu</h6>
        </div>
    </div>
<div class="col-md-12 col-sm-12 mb-3">
    <?php include ("process_create_menu.php")?>  
            <?php if (!empty($erreur)) : ?>
                <div id="error-message" class="alert alert-danger text-center" role="alert">
                    <?= $erreur ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($succes)) : ?>
                <div id="success-message" class="alert alert-success text-center" role="alert">
                    <?= $succes ?>
                </div>
            <?php endif; ?>
    </div>
    
    <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box p-3">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label for="nom">Nom du menu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="nom" name="nom">
                        <?php if (isset($erreur_champ) && empty($_POST['nom'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label for="lien">Nom de la page (sans extension) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="lien" name="lien" placeholder="Ex: service">
                        <?php if (isset($erreur_champ) && empty($_POST['lien'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label for="description">Description du menu</label>
                        <textarea class="form-control shadow-none" id="description" name="description">

                        </textarea>
                        <?php if (isset($erreur_champ) && empty($_POST['description'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label for="sort_order">Ordre de Tri</label>
                        <input type="number" id="sort_order" name="sort_order" class="form-control shadow-none" value="0">
                        <?php if (isset($erreur_champ) && empty($_POST['sort_order'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-customize text-white btn-responsive">Créer Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Attendre que le document soit prêt
    document.addEventListener("DOMContentLoaded", function() {
        // Masquer le message d'erreur après 2 secondes
        const errorMessage = document.getElementById('error-message');
        const successMessage = document.getElementById('success-message');

        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 2000); // 2000 ms = 2 secondes
        }

        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 2000); // 2000 ms = 2 secondes
        }
    });
</script>

