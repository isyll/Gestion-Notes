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
            <form method="post" action="<?= $urls['create-classe'] ?>" class="row">
                <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                <input type="hidden" name="niveauId" value="<?= $niveauId ?>" />
                <label for="classeLibelle" class="form-label col-3 align-self-center">Créer une classe</label>
                <div class="form-group align-self-center col-6">
                    <input required type="text" name="classeLibelle" class="form-control" />
                </div>
                <button class="btn btn-secondary align-self-center col-3" type="submit">Ajouter</button>
            </form>
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <?php if (isset($errors)): ?>
                        <small id="classeHelp" class="form-text text-muted">
                            <?= $errors['classeLibelle'] ?>
                        </small>
                    <?php endif ?>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
        <div class="col"></div>
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
                    <?php if (isset($classes)): ?>
                        <?php foreach ($classes as $c): ?>
                            <tr>
                                <td>
                                </td>
                                <td style="color:rgba(255, 255, 255, 0.75);">
                                    <?= $c['libelle'] ?>
                                </td>
                                <td>
                                    <a href="/app/<?= $c['id_niveau'] ?>/<?= $c['id'] ?>">
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
