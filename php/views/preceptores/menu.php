<?php
include "../../getUserId.php";
include "../../conn.php";
?>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a id="logo" class="navbar-brand" href="index.php">
      <img src="../../../img/LogoEESTN1.png" alt="Logo" style="height: 40px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Dropdown para Alumnos -->
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'agregar_alumnos.php' ? 'active' : ''; ?>" aria-current="page" href="alumno_curso.php">Ver alumnos</a>
        </li>
        <!-- Dropdown para Cursos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['agregar_cursos.php', 'ver_cursos.php']) ? 'active' : ''; ?>" href="#" id="cursosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Asistencias
          </a>
          <ul class="dropdown-menu" aria-labelledby="cursosDropdown">
            <li><a class="dropdown-item <?php echo $current_page == 'asistencia_curso.php' ? 'active' : ''; ?>" href="asistencia_curso.php">Tomar asistencia</a></li>
            <li><a class="dropdown-item <?php echo $current_page == 'fecha_registro.php' ? 'active' : ''; ?>" href="fecha_registro.php">Ver asistencia</a></li>
          </ul>
        </li>
        <!-- Dropdown para Materias -->
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'rite.php' ? 'active' : ''; ?>" aria-current="page" href="rite.php">Ver RITE</a>
        </li>
        <!-- Dropdown para Usuarios -->
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'materias.php' ? 'active' : ''; ?>" aria-current="page" href="materias.php">Ver materias</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            echo $userName;
            ?> 
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../../logout.php">Cerrar sesión</a></li>
            <li><a class="dropdown-item" href="change_password.php">Gestionar datos</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>