<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<div class="main-container mt-3 pb-5">

    <div class="col-lg-12 col-sm-12  mb-3">
      <div class="card-box text-center text-uppercase p-3">
            <h4>Ajouter un repas</h4>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 mb-3">
    <?php include ("process_create_meals.php")?>  
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

    <div class="col-lg-12 col-sm-12 mb-3">
    <div class="card-box p-3">
        <form action="" method="post" enctype="multipart/form-data"> <!-- Ajout de enctype pour le téléchargement de fichiers -->
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Repas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="nom"  name="nom" value="<?= htmlspecialchars($nom); ?>">
                        <?php if(isset($erreur_champ) && empty($_POST['nom'])): ?>
                                <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                            <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control shadow-none" id="date" name="date" value="<?= htmlspecialchars($date); ?>">
                        <?php if(isset($erreur_champ) && empty($_POST['date'])): ?>
                                <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                            <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-12 mb-3">
                    <div class="mb-3">
                        <label for="prix" class="form-label">Prix <span class="text-danger">*</span></label>
                        <input type="number" class="form-control shadow-none" id="prix" name="prix" value="<?= htmlspecialchars($prix); ?>">
                        <?php if(isset($erreur_champ) && empty($_POST['prix'])): ?>
                                <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="categorie">Catégorie <span class="text-danger">*</span></label>
                        <select class="form-control shadow-none select-custom" id="categorie" name="categorie">
                            <option value="" disabled <?= empty($categorie) ? 'selected' : ''; ?>>Choisir une catégorie</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['category_uuid']); ?>" <?= ($categorie == $category['category_uuid']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if(isset($erreur_champ) && empty($_POST['categorie'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>
                    </div>
                    </div>

                    <div class="mb-3">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control shadow-none" id="description" name="description" rows="5"><?= htmlspecialchars($description); ?></textarea>
                        <?php if(isset($erreur_champ) && empty($_POST['description'])): ?>
                            <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                        <?php endif; ?>
                    </div>

            <div class="mb-3">
                <label for="photos">Télécharger des photos (max 4) <span class="text-danger">*</span></label>
                <input type="file" class="form-control shadow-none" id="photos" name="photos[]" accept="image/*" multiple>
                <?php if(isset($erreur_champ) && empty($_POST['photos'])): ?>
                                <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                <?php endif; ?>
                <div id="preview" class="mt-2"></div> <!-- Zone de prévisualisation des images -->
            </div>

            <div class="mb-3">
                <button type="submit" name="submit" class="btn btn-customize text-white">
                    <i class="fas fa-save mr-1"></i>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>


</div>


<script>
    // Fonction pour afficher les aperçus des images téléchargées
    document.getElementById('photos').addEventListener('change', function(event) {
        const preview = document.getElementById('preview');
        preview.innerHTML = ''; // Efface les précédents aperçus

        const files = event.target.files; // Récupérer les fichiers téléchargés
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result; // Chemin de l'image
                img.style.width = '100px'; // Largeur d'affichage de l'aperçu
                img.style.height = '100px'; // Hauteur d'affichage automatique
                img.style.marginRight = '10px'; // Espace entre les images
                preview.appendChild(img); // Ajouter l'image à la zone de prévisualisation
            };

            reader.readAsDataURL(file); // Lire le fichier comme URL de données
        }
    });
</script>

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