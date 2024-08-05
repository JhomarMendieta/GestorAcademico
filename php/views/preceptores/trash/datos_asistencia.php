<?php
    // conn.php
    include '../../conn.php';

    // Obtener la fecha de la URL
    $fecha = $_GET['fecha'];

    // Consulta para obtener los registros de asistencia de la fecha específica
    $sql = "SELECT asistencia.id_alumno, alumno.nombres, asistencia.asistencia, asistencia.observaciones 
            FROM asistencia 
            JOIN alumno ON asistencia.id_alumno = alumno.id 
            WHERE asistencia.fecha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $fecha);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia del día <?php echo htmlspecialchars($fecha); ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Asistencia del día <?php echo htmlspecialchars($fecha); ?></h2>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Alumno</th><th>Asistencia</th><th>Observaciones</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nombres']) . "</td>";
            echo "<td>" . htmlspecialchars($row['asistencia']) . "</td>";
            echo "<td>" . htmlspecialchars($row['observaciones']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron registros de asistencia para esta fecha.";
    }

    $stmt->close();
    $conn->close();
    ?>
    <br>
    <a href="fecha_registro.php">Volver a las fechas de asistencia</a>
</body>
</html>
