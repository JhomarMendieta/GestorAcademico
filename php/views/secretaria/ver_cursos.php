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
include_once ('../../conn.php');
?>

<!-- funcionalidad -->
<h1>Cursos Disponibles</h1>
<div class="container">

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Año</th>
                <th>Division</th>
                <th>Año lectivo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT anio, division, anio_lectivo FROM curso"; // Ajusta el nombre de la tabla y las columnas según tu base de datos
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Mostrar los datos de cada fila
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["anio"]. "</td><td>" . $row["division"]. "</td><td>" . $row["anio_lectivo"]. "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No hay cursos disponibles</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
