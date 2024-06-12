<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <title>Menu</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
      <a id="logo" class="navbar-brand" href="menu.php">
                <img src="../../../img/LogoEESTN1.png" alt="">
      </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="ver_alumnos.php">Ver alumnos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="actualizar_rite.php">Actualizar RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ver_rite.php">Ver RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ver_materia.php">Ver materias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="gestionar_indicadores.php">Gestionar indicadores</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="titulo-menu">
    <h1>Menú</h1>
  </div>
<div class="main-container">

        <div class="column">
            <h2>ALUMNOS</h2>
            <a href="ver_alumnos.php" class="btn btn-secondary">Ver Alumnos en curso</a>
        </div>
        <div class="column">
            <h2>R.I.T.E</h2>
            <a href="ver_rite.php" class="btn btn-secondary">Ver RITE</a>
            <a href="actualizar_rite.php" class="btn btn-secondary">Actualizar RITE</a>
            <a href="gestionar_indicadores.php" class="btn btn-secondary">Gestionar indicadores</a>
        </div>
        <div class="column">
            <h2>MATERIAS</h2>
            <a href="ver_materia.php" class="btn btn-secondary">Ver Materias</a>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>