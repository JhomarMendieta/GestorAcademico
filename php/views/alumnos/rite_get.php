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

// Obtener el año lectivo seleccionado
$anio_seleccionado = isset($_GET['anio_lectivo']) ? (int)$_GET['anio_lectivo'] : 0;

// Consulta para obtener los años lectivos disponibles
$anios_query = "SELECT DISTINCT curso.anio_lectivo FROM curso 
                INNER JOIN materia ON curso.id = materia.id_curso
                INNER JOIN nota ON materia.id = nota.id_materia
                WHERE nota.id_alumno = $alumno_id
                ORDER BY curso.anio_lectivo ASC";
$anios_result = $conn->query($anios_query);

$anios_lectivos = [];
while ($row = $anios_result->fetch_assoc()) {
    $anios_lectivos[] = $row['anio_lectivo'];
}

// Consulta para obtener las notas del alumno, filtrando por el año lectivo seleccionado si se ha elegido uno
$notas_query = "
    SELECT curso.anio_lectivo AS anio_lectivo, curso.anio AS anio_curso, curso.division AS division, 
           materia.nombre AS materia, nota.nombre AS nombre_nota, nota.calificacion, nota.instancia
    FROM nota
    INNER JOIN materia ON nota.id_materia = materia.id
    INNER JOIN curso ON materia.id_curso = curso.id
    WHERE nota.id_alumno = $alumno_id"
    . ($anio_seleccionado ? " AND curso.anio_lectivo = $anio_seleccionado" : "") . 
    " ORDER BY curso.anio_lectivo ASC, curso.anio ASC, curso.division ASC, materia.nombre ASC, nota.id ASC";
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
        /* Agrega tu CSS aquí */
    </style>
</head>
<body>
    <h1>Notas de <?php echo htmlspecialchars($alumno['nombres']); ?> <?php echo htmlspecialchars($alumno['apellidos']); ?></h1>
    
    <form method="GET" action="">
        <input type="hidden" name="id" value="<?php echo $alumno_id; ?>">
        <label for="anio_lectivo">Seleccionar año lectivo:</label>
        <select name="anio_lectivo" id="anio_lectivo" onchange="this.form.submit()">
            <option value="">Todos los años</option>
            <?php foreach ($anios_lectivos as $anio): ?>
                <option value="<?php echo $anio; ?>" <?php if ($anio == $anio_seleccionado) echo 'selected'; ?>>
                    <?php echo $anio; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

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
                        echo "<tr class='table-secondary'><th scope='row'>Indicador</th><th scope='row'>Instancia</th><th scope='row'>Calificación</th></tr>";
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
