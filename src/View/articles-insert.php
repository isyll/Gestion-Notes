<div>
    <form action="" method="post">
        <label for="libelle">Prix de l'article</label>
        <input type="text" name="libelle" id="libelle">
        <?php if (isset($libelle)): ?>
            <small style="color:red;">
                <?= $libelle ?>
            </small>
        <?php endif ?>

        <label for="prix">Prix de l'article</label>
        <input type="text" name="prix" id="prix">
        <?php if (isset($prix)): ?>
            <small style="color:red;">
                <?= $prix ?>
            </small>
        <?php endif ?>
        <input type="submit" value="Envoyer">
        <?php if (isset($msg)): ?>
            <small style="color:green;">
                <?= $msg ?>
            </small>
        <?php endif ?>
    </form>
</div>