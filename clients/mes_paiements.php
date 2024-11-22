<?php include ('menu.php');?>
<?php include('fonction.php');?>
<?php
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_uuid']) || !isset($_SESSION['user_name'])) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: ../users/login.php");
    exit();
}
?>
<div class="main-container mt-3 pb-2">
   <div class="col-md-12 col-sm-12 mb-3">
        <div class="card-box p-3">
            <h5 class="text-uppercase">Mes paiements éffectués (<?php echo $total_payment_by_user_uuid?>) </h5>
        </div>
   </div>

   <div class="col-md-12 col-sm-12 mb-3">
    <div class="card-box p-3">
        <div class="table-responsive">
            <table class="table table-bordered text-center table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>N° Commande</th>
                        <th>N° Paiement</th>
                        <th>Montant</th>
                        <th>Méthode</th>
                        <th>Statut</th>
                        <th>Date paiement</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($all_payments_by_user_uuid)) : ?>
                        <?php foreach ($all_payments_by_user_uuid as $index => $payment) : ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= htmlspecialchars($payment['num_order']); ?></td>
                                <td><?= htmlspecialchars($payment['num_payments']); ?></td>
                                <td><?= number_format(round($payment['amount'], -2), 0) ?> FCFA</td>
                                <td><?= htmlspecialchars($payment['payment_method']); ?></td>
                                <td>
                                    <?php 
                                        if ($payment['payment_status'] == 'payé') {
                                            echo '<span class="badge badge-success">Payé</span>';
                                        } elseif ($payment['payment_status'] == 'échec') {
                                            echo '<span class="badge badge-danger">Échoué</span>';
                                        } else {
                                            echo '<span class="badge badge-warning">' . htmlspecialchars($payment['payment_status']) . '</span>';
                                        }
                                    ?>
                                </td>
                                <td><?= date('d-m-Y H:i', strtotime($payment['payment_date'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7">Aucun enregistrement trouvé</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>