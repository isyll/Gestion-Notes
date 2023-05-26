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
            <?php include 'parts/forms/studentform.html.php'; ?>
        </div>
        <div class="col-3"></div>
    </div>
</div>
