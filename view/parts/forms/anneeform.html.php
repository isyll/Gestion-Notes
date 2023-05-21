<form action="" method="post">
    <label for="period">Période de l'année scolaire</label>
    <select multiple size="3" type="text" id="period" name="period" class="form-select" required>
        <?php foreach ($periods as $p): ?>
            <option value="<?= $p ?>"><?= $p ?></option>
        <?php endforeach ?>
    </select>
</form>
