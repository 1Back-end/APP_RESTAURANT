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
<?php include ("process_code_otp.php")?>
<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100 mt-5 pb-5">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="mb-3">
                    <?php
                    if ($erreur) {
                        echo "<div class='alert alert-danger text-center' role='alert'>$erreur</div>";
                    }
                    if ($success) { 
                        echo "<div class='alert alert-success text-center' role='alert'>$success</div>";
                    }
                    ?>
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title">Code de validation</h4>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="otp">Entrer votre code de validation</label>
                                    <input type="number" class="form-control shadow-none py-2" name="otp" id="otp">
                                    <?php if (!empty($erreur_champ)): ?>
										<small class="text-danger"><?= htmlspecialchars($erreur_champ) ?></small>
									<?php endif; ?>
                                    <input type="hidden" value="<?php echo $admin_uuid; ?>" class="form-control shadow-none py-2" name="admin_uuid" id="admin_uuid">
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" name="submit" class="btn btn-primary btn-block shadow-none">
                                        Soumettre
                                    </button>
                                </div>
                            </form>

                            <!-- Lien pour renvoyer le code OTP -->
                            <div class="text-center mt-3">
                                <a class="text-decoration-none" href="otp_verification.php?admin_uuid=<?php echo urlencode($admin_uuid); ?>&resend=true">Vous n'avez pas reçu de code ? Renvoyer</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>
</html>