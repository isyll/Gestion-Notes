<header>
    <?php include 'parts/navbar.html.php' ?>
</header>
<div class="container w-100">
    <div class="row">
        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $msg['type'] ?>">
                <?= $msg['value'] ?>
            </div>
        <?php endif ?>

        <small>
            <?= $errors['newNiveauLibelle'] ?? '' ?>
        </small>
        <small>
            <?= $errors['niveauLibelle'] ?? '' ?>
        </small>
    </div>

    <div class="row position-relative">
        <div class="position-absolute w-auto h-auto end-0">
            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#createNiveau">
                <i class="bi bi-plus fs-1"></i>
            </button>
        </div>
        <div class="m-auto col-10 col-lg-6">
            <h4 class="my-4">Les niveaux</h4>
            <table class="table table-hover">
                <tbody>
                    <?php if (isset($niveaux)): ?>
                        <?php foreach ($niveaux as $n): ?>
                            <tr>
                                <td>
                                    <?php $n['id'] ?>
                                </td>
                                <td>
                                    <a href="<?= $urls['list-classes'] ?><?= $n['id'] ?>">
                                        <button class="btn btn-link p-0 fs-5 text-decoration-none text-black">
                                            <?= $n['libelle'] ?>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <button class="dataClickTransfer btn btn-link" data-bs-toggle="modal"
                                        data-bs-target="#editNiveau" dataToTransfer="<?= $n['id'] ?>" dataTargetId="#niveauId">
                                        <a href="#" data-bs-toggle="tooltip" data-bs-title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </button>
                                </td>
                                <td>
                                    <form class="delete-niveau-form" action="<?= $urls['delete-niveau'] ?>" method="post">
                                        <input type="hidden" name="niveauId" value="<?= $n['id'] ?>" />
                                        <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                                        <button type="submit" data-bs-toggle="modal" data-bs-target="#confirmDeleteNiveau"
                                            class="delete-btn btn btn-link text-danger">
                                            <a href="#" data-bs-toggle="tooltip" data-bs-title="Supprimer">
                                                <i class="text-danger bi bi-trash-fill"></i>
                                            </a>
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
<div class="modal fade" tabindex="-1" role="dialog" id="createNiveau">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Créer un niveau</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <?php include 'parts/forms/niveauform.html.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="editNiveau">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Modifier un niveau</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <?php include 'parts/forms/niveaueditform.html.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="confirmDeleteNiveau">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h6 class="modal-title text-white" id="myModalLabel">Souhaitez vous vraiment supprimer ce niveau ?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn-yes btn btn-danger">Oui</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>
