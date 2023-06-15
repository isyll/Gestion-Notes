<header>
    <?php include 'parts/navbar.html.php' ?>
</header>
<div class="container">
    <div class="row">
        <?php if (isset($msg)): ?>
            <div class="alert alert-<?= $msg['type'] ?>" role="alert">
                <?= $msg['value'] ?>
            </div>
        <?php endif ?>
        <div id="resultMsg" class="alert"></div>
    </div>

    <div class="row position-relative">
        <div class="position-absolute w-auto h-auto start-0 ms-5">
            <a href="<?= $urls['list-classes'] . $niveau['id'] ?>">
                <i class="bi bi-arrow-left fs-3 fw-bolder"></i>
            </a>
        </div>
        <div class="d-flex position-absolute w-auto h-auto end-0">
            <a href="<?= $urls['new-student'] . $classe['id'] ?>">
                <i class="bi bi-plus fs-1"></i>
            </a>
            <a class="align-self-center" href="<?= $urls['classe-coef'] . $classe['id'] ?>">Gérer les coefs</a>
        </div>
        <div class="m-auto pt-2 col-10 col-lg-6">
            <div>
                <?= $niveau['libelle'] ?>
                <code class="fs-5">/</code>
                <?= $classe['libelle'] ?> (
                <?= $yearInfos['libelle'] ?>)
                <div>Effectif :
                    <?= count($students ?? []) ?>
                </div>
                <div id="classAvg" class="fw-bold">Moyenne classe :
                </div>
            </div>
            <div class="row">
                <div class="d-flex justify-content-between mt-3">
                    <div></div>
                    <div class="d-flex">
                        <div class="me-2">
                            <label for="chooseSubject">Discipline</label>
                            <select class="filterNotesSelect form-select" name="subjectId" id="chooseSubject">
                                <option value="">Choisir</option>
                                <?php if (isset($subjects)): ?>
                                    <?php foreach ($subjects as $s): ?>
                                        <option value="<?= $s['id'] ?>">
                                            <?= $s['nom'] ?>
                                        </option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div class="me-2">
                            <label for="chooseCycle">
                                <?= $niveau['nom_cycle'] ?? 'Cycle' ?>
                            </label>
                            <select class="filterNotesSelect form-select" name="cycle" id="chooseCycle">
                                <option value="">Choisir</option>
                                <?php if (isset($niveau)): ?>
                                    <?php for ($i = 1; $i <= $niveau['nb_cycles']; $i++): ?>
                                        <option value="<?= $i ?>"><?= "{$niveau['nom_cycle']} $i" ?></option>
                                    <?php endfor ?>
                                <?php endif ?>
                            </select>
                        </div>
                        <div>
                            <label for="chooseType">Note de</label>
                            <select class="filterNotesSelect form-select" name="noteType" id="chooseType">
                                <option value="">Choisir</option>
                                <option value="ressource">Ressource</option>
                                <option value="examen">Examen</option>
                            </select>
                        </div>
                    </div>
                </div>
                <table class="table table-hover mt-2">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="text-start">
                        <?php if (isset($students)): ?>
                            <?php foreach ($students as $s): ?>
                                <tr>
                                    <td>
                                        <?php if (isset($s['photo'])): ?>
                                            <?php $img = base64_encode($s['photo']) ?>
                                            <img style="width: 80px;" class=" rounded-circle img-thumbnail"
                                                src="data:image/jpeg;base64,<?= $img; ?>" alt="Image profil">
                                        <?php else: ?>
                                            <img style="width: 80px;" class=" disabled rounded-circle img-thumbnail"
                                                src="/img/profiles/placeholderprofile.jpg">
                                        <?php endif ?>
                                    </td>
                                    <td class="pt-2">
                                        <a href="<?= "{$urls['student-page']}{$s['id']}" ?>"
                                            class="text-reset text-decoration-none">
                                            <?= $s['prenom'] ?>
                                            <?= $s['nom'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= "{$urls['edit-student-page']}{$s['id']}" ?>" data-bs-toggle="tooltip"
                                            data-bs-title="Modifier">
                                            <button class="btn btn-link">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                        <form class="delete-student-form" action="<?= $urls['delete-student'] ?>" method="post">
                                            <input type="hidden" name="studentId" value="<?= $s['id'] ?>" />
                                            <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                                            <button type="submit" data-bs-toggle="modal" data-bs-target="#confirmDeleteStudent"
                                                class="delete-btn btn btn-link text-danger">
                                                <a href="#" data-bs-toggle="tooltip" data-bs-title="Supprimer">
                                                    <i class="text-danger bi bi-trash-fill"></i>
                                                </a>
                                            </button>
                                        </form>
                                    </td>
                                    <td class=" d-flex flex-column">
                                        <div class="d-flex">
                                            <input data-student-id="<?= $s['id'] ?>" name="<?= 'notes-' . $s['id'] ?>"
                                                style="width:100px;" class=" studentNote form-control" type="number" value="" />
                                            <div class="max-note-sep fs-5 fw-bold">/</div>
                                            <div class="max-note fs-5 fw-bold"></div>
                                        </div>
                                        <small style="font-size: 74%;" class=" notDoThisSubject"
                                            data-student-id="<?= $s['id'] ?>"></small>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input name="<?= 'do-this-sbj-' . $s['id'] ?>" data-student-id="<?= $s['id'] ?>"
                                                type="checkbox" class="hasThisSubject form-check-input" disabled checked
                                                role="switch" />
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex">
                <button id="updateNotesBtn" type="button" class="btn btn-primary ms-auto me-3" onclick="modal()">
                    <a href="#" class="text-reset text-decoration-none">
                        Enregistrer
                    </a>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="confirmDeleteStudent">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h6 class="modal-title text-white" id="myModalLabel">Souhaitez vous vraiment supprimer cet élève ?
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

<div class="modal fade" tabindex="-1" role="dialog" id="confirmDeleteStudentSubject">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h6 class="modal-title text-white" id="myModalLabel">Voulez-vous retirer cette discipline à cet élève ?
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn-yes btn btn-danger" data-bs-dismiss="modal">Oui</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
            </div>
        </div>
    </div>
</div>
<div id="modalSpinner" class="modal bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>
<script type="application/json" id="classeDatas">
<?= json_encode($classe) ?>
</script>
