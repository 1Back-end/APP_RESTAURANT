<?php include ('menu.php');?>
<?php include('fonction.php');?>


<div class="main-container mt-3 pb-5">
    <div class="col-md-8 col-sm-12 mb-3">
        <div class="card-box p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h6 class="text-uppercase font-16">
                    Modifier les informations de mon compte
                </h6>
            </div>
            <div class="ml-auto">
                <h6 class="font-16"><?php echo $today;?></h6>       
            </div>
        </div>
        </div>
</div>

<div class="col-md-8 col-sm-12 mb-3">
    <div class="card-box p-3">
        <form action="" method="post">
            <div class="row">
                <div class="col-md-12 col-sm-12 mb-3">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control shadow-none" id="nom" name="nom">
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <label for="prenom">Email</label>
                    <input type="email" class="form-control shadow-none" id="email" name="email">
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <label for="adresse">Adresse</label>
                    <input type="text" class="form-control shadow-none" id="adresse" name="adresse">
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <label for="">Numéro de téléphone</label>
                    <input type="tel" class="form-control shadow-none" id="telephone" name="telephone">
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <button class="btn btn-customize text-white">
                        Modifier les informations
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
