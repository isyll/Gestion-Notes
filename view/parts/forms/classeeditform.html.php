<form action="<?= $urls['edit-classe'] ?>" method="post" class="d-flex" id="editClasseForm">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="hidden" name="niveauId" value="<?= $niveau['id'] ?>" />
    <input type="hidden" name="classeId" value="" />
    <input type="text" name="newClasseLibelle" id="newClasseLibelle" class="form-control align-self-center"
        placeholder="Nouveau nom" required />
    <button type="submit" class="btn btn-secondary align-self-center">Valider</button>
</form>
