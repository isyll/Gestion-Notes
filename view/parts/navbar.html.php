<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <div class="container">
        <a href="../" class="navbar-brand">
            <?= $GLOBALS['siteName'] ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" id="themes">Themes</a>
                    <div class="dropdown-menu" aria-labelledby="themes">
                        <a class="dropdown-item" href="#">Default</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Cerulean</a>
                        <a class="dropdown-item" href="#">Cosmo</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../help/">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://blog.bootswatch.com/">Blog</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" id="download">Superhero</a>
                    <div class="dropdown-menu" aria-labelledby="download">
                        <a class="dropdown-item" rel="noopener" target="_blank" href="#">item</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" download>item</a>
                        <a class="dropdown-item" href="#" download>item</a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ms-md-auto">
                <li class="nav-item">
                    <a target="_blank" rel="noopener" class="nav-link" href="#"><i class="bi bi-github"></i> GitHub</a>
                </li>
                <li class="nav-item">
                    <a target="_blank" rel="noopener" class="nav-link" href="#"><i class="bi bi-twitter"></i>
                        Twitter</a>
                </li>
            </ul>
        </div>
    </div>
</div>
