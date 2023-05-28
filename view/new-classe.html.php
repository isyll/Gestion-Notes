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
        <h4 class="my-4">Créer une classe pour
            <?= $niveau['libelle'] ?>
        </h4>
        <div class="m-auto col-10 col-lg-6">
            <form action="<?= $urls['create-classe'] ?>" method="post" class="d-flex">
                <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
                <input type="hidden" name="niveauId" value="<?= $niveau['id'] ?>" />
                <input type="text" name="classeLibelle" id="classeLibelle" class="form-control align-self-center"
                    placeholder="Nom de la classe" required />
                <button type="submit" class="btn btn-secondary align-self-center">Ajouter</button>
            </form>
        </div>
    </div>
</div>
