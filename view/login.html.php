<main class="form-signin w-100 m-auto">
    <div class="container">
        <div class="row">
            <?php if (isset($msg)): ?>
                <div class="text-<?= $msg['type'] ?>">
                    <?= $msg['value'] ?>
                </div>
            <?php endif ?>
        </div>
        <div class="row">
            <div class="col-4 m-auto">
                <div class="fs-4 text-info text-center mb-4">Veuillez vous connecter</div>
                <?php include 'parts/forms/loginform.html.php' ?>
            </div>
        </div>
    </div>
</main>
