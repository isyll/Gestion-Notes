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
    <div class="row m-auto pt-2 col-10 col-lg-6">
        <table class="table table-hover mt-2 table-striped">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="text-start">
                <?php if (isset($years)): ?>
                    <?php foreach ($years as $y): ?>
                        <tr>
                            <td>
                                <?= $y['libelle'] ?>
                            </td>
                            <?php if ($y['libelle'] === $currentYear): ?>
                                <td class="bg-success text-white">
                                    Actif
                                </td>
                            <?php else: ?>
                                <td class="bg-danger text-white">
                                    Inactif
                                </td>
                            <?php endif ?>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="changeYearStateCheckbox form-check-input" type="checkbox" role="switch"
                                        id="state" <?= $y['libelle'] === $currentYear ? 'checked' : '' ?> />
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>
