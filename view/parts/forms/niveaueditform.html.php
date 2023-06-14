<form action="<?= $urls['edit-niveau'] ?>" class="d-flex" method="post" id="editNiveauForm">
    <!-- <div id="addNoteTypeEdit" class=" me-2">
        <input type="text" name="noteType[]" class=" add-note-type mb-2 form-control align-self-center"
            placeholder="Nom type de note" />
    </div>
    <button id="insertNoteTypeBtn" type="button" class="btn btn-link align-self-center"><i
            class="bi bi-plus fs-1"></i></button> -->
    <div>
        <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
        <input type="hidden" name="niveauId" id="niveauId" value="" />
        <input type="text" name="newNiveauLibelle" id="newNiveauLibelle" class="form-control align-self-center"
            placeholder="Nouveau nom" required />
        <input type="text" name="cycleName" id="cycleName" class="form-control align-self-center"
            placeholder="Nom cycle" required />
        <input type="number" name="cyclesNumber" id="cyclesNumber" placeholder="Nombre de parties"
            class="form-control align-self-center" required />
        <button type="submit" class="btn btn-secondary align-self-center">Valider</button>
    </div>
</form>
