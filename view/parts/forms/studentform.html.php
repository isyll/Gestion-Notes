<form action="<?= $urls['create-student'] ?>" method="post" id="formAnnee">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <div class="row">
        <div class="col-6">
            <label for="firstname" class="form-label">Prénom</label>
            <input required type="text" class="form-control" placeholder="Prénom de l'étudiant" aria-label="Prénom"
                name="firstname" id="firstname" />
            <?php if (isset($errors['firstname'])): ?>
                <div id="fn" class="form-text text-danger">
                    <?= $errors['firstname'] ?>
                </div>
            <?php endif ?>
        </div>
        <div class="col-6">
            <label for="lastname" class="form-label">Nom</label>

            <input required type="text" class="form-control" placeholder="Nom de l'étudiant" name="lastname"
                id="lastname" />
            <?php if (isset($errors['lastname'])): ?>
                <div id="ln" class="form-text text-danger">
                    <?= $errors['lastname'] ?>
                </div>
            <?php endif ?>
        </div>

        <div class="col-12">
            <label for="studentType" class="form-label">Type</label>
            <select id="studentType" name="studentType" class="form-select" required>
                <option selected>Choisir...</option>
                <option value="externe">Externe</option>
                <option value="intene">Interne</option>
            </select>
        </div>

        <div class="col-6">
            <label for="niveauId" class="form-label">Niveau</label>
            <select id="niveauId" name="niveauId" class="form-select" required>
                <option selected value="">Choisir...</option>
                <?php if (isset($niveaux)): ?>
                    <?php foreach ($niveaux as $n): ?>
                        <option value="<?= $n['id'] ?>"><?= $n['libelle'] ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </div>

        <div class="col-6">
            <label for="classeId" class="form-label">Classe</label>
            <select id="classeId" name="classeId" class="form-select" required>
            </select>
        </div>

        <div class="col-12">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" class="form-control" name="email" id="email">
            <?php if (isset($errors['email'])): ?>
                <div id="em" class="form-text text-danger">
                    <?= $errors['email'] ?>
                </div>
            <?php endif ?>
        </div>
        <div class="col-12">
            <label for="phone" class="form-label">Numéro de téléphone</label>
            <input type="tel" class="form-control" name="phone" id="phone">
            <?php if (isset($errors['phone'])): ?>
                <div id="ph" class="form-text">
                    <?= $errors['phone'] ?>
                </div>
            <?php endif ?>
        </div>
        <div class="col-12">
            <label for="address" class="form-label">Adresse</label>
            <input type="text" class="form-control" name="address" id="address" />
            <?php if (isset($errors['address'])): ?>
                <div id="adr" class="form-text">
                    <?= $errors['address'] ?>
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center align-items-center">
        <button type="button" class="me-2 btn btn-secondary text-white" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="ms-2 text-white btn btn-primary">Valider</button>
    </div>
</form>
