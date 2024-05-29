<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once('../../conn.php');

// Obtener el ID del alumno desde la solicitud (por ejemplo, de la URL o formulario)
$alumno_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Consulta para obtener el nombre del alumno
$alumno_query = "SELECT nombres FROM alumno WHERE id = $alumno_id";
$alumno_result = $conn->query($alumno_query);

if ($alumno_result->num_rows > 0) {
    $alumno = $alumno_result->fetch_assoc();
} else {
    die("Alumno no encontrado.");
}

// Consulta para obtener las notas del alumno, incluyendo curso y año
$notas_query = "
    SELECT materia.nombre AS materia, curso.anio_lectivo AS anio, nota.calificacion, nota.nombre AS nombre_nota
    FROM nota
    INNER JOIN materia ON nota.id_materia = materia.id
    INNER JOIN curso ON materia.id_curso = curso.id
    WHERE nota.id_alumno = $alumno_id
    ORDER BY materia.nombre ASC, nota.id ASC
";
$notas_result = $conn->query($notas_query);

// Organizar las notas por materia
$notas_por_materia = [];
while ($row = $notas_result->fetch_assoc()) {
    $notas_por_materia[$row['materia']]['anio'] = $row['anio'];
    $notas_por_materia[$row['materia']]['notas'][] = [
        'calificacion' => $row['calificacion'],
        'nombre_nota' => $row['nombre_nota']
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas de <?php echo htmlspecialchars($alumno['nombres']); ?></title>
    <style>
        table {
            width: 70%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Notas de <?php echo htmlspecialchars($alumno['nombres']); ?></h1>
    <?php
    if (!empty($notas_por_materia)) {
        foreach ($notas_por_materia as $materia => $detalles) {
            echo "<h2>" . htmlspecialchars($materia) . " (Año: " . htmlspecialchars($detalles['anio']) . ")</h2>";
            echo "<table>";
            echo "<thead>";
            echo "<tr><th>Nombre de la Nota</th><th>Calificación</th></tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($detalles['notas'] as $nota) {
                echo "<tr><td>" . htmlspecialchars($nota['nombre_nota']) . "</td><td>" . htmlspecialchars($nota['calificacion']) . "</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
    } else {
        echo "<p>No se encontraron notas.</p>";
    }
    ?>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
