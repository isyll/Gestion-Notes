<form action="" method="post">
    <label for="libelleClasse">Nom de la classe</label>
    <input type="text" class="form-control" id="libelleClasse" name="libelleClasse" />
    <input type="hidden" id="niveauId" name="niveauId" value="<?= $requested['id'] ?>" />
    <?php if (isset($errors['libelleClasse'])): ?>
        <div id="perHelp" class="text-danger">
            <?= $errors['libelleClasse'] ?>
        </div>
    <?php endif ?>
    <div class="mt-4 d-flex justify-content-center align-items-center">
        <button type="button" class="me-2 btn btn-secondary text-white" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="ms-2 text-white btn btn-primary">Valider</button>
    </div>
</form>
