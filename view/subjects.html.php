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
    <div class="row m-auto">
        <h2 class="text-start">
            Gestion des disciplines
        </h2>
        <div class="p-4 border border-2 rounded-2">
            <form action="" method="post">
                <div class="row">
                    <div class="col-12 col-md-6 text-start">
                        <label for="niveaux" class="form-label">Niveau</label>
                        <select name="niveaux" id="niveaux" class="form-select border border-2">
                            <option value="">Choisir...</option>
                            <?php if (isset($niveaux)): ?>
                                <?php foreach ($niveaux as $n): ?>
                                    <option value="<?= $n['id'] ?>"><?= $n['libelle'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 text-start mb-3">
                        <label for="classes" class="form-label">Classe</label>
                        <select name="classes" id="classes" class="form-select border border-2">
                            <option value="">Choisir...</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 text-start">
                        <label for="subjectGroup" class="form-label">Groupe de disciplines</label>
                        <select name="subjectGroup" id="subjectGroup" class="form-select border border-2">
                            <option value="">Choisir...</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 text-start">
                        <label for="subject" class="form-label">Disciplines</label>
                        <div class="d-flex">
                            <input type="text" name="subject" id="subject" class="form-control border border-2" />
                            <button class="btn btn-primary ms-4" type="submit">OK</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

</script>
