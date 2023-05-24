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
            <div class="row ms-1">
                <div class="col-8">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            <form class="d-flex" method="post" action="<?= $urls['create-year'] ?>">
                                <label for="period" class="form-label me2">Libellé</label>
                                <input type="text" maxlength="9" class="form-control ms-2" name="period" id="period"
                                    required />
                                <input type="submit" class="btn btn-secondary ms-2 text-white" value="Ajouter" />
                            </form>
                        </div>
                        <div class="col-3"></div>
                    </div>
                    <div class="row">
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                Année scolaire
                                            </th>
                                            <th scope="col">
                                                Actions
                                            </th>
                                            <th scope="col">
                                                Etat
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($schoolYears as $y): ?>
                                            <tr>
                                                <td>
                                                    <?= $y['periode'] ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <a href="/<?= $urls['base'] ?>/<?= $y['periode'] ?>">Sélectionner</a>
                                                        <button type="submit" class="update-year-button p-0 btn btn-link"
                                                            data-bs-toggle="modal" data-bs-target="#modalUpdateYear"
                                                            yearPeriod="<?= $y['periode'] ?>"
                                                            yearId="<?= $y['id'] ?>">Modifier</button>
                                                        <form action="/remove-year" method="post">
                                                            <input type="hidden" name="yearId" value="<?= $y['id'] ?>" />
                                                            <button type="submit"
                                                                class="p-0 btn btn-link text-danger">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <form action="/change-year-state" method="post">
                                                            <input type="hidden" name="yearId" value="<?= $y['id'] ?>" />
                                                            <input class="form-check-input" type="checkbox" role="switch"
                                                                onchange="this.form.submit()" id="activeYear" name="action"
                                                                <?= $y['active'] ? 'checked' : '' ?>
                                                                value="<?= $y['active'] ? 'disable' : 'active' ?>" />
                                                            <label class="form-check-label" for="activeYear">
                                                                <?= $y['active'] ? 'désactiver' : 'activer' ?>
                                                            </label>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <div class="modal" tabindex="-1" id="modalUpdateYear">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Changer une année</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php include 'parts/forms/anneeform.html.php'; ?>
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</main>

<script>
    let updYear = document.getElementsByClassName('update-year-button');

    [...updYear].forEach(element =>
    {
        element.addEventListener('click', function (event)
        {
            let period = event.target.getAttribute('yearPeriod');
            let id = event.target.getAttribute('yearId');

            document.getElementById('yearId').value = id;
            document.getElementById('yearPeriod').value = period;
            document.getElementById('yearNewValue').value = period;
        });
    });
</script>
