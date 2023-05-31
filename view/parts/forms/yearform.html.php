<form action="<?= $urls['create-year'] ?>" method="post" class="d-flex">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="hidden" name="yearId" id="yearId" value="" />
    <input type="text" name="libelle" id="libelle" class="form-control align-self-center"
        placeholder="Libellé de l'année" required />
    <button type="submit" class="btn btn-secondary align-self-center">Valider</button>
</form>
