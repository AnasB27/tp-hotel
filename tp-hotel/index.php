<?php
// 1. Connexion à la base de données
require_once 'config/database.php';

// 2. Définition de la fonction de sécurité e() 
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// 3. Gestion du routage via le slug
$slug = $_GET['slug'] ?? 'clients_list';

// --- PHASE 1 : LOGIQUE & TRAITEMENT (CONTRÔLEURS) ---
// On traite les actions AVANT l'affichage HTML
switch ($slug) {
    case 'clients_add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'controllers/ClientController.php'; 
        }
        break;

    case 'reservations_create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'controllers/ReservationController.php';
        }
        break;

    case 'reservation_cancel':
        // L'annulation est un traitement pur (DELETE + Redirection)
        require_once 'controllers/ReservationController.php';
        break;
}

// --- PHASE 2 : AFFICHAGE (VUES) ---
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Hôtel - Gestion Interne</title>
    <link rel="stylesheet" href="views/style/main.css">
</head>
<body>

    <?php include 'views/nav.php'; ?>

    <main class="container">
        <?php
        switch ($slug) {
            case 'clients_list':
                include 'views/clients/list.php';
                break;
                
            case 'clients_add':
                include 'views/clients/add.php';
                break;
                
            case 'reservations_list':
                include 'views/reservations/list.php';
                break;
                
            case 'reservations_create':
                // C'est ici que le formulaire doit s'afficher
                include 'views/reservations/create.php';
                break;
            
            case 'reservation_cancel':
                // Rien à afficher, le contrôleur a déjà redirigé.
                // Si on arrive ici, c'est qu'il y a eu un problème.
                echo "<p>Traitement de l'annulation...</p>";
                break;

            default:
                echo "<h1>404 - Page non trouvée</h1>";
                break;
        }
        ?>
    </main>

</body>
</html>