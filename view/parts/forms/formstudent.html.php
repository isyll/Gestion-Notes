<form action="" method="post" id="formAnnee">
    <div class="row">
        <div class="col-6">
            <input type="text" class="form-control" placeholder="Prénom" aria-label="Prénom" name="firstname"
                id="firstname" required />
        </div>
        <div class="col-6">
            <input type="text" class="form-control" placeholder="Nom" aria-label="Nom" name="lastname" required
                id="lastname" />
        </div>
        <div class="col-12">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" required class="form-control" name="email" id="email">
        </div>
        <div class="col-12">
            <label for="phone" class="form-label">Numéro de téléphone</label>
            <input type="tel" required class="form-control" name="phone" id="phone">
        </div>
        <div class="col-12">
            <label for="address" class="form-label">Adresse</label>
            <input type="text" class="form-control" name="address" id="address">
        </div>
    </div>

    <div class="col-12">
        <label for="studentType" class="form-label">Type</label>
        <select id="studentType" class="form-select" required>
            <option selected>Choisir...</option>
            <option value="externe">Externe</option>
            <option value="intene">Interne</option>
        </select>
    </div>

    <div class="mt-4 d-flex justify-content-center align-items-center">
        <button type="button" class="me-2 btn btn-secondary text-white" data-bs-dismiss="modal">Fermer</button>
        <button type="submit" class="ms-2 text-white btn btn-primary">Valider</button>
    </div>
</form>
