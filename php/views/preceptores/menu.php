<?php
include "../../getUserId.php";
include "../../conn.php";
?>
<head>
  <!-- <link rel="stylesheet" href="./navb_secretaria.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a id="logo" class="navbar-brand" href="menu.php">
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
        <!-- Dropdown para Preceptores -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['agregar_preceptor.php', 'gestionar_preceptor.php']) ? 'active' : ''; ?>" href="#" id="preceptoresDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Preceptores
          </a>
          <ul class="dropdown-menu" aria-labelledby="preceptoresDropdown">
            <li><a class="dropdown-item <?php echo $current_page == 'agregar_preceptor.php' ? 'active' : ''; ?>" href="agregar_preceptor.php">Agregar preceptores</a></li>
            <li><a class="dropdown-item <?php echo $current_page == 'gestionar_preceptor.php' ? 'active' : ''; ?>" href="gestionar_preceptor.php">Gestionar preceptores</a></li>
          </ul>
        </li>
        <!-- Dropdown para Profesores -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['agregar_profesores.php', 'gestionar_profesores.php']) ? 'active' : ''; ?>" href="#" id="profesoresDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profesores
          </a>
          <ul class="dropdown-menu" aria-labelledby="profesoresDropdown">
            <li><a class="dropdown-item <?php echo $current_page == 'agregar_profesor.php' ? 'active' : ''; ?>" href="agregar_profesores.php">Agregar profesores</a></li>
            <li><a class="dropdown-item <?php echo $current_page == 'gestionar_profesores.php' ? 'active' : ''; ?>" href="gestionar_profesores.php">Gestionar profesores</a></li>
          </ul>
        </li>
        <!-- Dropdown para Cursos -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['agregar_cursos.php', 'ver_cursos.php']) ? 'active' : ''; ?>" href="#" id="cursosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cursos
          </a>
          <ul class="dropdown-menu" aria-labelledby="cursosDropdown">
            <li><a class="dropdown-item <?php echo $current_page == 'agregar_cursos.php' ? 'active' : ''; ?>" href="agregar_cursos.php">Agregar cursos</a></li>
            <li><a class="dropdown-item <?php echo $current_page == 'ver_cursos.php' ? 'active' : ''; ?>" href="ver_cursos.php">Ver cursos</a></li>
          </ul>
        </li>
        <!-- Dropdown para Materias -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['agregar_materias.php', 'ver_materias.php']) ? 'active' : ''; ?>" href="#" id="materiasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Materias
          </a>
          <ul class="dropdown-menu" aria-labelledby="materiasDropdown">
            <li><a class="dropdown-item <?php echo $current_page == 'agregar_materias.php' ? 'active' : ''; ?>" href="agregar_materias.php">Agregar materias</a></li>
            <li><a class="dropdown-item <?php echo $current_page == 'ver_materias.php' ? 'active' : ''; ?>" href="ver_materias.php">Ver materias</a></li>
          </ul>
        </li>
        <!-- Dropdown para Usuarios -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['registrar_usuarios.php', 'asignar_usuarios.php']) ? 'active' : ''; ?>" href="#" id="usuariosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Usuarios
          </a>
          <ul class="dropdown-menu" aria-labelledby="usuariosDropdown">
            <li><a class="dropdown-item <?php echo $current_page == 'registrar_usuarios.php' ? 'active' : ''; ?>" href="registrar_usuarios.php">Registrar usuarios</a></li>
            <li><a class="dropdown-item <?php echo $current_page == 'asignar_usuarios.php' ? 'active' : ''; ?>" href="asignar_usuarios.php">Asignar usuarios</a></li>
          </ul>
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
