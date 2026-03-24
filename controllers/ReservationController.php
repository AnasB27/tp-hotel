<?php
require_once 'models/reservation.php';

/**
 * ANNULATION
 */
if ($slug === 'reservation_cancel' && isset($_GET['id'])) {
    if (deleteReservation($pdo, (int)$_GET['id'])) {
        header('Location: index.php?slug=reservations_list');
        exit();
    }
}

/**
 * CRÉATION AVEC VÉRIFICATIONS (DATES & DISPONIBILITÉ)
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $slug === 'reservations_create') {
    $client_id = $_POST['client_id'] ?? null;
    $date_arr  = $_POST['date_arrivee'] ?? null;
    $date_dep  = $_POST['date_depart'] ?? null;
    $chambres  = $_POST['chambres'] ?? [];

    $aujourdhui = date('Y-m-d');

    // Validations de base et chronologiques
    if (empty($date_arr) || empty($date_dep)) {
        $error = "Veuillez remplir les dates de séjour.";
    } 
    // Empêche de réserver dans le passé
    elseif ($date_arr < $aujourdhui) {
        $error = "Erreur : La date d'arrivée ne peut pas être antérieure à aujourd'hui.";
    }
    // Vérifie que le départ est après l'arrivée
    elseif ($date_arr >= $date_dep) {
        $error = "Dates incohérentes : l'arrivée doit être avant le départ.";
    } 
    elseif (empty($chambres)) {
        $error = "Erreur : Sélectionnez au moins une chambre.";
    } 
    else {
        // VÉRIFICATION DU CHEVAUCHEMENT (Overlap)
        $chambres_occupees = [];
        
        foreach ($chambres as $chambre_id) {
            if (!isRoomAvailable($pdo, $chambre_id, $date_arr, $date_dep)) {
                $stmt = $pdo->prepare("SELECT numero FROM chambre WHERE id = ?");
                $stmt->execute([$chambre_id]);
                $chambres_occupees[] = $stmt->fetchColumn();
            }
        }

        if (!empty($chambres_occupees)) {
            $error = "Impossible de réserver : la/les chambre(s) " . implode(', ', $chambres_occupees) . " est déjà occupée sur cette période.";
        } 
        // Si tout est valide, on enregistre
        else {
            if (createReservation($pdo, $client_id, $date_arr, $date_dep, $chambres)) {
                header('Location: index.php?slug=reservations_list');
                exit();
            } else {
                $error = "Une erreur technique est survenue lors de l'enregistrement.";
            }
        }
    }
}