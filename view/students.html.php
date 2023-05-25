<main class="d-flex w-100">
    <div class="d-flex flex-column">
        <div class="p-5 w-100" style="background-color:#367fa9;"></div>
        <?php include 'parts/dashboard.html.php' ?>
    </div>
    <div id="main" class="w-100">
        <?php include 'parts/header.html.php' ?>
        <div id="content">
            <?php if (isset($msg)): ?>
                <div class="text-<?= $msg['type'] ?>">
                    <?= $msg['value'] ?>
                </div>
            <?php endif ?>
            <div class="d-flex row">
                <div class="col-8">
                    <div class="row ps-3">
                        <div class="col-8">
                            <div class="row">
                                <?php if (isset($students)): ?>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Prénom</th>
                                                <th scope="col">Nom</th>
                                                <th scope="col">Date de naissance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($students as $s): ?>

                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                <?php endif ?>

                                <div>
                                    <?= include 'parts/forms/formstudent.html.php'; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <button data-bs-toggle="modal" data-bs-target="#modalAddStudent" type="button"
                        class="btn btn-secondary">Ajouter un élève</button>
                </div>

            </div>

        </div>
    </div>

    <!-- <div class="modal fade" id="modalAddStudent" tabindex="-1" aria-labelledby="modalAddStudentLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddStudentLabel">Nouvel élève</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div> -->
</main>
