<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title><?php echo strtoupper(ucfirst(str_replace(".php", "", basename($_SERVER['PHP_SELF']))));?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    
<?php include ("process_create_users.php")?>
	<section class="h-100">
		<div class="container h-100 pb-5">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR747gBca1nrACYantWVCl-fWANdiFxdBrrj6D7x1-jgzIqHfqiUcwADJWGbjZmIhMgC_8&usqp=CAU" alt="logo" width="100">
					</div>
                    <?php if (!empty($erreur)): ?>
                        <div class="alert alert-danger text-center"><?= htmlspecialchars($erreur); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success text-center"><?= htmlspecialchars($success); ?></div>
                    <?php endif; ?> 

					<div class="card shadow-sm border-0">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Créer son compte</h1>
							<form method="POST" >
								<div class="mb-3">
									<label class="mb-2 text-muted" for="name">Nom</label>
									<input id="name" type="text" class="form-control" name="name" value="">
                                    <?php if(isset($erreur_champ) && empty($_POST['name'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                     <?php endif; ?>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">Email</label>
									<input id="email" type="email" class="form-control" name="email">
                                    <?php if(isset($erreur_champ) && empty($_POST['email'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                     <?php endif; ?>
								</div>

								<div class="mb-3">
									<label class="mb-2 text-muted" for="password">Mot de passe</label>
									<input id="password" type="password" class="form-control" name="password">
                                    <?php if(isset($erreur_champ) && empty($_POST['password'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                     <?php endif; ?>
								</div>
                                <div class="mb-3">
									<label class="mb-2 text-muted" for="password">Confirmer votre mot de passe</label>
									<input id="password" type="password" class="form-control" name="confirm_password">  
                                    <?php if(isset($erreur_champ) && empty($_POST['confirm_password'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                     <?php endif; ?>
								</div>

								<div class="d-grid gap-2 mb-3">
									<button type="submit" name="submit" class="btn btn-primary btn-block">
										Créer	
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Vous avez déjà un compte ? <a href="login.php" class="text-dark text-decoration-none">Connectez-vous</a>
                        </div>

						</div>
					</div>
					
				</div>
			</div>
		</div>
	</section>

	<script src="js/login.js"></script>
</body>
</html>