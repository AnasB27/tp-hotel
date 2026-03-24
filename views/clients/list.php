<?php
// 1. Appel du modèle pour récupérer les données [cite: 65, 66]
require_once 'models/clients.php';

// 2. Récupération de la liste (vérifie bien que $pdo est passé simplement)
$clients = getAllClients($pdo); 
?>

<h2>Liste des clients</h2>

<table border="1">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Ville</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= e($client['nom']) ?></td>
                <td><?= e($client['prenom']) ?></td>
                <td><?= e($client['email']) ?></td>
                <td><?= e($client['telephone']) ?></td>
                <td><?= e($client['ville']) ?></td>
                <td>
                    <a href="index.php?slug=reservations_create&client_id=<?= $client['id'] ?>">
                        Réserver pour ce client
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if (empty($clients)): ?>
    <p>Aucun client n'est enregistré dans la base de données.</p>
<?php endif; ?>