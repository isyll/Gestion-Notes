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
        <div class="col"></div>
        <div class="col">
            <form method="post" action="<?= $urls['create-niveau'] ?>" class="row">
                <label for="niveauLibelle" class="form-label col-3 align-self-center">Créer un niveau</label>
                <div class="form-group col-6 align-self-center">
                    <input required id="niveauLibelle" type="text" class="form-control  align-self-center"
                        name="niveauLibelle" />
                    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                </div>
                <input type="submit" class="col-3 text-white btn btn-secondary align-self-center" value="Ajouter" />
            </form>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <?php if (isset($errors)): ?>
                        <small id="classeHelp" class="form-text text-muted">
                            <?= $errors['niveauLibelle'] ?>
                        </small>
                    <?php endif ?>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
        <div class="col">
        </div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <table class="table table-striped table-hover mt-4">
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
        </div>
        <div class="col-3"></div>
    </div>
</div>
