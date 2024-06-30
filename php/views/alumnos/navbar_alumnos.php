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
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'reinscripcion.php' ? 'active' : ''; ?>" aria-current="page" href="reinscripcion.php">Solicitud de reinscripción</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'rite.php' ? 'active' : ''; ?>" href="rite.php">Ver RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'ver_materias.php' ? 'active' : ''; ?>" href="ver_materias.php">Ver materias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'materias_adeudadas.php' ? 'active' : ''; ?>" href="materias_adeudadas.php">Ver materias adeudadas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page == 'mesas.php' ? 'active' : ''; ?>" href="mesas.php">Gestionar mesas</a>
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
