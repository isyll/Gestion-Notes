<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <div class="container">
        <a href="/" class="navbar-brand">
            <?= $GLOBALS['siteName'] ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"
                        id="themes">Administration</a>
                    <div class="dropdown-menu" aria-labelledby="themes">
                        <a class="dropdown-item" href="<?= $urls['create-user-page'] ?>">Créer un utilisateur</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= $urls['user-admin'] ?>">Voir les utilisateurs</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $urls['new-student'] ?>">
                        Ajouter un élève
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-md-auto">
                <li class="nav-item">
                    <form action="<?= $urls['logout'] ?>" method="post">
                        <button type="submit" class="btn btn-link">Déconnexion</button>
                    </form>
                </li>
                <li class="nav-item">

                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Elève">
                        <button class="btn btn-secondary" type="button" id="button-addon2"><i
                                class="bi bi-search"></i></button>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
