<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('../../conn.php');
include('../../getUserId.php');



$id_usuario = $_SESSION["id"];

// Consulta para obtener el id_alumno correspondiente al id_usuario
$alumno_sql = "SELECT id FROM alumno WHERE id_usuario = ?";
$alumno_stmt = $conn->prepare($alumno_sql);
$alumno_stmt->bind_param("i", $id_usuario);
$alumno_stmt->execute();
$alumno_stmt->bind_result($id_alumno);
$alumno_stmt->fetch();
$alumno_stmt->close();


// Consulta para obtener las condiciones actuales
$conditions_sql = "
    SELECT 
        m.id AS id_materia,
        CASE 
            WHEN AVG(CASE WHEN n.instancia = 'JULIO' THEN n.calificacion ELSE NULL END) < 3 THEN 'TED'
            WHEN AVG(CASE WHEN n.instancia = 'JULIO' THEN n.calificacion ELSE NULL END) < 4 THEN 'TEP'
            WHEN AVG(CASE WHEN n.instancia = 'JULIO' THEN n.calificacion ELSE NULL END) >= 4 THEN 'TEA'
        END AS condicion_julio,
        CASE 
            WHEN AVG(CASE WHEN n.instancia IN ('SEPTIEMBRE', 'NOVIEMBRE') THEN n.calificacion ELSE NULL END) < 3 THEN 'TED'
            WHEN AVG(CASE WHEN n.instancia IN ('SEPTIEMBRE', 'NOVIEMBRE') THEN n.calificacion ELSE NULL END) < 4 THEN 'TEP'
            WHEN AVG(CASE WHEN n.instancia IN ('SEPTIEMBRE', 'NOVIEMBRE') THEN n.calificacion ELSE NULL END) >= 4 THEN 'TEA'
        END AS condicion_septiembre_noviembre
    FROM 
        alumno a
    JOIN 
        alumno_curso ac ON a.id = ac.id_alumno
    JOIN 
        curso c ON ac.id_curso = c.id
    JOIN 
        materia m ON m.id_curso = c.id
    JOIN 
        nota n ON n.id_alumno = a.id AND n.id_materia = m.id
    WHERE 
        a.id = ?
    GROUP BY 
        a.id, m.id
";

$conditions_stmt = $conn->prepare($conditions_sql);
$conditions_stmt->bind_param("i", $id_alumno);
$conditions_stmt->execute();
$conditions_result = $conditions_stmt->get_result();

if ($conditions_result) {
    while ($row = $conditions_result->fetch_assoc()) {
        $id_materia = $row['id_materia'];
        $condicion_julio = $row['condicion_julio'];
        $condicion_septiembre_noviembre = $row['condicion_septiembre_noviembre'];

        // Determinar la condición final más baja
        $condicion_final = $condicion_julio;
        if ($condicion_septiembre_noviembre == 'TED' || ($condicion_septiembre_noviembre == 'TEP' && $condicion_final != 'TED') || ($condicion_septiembre_noviembre == 'TEA' && $condicion_final == 'TEA')) {
            $condicion_final = $condicion_septiembre_noviembre;
        }

        // Verificar si hay calificación en mesa que cambie la condición a TEA
        $mesa_sql = "
            SELECT 
                am.calificacion 
            FROM 
                mesa m
            JOIN 
                alumno_mesa am ON m.id = am.id_mesa
            JOIN
                materia_mesa mm ON m.id = mm.id_mesa
            WHERE 
                am.id_alumno = ? 
                AND mm.id_materia = ? 
                AND am.calificacion >= 4
        ";
        $mesa_stmt = $conn->prepare($mesa_sql);
        $mesa_stmt->bind_param("ii", $id_alumno, $id_materia);
        $mesa_stmt->execute();
        $mesa_result = $mesa_stmt->get_result();
        if ($mesa_result && $mesa_result->num_rows > 0) {
            $condicion_final = 'TEA';
        }
        $mesa_stmt->close();

        // Comprobar si ya existe una entrada en la tabla 'condicion'
        $check_sql = "SELECT * FROM condicion WHERE id_alumno = ? AND id_materia = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $id_alumno, $id_materia);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result && $check_result->num_rows > 0) {
            // Si existe, actualizar la condición
            $update_sql = "UPDATE condicion SET condicion = ? WHERE id_alumno = ? AND id_materia = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("sii", $condicion_final, $id_alumno, $id_materia);
            $update_stmt->execute();
            $update_stmt->close();
        } else {
            // Si no existe, insertar una nueva entrada
            $insert_sql = "INSERT INTO condicion (id_alumno, id_materia, condicion) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iis", $id_alumno, $id_materia, $condicion_final);
            $insert_stmt->execute();
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
    $conditions_stmt->close();
}

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
function agregarEtiqueta($condicion) {
    return $condicion;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias Adeudadas</title>
    <link rel="stylesheet" href="materias_adeudadas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a id="logo" class="navbar-brand" href="menu.php">
                <img src="../../../img/LogoEESTN1.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="reinscripcion.php">Solicitud de reinscripción</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="rite.php">Ver RITE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="ver_materias.php">Ver materias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="materias_adeudadas.php">Ver materias adeudadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="mesas.php">Gestionar mesas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
