<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Menu</title>
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
          <a class="nav-link active" href="actualizar_rite.php">Actualizar RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ver_rite.php">Ver RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ver_materia.php">Ver materias</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
include '../../conn.php';

$userId = 1;

// Obtener el id del profesor basado en el id del usuario
$query = "SELECT numLegajo FROM profesores WHERE id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($profesorId);
$stmt->fetch();
$stmt->close();

// Obtener las materias que enseña el profesor
$query = "SELECT materia.id, materia.nombre FROM profesor_materia
          INNER JOIN materia ON profesor_materia.id_materia = materia.id
          WHERE profesor_materia.id_profesor = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $profesorId);
$stmt->execute();
$result = $stmt->get_result();
?>
<h1>Seleccione una Materia</h1>
<form method="POST" action="">
    <select name="materia_id" required>
        <option value="" disabled selected>Seleccione una Materia</option>
        <?php while($row = $result->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit">Ver Alumnos</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['materia_id'])) {
    $materiaId = $_POST['materia_id'];

    // Obtener los alumnos inscritos en la materia seleccionada
    $query = "SELECT alumno.id, alumno.nombres, alumno.apellidos FROM alumno
              INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno
              INNER JOIN curso ON alumno_curso.id_curso = curso.id
              INNER JOIN materia ON curso.id = materia.id_curso
              WHERE materia.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $materiaId);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Alumnos Inscritos</h2>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Apellido</th><th>Nombre</th><th>Notas</th><th>Acciones</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $alumnoId = $row['id'];
        $nombreAlumno = $row['nombres'];
        $apellidoAlumno = $row['apellidos'];

        // Obtener las notas del alumno
        $queryNotas = "SELECT id, calificacion FROM nota WHERE id_alumno = ? AND id_materia = ?";
        $stmtNotas = $conn->prepare($queryNotas);
        $stmtNotas->bind_param("ii", $alumnoId, $materiaId);
        $stmtNotas->execute();
        $resultNotas = $stmtNotas->get_result();

        echo "<tr>";
        echo "<td>{$apellidoAlumno}</td>";
        echo "<td>{$nombreAlumno}</td>";
        echo "<td>";
        $notas = [];
        while ($nota = $resultNotas->fetch_assoc()) {
            $notas[] = $nota;
            echo "<div>Indicador " . (count($notas)) . ": " . $nota['calificacion'] . "</div>";
        }
        echo "</td>";
        echo "<td>";
        echo "<form method='POST' action='' style='display:inline-block; margin-right:5px;'>
                <input type='hidden' name='materia_id' value='{$materiaId}'>
                <input type='hidden' name='alumno_id' value='{$alumnoId}'>
                <input type='hidden' name='notas' value='" . json_encode($notas) . "'>
                <button type='submit' name='action' value='add'>Agregar Nota</button>
              </form>";
        echo "<form method='POST' action='' style='display:inline-block; margin-right:5px;'>
                <input type='hidden' name='materia_id' value='{$materiaId}'>
                <input type='hidden' name='alumno_id' value='{$alumnoId}'>
                <input type='hidden' name='notas' value='" . json_encode($notas) . "'>
                <button type='submit' name='action' value='edit'>Editar Nota</button>
              </form>";
        echo "<form method='POST' action='' style='display:inline-block;'>
                <input type='hidden' name='materia_id' value='{$materiaId}'>
                <input type='hidden' name='alumno_id' value='{$alumnoId}'>
                <input type='hidden' name='notas' value='" . json_encode($notas) . "'>
                <button type='submit' name='action' value='delete'>Borrar Nota</button>
              </form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $materiaId = $_POST['materia_id'];
    $alumnoId = $_POST['alumno_id'];
    $notas = json_decode($_POST['notas'], true);

    if ($_POST['action'] == 'add') {
        // Mostrar formulario para agregar una nueva nota
        echo "<h2>Agregar Nota</h2>";
        echo "<form method='POST' action=''>
                <input type='hidden' name='materia_id' value='{$materiaId}'>
                <input type='hidden' name='alumno_id' value='{$alumnoId}'>
                <label for='calificacion'>Calificación:</label>
                <input type='text' name='calificacion' required>
                <button type='submit' name='save' value='add'>Guardar</button>
              </form>";
    } elseif ($_POST['action'] == 'edit') {
        // Mostrar formulario para seleccionar y editar una nota
        echo "<h2>Editar Nota</h2>";
        echo "<form method='POST' action=''>
                <input type='hidden' name='materia_id' value='{$materiaId}'>
                <input type='hidden' name='alumno_id' value='{$alumnoId}'>
                <label for='nota_id'>Seleccionar Nota:</label>
                <select name='nota_id' required>";
        foreach ($notas as $index => $nota) {
            echo "<option value='{$nota['id']}'>Nota " . ($index + 1) . "</option>";
        }
        echo "</select>
                <label for='calificacion'>Nueva Calificación:</label>
                <input type='text' name='calificacion' required>
                <button type='submit' name='save' value='edit'>Guardar Cambios</button>
              </form>";
    } elseif ($_POST['action'] == 'delete') {
        // Mostrar formulario para seleccionar y borrar una nota
        echo "<h2>Borrar Nota</h2>";
        echo "<form method='POST' action=''>
                <input type='hidden' name='materia_id' value='{$materiaId}'>
                <input type='hidden' name='alumno_id' value='{$alumnoId}'>
                <label for='nota_id'>Seleccionar Nota:</label>
                <select name='nota_id' required>";
        foreach ($notas as $index => $nota) {
            echo "<option value='{$nota['id']}'>Nota " . ($index + 1) . "</option>";
        }
        echo "</select>
                <button type='submit' name='save' value='delete'>Borrar</button>
              </form>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $materiaId = $_POST['materia_id'];
    $alumnoId = $_POST['alumno_id'];

    if ($_POST['save'] == 'add') {
        $calificacion = $_POST['calificacion'];
        $query = "INSERT INTO nota (calificacion, id_materia, id_alumno) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sii", $calificacion, $materiaId, $alumnoId);
        $stmt->execute();
        $stmt->close();
        echo "Nota agregada exitosamente.";
    } elseif ($_POST['save'] == 'edit') {
        $notaId = $_POST['nota_id'];
        $calificacion = $_POST['calificacion'];
        $query = "UPDATE nota SET calificacion = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $calificacion, $notaId);
        $stmt->execute();
        $stmt->close();
        echo "Nota actualizada exitosamente.";
    } elseif ($_POST['save'] == 'delete') {
        $notaId = $_POST['nota_id'];
        $query = "DELETE FROM nota WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $notaId);
        $stmt->execute();
        $stmt->close();
        echo "Nota borrada exitosamente.";
    }
}

$conn->close();
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>