<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-secondary" style="width: 280px;">

  <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <!-- <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>  -->
    <span class="fs-4">Tableau de bord</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a href="<?= $urls['students'] ?>" class="text-white nav-link <?= $current == 'students' ? 'active' : '' ?>"
        aria-current="page">
        <!-- <svg class="bi me-2" width="16" height="16">
          <use xlink:href=""></use>
        </svg>  -->
        &Eacute;lèves
      </a>
    </li>
    <li>
      <a href="<?= $urls['classes'] ?>" class="nav-link text-white <?= $current == 'classes' ? 'active' : '' ?>">
        <!-- <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#speedometer2"></use>
        </svg> -->
        Classes
      </a>
    </li>
    <li>
      <a href="<?= $urls['niveaux'] ?>" class="nav-link text-white <?= $current == 'niveaux' ? 'active' : '' ?>">
        <!-- <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#speedometer2"></use>
        </svg> -->
        Niveaux
      </a>
    </li>
    <li>
      <a href="<?= $urls['teachers'] ?>" class="nav-link text-white <?= $current == 'teachers' ? 'active' : '' ?>">
        <!-- <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#table"></use>
        </svg> -->
        Professeurs
      </a>
    </li>
    <li>
      <a href="<?= $urls['courses'] ?>" class="nav-link text-white <?= $current == 'students' ? 'courses' : '' ?>">
        <!-- <svg class="bi me-2" width="16" height="16">
          <use xlink:href="#grid"></use>
        </svg> -->
        Cours
      </a>
    </li>
  </ul>
  <hr>
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1"
      data-bs-toggle="dropdown" aria-expanded="false">
      <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
      <strong>Admin</strong>
    </a>
    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1" style="">
      <li><a class="dropdown-item" href="#">New project...</a></li>
      <li><a class="dropdown-item" href="#">Settings</a></li>
      <li><a class="dropdown-item" href="#">Profile</a></li>
      <li>
        <hr class="dropdown-divider">
      </li>
      <li><a class="dropdown-item" href="#">Sign out</a></li>
    </ul>
  </div>
</div>