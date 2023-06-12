<form action="<?= $urls['create-niveau'] ?>" method="post" class="d-flex">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="text" name="niveauLibelle" id="niveauLibelle" class="form-control align-self-center"
        placeholder="Nom du niveau" required />
    <div>
        <input type="text" name="cycleName" id="cycleName" class="form-control align-self-center"
            placeholder="Nom cycle" required />
        <input type="number" name="cyclesNumber" id="cyclesNumber" placeholder="Nombre de parties"
            class="form-control align-self-center" required />
    </div>
    <button type="submit" class="btn btn-secondary align-self-center">Ajouter</button>
</form>