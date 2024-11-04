<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo strtoupper(ucfirst(str_replace(".php", "", basename($_SERVER['PHP_SELF']))));?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
$order_id = $_GET['order_id'];
?>
<div class="container mt-5 pb-5">
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card shadow p-4 border-0">
            <h5 class="card-title mb-3">Annulation de la commande</h5>
            <p class="card-text mb-4 font-12">
                Veuillez entrer la raison pour laquelle la commande sera annulée
            </p>
            <div class="form-group mb-4">
                <textarea name="cancellation_reason" class="form-control shadow-none" id="cancellationReason" rows="5" placeholder="Raison de l'annulation..."></textarea>
            </div>
                <input type="hidden" value="<?php echo $order_id;?>" class="form-control">
            <button type="submit" class="btn btn-danger w-100 shadow-none">
                Annuler la commande
            </button>
        </div>
    </div>
</div>

</body>
</html>