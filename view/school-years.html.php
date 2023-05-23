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
                        <div class="col-3"></div>
                        <div class="col-6">
                            <form class="d-flex" method="post" action="<?= $urls['create-year'] ?>">
                                <label for="period" class="form-label me2">Libellé</label>
                                <input type="text" maxlength="9" class="form-control ms-2" name="period" id="period"
                                    required />
                                <input type="submit" class="btn btn-secondary ms-2 text-white" value="Ajouter" />
                            </form>
                        </div>
                        <div class="col-3"></div>
                    </div>
                    <div class="row">
                        <div class="list-group">
                            <?php foreach ($schoolYears as $y): ?>
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between mb-2 w-100">
                                        <h5>
                                            <?= $y['periode'] ?>
                                        </h5>
                                        <div class="d-flex flex-column">
                                            <a href="/school-years/<?= $y['periode'] ?>">Sélectionner</a>
                                            <form action="" method="post" id="updateYear<?= $y['id'] ?>">
                                                <input type="hidden" name="yearId" value="<?= $y['id'] ?>" />
                                                <button type="submit" class="p-0 btn btn-link">Modifier</button>
                                            </form>
                                            <form action="/remove-year" method="post">
                                                <input type="hidden" name="yearId" value="<?= $y['id'] ?>" />
                                                <button type="submit"
                                                    class="p-0 btn btn-link text-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="col-2"></div>
                </div>
                <!-- <div class="modal fade" id="confirmRemove" tabindex="-1" aria-labelledby="confirmRemoveLabel"
                    aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="confirmRemoveLabel">Voulez-vous réellement supprimer
                                    cette année</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="/remove-year">
                                    <input type="hidden" value="" />
                                    <div class="mt-4 d-flex justify-content-center align-items-center">
                                        <button type="button" class="me-2 btn btn-secondary text-white"
                                            data-bs-dismiss="modal">Non</button>
                                        <button type="submit" class="ms-2 text-white btn btn-primary">Oui</button>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
</main>
