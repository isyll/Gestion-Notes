<form action="" method="post">
    <label for="username" class="form-label">Nom d'utilisateur</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required
        aria-labelledby="unHelp" />

    <?php if (isset($errors['username'])): ?>
        <div id="unHelp" class="text-danger">
            <?= $errors['username'] ?>
        </div>
    <?php endif ?>

    <label for="email" class="form-label">Adresse email</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="Email" required
        aria-labelledby="emailHelp" />

    <?php if (isset($errors['email'])): ?>
        <div id="emailHelp" class="text-danger">
            <?= $errors['email'] ?>
        </div>
    <?php endif ?>

    <label for="password" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required
        aria-labelledby="passHelp" />

    <?php if (isset($errors['password'])): ?>
        <div id="passHelp" class="text-danger">
            <?= $errors['password'] ?>
        </div>
    <?php endif ?>

    <label for="firstname" class="form-label">Prénom</label>
    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom" required
        aria-labelledby="fnHelp" />

    <?php if (isset($errors['firstname'])): ?>
        <div id="fnHelp" class="text-danger">
            <?= $errors['firstname'] ?>
        </div>
    <?php endif ?>

    <label for="lastname" class="form-label">Nom</label>
    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom de famille" required
        aria-labelledby="lnHelp" />

    <?php if (isset($errors['lastname'])): ?>
        <div id="lnHelp" class="text-danger">
            <?= $errors['lastname'] ?>
        </div>
    <?php endif ?>

    <label for="phone" class="form-label">Téléphone</label>
    <input type="text" class="form-control" id="phone" name="phone" placeholder="Numéro de téléphone" required
        aria-labelledby="phHelp" />

    <?php if (isset($errors['phone'])): ?>
        <div id="phHelp" class="text-danger">
            <?= $errors['phone'] ?>
        </div>
    <?php endif ?>

    <label for="address" class="form-label">Adresse</label>
    <input type="text" class="form-control" id="address" name="address" placeholder="Adresse"
        aria-labelledby="unHelp" />

    <?php if (isset($errors['address'])): ?>
        <div id="unHelp" class="text-danger">
            <?= $errors['address'] ?>
        </div>
    <?php endif ?>

    <input type="submit" class="btn btn-primary text-white mt-2" value="Valider" />
</form>
