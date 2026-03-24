<?php
// 1. On inclut le modèle pour récupérer les données
require_once 'models/reservation.php';

// 2. Récupération de toutes les réservations avec les noms des clients
$reservations = getAllReservations($pdo);
?>

<div class="container">
    <h2>Liste des réservations</h2>

    <?php if (empty($reservations)): ?>
        <p>Aucune réservation n'a été enregistrée pour le moment.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Date d'Arrivée</th>
                    <th>Date de Départ</th>
                    <th>Chambres</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $res): ?>
                    <tr>
                        <td>
                            <strong><?= e($res['nom']) ?> <?= e($res['prenom']) ?></strong>
                        </td>
                        
                        <td><?= e($res['date_arrivee']) ?></td>
                        <td><?= e($res['date_depart']) ?></td>
                        
                        <td>
                            <?php 
                            // Récupération des chambres associées à cette réservation
                            $chambres = getRoomsByReservation($pdo, $res['id']);
                            foreach ($chambres as $ch): ?>
                                <span class="badge">Ch. <?= e($ch['numero']) ?></span>
                            <?php endforeach; ?>
                        </td>
                        
                        <td>
                            <a href="index.php?slug=reservation_cancel&id=<?= $res['id'] ?>" 
                               class="btn-danger" 
                               onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                               Annuler
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>