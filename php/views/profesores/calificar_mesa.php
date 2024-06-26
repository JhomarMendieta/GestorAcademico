<?php
include "./components/navbar_profesores.php";
include '../../conn.php';
include 'autenticacion_profesor.php';

// Obtener el ID del profesor
$query = "SELECT numLegajo FROM profesores WHERE id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($profesorId);
$stmt->fetch();
$stmt->close();

// Verificar si se obtuvo el numLegajo
if (!$profesorId) {
    die('Error: No se encontró el profesor correspondiente al usuario.');
}

// Procesar el formulario de calificación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['calificar'])) {
    $mesaId = $_POST['mesa_id'];
    $alumnoId = $_POST['alumno_id'];
    $calificacion = $_POST['calificacion'];

    $query = "UPDATE alumno_mesa SET calificacion = ? WHERE id_mesa = ? AND id_alumno = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("dii", $calificacion, $mesaId, $alumnoId);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Calificación actualizada con éxito.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar la calificación: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Obtener las materias que enseña el profesor
$query = "SELECT materia.id, materia.nombre FROM profesor_materia
          INNER JOIN materia ON profesor_materia.id_materia = materia.id
          WHERE profesor_materia.id_profesor = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $profesorId);
$stmt->execute();
$materias = $stmt->get_result();
$stmt->close();

$mesas = [];
$alumnos = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['materia_id'])) {
    $materiaId = $_POST['materia_id'];

    // Obtener las mesas de la materia seleccionada
    $query = "SELECT mesa.id, mesa.instancia, mesa.fecha FROM materia_mesa
              INNER JOIN mesa ON materia_mesa.id_mesa = mesa.id
              INNER JOIN profesor_mesa ON mesa.id = profesor_mesa.id_mesa
              WHERE materia_mesa.id_materia = ? AND profesor_mesa.id_profesor = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $materiaId, $profesorId);
    $stmt->execute();
    $mesas = $stmt->get_result();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mesa_id'])) {
    $mesaId = $_POST['mesa_id'];

    // Obtener los alumnos de la mesa seleccionada
    $query = "SELECT alumno.id, alumno.nombres, alumno.apellidos FROM alumno_mesa
              INNER JOIN alumno ON alumno_mesa.id_alumno = alumno.id
              WHERE alumno_mesa.id_mesa = ? AND alumno_mesa.calificacion IS NULL";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $mesaId);
    $stmt->execute();
    $alumnos = $stmt->get_result();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificar Mesa de Examen</title>
    <link rel="stylesheet" href="../../../css/profesores/calificar_mesa.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container-mesa"><div class="titulo-mesa">
    <h1>Calificar Mesa de Examen</h1></div>
    <form id="calificarMesaForm" method="POST" action="">
        <div class="form-group">
            <label for="materia_id">Seleccione una Materia:</label>
            <select name="materia_id" id="materia_id" class="form-control" required onchange="this.form.submit()">
                <option value="" disabled selected>Seleccione una Materia</option>
                <?php while ($row = $materias->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>" <?php if (isset($_POST['materia_id']) && $_POST['materia_id'] == $row['id']) echo 'selected'; ?>><?php echo $row['nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="mesa_id">Seleccione una Mesa:</label>
            <select name="mesa_id" id="mesa_id" class="form-control" required onchange="this.form.submit()">
                <option value="" disabled selected>Seleccione una Mesa</option>
                <?php while ($row = $mesas->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>" <?php if (isset($_POST['mesa_id']) && $_POST['mesa_id'] == $row['id']) echo 'selected'; ?>><?php echo $row['instancia'] . ' - ' . $row['fecha']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="alumno_id">Seleccione un Alumno:</label>
            <select name="alumno_id" id="alumno_id" class="form-control" required>
                <option value="" disabled selected>Seleccione un Alumno</option>
                <?php while ($row = $alumnos->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['apellidos'] . ', ' . $row['nombres']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="calificacion">Calificación:</label>
            <input type="number" name="calificacion" id="calificacion" class="form-control" min="0" max="10" required>
        </div>
        <button type="submit" name="calificar" class="btn btn-primary">Calificar</button>
    </form>
</div>
</body>
</html>
