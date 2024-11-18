<?php include_once('../fonction/fonction.php');?>
<?php include_once('../include/menu.php');?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="main-container mt-3 pb-5">
    <div class="col-md-12 col-sm-12 col-xl-12 mb-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h3 class="text-uppercase"><?php echo getCurrentPageName()?></h3>
            </div>
            <div class="ml-auto">
                <p><?php echo getCurrentDateTime();?></p>
            </div>


        </div>
    </div>


<div class="col-md-12 col-sm-12 mb-3">
    <div class="row">
        <div class="col-lg-3 col-sm-12 mb-3">
            <div class="card-box p-3 h-100 text-center">
                <div class="mb-3">
                    <h6 class="text-uppercase font-12">Total des commandes | Ajourd'hui</h6>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="mr-auto logo">
                            <span class="icon-pending text-white font-weight-bold">
                                <i class="fas fa-shopping-bag fs-3"></i> <!-- Icône d'ustensiles -->
                            </span>
                        </div>
                        <div class="ml-auto">
                            <h6>10</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>