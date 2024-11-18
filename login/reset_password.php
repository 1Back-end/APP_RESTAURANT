<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title><?php echo strtoupper(ucfirst(str_replace(".php", "", basename($_SERVER['PHP_SELF']))));?></title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>
<?php include 'process_reset_password.php'; ?>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100 mt-5 pb-5">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
                    <div class="mb-3">
                        <!-- Afficher les messages d'erreur ou de succès -->
                        <?php if ($erreur): ?>
                                <div class="alert alert-danger text-center"><?php echo $erreur; ?></div>
                            <?php endif; ?>
                            <?php if ($success): ?>
                                <div class="alert alert-success text-center"><?php echo $success; ?></div>
                        <?php endif; ?>
                    </div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Créer un nouveau mot de passe</h4>
							
							<form method="POST">
								<div class="form-group">
									<label for="password">Mot de passe</label>
									<input id="password" name="password" type="password" class="form-control shadow-none">
                                    <?php if (!empty($erreur_champ)): ?>
										<small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
									<?php endif; ?>
								</div>

								<div class="form-group">
									<label for="confirm_password">Confirmer votre mot de passe</label>
									<input id="confirm_password" name="confirm_password" type="password" class="form-control shadow-none">
                                    <?php if (!empty($erreur_champ)): ?>
										<small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
									<?php endif; ?>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="show_password" id="show_password" class="custom-control-input shadow-none">
										<label for="show_password" class="custom-control-label">Afficher mot de passe</label>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" name="submit" class="btn btn-primary btn-block shadow-none">
										Valider
									</button>
								</div>
							</form>

						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>

	<!-- Ajouter le script pour afficher/masquer les mots de passe -->
	<script>
		document.getElementById('show_password').addEventListener('change', function() {
			// Obtenez les éléments des champs de mot de passe
			var passwordField = document.getElementById('password');
			var confirmPasswordField = document.getElementById('confirm_password');

			// Si la case est cochée, afficher le mot de passe
			if (this.checked) {
				passwordField.type = 'text';
				confirmPasswordField.type = 'text';
			} else {
				// Sinon, masquer le mot de passe
				passwordField.type = 'password';
				confirmPasswordField.type = 'password';
			}
		});
	</script>
</body>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>
</html>