

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias Adeudadas</title>
    <link rel="stylesheet" href="materias_adeudadas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- navbar -->
    <?php
include 'navbar_alumnos.php';
include 'autenticacion_alumno.php';
?>

<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once ('../../conn.php');



$id_usuario = $_SESSION["id"];

// Consulta para obtener el id_alumno correspondiente al id_usuario
$alumno_sql = "SELECT id FROM alumno WHERE id_usuario = ?";
$alumno_stmt = $conn->prepare($alumno_sql);
$alumno_stmt->bind_param("i", $id_usuario);
$alumno_stmt->execute();
$alumno_stmt->bind_result($id_alumno);
$alumno_stmt->fetch();
$alumno_stmt->close();



// Consulta SQL para obtener las materias con condiciones TED o TEP desde la tabla 'condicion'
$sql = "
    SELECT 
        a.nombres AS alumno,
        a.apellidos AS apellido,
        c.anio_lectivo,
        c.anio,
        c.division,
        m.nombre AS materia,
        cond.condicion AS condicion_final
    FROM 
        alumno a
    JOIN 
        alumno_curso ac ON a.id = ac.id_alumno
    JOIN 
        curso c ON ac.id_curso = c.id
    JOIN 
        materia m ON m.id_curso = c.id
    JOIN 
        condicion cond ON cond.id_alumno = a.id AND cond.id_materia = m.id
    WHERE 
        a.id = ?
        AND cond.condicion IN ('TED', 'TEP')
    GROUP BY 
        a.nombres, a.apellidos, c.anio_lectivo, c.anio, c.division, m.nombre, cond.condicion;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_alumno);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}

$conn->close();

// Función para agregar las etiquetas según la condición
function agregarEtiqueta($condicion)
{
    return $condicion;
}
?>

    <div class="container mt-5">
        <h1>Materias Adeudadas</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Apellido</th>
                    <th>Año Lectivo</th>
                    <th>Año</th>
                    <th>División</th>
                    <th>Materia</th>
                    <th>Condición Final</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['alumno']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['apellido']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['anio_lectivo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['anio']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['division']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['materia']) . "</td>";
                    echo "<td>" . agregarEtiqueta($row['condicion_final']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>