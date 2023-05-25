<header>
    <?php include 'parts/navbar.html.php' ?>
</header>
<div class="container">
    <div class="row">
        <?php if (isset($msg)): ?>
            <div class="text-<?= $msg['type'] ?>">
                <?= $msg['value'] ?>
            </div>
        <?php endif ?>
    </div>

    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4">
            <form method="POST" action="http://localhost:8000<?= $urls['create-niveau'] ?>"
                class="d-flex justify-content-between">
                <div class="form-group">
                    <label for="libelleNiveau" class="form-label">Créer un niveau</label>
                    <input required id="niveauLibelle" type="text" class="form-control" name="niveauLibelle" />
                    <input type="hidden" name="current-url" value="<?= $currentURL ?>">
                    <?php if (isset($errors)): ?>
                        <small id="niveauHelp" class="form-text text-muted">
                            <?= $errors['niveauLibelle'] ?>
                        </small>
                    <?php endif ?>
                </div>
                <input type="submit" class="text-white btn btn-secondary align-self-center" value="Ajouter" />
            </form>
        </div>
        <div class="col-4">
        </div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Libellé</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($niveaux)): ?>
                        <?php foreach ($niveaux as $n): ?>
                            <tr>
                                <td>
                                    <?php $n['id'] ?>
                                </td>
                                <td style="color:rgba(255, 255, 255, 0.75);">
                                    <?= $n['libelle'] ?>
                                </td>
                                <td>
                                    <a href="/app/<?= $n['id'] ?>">
                                        <button class="btn btn-link p-0">
                                            Sélectionner
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>

            <div class="modal fade" id="Niveau" tabindex="-1" aria-labelledby="NiveauLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="NiveauLabel">
                                <?php if (isset($requested) && count($requested)): ?>
                                    Créer une classe
                                <?php else: ?>
                                    Créer un niveau
                                <?php endif ?>
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php if (isset($requested) && count($requested)): ?>
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
</div>
