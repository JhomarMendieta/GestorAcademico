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
<?php 
include "navbar_profesores.php";
?>
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