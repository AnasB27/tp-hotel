<?php
// Informations de connexion
$host     = 'localhost';
$dbname   = 'hotel_db';
$username = 'root';
$password = ''; 

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8", 
        $username, 
        $password
    );

    // Configuration des options PDO
    // pour simplifier le debogage
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Définit le mode de récupération par défaut en tableau associatif
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // En cas d'échec, on arrête tout et on affiche l'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}