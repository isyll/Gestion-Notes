<header>
    <?php include 'parts/navbar.html.php' ?>
</header>
<div class="container w-100">
    <div class="row">
        <?php if (isset($msg)): ?>
            <div class="text-<?= $msg['type'] ?>">
                <?= $msg['value'] ?>
            </div>
        <?php endif ?>
    </div>

    <div class="row position-relative">
        <div class="position-absolute w-auto h-auto end-0">
            <a href="<?= $urls['new-niveau'] ?>">
                <i class="bi bi-plus fs-1"></i>
            </a>
        </div>
        <div class="m-auto col-10 col-lg-6">
            <h4 class="my-4">Les niveaux</h4>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Libellé</th>
                        <th></th>
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
                                    <a href="<?= $urls['list-classes'] ?><?= $n['id'] ?>">
                                        <button class="btn btn-link p-0 text-decoration-none">
                                            Sélectionner
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <form class="delete-niveau-form" action="<?= $urls['delete-niveau'] ?>" method="post">
                                        <input type="hidden" name="niveauId" value="<?= $n['id'] ?>" />
                                        <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                                        <button type="submit" data-bs-toggle="modal" data-bs-target="#confirmDelete"
                                            class="delete-btn btn btn-link text-danger">
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
                <h6 class="modal-title" id="myModalLabel">Voulez-vous vraiment supprimer ce niveau ?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modal-btn-yes">Oui</button>
                <button type="button" class="btn btn-secondary" id="modal-btn-no" data-bs-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>
