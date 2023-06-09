<div class="navbar navbar-expand-lg fixed-top navbar-li bg-light">
    <div class="container">
        <a href="/" class="navbar-brand">
            <img src="/img/logo-site.png" alt="logo" width="80px" />
            <?= $GLOBALS['siteName'] ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-4">
                <li class="nav-item">
                    <a href="<?= $urls['subjects'] ?>" class="text-black text-decoration-none">
                        Disciplines
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-md-auto">
                <li class="nav-item me-4 align-self-center">
                    <a href="<?= $urls['school-years'] ?>" class="text-black text-decoration-none">
                        Année scolaire :
                        <span class="fw-bold">
                            <?= $currentYear ?>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="dropdown-toggle btn" type="button" data-bs-toggle="dropdown">
                            <img src="<?= $userInfos['photo'] ?>" alt="photo" width="60px" class="rounded-circle">
                            <?= $userInfos['username'] ?>
                        </button>
                        <ul class="dropdown-menu shadow-lg">
                            <li class="dropdown-item text-center">
                                <a href="<?= $urls['profile-page'] ?><?= $userInfos['id'] ?>">Profil</a>
                            </li>
                            <li class="dropdown-item text-center">
                                <form action="<?= $urls['logout'] ?>" method="post">
                                    <button type="submit" class="btn btn-link">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
