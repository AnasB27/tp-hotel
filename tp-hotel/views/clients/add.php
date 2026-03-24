<div class="container">
    <h2>Ajouter un nouveau client</h2>

    <?php if (isset($error)): ?>
        <div class="alert-error">
            <strong>⚠ Erreur :</strong> <?= e($error) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?slug=clients_add" method="POST">
        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="nom" value="<?= e($_POST['nom'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Prénom :</label>
            <input type="text" name="prenom" value="<?= e($_POST['prenom'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Date de naissance :</label>
            <input type="date" name="date_naissance" value="<?= e($_POST['date_naissance'] ?? '') ?>" required>
            <small>Note : Le client doit obligatoirement être majeur.</small>
        </div>

        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Téléphone :</label>
            <input type="tel" name="telephone" value="<?= e($_POST['telephone'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Adresse :</label>
            <textarea name="adresse" required><?= e($_POST['adresse'] ?? '') ?></textarea>
        </div>

        <div class="row" style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
                <label>Code Postal :</label>
                <input type="text" name="code_postal" value="<?= e($_POST['code_postal'] ?? '') ?>" placeholder="Ex: 75000">
            </div>
            <div class="form-group" style="flex: 2;">
                <label>Ville :</label>
                <input type="text" name="ville" value="<?= e($_POST['ville'] ?? '') ?>" placeholder="Ex: Paris">
            </div>
        </div>

        <button type="submit">Enregistrer le client</button>
    </form>
</div>