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
        <h5 class="text-start">Nom de la classe : <code><?= $classe['libelle'] ?></code>
        </h5>

        <div>
            <table class=" table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Disciplines</th>
                        <th scope="col">Ressources</th>
                        <th scope="col">Examens</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjects as $s): ?>
                        <tr>
                            <td>
                                <?= $s['nom'] ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
