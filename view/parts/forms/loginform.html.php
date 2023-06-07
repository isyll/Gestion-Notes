<form action="<?= $urls['login'] ?>" method="post">
    <input type="hidden" name="current-url" value="<?= $currentURL ?>" />
    <div class="mb-3 form-floating">
        <input type="text" class="form-control" id="username" name="username" required>
        <label for="username">Nom d'utilisateur</label>
        <div class="text-danger">
            <?= $errors['username'] ?? '' ?>
        </div>
    </div>
    <div class="mb-3 form-floating">
        <input type="password" class="form-control" id="password" name="password" required>
        <label for="password">Mot de passe</label>
        <div class="text-danger">
            <?= $errors['password'] ?? '' ?>
        </div>
    </div>
    <button type="submit" name="login-form" class="btn btn-primary w-100">Valider</button>
</form>
