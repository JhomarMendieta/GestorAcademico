<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Preceptor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="agregar_preceptor.css">
</head>
<body>
<?php
include "./navbar_secretaria.php";
include 'autenticacion_secretaria.php';
include '../../conn.php'; 
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<div class="container">
    <h2>Gestionar Preceptor</h2>
    <form action="" method="get" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control" name="nombre" placeholder="Buscar por Nombre">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="apellido" placeholder="Buscar por Apellido">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Buscar</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $nombre = $_GET['nombre'] ?? '';
        $apellido = $_GET['apellido'] ?? '';

        $sql = "SELECT * FROM preceptores WHERE 
                (nombre LIKE '%$nombre%' AND '$nombre' != '') OR 
                (apellido LIKE '%$apellido%' AND '$apellido' != '')";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-striped'>";
            echo "<thead><tr><th>Nombre</th><th>Apellido</th><th>Acción</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['nombre']}</td>";
                echo "<td>{$row['apellido']}</td>";
                echo "<td><a href='perfil_preceptor.php?id={$row['id']}' class='btn btn-info'>Ver Perfil</a></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning'>No se encontraron preceptores.</div>";
        }
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeo5sa1GsBCF9yJp4gyU06G1YLgKpZ1a6wr9kkF706LIKDeQ" crossorigin="anonymous"></script>
</body>
</html>
