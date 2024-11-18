<?php include_once('../fonction/fonction.php');?>
<?php include_once('../include/menu.php');?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div class="main-container mt-3 pb-5">
    <div class="col-md-12 col-sm-12 col-xl-12 mb-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="mr-auto">
                <h4 class="text-uppercase font-16"><?php echo getCurrentPageName()?></h4>
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
                            <h6><?php echo $total_amount_today;?> XAF</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-3 col-sm-12 mb-3">
            <div class="card-box p-3 h-100 text-center">
                <div class="mb-3">
                    <h6 class="text-uppercase font-12">Total des reservations | Ajourd'hui</h6>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="mr-auto logo">
                            <span class="icon-pending text-white font-weight-bold">
                                <i class="fas fa-utensils fs-3"></i> <!-- Icône d'ustensiles -->
                            </span>
                        </div>
                        <div class="ml-auto">
                            <h6><?php echo $total_reservations_today;?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-3 col-sm-12 mb-3">
            <div class="card-box p-3 h-100 text-center">
                <div class="mb-3">
                    <h6 class="text-uppercase font-12">Total des livraisons | Ajourd'hui</h6>
                </div>
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="mr-auto logo">
                            <span class="icon-pending text-white font-weight-bold">
                                <i class="fas fa-truck fs-3"></i> <!-- Icône d'ustensiles -->
                            </span>
                        </div>
                        <div class="ml-auto">
                            <h6><?php echo $deliveries_delivered_today;?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="col-lg-12 col-sm-12 mb-3">
        <div class="row">

        <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
            <div class="card-box p-3 h-100">
                <!-- <h6 class="mb-3 font-14 text-uppercase">Nombre de commandes par statut</h6> -->
                <canvas id="orderStatusChart" width="400" height="200"></canvas>
            </div>
        </div>
        </div>

    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
<script>
    Chart.defaults.font.family = 'Rubik';
    const ctx = document.getElementById('orderStatusChart').getContext('2d');
    const orderStatusChart = new Chart(ctx, {
        type: 'bar',  // Bar Chart
        data: {
            labels: <?php echo json_encode($translated_statuses); ?>,  // Les statuts en français
            datasets: [{
                label: 'Nombre de commandes par statut',
                data: <?php echo json_encode($data_counts); ?>,  // Les données (compte des commandes)
                backgroundColor: <?php echo json_encode($background_colors); ?>  // Couleurs des barres pour chaque statut
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Nombre de commandes par statut'
                }
            }
        }
    });
</script>