<form action="<?= $urls['login'] ?>" method="post">
    <input type="hidden" name="current-url" value="<?= $urls['current-url'] ?>" />
    <div class="mb-3 form-floating">
        <label for="username" class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" id="username" name="username">
        <div class="text-danger">
            <?= $errors['username'] ?? '' ?>
        </div>
    </div>
    <div class="mb-3 form-floating">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password">
        <div class="text-danger">
            <?= $errors['password'] ?? '' ?>
        </div>
    </div>
    <button type="submit" name="login-form" class="btn btn-primary w-100">Valider</button>
</form>
