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
<?php 
include "navbar_profesores.php";
include '../../conn.php';
?>
    <div class="container-materia">
        <?php
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

            // Consulta para obtener los alumnos ordenados alfabéticamente
            $query = "SELECT alumno.id, alumno.legajo, alumno.apellidos, alumno.nombres
                      FROM alumno
                      INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno
                      INNER JOIN curso ON alumno_curso.id_curso = curso.id
                      INNER JOIN materia ON curso.id = materia.id_curso
                      WHERE materia.id = ?
                      ORDER BY alumno.apellidos ASC, alumno.nombres ASC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $materiaId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si se encontraron resultados
            if ($result->num_rows > 0) {
                echo "<div class='table-responsive'>";
                echo "<table id='alumnosMostrados' class='table table-striped'>";
                echo "<thead><tr><th>Apellido</th><th>Nombre</th></tr></thead><tbody>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['apellidos'] . "</td>";
                    echo "<td>" . $row['nombres'] . "</td>";
                    echo "</tr>";
                }

                echo "</tbody></table>";
                echo "</div>";
                echo "<button class='btn btn-danger botonOcultar1' onclick='ocultarMateria()'>Ocultar</button>";
            } else {
                echo "No se encontraron alumnos inscritos en esta materia.";
            }

            $stmt->close();
        } else {
            echo "Seleccione una materia para ver más detalles.";
        }

        $conn->close();
        ?>
    </div>
    <script src="ver_materia.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
