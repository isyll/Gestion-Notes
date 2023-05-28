<header>
    <?php include 'parts/navbar.html.php' ?>
</header>
<div class="container w-100">
    <div class="row">
        <?php if (isset($msg)): ?>
            <div class="text-<?= $msg['type'] ?>">
                <?= $msg['value'] ?>
            </div>
        <?php endif ?>
    </div>

    <div class="row">
        <div class="m-auto col-10 col-lg-6">
            <label class="my-4 form-label fs-4" for="niveauLibelle">Créer un niveau</label>
            <form action="<?= $urls['create-niveau'] ?>" method="post" class="d-flex">
                <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                <input type="text" name="niveauLibelle" id="niveauLibelle" class="form-control align-self-center"
                    placeholder="Nom du niveau" required />
                <button type="submit" class="btn btn-secondary align-self-center">Ajouter</button>
            </form>
        </div>
    </div>
</div>
