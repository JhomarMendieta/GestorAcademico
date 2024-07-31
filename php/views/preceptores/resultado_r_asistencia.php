<?php
    include "../../conn.php";

    // Obtener los datos del formulario
    $materia_id = $_POST['materia_id'];
    $fecha = $_POST['fecha'];
    $asistencias = $_POST['asistencia'];
    $observaciones = $_POST['observacion'];
    $cargo = 'preceptor'; // O 'preceptor', según corresponda

    // Preparar y ejecutar la inserción de datos
    foreach ($asistencias as $alumno_id => $asistencia) {
        $observacion = $observaciones[$alumno_id];
        $sql = "INSERT INTO asistencia (asistencia, fecha, id_materias, id_preceptores, id_alumno, cargo, id_profesor, observaciones) VALUES (?, ?, '$materia_id', '1', ?, ?, '78979879', ?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $asistencia, $fecha, $alumno_id, $cargo, $observacion);
        $stmt->execute();
    }


    echo "Asistencia registrada exitosamente";

    // Cerrar conexión
    $stmt->close();
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body onload="redireccionar()">
    <script>
        // Función que redirige a la URL especificada después de 3 segundos
        function redireccionar() {
            setTimeout(function() {
                window.location.href = 'index.php'; // Reemplaza con la URL a la que deseas redirigir
            }, 2000);
        }
    </script>
</body>
</html>