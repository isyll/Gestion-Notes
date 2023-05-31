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
    <div class="row m-auto pt-2 col-10 col-lg-8">
        <ul class="list-group w-75 m-auto" id="yearList">
            <?php if (isset($years)): ?>
                <?php $i = 1;
                foreach ($years as $y): ?>
                    <li class="list-group-item d-flex justify-content-between flex-column flex-md-row">
                        <div class="align-self-center">
                            <span>
                                <?= $y['libelle'] ?>
                            </span>
                            <small class="fst-italic text-success fw-bold ms-lg-4">
                                <?= $y['libelle'] == $currentYear ? 'En cours' : '' ?>
                            </small>
                        </div>
                        <div class="align-self-center">
                            <div class="input-group mb-3">
                                <button type="button" class="btn btn-outline-secondary">Options</button>
                                <button type="button"
                                    class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split border-start-0"
                                    data-bs-toggle="dropdown">
                                </button>
                                <ul class="dropdown-menu shadow-lg">
                                    <?php if ($y['libelle'] != $currentYear): ?>
                                        <li><a class="dropdown-item" href="#">
                                                <i class="bi bi-toggle2-on"></i>
                                                Activer</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="#">
                                                <i class="text-danger bi bi-trash-fill"></i>
                                                Supprimer</a>
                                        </li>
                                    <?php endif ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">
                                            <i class="bi bi-pencil-fill"></i>
                                            Modifier</a></li>
                                </ul>
                            </div>

                            <!-- <form action="" method="post">
                                <input class="changeYearStateCheckbox form-check-input" type="checkbox" role="switch"
                                    id="year-state-<?= ++$i ?>" <?= $y['libelle'] === $currentYear ? 'checked' : '' ?> />
                                <label for="year-state-<?= $i ?>" class="form-label">
                                    <?= $y['libelle'] === $currentYear ? 'Désactiver' : 'Activer' ?>
                                </label>
                            </form> -->
                        </div>
                    </li>
                <?php endforeach ?>
            <?php endif ?>
        </ul>
    </div>
</div>
