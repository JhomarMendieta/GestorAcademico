<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once('../../conn.php');

// Obtener el ID del alumno desde la solicitud (por ejemplo, de la URL o formulario)
$alumno_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Consulta para obtener el nombre del alumno
$alumno_query = "SELECT nombres, apellidos FROM alumno WHERE id = $alumno_id";
$alumno_result = $conn->query($alumno_query);

if ($alumno_result->num_rows > 0) {
    $alumno = $alumno_result->fetch_assoc();
} else {
    die("Alumno no encontrado.");
}

// Consulta para obtener las notas del alumno, incluyendo curso, año y instancia
$notas_query = "
    SELECT curso.anio_lectivo AS anio_lectivo, curso.anio AS anio_curso, curso.division AS division, 
           materia.nombre AS materia, nota.nombre AS nombre_nota, nota.calificacion, nota.instancia
    FROM nota
    INNER JOIN materia ON nota.id_materia = materia.id
    INNER JOIN curso ON materia.id_curso = curso.id
    WHERE nota.id_alumno = $alumno_id
    ORDER BY curso.anio_lectivo ASC, curso.anio ASC, curso.division ASC, materia.nombre ASC, nota.id ASC
";
$notas_result = $conn->query($notas_query);

// Organizar las notas por año lectivo, curso y materia
$notas_por_anio_lectivo = [];
while ($row = $notas_result->fetch_assoc()) {
    $anio_lectivo = $row['anio_lectivo'];
    $anio_curso = $row['anio_curso'];
    $division = $row['division'];
    $materia = $row['materia'];
    $notas_por_anio_lectivo[$anio_lectivo][$anio_curso][$division][$materia][] = [
        'calificacion' => $row['calificacion'],
        'nombre_nota' => $row['nombre_nota'],
        'instancia' => $row['instancia']
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notas de <?php echo htmlspecialchars($alumno['nombres']); ?> <?php echo htmlspecialchars($alumno['apellidos']); ?></title>
    <style>


    </style>
</head>
<body>
    <h1>Notas de <?php echo htmlspecialchars($alumno['nombres']); ?> <?php echo htmlspecialchars($alumno['apellidos']); ?></h1>
    <?php
    if (!empty($notas_por_anio_lectivo)) {
        foreach ($notas_por_anio_lectivo as $anio_lectivo => $cursos) {
            echo "<div class='curso'><h2>" . htmlspecialchars($anio_lectivo);
            foreach ($cursos as $anio_curso => $divisiones) {
                foreach ($divisiones as $division => $materias) {
                    echo " - ". htmlspecialchars($anio_curso) . "° " . htmlspecialchars($division) . "°</h2>";
                    foreach ($materias as $materia => $notas) {
                        echo "<div class='materia'><h4>Materia: " . htmlspecialchars($materia) . "</h4>";
                        echo "<table class='table table-light'>";
                        echo "<thead>";
                        echo "<tr class='table-secondary'><th scope='row'>Nombre de la Nota</th><th scope='row'>Instancia</th><th scope='row'>Calificación</th></tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        $sum = 0;
                        $count = 0;
                        foreach ($notas as $nota) {
                            echo "<tr><td class='nota-nombre'>" . htmlspecialchars($nota['nombre_nota']) . "</td><td>" . htmlspecialchars($nota['instancia']) . "</td><td>" . htmlspecialchars($nota['calificacion']) . "</td></tr>";
                            $sum += $nota['calificacion'];
                            $count++;
                        }
                        $promedio = $count > 0 ? $sum / $count : 0;
                        $etiqueta = "";
                        if ($promedio >= 0 && $promedio < 3) {
                            $etiqueta = "TED";
                        } elseif ($promedio >= 3 && $promedio < 4) {
                            $etiqueta = "TEP";
                        } elseif ($promedio >= 4 && $promedio <= 5) {
                            $etiqueta = "TEA";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        echo "<h5>Promedio: " . htmlspecialchars(number_format($promedio, 2)) . " - " . htmlspecialchars($etiqueta) . " (PRELIMINAR) </h5></div></div>";
                    }
                }
            }
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
