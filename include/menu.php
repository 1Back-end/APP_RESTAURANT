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
			<?php
			session_start();
			if (!isset($_SESSION["admin_uuid"])) {
				header("Location: ../login/login.php");
				exit();
			}
			?>
			<div class="user-info-dropdown">
				<div class="dropdown text-success" id="userInfo">
					<a class="dropdown-toggle text-success" href="#" role="button" data-toggle="dropdown">
					<span class="user-icon shadow-none">
					<?php
						$avatar_path = "../uploads/";
						$default_avatar = "https://i.pinimg.com/564x/07/01/e5/0701e5a1cd4f91681f76cf3691176680.jpg";
						$avatar = isset($_SESSION['photo']) && !empty($_SESSION['photo']) && file_exists($avatar_path . $_SESSION['photo'])
								? $avatar_path . $_SESSION['photo'] 
								: $default_avatar;

						$username = ucfirst(strtolower($_SESSION['username'] ?? 'Utilisateur Lamda')); // Gestion du cas où la session est vide
						?>
						<img id="userPhoto" src="<?= htmlspecialchars($avatar) ?>" width="50" height="50" class="rounded-circle" 
						style="border-radius: 50%; object-fit: cover; aspect-ratio: 1/1;">
					</span>

					<small id="userName" class="user-name fw-bold font-14 text-capitalize" style="color: #28a745;">
						<?= htmlspecialchars($username) ?>
					</small>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
						<a class="dropdown-item" href="../admin/profil.php"><i class="fas fa-user"></i> Profil</a>
						<a class="dropdown-item" href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
					</div>

				</div>
			</div>
			
		</div>
	</div>

	
	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="../admin/tableau_de_bord.php">
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
					<a href="../admin/tableau_de_bord.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-tachometer-alt"></span><span class="mtext">Tableau de bord</span>
					</a>
				</li>
				<li>
					<a href="../admin/toutes_commandes.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-shopping-bag"></span><span class="mtext">Commandes</span>
					</a>
				</li>
				<li>
					<a href="../admin/reservations.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-cart-plus"></span><span class="mtext">Reservations</span>
					</a>
				</li>
				<li>
					<a href="../admin/livraisons_disponibles.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-truck"></span><span class="mtext">Livraisons</span>
					</a>
				</li>
				<li>
					<a href="../admin/historique_paiements.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-credit-card"></span><span class="mtext">Paiements</span>
					</a>
				</li>

				<li>
					<a href="../admin/liste_users.php" class="dropdown-toggle no-arrow">
						<span class="micon fas fa-users"></span><span class="mtext">Utilisateurs</span>
					</a>
				</li>

				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon fas fa-utensils"></span><span class="mtext">Repas</span>
					</a>
					<ul class="submenu">
						<li><a href="../admin/liste_repas.php">Liste des repas</a></li>
						<li><a href="../admin/ajouter_repas.php">Ajouter un repas</a></li>
						<li><a href="../admin/categorie_repas.php">Catégories de repas</a></li>
					</ul>
				</li>

				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon fas fa-user-plus"></span><span class="mtext">Livreurs</span>
					</a>
					<ul class="submenu">
						<li><a href="../admin/liste_livreurs.php">Liste des livreurs</a></li>
						<li><a href="../admin/ajouter_livreur.php">Ajouter un livreur</a></li>
					</ul>
				</li>

			
				<li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon fas fa-cog"></span><span class="mtext">Paramètres</span>
					</a>
					<ul class="submenu">
						<li><a href="../admin/mon_compte.php">Mon compte</a></li>
						<!-- <li><a href="../admin/liste_users.php">Mes utilisateurs</a></li>
						<li><a href="../admin/notificactions.php">Notifications</a></li> -->
					</ul>
				</li>
				
				<!-- <li class="dropdown">
					<a href="javascript:;" class="dropdown-toggle">
						<span class="micon fas fa-cloud-upload"></span><span class="mtext">CMS</span>
					</a>
					<ul class="submenu">
						<li><a href="../admin/menu.php">Menu</a></li>
					</ul>
				</li> -->
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
	<script src="../vendors/scripts/dashboard.js"></script>
</body>
</html>