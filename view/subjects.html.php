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
            <?= $errors['groupName'] ?? '' ?>
        </small>
    </div>
    <div class="row m-auto">
        <h2 class="text-start">
            Gestion des disciplines
        </h2>
        <div class="p-4 border border-2 rounded-2">
            <form action="" method="post">
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
                    </div>
                    <div class="col-12 col-md-6 text-start mb-3">
                        <label for="classes" class="form-label">Classe</label>
                        <select name="classes" id="classes" class="form-select border border-2">
                            <option value="">Choisir...</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 text-start">
                        <label for="subjectGroup" class="form-label">Groupe de disciplines</label>
                        <div class="d-flex">
                            <select name="subjectGroup" id="subjectGroup" class="form-select border border-2">
                                <option value="">Choisir...</option>
                            </select>
                            <button class="ms-2 btn btn-link" type="button" data-bs-toggle="modal"
                                data-bs-target="#newGroup">
                                <i class="bi bi-plus-circle fs-4 text-black"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-start">
                        <label for="subject" class="form-label">Disciplines</label>
                        <div class="d-flex">
                            <input type="text" name="subject" id="subject" class="form-control border border-2" />
                            <button class="btn btn-primary ms-4" type="submit">OK</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="newGroup">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-white" id="myModalLabel">Nouveau groupe de discipline
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <?php include include 'parts/forms/subjectgroupform.html.php'; ?>
            </div>
        </div>
    </div>
</div>
