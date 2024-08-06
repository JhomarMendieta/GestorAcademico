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
    include 'nav_directivos.php';
    include 'autenticacion_directivo.php';
    ?>
    <!-- funcionalidad -->
    <div class="container">
        <div class="opciones">
            <div class="column">
                <img src="../../../img/estudiante.png" alt="">
                <a type="button" class="btn btn-secondary" href="ver_alumnos.php">Ver Alumnos</a>
            </div>
            <div class="column">
                <img src="../../../img/curso.png" alt="">
                <a type="button" class="btn btn-secondary" href="ver_cursos.php">Ver Cursos</a>
            </div>
            <div class="column">
                <img src="../../../img/materia.png" alt="">
                <a type="button" class="btn btn-secondary" href="ver_materias.php">Ver Materias</a>
            </div>
        </div>
    </div>

</body>

</html>