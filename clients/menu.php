<!DOCTYPE html>
<html>
<head>
	<!-- Basic admin Info -->
	<meta charset="utf-8">
	<title><?php echo strtoupper(ucfirst(str_replace(".php", "", basename($_SERVER['PHP_SELF']))));?></title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" type="text/css" href="../vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="../vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="../src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="../vendors/styles/style.css">
	<link rel="stylesheet" type="text/css" href="../vendors/styles/main.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>



	<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
			<div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
			<div class="header-search">
				
			</div>
		</div>
		<div class="header-right">
			<div class="dashboard-setting user-notification">
				
			</div>
			<div class="user-notification">
				<div class="dropdown">
					
					<div class="dropdown-menu dropdown-menu-right">
						<div class="notification-list mx-h-350 customscroll">
						</div>
					</div>
				</div>
			</div>
            <?php include_once('check_session.php');?>
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle">
					<span class="user-icon shadow-none">
                        <span class="user-img">
                            <img src="https://divvia.ca/wp-content/uploads/2023/08/How-To-Ensure-Your-Restaurants-Guests-Are-Enjoying-Themselves-1024x768.jpg" alt="user-img" class="rounded-circle" width='50' height='50' class='rounded-circle' style='border-radius: 50%; object-fit: cover; aspect-ratio: 1/1;'>
                        </span>
				    </span>

                        <small class="user-name fw-bold font-14 text-uppercase" style="color: #28a745;">
                                <?= htmlspecialchars($_SESSION['user_name']); ?>
                        </small>
                </a>

				</div>
			</div>
			
		</div>
	</div>

	
	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="dashboard.php">
				<h3 class="text-uppercase text-white">
					QuickMeal
				</h3>
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
			<ul  id="accordion-menu">
            <li>
					<a href="dashboard.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-tachometer-alt"></span><span class="mtext">Tableau de bord</span>
					</a>
			</li>
                <li>
					<a href="mes_commandes.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-receipt"></span><span class="mtext">Mes commandes</span>
					</a>
				</li>
                <li>
					<a href="mes_paiements.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-credit-card-alt"></span><span class="mtext">Mes paiements</span>
					</a>
				</li>
                <li>
					<a href="mon_compte.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-user"></span><span class="mtext">Mon compte</span>
					</a>
				</li>
                <li>
					<a href="../clients/logout.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-sign-out-alt"></span><span class="mtext">Déconnexion</span>
					</a>
				</li>
			</ul>
			</div>
		</div>
	</div>
	</div>
	</div>

	</div>
	<!-- js -->
	<!-- js -->
	<script src="../vendors/scripts/core.js"></script>
	<script src="../vendors/scripts/script.min.js"></script>
	<script src="../vendors/scripts/process.js"></script>
	<script src="../vendors/scripts/layout-settings.js"></script>
	<script src="../src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="../src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="../src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="../src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<script src="../vendors/scripts/dashboard.js"></script>
</body>
</html>