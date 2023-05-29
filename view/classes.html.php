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
    <div class="row position-relative">
        <div class="position-absolute w-auto h-auto end-0">
            <a href="<?= $urls['new-classe'] ?><?= $niveau['id'] ?>">
                <i class="bi bi-plus fs-1"></i>
            </a>
        </div>
        <div class="m-auto pt-3 col-10 col-lg-6">
            <h4 class="my-4">Les classes de
                <?= $niveau['libelle'] ?>
            </h4>
            <table class="table table-striped table-hover mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Libellé</th>
                        <th></th>
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
                                        <button class="btn btn-link p-0 text-decoration-none">
                                            Sélectionner
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <form action="<?= $urls['delete-classe'] ?>" method="post">
                                        <input type="hidden" name="classeId" value="<?= $c['id'] ?>" />
                                        <input type="hidden" name="niveauId" value="<?= $niveau['id'] ?>" />
                                        <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                                        <button type="submit" class="delete-btn btn btn-link text-danger" data-bs-toggle="modal"
                                            data-bs-target="#confirmDelete">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="confirmDelete">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Voulez-vous vraiment supprimer cette classe ?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modal-btn-yes">Oui</button>
                <button type="button" class="btn btn-secondary" id="modal-btn-no" data-bs-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>
