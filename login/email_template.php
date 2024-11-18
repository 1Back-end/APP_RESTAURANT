<?php
function emailTemplate($username, $otp) {
    return "
    <html>
        <body style='font-family: Arial, sans-serif;'>
            <div style='max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd;'>
                <h2 style='text-align: center; color: #28a745;'>Réinitialisation de mot de passe</h2>
                <p>Bonjour <strong>{$username}</strong>,</p>
                <p>Nous avons reçu une demande de réinitialisation de votre mot de passe. Voici votre code OTP :</p>
                <div style='text-align: center; padding: 20px; font-size: 24px; font-weight: bold; background: #f4f4f4; border-radius: 5px;'>
                    {$otp}
                </div>
                <p>Ce code est valide pendant 30 minutes.</p>
                <p>Si vous n'avez pas demandé cette opération, veuillez ignorer cet email.</p>
                <p>Cordialement,<br>L'équipe Support</p>
            </div>
        </body>
    </html>";
}
