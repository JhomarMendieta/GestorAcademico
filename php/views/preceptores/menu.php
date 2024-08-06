<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./navStyle.css">
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>

    <!-- navbar -->


    <?php
    include 'nav_preseptor.php';
    ?>
    <!-- funcionalidad -->
    <div class="container">
        <div class="opciones">
            <div class="column">
                <img src="../../../img/profesores.png" alt="">
                <a type="button" class="btn btn-secondary" href="agregar_profesores.php">Registrar profesores</a>
                <a type="button" class="btn btn-secondary" href="gestionar_profesores.php">Gestionar profesores</a>
                <a type="button" class="btn btn-secondary" href="asignar_materiass.php">Asignar materias</a>
            </div>
            <div class="column">
                <img src="../../../img/estudiante.png" alt="">
                <a type="button" class="btn btn-secondary" href="agregar_alumnos.php">Agregar alumnos</a>
                <a type="button" class="btn btn-secondary" href="gestionar_alumnos.php">Gestionar alumnos</a>
            </div>
            <div class="column">
                <img src="../../../img/preceptor.png" alt="">
                <a type="button" class="btn btn-secondary" href="agregar_preceptor.php">Registrar preceptores</a>
                <a type="button" class="btn btn-secondary" href="gestionar_preceptor.php">Gestionar preceptores</a>
            </div>
            <div class="column">
                <img src="../../../img/materias.png" alt="">
                <div class="materias-buttons">
                    <a type="button" class="btn btn-secondary" href="ver_materias.php">Agregar materias</a>
                    <a type="button" class="btn btn-secondary" href="ver_materias.php">Ver materias</a>
                </div>
            </div>
            <div class="column">
                <img src="../../../img/curso.png" alt="">
                <a type="button" class="btn btn-secondary" href="agregar_cursos.php">Agregar cursos</a>
                <a type="button" class="btn btn-secondary" href="ver_cursos.php">Ver cursos</a>
            </div>
            <div class="column">
                <img src="../../../img/usuarios.png" alt="">
                <a type="button" class="btn btn-secondary" href="registrar_usuarios.php">Registrar usuarios</a>
                <a type="button" class="btn btn-secondary" href="asignar_usuarios.php">Asignar usuarios</a>
            </div>

        </div>
    </div>

</body>

</html>