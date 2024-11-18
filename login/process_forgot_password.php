<?php
include_once("../database/connexion.php");

$erreur = "";
$erreur_champ = "";

if (isset($_POST["submit"])) {
    $email = $_POST["email"] ?? null;

    if (empty($email)) {
        $erreur_champ = "Veuillez entrer une adresse email.";
    } else {
        // Vérifier si l'email existe dans la base de données
        $query = $connexion->prepare("SELECT admin_uuid, username FROM admin_users WHERE email = :email AND is_deleted = 0 AND is_active = 1");
        $query->execute(['email' => $email]);
        $user = $query->fetch();

        if ($user) {
            // Générer un OTP à 4 chiffres
            $otp = rand(1000, 9999); // Génère un code OTP à 4 chiffres

            // Définir l'expiration du token (30 minutes)
            $token_expiration = date('Y-m-d H:i:s', strtotime('+30 minutes'));

            // Insérer l'OTP et la date d'expiration dans la base de données
            $insert = $connexion->prepare("INSERT INTO forgot_password (uuid, admin_uuid, token, expires_at) VALUES (UUID(), :admin_uuid, :token, :expires_at)");
            $insert->execute([
                'admin_uuid' => $user['admin_uuid'],
                'token' => $otp,
                'expires_at' => $token_expiration,
            ]);

            // Envoyer l'OTP par email
            include_once("send_otp_email.php");
            sendOtpEmail($email, $user['username'], $otp);

            // Rediriger vers le formulaire d'OTP en utilisant admin_uuid
            header("Location: otp_verification.php?admin_uuid=" . urlencode($user['admin_uuid']));
            exit;
        } else {
            $erreur = "Aucun utilisateur trouvé avec cet email.";
        }
    }
}
?>
