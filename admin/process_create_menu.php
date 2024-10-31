<?php
include_once("../database/connexion.php"); // Assurez-vous d'utiliser une connexion PDO

$erreur = '';
$succes = '';
$erreur_champ = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $lien = trim($_POST['lien']);
    $description = trim($_POST['description']);
    $sort_order = (int)$_POST['sort_order'];

    // Validation des données
    if (empty($nom) || empty($lien) || empty($description) || empty($sort_order)) {
        $erreur_champ = 'Tous les champs sont obligatoires.';
    }
    if ($sort_order < 0) {
        $erreur = 'L\'ordre de tri ne peut pas être négatif.';
    }

    if (empty($erreur_champ)) {
        // Vérifier si le menu existe déjà
        try {
            $query = "SELECT menu_uuid FROM menus WHERE menu_label = :nom";
            $stmt = $connexion->prepare($query);
            $stmt->bindParam(':nom', $nom);
            $stmt->execute();
    
            if ($stmt->rowCount() > 0) {
                $erreur = 'Ce menu existe déjà.';
            } else {
                // Création du nouveau menu
                $menu_uuid = uniqid('', true); // Générer un UUID
    
                // Nom du fichier et lien
                $file_name = strtolower(trim($lien)) . '.php'; // Exemple : services.php
                $menu_link = strtolower(trim($lien)) . '.php'; // Utiliser pour la base de données
    
                // Insérer dans la base de données
                $query = "INSERT INTO menus (menu_uuid, menu_label, menu_link, sort_order, is_active) VALUES (:menu_uuid, :menu_label, :menu_link, :sort_order, :is_active)";
                $stmt = $connexion->prepare($query);
                $stmt->bindParam(':menu_uuid', $menu_uuid);
                $stmt->bindParam(':menu_label', $nom);
                $stmt->bindParam(':menu_link', $menu_link); // Utiliser le lien formaté
                $stmt->bindParam(':sort_order', $sort_order);
                $is_active = 1; // Actif par défaut
                $stmt->bindParam(':is_active', $is_active);
    
                if ($stmt->execute()) {
                    // Chemin vers APP_REPAS
                    $app_repas_dir = dirname(__DIR__) . '/' . $file_name; // Utiliser dirname(__DIR__) pour remonter au répertoire APP_REPAS
    
                    // Vérifiez si le fichier existe, sinon créez-le
                    if (!file_exists($app_repas_dir)) {
                        // Contenu de base du fichier PHP
                        $file_content = "<?php\n";
                        $file_content .= "// Fichier généré pour le menu $nom\n";
                        $file_content .= "echo 'Page $nom';\n";
    
                        // Créez le fichier et écrivez le contenu
                        if (file_put_contents($app_repas_dir, $file_content) !== false) {
                            $succes = 'Menu créé avec succès et fichier "' . $file_name . '" créé dans APP_REPAS.';
                        } else {
                            $erreur = 'Le fichier n\'a pas pu être créé.';
                        }
                    } else {
                        $succes = 'Menu créé avec succès mais le fichier existe déjà.';
                    }
                } else {
                    $erreur = 'Une erreur est survenue lors de la création du menu.';
                }
            }
        } catch (PDOException $e) {
            $erreur = 'Erreur de base de données : ' . $e->getMessage();
        }
    }
    
}

?>
