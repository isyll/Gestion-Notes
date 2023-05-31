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
        <small>
            <?= $errors['libelle'] ?? '' ?>
        </small>
        <small>
            <?= $errors['yearId'] ?? '' ?>
        </small>
    </div>
    <div class="row m-auto pt-2 col-10 col-lg-8 position-relative">
        <div class="position-absolute w-auto h-auto end-0">
            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#createYear">
                <i class="bi bi-plus fs-1"></i>
            </button>
        </div>
        <ul class="list-group w-75 m-auto" id="yearList">
            <?php if (isset($years)): ?>
                <?php $i = 1;
                foreach ($years as $y): ?>
                    <li class="list-group-item d-flex justify-content-between flex-column flex-md-row">
                        <div class="align-self-center">
                            <span>
                                <?= $y['libelle'] ?>
                            </span>
                            <small class="fst-italic text-success fw-bold ms-lg-4">
                                <?= $y['libelle'] == $currentYear ? 'En cours' : '' ?>
                            </small>
                        </div>
                        <div class="align-self-center">
                            <div class="input-group mb-3">
                                <button type="button" class="btn btn-outline-secondary">Options</button>
                                <button type="button"
                                    class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split border-start-0"
                                    data-bs-toggle="dropdown">
                                </button>
                                <ul class="dropdown-menu shadow-lg">
                                    <?php if ($y['libelle'] != $currentYear): ?>
                                        <li>
                                            <button class="dropdown-item" href="#">
                                                <i class="bi bi-toggle2-on"></i>
                                                Activer
                                            </button>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form action="<?= $urls['delete-year'] ?>" method="post">
                                                <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                                                <input type="hidden" name="yearId" value="<?= $y['id'] ?>" />
                                                <button class="delete-btn dropdown-item text-danger" type="submit" data-bs-toggle="modal" data-bs-target="#deleteYear">
                                                    <i class="text-danger bi bi-trash-fill"></i>
                                                    Supprimer
                                                </button>
                                            </form>
                                        </li>
                                    <?php endif ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <button class="dataClickTransfer dropdown-item" href="#" dataToTransfer="<?= $y['id'] ?>"
                                            dataTargetId="#yearId" data-bs-toggle="modal" data-bs-target="#editYear">
                                            <i class="bi bi-pencil-fill"></i>
                                            Modifier
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php endforeach ?>
            <?php endif ?>
        </ul>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="editYear">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Modifier une année</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <?php include 'parts/forms/yeareditform.html.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="createYear">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Créer une année</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <?php include 'parts/forms/yearform.html.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="deleteYear">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h6 class="modal-title text-white" id="myModalLabel">Souhaitez vous vraiment supprimer cette année ?
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="modal-btn-yes">Oui</button>
                <button type="button" class="btn btn-danger" id="modal-btn-no" data-bs-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>
