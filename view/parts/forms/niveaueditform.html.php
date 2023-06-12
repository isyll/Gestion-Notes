<form action="<?= $urls['edit-niveau'] ?>" method="post" class="d-flex" id="editNiveauForm">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="hidden" name="niveauId" id="niveauId" value="" />
    <input type="text" name="newNiveauLibelle" id="newNiveauLibelle" class="form-control align-self-center"
        placeholder="Nouveau nom" required />
    <div>
        <input type="text" name="cycleName" id="cycleName" class="form-control align-self-center"
            placeholder="Nom cycle" required />
        <input type="number" name="cyclesNumber" id="cyclesNumber"  placeholder="Nombre de parties" class="form-control align-self-center" required />
    </div>
    <button type="submit" class="btn btn-secondary align-self-center">Valider</button>
</form>