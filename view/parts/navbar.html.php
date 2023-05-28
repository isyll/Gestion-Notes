<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <div class="container">
        <a href="/" class="navbar-brand">
            <img src="/img/logo-site.png" alt="logo" width="80px" />
            <?= $GLOBALS['siteName'] ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="<?= $urls['new-student'] ?>">
                        Ajouter un élève
                    </a>
                </li> -->
            </ul>
            <ul class="navbar-nav ms-md-auto">
                <li class="nav-item me-4 align-self-center">
                    <small>
                        Année scolaire :
                        <?= $currentYear ?>
                    </small>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="dropdown-toggle btn" type="button" data-bs-toggle="dropdown">
                            <img src="<?= $userInfos['photo'] ?>" alt="photo" width="60px" class="rounded-circle">
                            <?= $userInfos['username'] ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item text-center">
                                <a class="text-white"
                                    href="<?= $urls['profile-page'] ?><?= $userInfos['id'] ?>">Profil</a>
                            </li>
                            <li class="dropdown-item text-center">
                                <form action="<?= $urls['logout'] ?>" method="post">
                                    <button type="submit" class="btn btn-link text-white">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
