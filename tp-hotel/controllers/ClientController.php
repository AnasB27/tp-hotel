<?php
require_once 'models/clients.php';

// Initialisation des données et nettoyage
$nom       = trim($_POST['nom'] ?? '');
$prenom    = trim($_POST['prenom'] ?? '');
$email     = trim($_POST['email'] ?? '');
$tel       = trim($_POST['telephone'] ?? '');
$adresse   = trim($_POST['adresse'] ?? '');
$naissance = $_POST['date_naissance'] ?? '';

// --- VALIDATION SERVEUR  ---

if (empty($nom) || empty($prenom) || empty($email) || empty($tel) || empty($adresse) || empty($naissance)) {
    $error = "Tous les champs, y compris la date de naissance, sont obligatoires.";
} 
// Nouvelle condition : Vérification de la majorité
else {
    $dateNaissance = new DateTime($naissance);
    $aujourdhui    = new DateTime(); 
    $age = $aujourdhui->diff($dateNaissance)->y;

    if ($age < 18) {
        $error = "Erreur : Le client doit être majeur (18 ans minimum) pour être enregistré.";
    } 
    // Validation de l'email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "L'adresse email n'est pas valide.";
    } 
    else {
        // Si tout est OK, on procède à l'INSERT 
        $data = [
            'nom'            => $nom,
            'prenom'         => $prenom,
            'email'          => $email,
            'telephone'      => $tel,
            'adresse'        => $adresse,
            'code_postal'    => $_POST['code_postal'] ?? null,
            'ville'          => $_POST['ville'] ?? null,
            'date_naissance' => $naissance
        ];

        if (addClient($pdo, $data)) {
            header('Location: index.php?slug=clients_list');
            exit();
        } else {
            $error = "Une erreur technique est survenue.";
        }
    }
}