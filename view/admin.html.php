<main class="d-flex w-100">
    <div class="d-flex flex-column">
        <div class="p-5 w-100" style="background-color:#367fa9;"></div>
        <?php include 'parts/dashboard.html.php' ?>
    </div>
    <div id="main" class="w-100">
        <?php include 'parts/header.html.php' ?>
        <div id="content">
            <div class="row ms-1">
                <button data-bs-toggle="modal" data-bs-target="#modalAnneeScolaire"
                    class=" btn btn-light rounded col-2">Créer une année scolaire</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAnneeScolaire" tabindex="-1" aria-labelledby="modalAnneeScolaireLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAnneeScolaireLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php include 'parts/forms/anneeform.html.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="text-white btn btn-primary">Valider</button>
                </div>
            </div>
        </div>
    </div>
</main>
