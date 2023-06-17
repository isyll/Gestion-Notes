<form action="<?= $urls['edit-niveau'] ?>" class="d-flex flex-column" method="post" id="editNiveauForm">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="hidden" name="niveauId" id="niveauId" value="" />
    <input type="text" name="newNiveauLibelle" id="newNiveauLibelle" class="form-control align-self-center"
        placeholder="Nouveau nom" required />
    <input type="text" name="cycleName" id="cycleName" class="form-control align-self-center" placeholder="Nom cycle"
        required />
    <input type="number" name="cyclesNumber" id="cyclesNumber" placeholder="Nombre de parties"
        class="form-control align-self-center" required />
    <button type="submit" class="btn btn-secondary align-self-center">Valider</button>
</form>
