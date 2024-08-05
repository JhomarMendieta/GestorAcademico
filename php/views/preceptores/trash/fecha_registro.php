<?php
// conn.php
include '../../conn.php';

// Consulta para obtener las fechas únicas de asistencia
$sql = "SELECT DISTINCT fecha FROM asistencia ORDER BY fecha DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fechas de Asistencia</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { color: #333; }
        ul { list-style-type: none; padding: 0; }
        li { margin: 5px 0; }
        a { text-decoration: none; color: #007BFF; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <?php include "menu.php";?>
    <h2>Fechas de Asistencia</h2>
    <?php
    if ($result->num_rows > 0) {
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li><a href='datos_asistencia.php?fecha=" . htmlspecialchars($row['fecha']) . "'>" . htmlspecialchars($row['fecha']) . "</a></li>";
        }
        echo "</ul>";
    } else {
        echo "No se encontraron registros de asistencia.";
    }

    $conn->close();
    ?>
</body>
</html>
