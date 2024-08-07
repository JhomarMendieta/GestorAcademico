<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tomar Asistencia</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php include("assets/menu.php"); ?>
    <main class="body mt-5">
        <h1 class="text-center p-4">Tomar Asistencia</h1>
        <?php
        include("../../conn.php");

        // Obtener lista de cursos
        $query_cursos = "SELECT id, anio, division FROM curso";
        $result_cursos = $conn->query($query_cursos);

        if ($result_cursos->num_rows > 0) {
            echo '<form method="GET" action="tomar_asistencia.php">';
            echo '<div class="mb-3">';
            echo '<label for="curso" class="form-label">Seleccionar Curso</label>';
            echo '<select name="curso_id" id="curso" class="form-select" required>';
            echo '<option value="">Seleccione un curso</option>';
            while ($curso = $result_cursos->fetch_assoc()) {
                $selected = isset($_GET['curso_id']) && $_GET['curso_id'] == $curso['id'] ? 'selected' : '';
                echo "<option value='{$curso['id']}' $selected>{$curso['anio']}° {$curso['division']}</option>";
            }
            echo '</select>';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary">Siguiente</button>';
            echo '</form>';
        }

        if (isset($_GET['curso_id'])) {
            $curso_id = $_GET['curso_id'];

            // Obtener lista de materias del curso seleccionado
            $query_materias = "SELECT id, nombre FROM materia WHERE id_curso = '$curso_id'";
            $result_materias = $conn->query($query_materias);

            if ($result_materias->num_rows > 0) {
                echo '<form method="GET" action="tomar_asistencia.php">';
                echo '<input type="hidden" name="curso_id" value="' . $curso_id . '">';
                echo '<div class="mb-3">';
                echo '<label for="materia" class="form-label">Seleccionar Materia</label>';
                echo '<select name="materia_id" id="materia" class="form-select" required>';
                echo '<option value="">Seleccione una materia</option>';
                while ($materia = $result_materias->fetch_assoc()) {
                    $selected = isset($_GET['materia_id']) && $_GET['materia_id'] == $materia['id'] ? 'selected' : '';
                    echo "<option value='{$materia['id']}' $selected>{$materia['nombre']}</option>";
                }
                echo '</select>';
                echo '</div>';
                echo '<button type="submit" class="btn btn-primary">Ver Alumnos</button>';
                echo '</form>';
            }
        }

        if (isset($_GET['curso_id']) && isset($_GET['materia_id'])) {
            $curso_id = $_GET['curso_id'];
            $materia_id = $_GET['materia_id'];

            // Obtener datos del curso
            $query_anio = "SELECT anio, division FROM curso WHERE id = '$curso_id'";
            $r_query_anio = $conn->query($query_anio);
            $curso = $r_query_anio->fetch_assoc();

            // Mostrar lista de alumnos del curso seleccionado
            echo "<h2 class='text-center p-4'>Lista de los alumnos del curso {$curso['anio']}° {$curso['division']}° - Materia: {$materia_id}</h2>";
            echo '<form action="tomar_asistencia.php" method="post">';
            echo '<input type="hidden" name="id_curso" value="' . $curso_id . '">';
            echo '<input type="hidden" name="id_materia" value="' . $materia_id . '">';
            echo '<table class="table">';
            echo '<thead class="table-dark">';
            echo '<tr>';
            echo '<th scope="col" class="px-4">#</th>';
            echo '<th scope="col">DNI</th>';
            echo '<th scope="col">Apellido/s</th>';
            echo '<th scope="col">Nombre/s</th>';
            echo '<th scope="col">Asistencia</th>';
            echo '<th scope="col">Observaciones</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $query_alumnos = "SELECT id, dni, apellidos, nombres FROM alumno WHERE id IN (SELECT id_alumno FROM alumno_curso WHERE id_curso = $curso_id)";
            $r_query_alumnos = $conn->query($query_alumnos);
            $cont = 0;
            while ($row = $r_query_alumnos->fetch_assoc()) {
                $cont++;
                echo '<tr>';
                echo '<td class="td-size-alumno_curso px-4">' . $cont . '</td>';
                echo '<td>' . $row['dni'] . '</td>';
                echo '<td>' . $row['apellidos'] . '</td>';
                echo '<td>' . $row['nombres'] . '</td>';
                echo '<td>';
                echo '<select name="asistencia[' . $row['id'] . ']" class="form-select">';
                echo '<option value="Presente">Presente</option>';
                echo '<option value="Ausente">Ausente</option>';
                echo '<option value="Tarde">Tarde</option>';
                echo '<option value="Ausente con presencia">Ausente con presencia</option>';
                echo '<option value="Retiro anticipado">Retiro anticipado</option>';
                echo '</select>';
                echo '</td>';
                echo '<td>';
                echo '<input type="text" name="observaciones[' . $row['id'] . ']" class="form-control">';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '<button type="submit" class="btn btn-primary">Guardar Asistencia</button>';
            echo '</form>';
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $materia_id = $_POST['id_materia'];
            $asistencia = $_POST['asistencia'];
            $observaciones = $_POST['observaciones'];
            $id_preceptor = 1;  // Valor fijo para id_preceptor
            $cargo = 'preceptor';  // Valor fijo para cargo

            foreach ($asistencia as $id_alumno => $estado) {
                $observacion = isset($observaciones[$id_alumno]) ? $observaciones[$id_alumno] : '';
                $query = "INSERT INTO asistencia (id_alumno, id_materias, fecha, asistencia, id_preceptores, cargo, observaciones) VALUES (?, ?, NOW(), ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iissis", $id_alumno, $materia_id, $estado, $id_preceptor, $cargo, $observacion);
                $stmt->execute();
            }

            echo '<div class="alert alert-success mt-3">Asistencia guardada exitosamente.</div>';
        }
        ?>
    </main>
</body>
</html>
