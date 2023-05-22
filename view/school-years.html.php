<main class="d-flex w-100">
    <div class="d-flex flex-column">
        <div class="p-5 w-100" style="background-color:#367fa9;"></div>
        <?php include 'parts/dashboard.html.php' ?>
    </div>
    <div id="main" class="w-100">
        <?php include 'parts/header.html.php' ?>
        <div id="content">
            <?php if (isset($msg)): ?>
                <div class="text-<?= $msg['type'] ?>">
                    <?= $msg['value'] ?>
                </div>
            <?php endif ?>
            <div class="row ms-1">
                <div class="col-8">
                    <div class="row">
                        <?php foreach ($schoolYears as $y): ?>
                            <div class="card col-4">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <h5 role="btn" class="card-title text-center">
                                        <?= $y['periode'] ?>
                                    </h5>
                                    <a href="/school-year/<?= $y['periode'] ?>" class="card-link">
                                        <button type="button" class="btn btn-secondary text-white">
                                            Sélectionner</button>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="col-2"></div>

                <button data-bs-toggle="modal" data-bs-target="#modalAnneeScolaire"
                    class="h-auto btn btn-light rounded col-2">Créer
                    une année scolaire</button>
            </div>
            <div class="modal fade" id="modalAnneeScolaire" tabindex="-1" aria-labelledby="modalAnneeScolaireLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalAnneeScolaireLabel">Créer une année scolaire</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php include 'parts/forms/anneeform.html.php'; ?>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
