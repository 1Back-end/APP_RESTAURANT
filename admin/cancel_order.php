<?php include_once('../include/menu.php');?>
<?php include_once('../fonction/fonction.php');?>

<?php $order_id = $_GET['order_id'];?>
<div class="main-container mt-5 pb-5">
<div class="col-lg-6 col-sm-12 mb-3 mx-auto">
    <?php include ("process_cancel_order.php")?>  
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
<div class="col-md-6 col-sm-12 mx-auto">
       <form action="" method="post">
       <div class="card-box shadow p-4 border-0">
            <h5 class="card-title mb-3">Annulation de la commande</h5>
            <p class="card-text mb-4 font-12">
                Veuillez entrer la raison pour laquelle la commande sera annulée
            </p>
            <div class="form-group mb-4">
                <textarea name="cancellation_reason" class="form-control shadow-none" rows="5" required placeholder="Raison de l'annulation..."></textarea>
                <?php if(isset($erreur_champ) && empty($_POST['cancellation_reason'])): ?>
                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                <?php endif; ?>
            </div>
                <input type="hidden" value="<?php echo $order_id;?>" name="order_id" class="form-control">
                <button type="submit" name="submit" class="btn btn-danger w-100 shadow-none">
                    Annuler la commande
                </button>
        </div>
       </form>
    </div>

</div>

