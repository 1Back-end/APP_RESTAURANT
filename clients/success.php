<?php
session_start();
require_once '../vendor/autoload.php';
include_once("../database/connexion.php");
include_once("../fonction/fonction.php");

\Stripe\Stripe::setApiKey('sk_test_51PvK3l08QILWwY1ztJaryXP5o5GwQLKyf6enbJr6cnbO06R1p8ld4HKqNrYzOdFUF6UH1Fz8kwj47UfS0c2n5lmi00Sijvkwu7');

$session_id = $_GET['session_id'] ?? null;
$order_uuid = $_GET['order_uuid'] ?? null;
$added_by = $_SESSION['user_uuid'] ?? null;

if (!$session_id || !$order_uuid || !$added_by) {
    header('Location: mes_commandes.php?status=error&message=Données de paiement manquantes');
    exit;
}

try {
    // Récupération de la session Stripe
    $session = \Stripe\Checkout\Session::retrieve($session_id);
    $amount_eur = $session->amount_total / 100; // Montant en EUR
    $conversion_rate = 655.957; // Taux de conversion EUR -> FRCFA
    $amount_frcfa = round($amount_eur * $conversion_rate, 2); // Conversion en FRCFA

    // Enregistrement du paiement dans la base de données
    $stmt = $connexion->prepare("
        INSERT INTO payments (payment_uuid, order_uuid, amount, payment_method, payment_status, added_by,num_payments)
        VALUES (:payment_uuid, :order_uuid, :amount, 'carte', 'payé', :added_by,:num_payments)
    ");
    $stmt->execute([
        'payment_uuid' => generateUUID(),
        'order_uuid' => $order_uuid,
        'amount' => $amount_frcfa,
        'added_by' => $added_by,
        'num_payments'=>num_payment(),
    ]);

    // Mise à jour du statut de la commande
    $updateStmt = $connexion->prepare("
        UPDATE orders SET status = 'paid' WHERE order_uuid = :order_uuid
    ");
    $updateStmt->execute(['order_uuid' => $order_uuid]);

    // Redirection en cas de succès
    header('Location: mes_commandes.php?status=success&message=Paiement effectué avec succès');
    exit;

} catch (\Stripe\Exception\ApiErrorException $e) {
    // Gestion des erreurs Stripe
    header('Location: mes_commandes.php?status=error&message=' . urlencode('Erreur Stripe : ' . $e->getMessage()));
    exit;
}
