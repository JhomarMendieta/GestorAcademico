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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $materiaId = $_POST['materia_id'];
    $alumnoId = $_POST['alumno_id'];

    if ($_POST['save'] == 'add') {
        $nombre = $_POST['nombre'];
        $calificacion = $_POST['calificacion'];
        $instancia = $_POST['instancia'];

        // Insertar nueva nota
        $query = "INSERT INTO nota (nombre, calificacion, instancia, id_materia, id_alumno) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $nombre, $calificacion, $instancia, $materiaId, $alumnoId);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['save'] == 'edit') {
        $notaId = $_POST['nota_id'];
        $nombre = $_POST['nombre'];
        $calificacion = $_POST['calificacion'];
        $instancia = $_POST['instancia'];

        // Actualizar nota existente
        $query = "UPDATE nota SET nombre = ?, calificacion = ?, instancia = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $nombre, $calificacion, $instancia, $notaId);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['save'] == 'delete') {
        $notaId = $_POST['nota_id'];

        // Eliminar nota
        $query = "DELETE FROM nota WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $notaId);
        $stmt->execute();
        $stmt->close();
    }

    // Recargar la página para reflejar los cambios
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener las materias que enseña el profesor
$query = "SELECT materia.id, materia.nombre FROM profesor_materia
          INNER JOIN materia ON profesor_materia.id_materia = materia.id
          WHERE profesor_materia.id_profesor = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $profesorId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Notas</title>
    <style>
        .form-container {
            display: none;
        }
    </style>
    <script>
        function showForm(formId) {
            document.querySelectorAll('.form-container').forEach(function (form) {
                form.style.display = 'none';
            });
            document.getElementById(formId).style.display = 'block';
        }
    </script>
</head>
<body>
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
    echo "<table class='table table-striped'>";
    echo "<tr><th>Apellido</th><th>Nombre</th><th>Calificación</th><th>Indicador</th><th>Instancia</th><th>Acciones</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $alumnoId = $row['id'];
        $nombreAlumno = $row['nombres'];
        $apellidoAlumno = $row['apellidos'];
    
        // Obtener las notas del alumno
        $queryNotas = "SELECT id, nombre, calificacion, instancia FROM nota WHERE id_alumno = ? AND id_materia = ?";
        $stmtNotas = $conn->prepare($queryNotas);
        $stmtNotas->bind_param("ii", $alumnoId, $materiaId);
        $stmtNotas->execute();
        $resultNotas = $stmtNotas->get_result();
    
        // Inicializar variables para las notas del alumno
        $notas = [];
    
        while ($nota = $resultNotas->fetch_assoc()) {
            $notas[] = $nota;
        }
    
        // Mostrar los datos en columnas separadas
        echo "<tr>";
        echo "<td>{$apellidoAlumno}</td>";
        echo "<td>{$nombreAlumno}</td>";
        
        echo "<td>";
        foreach ($notas as $nota) {
            echo "<div>" . $nota['calificacion'] . "</div>";
        }
        echo "</td>";

        echo "<td>";
        foreach ($notas as $nota) {
            echo "<div>" . $nota['nombre'] . "</div>";
        }
        echo "</td>";
        echo "<td>";
        foreach ($notas as $nota) {
            echo "<div>" . $nota['instancia'] . "</div>";
        }
        echo "</td>";
        echo "<td>
                <select onchange='showForm(this.value)'>
                    <option value='' disabled selected>Seleccionar</option>
                    <option value='form-add-{$alumnoId}'>Agregar Nota</option>
                    <option value='form-edit-{$alumnoId}'>Editar Nota</option>
                    <option value='form-delete-{$alumnoId}'>Borrar Nota</option>
                </select>
              </td>";
        echo "</tr>";
        echo "<table>";
        // Formularios para agregar, editar y borrar nota
        echo "<tr id='form-add-{$alumnoId}' class='form-container'>
                <td colspan='6'>
                    <form method='POST' action=''>
                        <input type='hidden' name='materia_id' value='{$materiaId}'>
                        <input type='hidden' name='alumno_id' value='{$alumnoId}'>
                        <label for='nombre'>Nombre de la Nota:</label>
                        <input type='text' name='nombre' required>
                        <label for='calificacion'>Calificación:</label>
                        <input type='text' name='calificacion' required>
                        <label for='instancia'>Instancia:</label>
                        <select name='instancia' required>
                            <option value='' disabled selected>Seleccione instancia</option>
                            <option value='MAYO'>MAYO</option>
                            <option value='JULIO'>JULIO</option>
                            <option value='SEPTIEMBRE'>SEPTIEMBRE</option>
                            <option value='NOVIEMBRE'>NOVIEMBRE</option>
                        </select>
                        <button type='submit' name='save' value='add'>Agregar</button>
                    </form>
                </td>
              </tr>";
        
        echo "<tr id='form-edit-{$alumnoId}' class='form-container'>
                <td colspan='6'>
                    <form method='POST' action=''>
                        <input type='hidden' name='materia_id' value='{$materiaId}'>
                        <input type='hidden' name='alumno_id' value='{$alumnoId}'>
                        <label for='nota_id'>Seleccionar Nota:</label>
                        <select name='nota_id' required>
                        <option value='' disabled selected>Elija indicador</option>";
        foreach ($notas as $nota) {
            echo "
            <option value='{$nota['id']}'>" . $nota['nombre'] . "</option>";
        }
        echo "  </select>
                        <label for='nombre'>Nombre de la Nota:</label>
                        <input type='text' name='nombre' required>
                        <label for='calificacion'>Calificación:</label>
                        <input type='text' name='calificacion' required>
                        <label for='instancia'>Instancia:</label>
                        <select name='instancia' required>
                            <option value='' disabled selected>Seleccione instancia</option>
                            <option value='MAYO'>MAYO</option>
                            <option value='JULIO'>JULIO</option>
                            <option value='SEPTIEMBRE'>SEPTIEMBRE</option>
                            <option value='NOVIEMBRE'>NOVIEMBRE</option>
                        </select>
                        <button type='submit' name='save' value='edit'>Guardar Cambios</button>
                    </form>
                </td>
              </tr>";
        
        echo "<tr id='form-delete-{$alumnoId}' class='form-container'>
                <td colspan='6'>
                    <form method='POST' action=''>
                        <input type='hidden' name='materia_id' value='{$materiaId}'>
                        <input type='hidden' name='alumno_id' value='{$alumnoId}'>
                        <label for='nota_id'>Seleccionar Nota:</label>
                        <select name='nota_id' required>";
        foreach ($notas as $nota) {
            echo "<option value='{$nota['id']}'>" . $nota['nombre'] . "</option>";
        }
        echo "</select>
                        <button type='submit' name='save' value='delete'>Borrar Nota</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
}
$conn->close();
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>