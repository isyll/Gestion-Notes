<header>
    <?php include 'parts/navbar.html.php' ?>
</header>
<div class="container">
    <div class="row">
        <div id="updateMsg"></div>
        <?php if (isset($msg)): ?>
            <div class="text-<?= $msg['type'] ?>">
                <?= $msg['value'] ?>
            </div>
        <?php endif ?>
        <small>
            <?= $errors['groupName'] ?? '' ?>
        </small>
    </div>
    <div class="row m-auto">
        <div class="d-flex justify-content-between">
            <h2 class="text-start">
                Gestion des disciplines
            </h2>
            <div class="text-end fs-5" id="handleClasseSbjBtn"><a class=" text-decoration-none"
                    href="<?= $urls['classe-coef'] ?>"></a></div>
        </div>
        <div class="p-4 border border-2 rounded-2">
            <div class="row">
                <div class="col-12 col-md-6 text-start">
                    <label for="niveaux" class="form-label">Niveau</label>
                    <select name="niveaux" id="niveaux" class="form-select border border-2">
                        <option value="">Choisir...</option>
                        <?php if (isset($niveaux)): ?>
                            <?php foreach ($niveaux as $n): ?>
                                <option value="<?= $n['id'] ?>"><?= $n['libelle'] ?></option>
                            <?php endforeach ?>
                        <?php endif ?>
                    </select>
                    <small class=" text-danger" id="niveauxHelp">
                        <?= $errors['niveaux'] ?? '' ?>
                    </small>
                </div>
                <div class="col-12 col-md-6 text-start mb-3">
                    <label for="classes" class="form-label">Classe</label>
                    <select name="classes" id="classes" class="form-select border border-2">
                        <option value="">Choisir...</option>
                    </select>
                    <small class=" text-danger" id="classesHelp">
                        <?= $errors['classes'] ?? '' ?>
                    </small>
                </div>
                <div class="col-12 col-md-6 text-start">
                    <div class="d-flex">
                        <label for="subjectGroup" class="form-label align-self-center">
                            Groupe de disciplines
                        </label>
                        <div class="align-self-center">
                            <small>
                                <button type="button" id="editGroupBtn"
                                    class="btn btn-link text-decoration-none ms-2 text-reset" data-bs-toggle="modal"
                                    data-bs-target="#editGroup" style="font-size: x-small;">
                                    <i class="bi bi-pencil-fill"></i>
                                    Modifier
                                </button>
                            </small>
                            <small>
                                <button class="btn btn-link text-reset text-decoration-none" type="button"
                                    data-bs-toggle="modal" data-bs-target="#newGroup" style="font-size: x-small;">
                                    <i class="bi bi-plus-circle text-reset"></i>
                                    Ajouter
                                </button>
                            </small>
                            <small>
                                <button id="deleteGrpBtn" class=" btn btn-link text-danger text-decoration-none"
                                    type="button" data-bs-toggle="modal" data-bs-target="#deleteGroup"
                                    style="font-size: x-small;">
                                    <i class="bi bi-trash-fill text-reset"></i>
                                    Supprimer
                                </button>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex">
                        <select name="subjectGroup" id="subjectGroup" class="form-select border border-2">
                            <option value="">Choisir...</option>
                            <?php if (isset($groups)): ?>
                                <?php foreach ($groups as $g): ?>
                                    <option value="<?= $g['id'] ?>" <?= isset($selectedGroup) && $selectedGroup == $g['id'] ? 'selected' : '' ?>><?= $g['nom'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <small class=" text-danger" id="subjGrpHelp">
                        <?= $errors['subjectGroup'] ?? '' ?>
                    </small>
                </div>
                <div class="col-12 col-md-6 text-start align-self-end">
                    <label for="subject" class="form-label">Disciplines</label>
                    <div class="d-flex">
                        <input type="text" name="subject" id="subject" class="form-control border border-2" />
                        <button id="addSubjectBtn" class="btn btn-primary ms-4" type="submit">OK</button>
                    </div>
                    <small class=" text-danger" id="subjectHelp">
                        <?= $errors['subject'] ?? '' ?>
                    </small>
                    <small id="subjectOk" class="text-success"></small>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h4 id="subjectsTitle" class="text-start fw-semibold mb-4"></h4>
        <div id="subjectsContainer" class="p-4 bg-light text-start"></div>
        <div class="d-flex justify-content-end">
            <button id="updateSubjectsBtn" type="submit" class="btn btn-primary ms-auto me-3">Mettre à jour</button>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="newGroup">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Nouveau groupe de discipline
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <?php include 'parts/forms/subjectgroupform.html.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="editGroup">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Modifier groupe de discipline
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <?php include 'parts/forms/subjectgroupeditform.html.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="deleteGroup">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h6 class="modal-title text-white" id="myModalLabel">Souhaitez vous vraiment supprimer ce groupe de
                    disciplines ?
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <form action="<?= $urls['delete-subject-group'] ?>" method="post">
                    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                    <input type="hidden" name="groupId" id="deleteGroupId" value="" />
                    <button type="submit" class="modal-btn-yes btn btn-danger">Oui</button>
                </form>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="createSubjectConfirm">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Souhaitez-vous créer cette discipline ?</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="createSubjectBtn btn" data-bs-dismiss="modal">Oui</button>
                <button type="button" class="btn" data-bs-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="selectSbjGrpModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Cette discipline n'existe pas sélectionnez un groupe pour la
                    créer.</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
