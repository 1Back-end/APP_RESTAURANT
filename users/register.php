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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

<style>
    .card-box {
    background-color: #fff;
    border-radius: 10px;
    -webkit-box-shadow: 0 0 28px rgba(0,0,0,.08);
    box-shadow: 0 0 28px rgba(0,0,0,.08);
  }
  small{
    font-size: 10px;
}
</style>
    
<?php include ("process_create_users.php")?>
	<section class="h-100">
		<div class="container h-100 pb-5">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-1">
						<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR747gBca1nrACYantWVCl-fWANdiFxdBrrj6D7x1-jgzIqHfqiUcwADJWGbjZmIhMgC_8&usqp=CAU" alt="logo" width="100">
					</div>
                    <?php if (!empty($erreur)): ?>
                        <div class="alert alert-danger text-center"><?= htmlspecialchars($erreur); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success text-center"><?= htmlspecialchars($success); ?></div>
                    <?php endif; ?> 

					<div class="card shadow-sm border-0">
						<div class="card-body p-3">
							<h1 class="fs-4 card-title fw-bold mb-4">Créer son compte</h1>
							<form method="POST" >
								<div class="mb-3">
									<label class="mb-2" for="name">Nom <span class="text-danger">*</span></label>
									<input id="name" type="text" class="form-control shadow-none" name="name" value="">
                                    <?php if(isset($erreur_champ) && empty($_POST['name'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                     <?php endif; ?>
								</div>

								<div class="mb-3">
									<label class="mb-2" for="email">Email <span class="text-danger">*</span></label>
									<input id="email" type="email" class="form-control shadow-none" name="email">
                                    <?php if(isset($erreur_champ) && empty($_POST['email'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                     <?php endif; ?>
								</div>

								<div class="mb-3">
									<label class="mb-2" for="password">Mot de passe <span class="text-danger">*</span></label>
									<input id="password" type="password" class="form-control shadow-none" name="password">
                                    <?php if(isset($erreur_champ) && empty($_POST['password'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                     <?php endif; ?>
								</div>
                                <div class="mb-3">
									<label class="mb-2" for="password">Confirmer votre mot de passe <span class="text-danger">*</span></label>
									<input id="password" type="password" class="form-control shadow-none" name="confirm_password">  
                                    <?php if(isset($erreur_champ) && empty($_POST['confirm_password'])): ?>
                                        <small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
                                     <?php endif; ?>
								</div>

								<div class="d-flex align-items-center justify-content-between">
									<div class="mr-auto">
									<button type="submit" name="submit" class="btn btn-primary ms-auto shadow-none">
										Créer
									</button>
									</div>
									<div class="ml-auto">
									<a href="../index.php" class="btn btn-secondary shadow-none">
                                        Retour
                                    </a>

									</div>
                           
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