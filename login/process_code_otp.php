<?php
include_once("../database/connexion.php");

$admin_uuid = $_GET['admin_uuid']; // Récupérer l'admin_uuid depuis l'URL
$erreur = "";
$success = "";
$erreur_champ = "";

// Vérifier si le formulaire a été soumis
if (isset($_POST["submit"])) {
    $otp_input = $_POST["otp"] ?? null;
    $admin_uuid = $_POST["admin_uuid"] ?? null;

    // Vérifier si l'OTP est bien renseigné
    if (empty($otp_input)) {
        $erreur_champ = "Veuillez entrer le code de validation.";
    } else {
        // Vérifier si l'OTP existe et n'a pas expiré
        $query = $connexion->prepare("SELECT * FROM forgot_password WHERE admin_uuid = :admin_uuid AND token = :otp AND expires_at > NOW() AND status = 'pending' LIMIT 1");
        $query->execute(['admin_uuid' => $admin_uuid, 'otp' => $otp_input]);
        $forgot_data = $query->fetch();

        if ($forgot_data) {
            // OTP valide et non expiré
            $success = "OTP vérifié avec succès. Vous pouvez maintenant réinitialiser votre mot de passe.";

            // Mettre à jour le statut de l'OTP à 'used'
            $update = $connexion->prepare("UPDATE forgot_password SET status = 'used' WHERE uuid = :uuid");
            $update->execute(['uuid' => $forgot_data['uuid']]);

            // Vous pouvez rediriger l'utilisateur vers la page de réinitialisation du mot de passe
            header("Location: reset_password.php?admin_uuid=" . urlencode($admin_uuid));
            exit;
        } else {
            // OTP invalide ou expiré
            $erreur = "Le code de validation est invalide ou a expiré.";
        }
    }
}

// Vérification si l'utilisateur a cliqué sur le lien pour renvoyer l'OTP
if (isset($_GET['resend']) && $_GET['resend'] == 'true') {
    // Vérifier si l'admin_uuid existe
    $query = $connexion->prepare("SELECT admin_uuid, email, username FROM admin_users WHERE admin_uuid = :admin_uuid AND is_deleted = 0 AND is_active = 1");
    $query->execute(['admin_uuid' => $admin_uuid]);
    $user = $query->fetch();

    if ($user) {
        // Générer un nouvel OTP
        $otp = rand(1000, 9999); // Code OTP à 4 chiffres
        $token_expiration = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        // Vérifier si un OTP existe déjà pour cet utilisateur et s'il est encore en statut 'pending'
        $check_existing_otp = $connexion->prepare("SELECT * FROM forgot_password WHERE admin_uuid = :admin_uuid AND status = 'pending' LIMIT 1");
        $check_existing_otp->execute(['admin_uuid' => $user['admin_uuid']]);
        $existing_otp = $check_existing_otp->fetch();

        if ($existing_otp) {
            // Si un OTP est encore 'pending', on met à jour le token et son expiration
            $update = $connexion->prepare("UPDATE forgot_password SET token = :token, expires_at = :expires_at WHERE admin_uuid = :admin_uuid AND status = 'pending'");
            $update->execute([
                'token' => $otp,
                'expires_at' => $token_expiration,
                'admin_uuid' => $user['admin_uuid'],
            ]);
        } else {
            // Sinon, on insère un nouvel OTP
            $update = $connexion->prepare("INSERT INTO forgot_password (uuid, admin_uuid, token, expires_at) VALUES (UUID(), :admin_uuid, :token, :expires_at)");
            $update->execute([
                'admin_uuid' => $user['admin_uuid'],
                'token' => $otp,
                'expires_at' => $token_expiration,
            ]);
        }

        // Envoyer le nouvel OTP par email
        include_once("send_otp_email.php");
        sendOtpEmail($user['email'], $user['username'], $otp);

        $success = "Un nouveau code de validation a été envoyé à votre adresse email.";
    } else {
        $erreur = "Aucun utilisateur trouvé avec cet identifiant.";
    }
}
?>