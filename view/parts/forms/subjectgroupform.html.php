<form action="<?= $urls['create-subject-group'] ?>" method="post" class="d-flex">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="text" name="groupName" id="groupName" class="form-control align-self-center"
        placeholder="Nom du groupe" required />
    <button type="submit" class="btn btn-secondary align-self-center">Créer</button>
</form>
