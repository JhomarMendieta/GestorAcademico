<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/navStyle.css">
</head>
<body>
<header class="header">
    <!-- Header content here -->
</header>

<center><h1>Lista de Asistencias</h1></center>
<div class="container">
    <form action="guardar_listado.php" method="POST">
        <?php
            // Llamada a la consulta
            include_once('listado.php');
        ?>
        <input type="hidden" name="id_materia" value="5"> <!-- Replace '1' with the actual ID of the materia -->
        <input type="hidden" name="id_preceptor" value="1"> <!-- Replace '1' with the actual ID of the preceptor -->
        <input type="hidden" name="id_profesor" value="1"> <!-- Replace '1' with the actual ID of the profesor -->
        <input type="hidden" name="fecha" value="<?php echo date('Y-m-d'); ?>">
        <button type="submit" class="btn btn-primary">Guardar Listado</button>
    </form>
</div>
</body>
</html>
