<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./menu.css">
</head>
<body>

<!-- navbar -->

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a id="logo" class="navbar-brand" href="menu.php">
        <img  src="../../../img/LogoEESTN1.png" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="reinscripcion.php">Solicitud de reinscripción</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="rite.php?id=1">Ver RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="ver_materias.php">Ver materias</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- funcionalidad -->
<div class="container">
    <div class="opciones">
        <div class="opcion">
            <h1>Alumnos</h1>
            <a type="button" class="btn btn-secondary" href="reinscripcion.php">Solicitud de reinscripción</a>
        </div>
        <div class="opcion">
            <h1>R.I.T.E</h1>
            <a type="button" class="btn btn-secondary" href="rite.php?id=1">Ver RITE</a>
        </div>
        <div class="opcion">
            <h1>Materias</h1>
            <button type="button" class="btn btn-secondary">Ver materias</button>
        </div>
    </div>
</div>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>