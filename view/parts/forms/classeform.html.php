<form action="<?= $urls['create-classe'] ?>" method="post" class="d-flex">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="hidden" name="niveauId" value="<?= $niveau['id'] ?>" />
    <input type="text" name="classeLibelle" id="classeLibelle" class="form-control align-self-center"
        placeholder="Nom de la classe" required />
    <button type="submit" class="btn btn-secondary align-self-center">Ajouter</button>
</form>
