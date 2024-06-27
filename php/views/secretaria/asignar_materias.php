<?php
include "./navbar_secretaria.php";
include 'autenticacion_secretaria.php';
include '../../conn.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Materias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./asignar_materias.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container-asignar-materias">
        <div class="titulo-asignar-materias">
        <h1>Asignar Materias a Profesores</h1>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $anio_lectivo = $_POST['anio_lectivo'];
            $profesor = $_POST['profesor'];
            $curso = $_POST['curso'];
            $materia = $_POST['materia'];
            $grupo = $_POST['grupo'];

            if (empty($profesor) || empty($materia)) {
                $error = "El profesor o la materia no se han seleccionado correctamente.";
                echo '<div class="alert alert-danger">' . $error . '</div>';
            } else {
                // Verificar si el profesor ya está asignado a esa materia
                $check_sql = "SELECT * FROM profesor_materia WHERE id_profesor = $profesor AND id_materia = $materia";
                $check_result = $conn->query($check_sql);

                if ($check_result->num_rows > 0) {
                    $error = "El profesor ya está asignado a esta materia.";
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                } else {
                    // Asignar la materia al profesor
                    $insert_sql = "INSERT INTO profesor_materia (id_profesor, id_materia, grupo) VALUES ($profesor, $materia, '$grupo')";
                    if ($conn->query($insert_sql) === TRUE) {
                        echo '<div class="alert alert-success">Materia asignada exitosamente.</div>';
                    } else {
                        echo '<div class="alert alert-danger">Error: ' . $insert_sql . '<br>' . $conn->error . '</div>';
                    }
                }
            }
        }
        ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="anio_lectivo">Año Lectivo</label>
                <select class="form-control" id="anio_lectivo" name="anio_lectivo" required>
                    <option value="">Seleccione un Año Lectivo</option>
                    <?php
                    // Obtener años lectivos disponibles
                    $sql = "SELECT DISTINCT anio_lectivo FROM curso";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['anio_lectivo'] . "'>" . $row['anio_lectivo'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="profesor">Profesor</label>
                <select class="form-control" id="profesor" name="profesor" required>
                    <option value="">Seleccione un Profesor</option>
                    <?php
                    // Obtener profesores disponibles
                    $sql = "SELECT numLegajo, prof_nombre, prof_apellido FROM profesores";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['numLegajo'] . "'>" . $row['prof_nombre'] . " " . $row['prof_apellido'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="curso">Curso</label>
                <select class="form-control" id="curso" name="curso" required>
                    <option value="">Seleccione un Curso</option>
                    <?php
                    // Obtener cursos disponibles
                    $sql = "SELECT id, division, anio, especialidad FROM curso";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['anio'] . " " . $row['division'] . " " . $row['especialidad'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="materia">Materia</label>
                <select class="form-control" id="materia" name="materia" required>
                    <option value="">Seleccione una Materia</option>
                    <!-- Las opciones se cargarán dinámicamente con JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="grupo">Grupo</label>
                <select class="form-control" id="grupo" name="grupo" required>
                    <option value="NA">NA</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Asignar Materia</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#curso').change(function() {
            var curso_id = $(this).val();
            if (curso_id !== '') {
                // Obtener materias disponibles para el curso seleccionado
                $.ajax({
                    url: 'get_materias.php',
                    type: 'POST',
                    data: { curso_id: curso_id },
                    success: function(response) {
                        $('#materia').html(response);
                    }
                });
            } else {
                $('#materia').html('<option value="">Seleccione una Materia</option>');
            }
        });
    });
</script>

</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
