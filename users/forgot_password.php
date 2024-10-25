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
	<section class="h-100">
		<div class="container h-100 pb-5">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-2">
						<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR747gBca1nrACYantWVCl-fWANdiFxdBrrj6D7x1-jgzIqHfqiUcwADJWGbjZmIhMgC_8&usqp=CAU" alt="logo" width="100">
					</div>
					<div class="card shadow-sm border-0">
						<div class="card-body p-3">
							<h1 class="fs-4 card-title fw-bold mb-4">Mot de passe oublié</h1>
							<form method="POST" class="needs-validation" novalidate="" autocomplete="off">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">Adresse email</label>
									<input id="email" type="email" class="form-control shadow-none" name="email" value="" required autofocus>
									
								</div>

								<div class="d-grid gap-2 mb-3">
									<button type="submit" class="btn btn-primary btn-block shadow-none btn-lg">
                                    <i class="fas fa-paper-plane-o"></i>
                                        Soumettre
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Vous vous souvenez de votre mot de passe ? <a href="login.php" class="text-dark text-decoration-none">Connectez-vous</a>
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