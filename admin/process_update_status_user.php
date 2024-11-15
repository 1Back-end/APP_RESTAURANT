<?php
include_once("../database/connexion.php");

if (isset($_GET['user_uuid'])) {
    $user_uuid = $_GET['user_uuid'];

    // Récupérer le statut actuel de l'Utilisateur
    $stmt = $connexion->prepare("SELECT is_active FROM admin_users WHERE admin_uuid  = ?");
    $stmt->execute([$user_uuid]);
    $users = $stmt->fetch();

    if ($users) {
        $new_status = $users['is_active'] == 1 ? 0 : 1;
        $stmt_update = $connexion->prepare("UPDATE admin_users SET is_active = ?, deleted_at = ? WHERE admin_uuid = ?");
        $deleted_at = $new_status == 0 ? date('d-m-Y H:i:s') : null;

        if ($stmt_update->execute([$new_status, $deleted_at, $admin_uuid])) {
            $msg = $new_status == 0 ? 'Utilisateur activé avec succès.' : 'Utilisateur désactivé avec succès.';
            header("Location: liste_users.php?msg=" . urlencode($msg));
            exit();
        } else {
            header("Location: liste_users.php?msg=" . urlencode('Erreur lors de la mise à jour du statut de l\'Utilisateur.'));
            exit();
        }
    } else {
        header("Location: liste_users.php?msg=" . urlencode('Utilisateur non trouvé.'));
        exit();
    }
} else {
    header("Location: liste_users.php?msg=" . urlencode('ID de l\'Utilisateur manquant.'));
    exit();
}
