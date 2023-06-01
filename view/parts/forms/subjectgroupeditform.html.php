<form action="<?= $urls['edit-subject-group'] ?>" method="post" class="d-flex">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="hidden" name="groupId" id="groupId" value="" />
    <input type="text" name="groupName" id="groupName" class="form-control align-self-center"
        placeholder="Nom du groupe" required />
    <button type="submit" class="btn btn-secondary align-self-center">Valider</button>
</form>
