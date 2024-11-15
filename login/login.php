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

<?php include ("script_login.php")?>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100 mt-5 pb-5">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
                <?php if (!empty($erreur)) : ?>
           			 <div class="alert alert-danger text-center" role="alert">
                <?= $erreur ?>
                    </div>
                <?php endif; ?>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Connectez vous à votre compte</h4>
							<form method="POST">
								<div class="form-group">
									<label for="email">Adresse Email</label>
									<input id="email" type="email" class="form-control shadow-none" value="<?= htmlspecialchars($emailOrUsername ?? '') ?>" name="email">
                                    <?php if(isset($erreur_champ) && empty($_POST['email'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                    <?php endif; ?>
								</div>

								<div class="form-group">
									<label for="password">Mot de passe
										<a href="forgot.php" class="float-right text-decoration-none">
											Mot de passe oublié ?
										</a>
									</label>
									<input id="password" type="password" class="form-control shadow-none" name="password" data-eye>
                                    <?php if(isset($erreur_champ) && empty($_POST['password'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                    <?php endif; ?>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="remember_me" id="remember" class="custom-control-input shadow-none">
										<label for="remember" class="custom-control-label">Se souvenir de moi</label>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" name="submit" class="btn btn-primary btn-block shadow-none">
										Se connecter
									</button>
								</div>
								
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>
</html>