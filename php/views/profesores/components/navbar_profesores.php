<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<head>
  <link rel="stylesheet" href="../../../css/profesores/navbar_profesores.css">
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
          <a class="nav-link <?php echo $current_page == 'ver_alumnos.php' ? 'active' : ''; ?>" aria-current="page" href="ver_alumnos.php">Ver alumnos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'actualizar_rite.php' ? 'active' : ''; ?>" href="actualizar_rite.php">Actualizar RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'ver_rite.php' ? 'active' : ''; ?>" href="ver_rite.php">Ver RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'ver_materia.php' ? 'active' : ''; ?>" href="ver_materia.php">Ver materias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'gestionar_indicadores.php' ? 'active' : ''; ?>" href="gestionar_indicadores.php">Gestionar indicadores</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['calificar_mesa.php', 'crear_mesa.php']) ? 'active' : ''; ?>" href="#" id="materiasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Mesas
          </a>
          <ul class="dropdown-menu" aria-labelledby="materiasDropdown">
            <li><a class="dropdown-item <?php echo $current_page == 'calificar_mesa.php' ? 'active' : ''; ?>" href="calificar_mesa.php">Calificar mesas</a></li>
            <li><a class="dropdown-item <?php echo $current_page == 'crear_mesa.php' ? 'active' : ''; ?>" href="crear_mesa.php">Crear mesa</a></li>
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
            <li><a class="dropdown-item" href="./change_password.php">Gestionar datos</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
