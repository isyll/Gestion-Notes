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
            <div class="row ps-3">
                <div class="col-8">
                    <div class="row">
                        <?php if (isset($students) && count($students)): ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <?php foreach ($students as $s): ?>

                                <?php endforeach ?>
                                </students>
                            <?php elseif (!$exists): ?>
                            <?php else: ?>
                                <div>
                                    Rien à afficher
                                </div>
                            <?php endif ?>
                    </div>
                </div>
                <div class="col-2"></div>
                <?php if ($exists): ?>
                    <button data-bs-toggle="modal" data-bs-target="#Niveau"
                        class="clearfix h-auto btn btn-light rounded col-2">
                        Enregistrer un élève
                    </button>
                <?php endif ?>
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
                            <?php include 'parts/forms/formstudent.html.php'; ?>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>





        </div>
    </div>
</main>
