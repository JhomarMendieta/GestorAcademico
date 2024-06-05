<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="rite.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
          <a class="nav-link active" aria-current="page" href="rite.php?id=1">Ver RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="ver_materias.php">Ver materias</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" aria-current="page" href="materias_adeudadas.php?id_alumno=1">Ver materias adeudadas</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- !!!!!!!!!!!!!!!!!!!!!!!! -->
<!-- ACCEDER A localhost/gestoracademico/php/views/alumnos/RITE.PHP?id=1
y en id pasar el id del alumno a ver-->


<div class="container1">
  <h6>*Las notas se promedian teniendo en cuenta los indicadores de JULIO para el primer cuatrimestre y de NOVIEMBRE para el segundo, ya que las instancias de MAYO y SEPTIEMBRE son simplemente avances.</h6>
<?php 

include ('rite_get.php');

?>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>