<main class="d-flex w-100">
    <div class="d-flex flex-column">
        <div class="w-100" style="height:100px;background-color:#367fa9;"></div>
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
            <div class="row ps-3">
                <div class="col-8">
                    <div class="row">
                        <?php if (isset($classes) && count($classes)): ?>
                            <?php foreach ($classes as $c): ?>
                                <div class="card col-4">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h5 role="btn" class="card-title text-center">
                                            <?= $c['libelle'] ?>
                                        </h5>
                                        <a href="/classes/<?= $c['id'] ?>" class="card-link">
                                            <button type="button" class="btn btn-secondary text-white">
                                                Sélectionner</button>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php else: ?>
                            <div>
                                Ce niveau ne possède aucune classe
                            </div>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-2"></div>
                <button data-bs-toggle="modal" data-bs-target="#Niveau"
                    class="clearfix h-auto btn btn-light rounded col-2">
                    <?php if ($exists): ?>
                        Créer une classe
                    <?php else: ?>
                        Créer un niveau
                    <?php endif ?>
                </button>
            </div>
            <div class="modal fade" id="Niveau" tabindex="-1" aria-labelledby="NiveauLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="NiveauLabel">
                                <?php if ($exists): ?>
                                    Créer une classe
                                <?php else: ?>
                                    Créer un niveau
                                <?php endif ?>
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php if ($exists): ?>
                                <?php include 'parts/forms/classeform.html.php'; ?>
                            <?php else: ?>
                                <?php include 'parts/forms/niveauform.html.php'; ?>
                            <?php endif ?>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>