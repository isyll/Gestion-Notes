<header>
    <?php include 'parts/navbar.html.php' ?>
</header>
<div class="container">
    <div class="row">
        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $msg['type'] ?>">
                <?= $msg['value'] ?>
            </div>
        <?php endif ?>

        <small>
            <?= $errors['newClasseLibelle'] ?? '' ?>
        </small>
        <small>
            <?= $errors['classeLibelle'] ?? '' ?>
        </small>
    </div>
    <div class="row position-relative">
        <div class="position-absolute w-auto h-auto start-0 ms-5">
            <a href="<?= $urls['list-niveaux'] ?>">
                <i class="bi bi-arrow-left fs-3 fw-bolder"></i>
            </a>
        </div>
        <div class="position-absolute w-auto h-auto end-0">
            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#createClasse">
                <i class="bi bi-plus fs-1"></i>
            </button>
        </div>
        <div class="m-auto pt-3 col-10 col-lg-6">
            <h4 class="my-4">Les classes de
                <?= $niveau['libelle'] ?>
            </h4>
            <table class="table table-hover mt-4">
                <tbody>
                    <?php if (isset($classes)): ?>
                        <?php foreach ($classes as $c): ?>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <a href="<?= $urls['list-students'] . $c['id'] ?>">
                                        <button class="btn btn-link p-0 fs-5 text-decoration-none text-black">
                                            <?= $c['libelle'] ?>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <button class="dataClickTransfer btn btn-link" data-bs-toggle="modal"
                                        data-bs-target="#editClasse" dataToTransfer="<?= $c['id'] ?>" dataTargetId="#classeId">
                                        <a href="#" data-bs-toggle="tooltip" data-bs-title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </button>
                                </td>
                                <td>
                                    <form action="<?= $urls['delete-classe'] ?>" method="post">
                                        <input type="hidden" name="classeId" value="<?= $c['id'] ?>" />
                                        <input type="hidden" name="niveauId" value="<?= $niveau['id'] ?>" />
                                        <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                                        <button type="submit" class="delete-btn btn btn-link" data-bs-toggle="modal"
                                            data-bs-target="#deleteClasse">
                                            <a href="#" data-bs-toggle="tooltip" data-bs-title="Supprimer">
                                                <i class="text-danger bi bi-trash-fill"></i>
                                            </a>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <a href="<?= $urls['classe-coef'] . $c['id'] ?>">Gérer les coefs</a>
                                </td>
                                <td>
                                    <button class="dataClickTransfer manageNiveauBtn btn btn-link" data-bs-toggle="modal"
                                        data-bs-target="#manageNoteTypes" dataToTransfer="<?= $c['id'] ?>"
                                        dataTargetId="#classeManageId"
                                        data-noteTypes='<?= json_encode($c['noteTypes']) ?>'>Types de note</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="createClasse">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">
                    <?= "Créer une classe pour {$niveau['libelle']}" ?>
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <?php include 'parts/forms/classeform.html.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="editClasse">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Modifier une classe</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <?php include 'parts/forms/classeeditform.html.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="deleteClasse">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h6 class="modal-title text-white" id="myModalLabel">Souhaitez vous vraiment supprimer cette classe ?
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn-yes btn btn-danger">Oui</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="manageNoteTypes">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Gérer classe</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <?php include 'parts/forms/classemanageform.html.php'; ?>
            </div>
        </div>
    </div>
</div>
