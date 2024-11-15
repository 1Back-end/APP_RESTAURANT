<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>
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
    <div class="col-md-12 col-sm-12 mb-3">
        <form action="" method="post">
            <div class="row">
                <div class="col-md-4 col-sm-12 mb-3">
                    <div class="card-box p-3 text-center rounded-2">
                    <?php if (!empty($admin_info['photo'])): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($admin_info['photo']); ?>" 
                            alt="Photo de <?php echo htmlspecialchars($admin_info['username']); ?>" 
                            class="rounded-circle img-thumbnail" style="object-fit: cover; width: 200px; height: 250px;">
                    <?php else: ?>
                        <img src="https://i.pinimg.com/564x/07/01/e5/0701e5a1cd4f91681f76cf3691176680.jpg" 
                            alt="Photo de <?php echo htmlspecialchars($admin_info['username']); ?>" 
                            class="rounded-circle img-thumbnail" style="object-fit: cover; width: 200px; height: auto;">
                    <?php endif; ?>
                    <button class="btn btn-customize btn-sm btn-xs text-white py-2 mt-2">Télécharger une nouvelle photo</button>
                    </div>
                </div>
                <div class="col-md-6">
                   <div class="card-box p-3">
                   <div class="col-md-12 col-sm-12 mb-3">
                        <label for="nom">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="nom" value="<?php echo htmlspecialchars($admin_info['username']); ?>" name="nom">
                    </div>
                    <input type="hidden" class="form-control shadow-none" id="user_uuid" value="<?php echo htmlspecialchars($admin_info['admin_uuid']); ?>" name="user_uuid">
                    <div class="col-md-12 col-sm-12 mb-3">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control shadow-none" id="email" name="email" value="<?php echo htmlspecialchars($admin_info['email']); ?>">
                    </div>
                    <div class="col-md-12 col-sm-12 mb-3">
                        <label for="adresse">Adresse <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="adresse" name="adresse" value="<?php echo htmlspecialchars($admin_info['address']); ?>">
                    </div>
                    <div class="col-md-12 col-sm-12 mb-3">
                        <label for="adresse">Numéro de téléphone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-none" id="adresse" name="adresse" value="<?php echo htmlspecialchars($admin_info['phone_number']); ?>">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-customize text-white">Enregistrer les modifications</button>
                    </div>
                   </div>
                </div>
            </div>
        </form>
    </div>
</div>
