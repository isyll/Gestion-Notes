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
            <?= $niveau['libelle'] ?> <code class="fs-4 text-white">/</code>
            Classe :
            <?= $classe['libelle'] ?>
        </h5>
        <div class="m-auto pt-3 col-10 col-lg-6">
            <?php include 'parts/forms/studentform.html.php'; ?>
        </div>
    </div>
</div>
