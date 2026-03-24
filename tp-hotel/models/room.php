<?php
// models/room.php

/**
 * Récupère toutes les chambres existantes [cite: 33-34]
 */
function getAllRooms($pdo) {
    $sql = "SELECT * FROM chambre ORDER BY numero ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}