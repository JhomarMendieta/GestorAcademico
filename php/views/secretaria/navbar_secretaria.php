<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<head>
  <link rel="stylesheet" href="./navbar_secretaria.css">

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
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'agregar_alumnos.php' ? 'active' : ''; ?>" aria-current="page" href="agregar_alumnos.php">Agregar alumnos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'agregar_cursos.php' ? 'active' : ''; ?>" href="agregar_cursos.php">Agregar cursos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'agregar_materias.php' ? 'active' : ''; ?>" href="agregar_materias.php">Agregar materias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'ver_alumnos.php' ? 'active' : ''; ?>" href="ver_alumnos.php">Ver alumnos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'ver_cursos.php' ? 'active' : ''; ?>" href="ver_cursos.php">Ver cursos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'ver_materias.php' ? 'active' : ''; ?>" href="ver_materias.php">Ver materias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'registrar_usuarios.php' ? 'active' : ''; ?>" href="registrar_usuarios.php">Registrar usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'asignar_usuarios.php' ? 'active' : ''; ?>" href="asignar_usuarios.php">Asignar usuarios</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
