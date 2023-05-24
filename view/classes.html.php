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
            <div class="row">
                <div class="col"></div>
                <div class="col">
                    <form action="/create-classe" method="post" class="d-flex">
                        <input type="text" name="libelleClasse" class="form-control" />
                        <input type="hidden" name="period" value="<?= $period ?>" />
                        <input type="hidden" name="niveauSlug" value="<?= $niveauSlug ?>" />
                        <button class="btn btn-secondary" type="submit">Ajouter</button>
                    </form>
                </div>
                <div class="col"></div>
            </div>
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
                                        <a href="/<?= $urls['base'] ?>/<?= $period ?>/<?= $niveauSlug ?>/<?= $c['slug'] ?>"
                                            class="card-link">
                                            <button type="button" class="btn btn-secondary text-white">
                                                Sélectionner</button>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
