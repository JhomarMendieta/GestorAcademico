

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


<?php
include 'navbar_alumnos.php';
include 'autenticacion_alumno.php';
?>
<!-- funcionalidad -->
<div class="container">
    <div class="opciones">
        <div class="opcion">
            <h1>Alumnos</h1>
            <a type="button" class="btn btn-secondary" href="reinscripcion.php">Solicitud de reinscripción</a>
        </div>
        <div class="opcion">
            <h1>Materias</h1>
            <div class="materias-buttons">
                <a type="button" class="btn btn-secondary" href="ver_materias.php">Ver materias</a>
                <a type="button" class="btn btn-secondary" href="materias_adeudadas.php">Ver materias adeudadas</a>
                <a type="button" class="btn btn-secondary" href="mesas.php">Gestionar mesas</a>
            </div>
        </div>
        <div class="opcion">
            <h1>R.I.T.E</h1>
            <a type="button" class="btn btn-secondary" href="rite.php">Ver RITE</a>
        </div>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
