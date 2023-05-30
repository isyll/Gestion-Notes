<form action="<?= $urls['create-niveau'] ?>" method="post" class="d-flex">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="text" name="niveauLibelle" id="niveauLibelle" class="form-control align-self-center"
        placeholder="Nom du niveau" required />
    <button type="submit" class="btn btn-secondary align-self-center">Ajouter</button>
</form>
