<?php
require_once 'models/clients.php';
require_once 'models/room.php';

$clients = getAllClients($pdo);
$rooms = getAllRooms($pdo);
$selected_client_id = $_GET['client_id'] ?? null;
$aujourdhui = date('Y-m-d');
?>

<div class="container">
    <h2>Créer une réservation</h2>

    <?php if (isset($error)): ?>
        <div class="alert-error">
            <strong>⚠ Problème :</strong> <?= e($error) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?slug=reservations_create" method="POST">
        
        <div class="form-group">
            <label>Client :</label>
            <select name="client_id" required>
                <option value="">-- Choisir un client --</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= $client['id'] ?>" <?= ($selected_client_id == $client['id']) ? 'selected' : '' ?>>
                        <?= e($client['nom']) ?> <?= e($client['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row" style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label>Date d'arrivée :</label>
                <input type="date" name="date_arrivee" 
                       min="<?= $aujourdhui ?>"
                       value="<?= e($_POST['date_arrivee'] ?? '') ?>" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Date de départ :</label>
                <input type="date" name="date_depart" 
                       min="<?= $aujourdhui ?>"
                       value="<?= e($_POST['date_depart'] ?? '') ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>Choisir les chambres :</label>
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #ddd;">
                <?php foreach ($rooms as $room): ?>
                    <div style="margin-bottom: 8px;">
                        <input type="checkbox" name="chambres[]" value="<?= $room['id'] ?>" 
                            <?= (isset($_POST['chambres']) && in_array($room['id'], $_POST['chambres'])) ? 'checked' : '' ?>>
                        <span class="badge">Ch. <?= e($room['numero']) ?></span> 
                        <small style="display: inline;">(<?= e($room['type']) ?>)</small>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit">Confirmer la réservation</button>
    </form>
</div>