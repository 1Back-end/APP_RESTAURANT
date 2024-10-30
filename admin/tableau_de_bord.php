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
        
    <div class="col-lg-3 col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3 text-center h-100">
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
    <div class="card-box p-3 text-center h-100">
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
    <div class="card-box p-3 text-center h-100">
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
    <div class="card-box p-3 text-center h-100">
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


<div class="col-lg-6 col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3 h-100">
        <h6 class="mb-3 font-14 text-uppercase">Nombre de commandes par jour</h6>
        <canvas id="ordersChart"></canvas>
    </div>
</div>


<div class="col-lg-6 col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3 h-100">
        <h6 class="mb-3 font-14 text-uppercase">Montant Total des Commandes par Jour</h6>
        <canvas id="totalAmountChart"></canvas>
    </div>
</div>

        
    </div>
</div>










</div>


<script>
     Chart.defaults.font.family = 'Rubik';
     const labels = <?= json_encode($labels); ?>;
const data = {
    labels: labels,
    datasets: [{
        label: 'Nombre de commandes',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        data: <?= json_encode($orderCounts); ?>,
        tension:1.5,
    }]
};

const config = {
    type: 'line', // Utiliser 'line' pour un graphique linéaire
    data: data,
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw; // Affiche le nombre de commandes
                    }
                }
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Date'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Nombre de Commandes'
                },
                beginAtZero: true
            }
        }
    }
};

// Créer le graphique
const ordersChart = new Chart(
    document.getElementById('ordersChart'),
    config
);
</script>

<script>
// Données passées par PHP
const totalLabels = <?= json_encode($totalLabels); ?>;
const totalData = {
    labels: totalLabels,
    datasets: [{
        label: 'Montant Total',
        backgroundColor: 'rgba(153, 102, 255, 0.2)',
        borderColor: 'rgba(153, 102, 255, 1)',
        borderWidth: 1,
        data: <?= json_encode($totalAmounts); ?>,
        tension:1.2,
    }]
};

const totalConfig = {
    type: 'line', // Utiliser 'line' pour un graphique linéaire
    data: totalData,
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw + ' FCFA'; // Affiche le montant total
                    }
                }
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Date'
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Montant Total (FCFA)'
                },
                beginAtZero: true
            }
        }
    }
};

// Créer le graphique
const totalAmountChart = new Chart(
    document.getElementById('totalAmountChart'),
    totalConfig
);
</script>