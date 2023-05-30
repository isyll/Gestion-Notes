<form action="<?= $urls['edit-niveau'] ?>" method="post" class="d-flex" id="editNiveauForm">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="hidden" name="niveauId" value="<?= $niveau['id'] ?>" />
    <input type="text" name="newNiveauLibelle" id="newNiveauLibelle" class="form-control align-self-center"
        placeholder="Nouveau nom" required />
    <button type="submit" class="btn btn-secondary align-self-center">Valider</button>
</form>
