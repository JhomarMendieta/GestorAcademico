<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ver_materia.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <title>Ver materia</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="menu.php">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="ver_alumnos.php">Ver alumnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="actualizar_rite.php">Actualizar RITE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ver_rite.php">Ver RITE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="ver_materia.php">Ver materias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestionar_indicadores.php">Gestionar indicadores</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-materia">
        <?php
        // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        include '../../conn.php';
        include '../../getUserId.php';

        // Obtener el id del profesor basado en el id del usuario
        $query = "SELECT numLegajo FROM profesores WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($profesorId);
        $stmt->fetch();
        $stmt->close();

        // Obtener las materias que enseña el profesor junto con el nombre del curso
        $query = "SELECT materia.id, materia.nombre, curso.division, curso.anio, curso.especialidad 
          FROM profesor_materia
          INNER JOIN materia ON profesor_materia.id_materia = materia.id
          INNER JOIN curso ON materia.id_curso = curso.id
          WHERE profesor_materia.id_profesor = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $profesorId);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <div class="titulo-materia">
            <h1>Materias</h1>
        </div>
        <form id="materiaForm" method="POST" action="">
            <input type="hidden" name="materia_id" id="materia_id" value="">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Materia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr onclick="selectMateria('<?php echo $row['id']; ?>')">
                            <td><?php echo $row['anio'] . "° " . $row['division'] . "° " . $row['especialidad']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['materia_id'])) {
            $materiaId = $_POST['materia_id'];

            // Consulta para obtener el nombre de la materia
            $queryMateria = "SELECT nombre, id_curso FROM materia WHERE id = ?";
            $stmtMateria = $conn->prepare($queryMateria);
            $stmtMateria->bind_param("i", $materiaId);
            $stmtMateria->execute();
            $stmtMateria->bind_result($nombreMateria, $idCurso);
            $stmtMateria->fetch();
            $stmtMateria->close();

            // Consulta para obtener el nombre del curso
            $queryCurso = "SELECT division, anio, especialidad FROM curso WHERE id = ?";
            $stmtCurso = $conn->prepare($queryCurso);
            $stmtCurso->bind_param("i", $idCurso);
            $stmtCurso->execute();
            $stmtCurso->bind_result($division, $anio, $especialidad);
            $stmtCurso->fetch();
            $stmtCurso->close();

            echo "<h2 id='materiaMostrada'>$nombreMateria - $anio ° $division ° $especialidad</h2>";

            // Consulta para obtener y mostrar los alumnos inscritos en la materia seleccionada junto con sus notas
            $query = "SELECT alumno.*, GROUP_CONCAT(nota.calificacion ORDER BY nota.id) AS calificaciones
              FROM alumno
              INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno
              INNER JOIN curso ON alumno_curso.id_curso = curso.id
              INNER JOIN materia ON curso.id = materia.id_curso
              LEFT JOIN nota ON alumno.id = nota.id_alumno AND materia.id = nota.id_materia
              WHERE materia.id = ?
              GROUP BY alumno.id";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $materiaId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si se encontraron resultados
            if ($result->num_rows > 0) {
                // Inicializar variables para rastrear la cantidad máxima de notas
                $maxNotas = 0;
                $alumnos = [];

                while ($row = $result->fetch_assoc()) {
                    $calificaciones = array_filter(explode(",", $row['calificaciones']));
                    $row['calificaciones'] = $calificaciones;
                    $alumnos[] = $row;

                    // Actualizar la cantidad máxima de notas
                    $maxNotas = max($maxNotas, count($calificaciones));
                }
        ?>
                <div class="table-responsive">
                    <?php
                    echo "<table id='alumnosMostrados' class='table table-striped'>";
                    echo "<tr><th>Apellido</th><th>Nombre</th>";

                    // Generar dinámicamente los encabezados de las notas
                    if ($maxNotas == 0) {
                        echo "<th>Indicador</th>";
                    } else {
                        for ($i = 1; $i <= $maxNotas; $i++) {
                            echo "<th>Indicador $i</th>";
                        }
                    }
                    echo "</tr>";

                    // Generar dinámicamente las filas de alumnos y sus notas
                    foreach ($alumnos as $alumno) {
                        echo "<tr>";
                        echo "<td>" . $alumno['apellidos'] . "</td>";
                        echo "<td>" . $alumno['nombres'] . "</td>";

                        // Imprimir las notas del alumno
                        if ($maxNotas == 0) {
                            echo "<td>-</td>";
                        } else {
                            for ($i = 0; $i < $maxNotas; $i++) {
                                echo "<td>" . (isset($alumno['calificaciones'][$i]) ? $alumno['calificaciones'][$i] : "-") . "</td>";
                            }
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                    ?>
                </div>
                <button class='btn btn-danger botonOcultar1' onclick='ocultarMateria()'>Ocultar</button>

            <?php
            } else {
            ?>

                <table id='alumnosMostrados' class='table table-striped'>
                    <tr>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>Indicador</th>
                    </tr>
                    <tr>
                        <td> - </td>
                        <td> - </td>
                        <td> - </td>
                    </tr>
                </table>
                <button class='btn btn-danger botonOcultar2' onclick='ocultarMateria()'>Ocultar</button>

        <?php
            }

            $stmt->close(); // Cerrar la consulta preparada
        } else {
            echo "Seleccione una materia para ver más detalles.";
        }


        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </div>
    <script src="ver_materia.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>