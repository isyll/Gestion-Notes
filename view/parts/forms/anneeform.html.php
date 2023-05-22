<form action="<?= $urls['create-year'] ?>" method="post" id="formAnnee">
    <label for="period">Période de l'année scolaire</label>
    <select multiple size="3" type="text" id="period" name="period" class="form-select" required
        aria-describedby="perHelp">
    </select>
    <?php if (isset($errors['period'])): ?>
        <div id="perHelp" class="text-danger">
            <?= $errors['period'] ?>
        </div>
    <?php endif ?>
    <div class="mt-4 d-flex justify-content-center align-items-center">
        <button type="button" class="me-2 btn btn-secondary text-white" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="ms-2 text-white btn btn-primary">Valider</button>
    </div>
</form>
