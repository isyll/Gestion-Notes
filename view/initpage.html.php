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
        <div class="m-auto pt-2 col-10 col-lg-6 h3">
            <br>
            <a href="<?= $urls['school-years'] ?>">
                Vous devez activer une année scolaire par défaut avant d'utiliser l'application.
            </a>
        </div>
    </div>
</div>
