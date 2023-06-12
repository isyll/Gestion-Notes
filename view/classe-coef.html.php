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
        <div id="resultMsg"></div>
    </div>
    <div>
        <div class="row">
            <h5 class="col-6 mx-auto text-center">Classe : <a class=" text-danger"
                    href="<?= $urls['list-students'] . $classe['id'] ?>"><code><?= $classe['libelle'] ?></code></a>
            </h5>
        </div>
        <div class=" row">
            <div class="col-8 m-auto">
                <table class=" table table-hover" id="coefsTable">
                    <thead>
                        <tr>
                            <th scope="col">Disciplines</th>
                            <th scope="col">Ressource</th>
                            <th scope="col">Examen</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subjects as $s): ?>
                            <tr>
                                <td>
                                    <?= $s['nom'] ?>
                                </td>
                                <td>
                                    <input type="number" class="inputCoef form-control" name="<?= $s['code'] ?>"
                                        typeMax="max_ressource"
                                        value="<?= $s['coef']['max_ressource'] != 0 ? $s['coef']['max_ressource'] : '' ?>" />
                                </td>
                                <td>
                                    <input type="number" class="inputCoef form-control" name="<?= $s['code'] ?>"
                                        typeMax="max_examen"
                                        value="<?= $s['coef']['max_examen'] != 0 ? $s['coef']['max_examen'] : '' ?>" />
                                </td>
                                <td>
                                    <form action="<?= $urls['delete-classe-subject'] ?>" method="post">
                                        <input type="hidden" name="classeId" value="<?= $classe['id'] ?>" />
                                        <input type="hidden" name="subjectId" value="<?= $s['id'] ?>" />
                                        <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                                        <button type="submit" class="delete-btn btn btn-link" data-bs-toggle="modal"
                                            data-bs-target="#deleteClasseSubject">
                                            <a href="#" data-bs-toggle="tooltip" data-bs-title="Supprimer">
                                                <i class="text-danger bi bi-x fs-3 fw-bolder"></i>
                                            </a>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button id="updateCoefsBtn" type="submit" class="btn btn-primary ms-auto me-3">Mettre à jour</button>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="deleteClasseSubject">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h6 class="modal-title text-white" id="myModalLabel">Souhaitez vous vraiment supprimer cette discipline
                    ?
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
<script>
    const getClasseId = <?= $classe['id'] ?>;
</script>
