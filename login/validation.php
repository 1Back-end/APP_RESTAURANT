<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kodinger">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/my-login.css">
    <style>
        .otp-input {
            width: 60px; /* Adjust the width as needed */
            margin: 0 5px; /* Space between inputs */
            text-align: center; /* Center the text in the input */
        }
    </style>
</head>

<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100 mt-5 pb-5">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title text-center">Entrer votre code de validation</h4>
                            <form method="POST">
                                <div class="form-group d-flex justify-content-center">
                                    <input type="text" class="form-control otp-input" maxlength="1" required>
                                    <input type="text" class="form-control otp-input" maxlength="1" required>
                                    <input type="text" class="form-control otp-input" maxlength="1" required>
                                    <input type="text" class="form-control otp-input" maxlength="1" required>
                                </div>

                                <div class="form-group d-flex justify-content-center mt-3">
                                    <button type="submit" class="btn btn-primary shadow-none">
                                        Soumettre
                                    </button>
                                </div>
                                
                            </form>
                        </div>
                        <div class="card-footer py-3 border-0">
                            <div class="text-center">
                                Je n'ai pas reçu   <a href="login.php" class="text-primary text-decoration-none">Renvoyer</a>
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
