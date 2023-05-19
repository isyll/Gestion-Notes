<div>
    <table class="table-primary">
        <thead>
            <tr>
                <th scope="col">Numéro</th>
                <th scope="col">Prix</th>
                <th scope="col">Libellé</th>
            </tr>
        </thead>
        <?php $i = 1; ?>
        <?php foreach ($data as $d): ?>
            <tr>
                <th scope="row">
                    <?= $i; ?>
                    </td>
                <td>
                    <?= $d["prix"] ?>
                </td>
                <td>
                    <?= $d["libelle"] ?>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach ?>
    </table>
</div>
