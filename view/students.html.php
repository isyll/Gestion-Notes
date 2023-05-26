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

    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <table class="table table-striped table-hover mt-4">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">autres informations
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($students)): ?>
                        <?php foreach ($students as $s): ?>
                            <tr>
                                <td></td>
                                <td>
                                    <?= $s['prenom'] ?>
                                </td>
                                <td>
                                    <?= $s['nom'] ?>
                                </td>
                                <td>
                                    <?= $s['telephone'] ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-link p-0">plus...</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        <div class="col-3"></div>
    </div>
</div>
