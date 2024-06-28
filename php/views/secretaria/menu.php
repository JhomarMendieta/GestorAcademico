

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
include 'navbar_secretaria.php';
include 'autenticacion_secretaria.php';
?>
<!-- funcionalidad -->
<div class="container">
    <div class="opciones">
    <div class="opcion">
            <h1>Profesores</h1>
            <a type="button" class="btn btn-secondary" href="agregar_profesores.php">Registrar profesores</a>
            <a type="button" class="btn btn-secondary" href="gestionar_profesores.php">Gestionar profesores</a>
        </div>
        <div class="opcion">
            <h1>Alumnos</h1>
            <a type="button" class="btn btn-secondary" href="agregar_alumnos.php">Agregar alumnos</a>
            <a type="button" class="btn btn-secondary" href="gestionar_alumnos.php">Gestionar alumnos</a>
        </div>
        <div class="opcion">
            <h1>Preceptores</h1>
            <a type="button" class="btn btn-secondary" href="agregar_preceptor.php">Registrar preceptores</a>
            <a type="button" class="btn btn-secondary" href="gestionar_preceptor.php">Gestionar preceptores</a>
        </div>
        <div class="opcion">
            <h1>Materias</h1>
            <div class="materias-buttons">
            <a type="button" class="btn btn-secondary" href="ver_materias.php">Agregar materias</a>
            <a type="button" class="btn btn-secondary" href="ver_materias.php">Ver materias</a>
            </div>
        </div>
        <div class="opcion">
            <h1>Cursos</h1>
            <a type="button" class="btn btn-secondary" href="agregar_cursos.php">Agregar cursos</a>
            <a type="button" class="btn btn-secondary" href="ver_cursos.php">Ver cursos</a>
        </div>
        <div class="opcion">
            <h1>Usuarios</h1>
            <a type="button" class="btn btn-secondary" href="registrar_usuarios.php">Registrar usuarios</a>
            <a type="button" class="btn btn-secondary" href="asignar_usuarios.php">Asignar usuarios</a>
        </div>
        
    </div>
</div>

</body>
</html>
