<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a id="logo" class="navbar-brand" href="menu.php">
      <img src="../../../img/LogoEESTN1.png" alt="Logo" style="height: 40px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Alumnos
          </a>
          <ul class="dropdown-menu">
            <li><a class="nav-link <?php echo $current_page == 'reinscripcion.php' ? 'active' : ''; ?>" aria-current="page" href="reinscripcion.php">Agregar alumnos</a></li>
            <li><a class="nav-link <?php echo $current_page == 'reinscripcion.php' ? 'active' : ''; ?>" aria-current="page" href="reinscripcion.php">Ver alumnos</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Materias
          </a>
          <ul class="dropdown-menu">
            <li><a class="nav-link <?php echo $current_page == 'reinscripcion.php' ? 'active' : ''; ?>" aria-current="page" href="reinscripcion.php">Agregar materias</a></li>
            <li><a class="nav-link <?php echo $current_page == 'reinscripcion.php' ? 'active' : ''; ?>" aria-current="page" href="reinscripcion.php">Ver materias</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cursos
          </a>
          <ul class="dropdown-menu">
            <li><a class="nav-link <?php echo $current_page == 'reinscripcion.php' ? 'active' : ''; ?>" aria-current="page" href="reinscripcion.php">Agregar cursos</a></li>
            <li><a class="nav-link <?php echo $current_page == 'ver_cursos.php' ? 'active' : ''; ?>" aria-current="page" href="ver_cursos.php">Ver cursos</a></li>
          </ul>
        </li>

      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php 
            include "../../conn.php";
            include "../../getUserId.php";
            echo $userName;
            ?> 
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../../logout.php">Cerrar sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
