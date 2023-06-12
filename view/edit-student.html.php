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
            <a href="<?= $urls['new-student'] . $classe['id'] ?>">
                <i class="bi bi-plus fs-1"></i>
            </a>
        </div>
        <div class="m-auto pt-2 col-10 col-lg-6">
            <div>
                <?= $niveau['libelle'] ?>
                <code class="fs-5">/</code>
                <?= $classe['libelle'] ?>
                <div>
                    <?php $studentFormTarget = $urls['edit-student'];
                    include 'parts/forms/studentform.html.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>
