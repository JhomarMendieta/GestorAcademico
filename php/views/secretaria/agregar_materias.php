<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="agregar_materias.css">
</head>


<?php
include "./navbar_secretaria.php";
include 'autenticacion_secretaria.php';

// Incluir el archivo de conexión a la base de datos

// Procesamiento de formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addMateria'])) {
        $cursoId = $_POST['curso_id'];
        $nombre = $_POST['nombre'];
        $horario = $_POST['horario'];

        $queryInsert = "INSERT INTO materia (id_curso, nombre, horario) VALUES (?, ?, ?)";
        $stmtInsert = $conn->prepare($queryInsert);
        $stmtInsert->bind_param("iss", $cursoId, $nombre, $horario);
        $stmtInsert->execute();
        $stmtInsert->close();
    }

    if (isset($_POST['editMateria'])) {
        $materiaId = $_POST['materia_id'];
        $nombre = $_POST['nombre'];
        $horario = $_POST['horario'];

        $queryUpdate = "UPDATE materia SET nombre = ?, horario = ? WHERE id = ?";
        $stmtUpdate = $conn->prepare($queryUpdate);
        $stmtUpdate->bind_param("ssi", $nombre, $horario, $materiaId);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    }

    if (isset($_POST['deleteMateria'])) {
        $materiaId = $_POST['materia_id'];

        $queryDelete = "DELETE FROM materia WHERE id = ?";
        $stmtDelete = $conn->prepare($queryDelete);
        $stmtDelete->bind_param("i", $materiaId);
        $stmtDelete->execute();
        $stmtDelete->close();
    }
}
?>

<div class="container-agregar-materia">
    <?php
    // Consulta para obtener los años lectivos disponibles
    $sql = "SELECT DISTINCT anio_lectivo FROM curso ORDER BY anio_lectivo DESC";
    $resultAnioLectivo = $conn->query($sql);
    ?>
    <div class="titulo-agregar-materia">
        <h1>Agregar materias</h1>
    </div>
    <form id="anioLectivoForm" method="POST" action="">
        <select class='form-select' name="anio_lectivo" required onchange="this.form.submit()">
            <option value="" disabled selected>Seleccione un Año Lectivo</option>
            <?php while ($row = $resultAnioLectivo->fetch_assoc()) : ?>
                <option value="<?php echo $row['anio_lectivo']; ?>"><?php echo $row['anio_lectivo']; ?></option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['anio_lectivo'])) {
        $anioLectivoSeleccionado = $_POST['anio_lectivo'];

        // Consulta para obtener los cursos del año lectivo seleccionado
        $queryCursos = "SELECT id, anio, division, anio_lectivo FROM curso WHERE anio_lectivo = ?";
        $stmtCursos = $conn->prepare($queryCursos);
        $stmtCursos->bind_param("i", $anioLectivoSeleccionado);
        $stmtCursos->execute();
        $resultCursos = $stmtCursos->get_result();
        ?>
        <form id="cursoForm" method="POST" action="">
            <input type="hidden" name="anio_lectivo" value="<?php echo $anioLectivoSeleccionado; ?>">
            <select class='form-select' name="curso_id" required onchange="this.form.submit()">
                <option value="" disabled selected>Seleccione un Curso</option>
                <?php while ($row = $resultCursos->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>">
                        <?php echo "Año: " . $row['anio'] . " - División: " . $row['division'] . " - Año Lectivo: " . $row['anio_lectivo']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>
        <?php
        $stmtCursos->close();

        if (isset($_POST['curso_id'])) {
            $cursoId = $_POST['curso_id'];

            // Consulta para obtener el nombre del curso
            $queryCurso = "SELECT anio, division, anio_lectivo FROM curso WHERE id = ?";
            $stmtCurso = $conn->prepare($queryCurso);
            $stmtCurso->bind_param("i", $cursoId);
            $stmtCurso->execute();
            $stmtCurso->bind_result($anio, $division, $anioLectivo);
            $stmtCurso->fetch();
            $stmtCurso->close();

            echo "<div class='subtitulo-alumno'>";
            echo "<h5> Curso seleccionado: Año $anio - División $division - Año Lectivo $anioLectivo</h5>";
            echo "</div>";

            // Consulta para obtener y mostrar las materias del curso seleccionado
            $query = "SELECT id, nombre, horario
                      FROM materia
                      WHERE id_curso = ?
                      ORDER BY nombre ASC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $cursoId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verificar si se encontraron resultados
            if ($result->num_rows > 0) {
                echo "<div class='subtitulo-nombre'>";
                echo "<h2>Materias</h2>";
                echo "</div>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-striped'>";
                echo "<tr><th>Nombre</th><th>Horario</th><th>Acciones</th></tr>";

                // Generar dinámicamente las filas de materias
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['horario'] . "</td>";
                    echo "<td>";
                    echo "<button class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' data-id='" . $row['id'] . "' data-nombre='" . $row['nombre'] . "' data-horario='" . $row['horario'] . "'>Editar</button> ";
                    echo "<form method='POST' action='' style='display:inline-block;'>";
                    echo "<input type='hidden' name='materia_id' value='" . $row['id'] . "'>";
                    echo "<button type='submit' name='deleteMateria' class='btn btn-danger btn-sm'>Borrar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "No se encontraron materias para este curso.";
            }

            $stmt->close();
            ?>
            <div class="mt-4">
                <h3>Agregar Materia</h3>
                <form method="POST" action="">
                    <input type="hidden" name="curso_id" value="<?php echo $cursoId; ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Materia</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="horario" class="form-label">Horario</label>
                        <input type="text" class="form-control" name="horario" required>
                    </div>
                    <button type="submit" name="addMateria" class="btn btn-success">Agregar</button>
                </form>
            </div>

            <!-- Modal para editar materia -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Materia</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST" action="">
                                <input type="hidden" name="materia_id" id="editMateriaId">
                                <div class="mb-3">
                                    <label for="editNombre" class="form-label">Nombre de la Materia</label>
                                    <input type="text" class="form-control" name="nombre" id="editNombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editHorario" class="form-label">Horario</label>
                                    <input type="text" class="form-control" name="horario" id="editHorario" required>
                                </div>
                                <button type="submit" name="editMateria" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src = "agregar_materias.js"></script>
            <?php
        }
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</div>
</body>
</html>
