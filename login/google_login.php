<?php
require_once 'vendor/autoload.php';

session_start();

// Configuration du client Google
$client = new Google_Client();
$client->setClientId('YOUR_GOOGLE_CLIENT_ID');
$client->setClientSecret('YOUR_GOOGLE_CLIENT_SECRET');
$client->setRedirectUri('http://localhost/google_login.php'); // Assurez-vous de mettre l'URL correcte de redirection
$client->addScope('email');
$client->addScope('profile');

// Si l'utilisateur est déjà redirigé après l'authentification
if (isset($_GET['code'])) {
    // Échange du code d'autorisation contre un token d'accès
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;

    // Créez une instance du service Google pour récupérer les informations de l'utilisateur
    $oauth = new Google_Service_Oauth2($client);
    $userData = $oauth->userinfo->get(); // Récupère les données de l'utilisateur connecté
    
    // Récupérer les informations de l'utilisateur
    $email = $userData->email;
    $name = $userData->name;
    $profilePic = $userData->picture;

    // Vérifier si l'utilisateur existe déjà dans votre base de données
    include_once("../database/connexion.php");
    $query = "SELECT * FROM admin_users WHERE email = :email";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // L'utilisateur existe, on le connecte
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_uuid'] = $user['admin_uuid'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['photo'] = $user['photo'];

        header("Location: ../admin/tableau_de_bord.php");
        exit;
    } else {
        // Si l'utilisateur n'existe pas, vous pouvez enregistrer les informations dans la base de données
        $query = "INSERT INTO admin_users (email, username, photo) VALUES (:email, :username, :photo)";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $name);
        $stmt->bindParam(':photo', $profilePic);
        $stmt->execute();

        // Connecter l'utilisateur
        $_SESSION['admin_uuid'] = $connexion->lastInsertId();
        $_SESSION['username'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['photo'] = $profilePic;

        header("Location: ../admin/tableau_de_bord.php");
        exit;
    }
}

// Si l'utilisateur n'est pas authentifié, redirigez-le vers la page d'authentification Google
$authUrl = $client->createAuthUrl();
header('Location: ' . $authUrl);
exit();
?>
