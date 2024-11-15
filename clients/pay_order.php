<?php
require_once '../vendor/autoload.php';
include_once("../database/connexion.php");
include_once("../fonction/fonction.php");

\Stripe\Stripe::setApiKey('sk_test_51PvK3l08QILWwY1ztJaryXP5o5GwQLKyf6enbJr6cnbO06R1p8ld4HKqNrYzOdFUF6UH1Fz8kwj47UfS0c2n5lmi00Sijvkwu7');

$order_uuid = $_GET["order_uuid"] ?? null;

// Vérifiez si l'UUID de commande est valide
if (!$order_uuid) {
    header('Location: mes_commandes.php?status=error&message=Commande introuvable');
    exit;
}

try {
    // Récupération du montant en FRCFA depuis la base de données
    $stmt = $connexion->prepare("SELECT total_amount FROM orders WHERE order_uuid = :order_uuid");
    $stmt->execute(['order_uuid' => $order_uuid]);
    $order = $stmt->fetch();

    if (!$order) {
        header('Location: mes_commandes.php?status=error&message=Commande introuvable');
        exit;
    }

    $amount_frcfa = $order['total_amount']; // Montant en FRCFA
    $conversion_rate = 655.957; // Taux de conversion FRCFA -> EUR
    $amount_eur = round($amount_frcfa / $conversion_rate, 2); // Conversion en EUR

    // Construisez l'URL complète pour les redirections success et cancel
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . $host . dirname($_SERVER['SCRIPT_NAME']);

    $success_url = $base_url . '/success.php?session_id={CHECKOUT_SESSION_ID}&order_uuid=' . $order_uuid;
    $cancel_url = $base_url . '/cancel.php?order_uuid=' . $order_uuid;

    // Création de la session Stripe
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur', // Stripe utilise EUR
                'product_data' => ['name' => "Commande #$order_uuid"],
                'unit_amount' => $amount_eur * 100, // Stripe travaille en centimes
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $success_url,
        'cancel_url' => $cancel_url,
    ]);

    // Redirigez l'utilisateur vers la page de paiement Stripe
    header("Location: " . $session->url);
    exit;

} catch (\Stripe\Exception\ApiErrorException $e) {
    // Redirection en cas d'erreur Stripe
    header('Location: mes_commandes.php?status=error&message=' . urlencode('Erreur Stripe : ' . $e->getMessage()));
    exit;
}
