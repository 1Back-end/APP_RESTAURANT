<?php include_once('../fonction/fonction.php');?>
<?php include_once('../include/menu.php');?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


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
        
    <div class="col-lg-3 col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3 text-center">
        <h6 class="mb-3 font-16 text-uppercase">Total des repas</h6>
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <span class="icon-pending text-white font-weight-bold">
                    <i class="fas fa-utensils fs-3"></i> <!-- Icône d'ustensiles -->
                </span>
            </div>
            <h6 class="fs-3">
                <?php echo $total_meals; // Récupération du nombre de repas?>
            </h6>
        </div>
    </div>
</div>



<div class="col-lg-3 col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3 text-center">
        <h6 class="mb-3 font-14 text-uppercase">Total des catégories</h6>
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <span class="icon-pending text-white font-weight-bold">
                    <i class="fas fa-concierge-bell"></i> <!-- Icône d'ustensiles -->
                </span>
            </div>
            <h6 class="fs-3">
                <?php echo $total_category;?> <!-- Récupération du nombre de catégories -->
            </h6>
        </div>
    </div>
</div>


<div class="col-lg-3 col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3 text-center">
        <h6 class="mb-3 font-14 text-uppercase">Total des livreurs</h6>
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <span class="icon-pending text-white font-weight-bold">
                    <i class="fas fa-bicycle fs-3"></i> <!-- Icône d'ustensiles -->
                </span>
            </div>
            <h6 class="fs-3">
                <?php echo $total_delivery;?> <!-- Récupération du nombre de livreurs -->
            </h6>
        </div>
    </div>
</div>



<div class="col-lg-3 col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3 text-center">
        <h6 class="mb-3 font-14 text-uppercase">Total des clients</h6>
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <span class="icon-pending text-white font-weight-bold">
                    <i class="fas fa-users fs-3"></i> <!-- Icône d'ustensiles -->
                </span>
            </div>
            <h6 class="fs-3" id="customerCount">
                <?php echo $total_customer;?> <!-- Récupération du nombre de clients -->
            </h6>
        </div>
    </div>
</div>

        
    </div>
</div>










</div>