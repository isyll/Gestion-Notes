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
        <h5>
            Niveau :
            <?= $niveau['libelle'] ?> <code class="fs-4">/</code>
            Classe :
            <?= $classe['libelle'] ?>
            <br />
            Prénom :
            <?= $student['prenom'] ?> <code class="fs-4">/</code>
            Nom :
            <?= $student['nom'] ?>
        </h5>
    </div>
</div>
