<form action="" method="post" id="formAnnee">
    <label for="libelleNiveau">Libellé du niveau</label>
    <input type="text" class="form-control" name="libelleNiveau" placeholder="Libellé" required/>
    <?php if (isset($errors['libelleNiveau'])): ?>
        <div id="libHelp" class="text-danger">
            <?= $errors['libelle'] ?>
        </div>
    <?php endif ?>
    <div class="mt-4 d-flex justify-content-center align-items-center">
        <button type="button" class="me-2 btn btn-secondary text-white" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="ms-2 text-white btn btn-primary">Valider</button>
    </div>
</form>
