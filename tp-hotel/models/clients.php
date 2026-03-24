<?php
// models/clients.php

/**
 * Enregistre un nouveau client en base de données 
 */
function addClient($pdo, $data) {
    $sql = "INSERT INTO client (nom, prenom, email, telephone, adresse, code_postal, ville, date_naissance) 
            VALUES (:nom, :prenom, :email, :telephone, :adresse, :code_postal, :ville, :date_naissance)";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':nom'            => $data['nom'],
        ':prenom'         => $data['prenom'],
        ':email'          => $data['email'],
        ':telephone'      => $data['telephone'],
        ':adresse'        => $data['adresse'],
        ':code_postal'    => $data['code_postal'],
        ':ville'          => $data['ville'],
        ':date_naissance' => $data['date_naissance']
    ]);
}

/**
 * Récupère la liste de tous les clients 
 */
function getAllClients($pdo) {
    $sql = "SELECT * FROM client ORDER BY nom ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}