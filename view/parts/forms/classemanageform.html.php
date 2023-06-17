<form action="<?= $urls['manage-classe'] ?>" method="post" id="manageNiveauForm">
    <div id="addNoteTypeEditGroup">
        <div class="addNoteTypeEdit input-group me-2">
            <input type="text" name="noteType[]" class="addNoteTypeInput mb-2 form-control align-self-center"
                placeholder="Nom type de note" />
            <button type="button" class="removeAddNoteField btn btn-link text-danger">
                <i class="text-danger bi bi-x fs-3 fw-bolder"></i>
            </button>
        </div>
    </div>
    <input type="hidden" name="classeId" id="classeManageId" value="" />
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <button id="insertNoteTypeBtn" type="button" class="btn btn-link align-self-center"><i
            class="bi bi-plus fs-1"></i></button>
    <input type="submit" value="Enregistrer" class="btn btn-secondary" />
</form>
