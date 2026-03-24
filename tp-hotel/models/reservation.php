<?php
// models/reservation.php

/**
 * Crée une réservation et associe les chambres [cite: 73, 74]
 */
function createReservation($pdo, $client_id, $date_arrivee, $date_depart, $chambres) {
    try {
        $pdo->beginTransaction(); 
        $sql = "INSERT INTO reservation (client_id, date_arrivee, date_depart) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$client_id, $date_arrivee, $date_depart]);
        
        $reservation_id = $pdo->lastInsertId();

        $sql_chambre = "INSERT INTO reservation_chambre (reservation_id, chambre_id) VALUES (?, ?)";
        $stmt_chambre = $pdo->prepare($sql_chambre);
        
        foreach ($chambres as $chambre_id) {
            $stmt_chambre->execute([$reservation_id, $chambre_id]);
        }
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

/**
 * Liste les réservations avec JOIN client [cite: 75, 76]
 */
function getAllReservations($pdo) {
    $sql = "SELECT r.*, c.nom, c.prenom 
            FROM reservation r 
            JOIN client c ON r.client_id = c.id 
            ORDER BY r.date_arrivee DESC";
    $stmt = $pdo->prepare($sql); // Correction : Passage en requête préparée 
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Récupère les chambres d'une réservation [cite: 77]
 */
function getRoomsByReservation($pdo, $reservation_id) {
    $sql = "SELECT c.numero FROM reservation_chambre rc 
            JOIN chambre c ON rc.chambre_id = c.id 
            WHERE rc.reservation_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$reservation_id]);
    return $stmt->fetchAll();
}

/**
 * Annule (DELETE) une réservation [cite: 78, 79]
 */
function deleteReservation($pdo, $id) {
    $sql = "DELETE FROM reservation WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}

/**
 * Vérifie si une chambre est disponible sur une période donnée
 * Retourne TRUE si libre, FALSE si déjà occupée
 */
function isRoomAvailable($pdo, $chambre_id, $date_arr, $date_dep) {
    // Requête SQL pour compter les réservations qui se chevauchent pour CETTE chambre
    $sql = "SELECT COUNT(*) 
            FROM reservation_chambre rc
            JOIN reservation r ON rc.reservation_id = r.id
            WHERE rc.chambre_id = ? 
            AND r.date_arrivee < ? 
            AND r.date_depart > ?";
            
    $stmt = $pdo->prepare($sql);
    // On compare : Arrivée existante < Nouveau Départ ET Départ existant > Nouvelle Arrivée
    $stmt->execute([$chambre_id, $date_dep, $date_arr]);
    
    return $stmt->fetchColumn() == 0; // Si 0, la chambre est libre
}