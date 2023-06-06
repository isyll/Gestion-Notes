<form action="<?= $studentFormTarget ?? $urls['create-student'] ?>" method="post" id="formAnnee"
    class="text-start m-auto">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <input type="hidden" name="niveauId" value="<?= $niveau['id'] ?? '' ?>" />
    <input type="hidden" name="classeId" value="<?= $classe['id'] ?? '' ?>" />
    <input type="hidden" name="studentId" value="<?= $student['id'] ?? '' ?>" />
    <div class="row">
        <div class="col-lg-6 col-12">
            <label for="firstname" class="form-label">Prénom</label>
            <input required type="text" class="form-control" placeholder="Prénom de l'étudiant" name="firstname"
                id="firstname" value="<?= $student['prenom'] ?? '' ?>" />
            <?php if (isset($errors['firstname'])): ?>
                <div id="fn" class="form-text text-danger">
                    <?= $errors['firstname'] ?>
                </div>
            <?php endif ?>
        </div>
        <div class="col-lg-6 col-12">
            <label for="lastname" class="form-label">Nom</label>

            <input required type="text" class="form-control" placeholder="Nom de l'étudiant" name="lastname"
                id="lastname" value="<?= $student['nom'] ?? '' ?>" />
            <div id="ln" class="form-text text-danger">
                <?= $errors['lastname'] ?? '' ?>
            </div>
        </div>

        <div class="col-12">
            <label for="studentType" class="form-label">Type</label>
            <select id="studentType" name="studentType" class="form-select" required>
                <option>Choisir...</option>
                <option value="externe" <?= isset($student['type']) ? ($student['type'] === 'externe' ? 'selected' : '') : '' ?>>Externe</option>
                <option value="interne" <?= isset($student['type']) ? ($student['type'] === 'interne' ? 'selected' : '') : '' ?>>Interne</option>
            </select>
            <div id="ln" class="form-text text-danger">
                <?= $errors['studentType'] ?? '' ?>
            </div>
        </div>
        <div class="col-12">
            <label for="birthdate" class="form-label">Date de naissance</label>
            <input type="date" name="birthdate" class="form-control" value="<?= $student['naissance'] ?? '' ?>" />
            <div id="ln" class="form-text text-danger">
                <?= $errors['birthdate'] ?? '' ?>
            </div>
        </div>

        <div class="col-12">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" class="form-control" name="email" id="email" value="<?= $student['email'] ?? '' ?>" />
            <div id="em" class="form-text text-danger">
                <?= $errors['email'] ?? '' ?>
            </div>
        </div>
        <div class="col-12">
            <label for="phone" class="form-label">Numéro de téléphone</label>
            <input type="tel" class="form-control" name="phone" id="phone" value="<?= $student['telephone'] ?? '' ?>" />
            <div id="ph" class="form-text">
                <?= $errors['phone'] ?? '' ?>
            </div>
        </div>
        <div class="col-12">
            <label for="address" class="form-label">Adresse</label>
            <input type="text" class="form-control" name="address" id="address"
                value="<?= $student['adresse'] ?? '' ?>" />
            <div id="adr" class="form-text">
                <?= $errors['address'] ?? '' ?>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center align-items-center">
        <button type="button" class="me-2 btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="ms-2 btn btn-primary">Valider</button>
    </div>
</form>
