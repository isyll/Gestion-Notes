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
            <a href="<?= $urls['new-student'] . $niveau['id'] . '/' . $classe['id'] ?>">
                <i class="bi bi-plus fs-1"></i>
            </a>
        </div>
        <div class="m-auto pt-2 col-10 col-lg-6">
            <div>
                <?= $niveau['libelle'] ?>
                <code class="fs-5">/</code>
                <?= $classe['libelle'] ?>
                <code class="fs-5">/</code>
                Nombre d'élèves :
                <code class="text-black fs-5">
                    <?= count($students ?? []) ?>
                </code>
            </div>
            <table class="table table-hover mt-2 table-striped">
                <thead>
                    <tr>
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
                                    <a href="<?= "{$urls['student-page']}{$niveau['id']}/{$classe['id']}/{$s['id']}" ?>"
                                        class="text-reset text-decoration-none">
                                        <?= $s['prenom'] ?>
                                        <?= $s['nom'] ?>
                                    </a>
                                </td>
                                <td>
                                    <?= $s['telephone'] ?>
                                </td>
                                <td>
                                    <a href="<?= "{$urls['edit-student-page']}{$niveau['id']}/{$classe['id']}/{$s['id']}" ?>"
                                        data-bs-toggle="tooltip" data-bs-title="Modifier">
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
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
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
