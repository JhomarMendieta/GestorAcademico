<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="actualizar_rite.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Actualizar RITEs</title>
</head>
<body>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------- -->
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
        <li class="nav-item">
          <a class="nav-link" href="gestionar_indicador.php">Gestionar indicadores</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------------- -->
<div class="container-update">

<div class = "titulo-update">
    <h1>Actualizar RITE</h1>
</div>

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
<div class = "select-materia">
    <form id="materiaForm" method="POST" action="">
        <select name="materia_id" class='form-select' required onchange="this.form.submit()">
            <option value="" disabled selected>Seleccione una Materia</option>
            <?php while($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
            <?php endwhile; ?>
        </select>
    </form>
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['materia_id'])) {
    $materiaId = $_POST['materia_id'];
    $instancia = isset($_POST['instancia']) ? $_POST['instancia'] : '';

    $query = "SELECT alumno.id, alumno.nombres, alumno.apellidos FROM alumno
              INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno
              INNER JOIN curso ON alumno_curso.id_curso = curso.id
              INNER JOIN materia ON curso.id = materia.id_curso
              WHERE materia.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $materiaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $queryMateria = "SELECT nombre FROM materia WHERE id = ?";
    $stmtMateria = $conn->prepare($queryMateria);
    $stmtMateria->bind_param("i", $materiaId);
    $stmtMateria->execute();
    $stmtMateria->bind_result($nombreMateria);
    $stmtMateria->fetch();
    $stmtMateria->close();
    echo "<div class = 'instancia-form'>";
    echo "<p>Materia: {$nombreMateria}</p>";
    echo "<form id='instanciaForm' method='POST' action=''>";
    echo "<input type='hidden' name='materia_id' value='{$materiaId}'>";
    echo "<select name='instancia' class='form-select' required onchange='this.form.submit()'>";
    echo "<option value='' disabled selected>Seleccione una Instancia</option>";
    echo "<option value='MAYO'" . ($instancia == 'MAYO' ? ' selected' : '') . ">MAYO</option>";
    echo "<option value='JULIO'" . ($instancia == 'JULIO' ? ' selected' : '') . ">JULIO</option>";
    echo "<option value='SEPTIEMBRE'" . ($instancia == 'SEPTIEMBRE' ? ' selected' : '') . ">SEPTIEMBRE</option>";
    echo "<option value='NOVIEMBRE'" . ($instancia == 'NOVIEMBRE' ? ' selected' : '') . ">NOVIEMBRE</option>";
    echo "</select>";
    echo "</form>";
    
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['instancia']) && isset($_POST['materia_id'])) {
    $materiaId = $_POST['materia_id'];
    $instancia = $_POST['instancia'];

    $query = "SELECT alumno.id, alumno.nombres, alumno.apellidos FROM alumno
              INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno
              INNER JOIN curso ON alumno_curso.id_curso = curso.id
              INNER JOIN materia ON curso.id = materia.id_curso
              WHERE materia.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $materiaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $queryMateria = "SELECT nombre FROM materia WHERE id = ?";
    $stmtMateria = $conn->prepare($queryMateria);
    $stmtMateria->bind_param("i", $materiaId);
    $stmtMateria->execute();
    $stmtMateria->bind_result($nombreMateria);
    $stmtMateria->fetch();
    $stmtMateria->close();

    echo "<p>Materia {$nombreMateria} - Instancia {$instancia}</p>";
    echo "<form id='alumnoForm' method='POST' action=''>";
    echo "<input type='hidden' name='materia_id' value='{$materiaId}'>";
    echo "<input type='hidden' name='instancia' value='{$instancia}'>";
    echo "<select name='alumno_id' class='form-select' required onchange='this.form.submit()'>";
    echo "<option value='' disabled selected>Seleccione un Alumno</option>";

    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id']}'>{$row['apellidos']} {$row['nombres']}</option>";
    }
    echo "</select>";
    echo "</form>";
    echo "</div>";
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['alumno_id']) && isset($_POST['instancia']) && isset($_POST['materia_id'])) {
    $materiaId = $_POST['materia_id'];
    $alumnoId = $_POST['alumno_id'];
    $instancia = $_POST['instancia'];

    $queryAlumno = "SELECT nombres, apellidos FROM alumno WHERE id = ?";
    $stmtAlumno = $conn->prepare($queryAlumno);
    $stmtAlumno->bind_param("i", $alumnoId);
    $stmtAlumno->execute();
    $stmtAlumno->bind_result($nombreAlumno, $apellidoAlumno);
    $stmtAlumno->fetch();
    $stmtAlumno->close();

    $queryNombres = "SELECT DISTINCT nombre FROM nota WHERE id_materia = ? AND instancia = ? AND calificacion IS NULL AND id_alumno IS NULL";
    $stmtNombres = $conn->prepare($queryNombres);
    $stmtNombres->bind_param("is", $materiaId, $instancia);
    $stmtNombres->execute();
    $resultNombres = $stmtNombres->get_result();
    $nombres = [];
    while ($nombreRow = $resultNombres->fetch_assoc()) {
        $nombres[] = $nombreRow['nombre'];
    }

    $queryNotas = "SELECT id, nombre, calificacion, instancia FROM nota WHERE id_alumno = ? AND id_materia = ? AND instancia = ?";
    $stmtNotas = $conn->prepare($queryNotas);
    $stmtNotas->bind_param("iis", $alumnoId, $materiaId, $instancia);
    $stmtNotas->execute();
    $resultNotas = $stmtNotas->get_result();
    ?>

<h5>Notas de <?php echo "{$apellidoAlumno} {$nombreAlumno}"; ?> en la Materia <?php echo $nombreMateria; ?> - Instancia <?php echo $instancia; ?></h5>
<div class="table-responsive">
    <table  class='table table-striped'>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Calificación</th>
                <th>Instancia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultNotas->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['calificacion']; ?></td>
                    <td><?php echo $row['instancia']; ?></td>
                    <td>
                        <form method="POST" action="" class="d-inline-block">
                            <input type="hidden" name="nota_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="materia_id" value="<?php echo $materiaId; ?>">
                            <input type="hidden" name="alumno_id" value="<?php echo $alumnoId; ?>">
                            <input type="hidden" name="instancia" value="<?php echo $instancia; ?>">
                            <button type="button" onclick="editNota(<?php echo $row['id']; ?>, '<?php echo $row['nombre']; ?>', '<?php echo $row['calificacion']; ?>', '<?php echo $row['instancia']; ?>')">Editar</button>
                            <button type="submit" name="save" value="delete">Eliminar</button>
                            
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>

    <h3 id="formTitle">Subir Nota</h3>
    <form id="notaForm" method="POST" action="">
        <input type="hidden" name="materia_id" value="<?php echo $materiaId; ?>">
        <input type="hidden" name="alumno_id" value="<?php echo $alumnoId; ?>">
        <input type="hidden" name="instancia" value="<?php echo $instancia; ?>">
        <input type="hidden" name="nota_id" id="nota_id" value="">
        <div class="form-group">
            <label for="nombre">Indicador</label>
            <select id="nombre" name="nombre" class="form-select" required>
                <option value="" disabled selected>Seleccione un indicador</option>
                <?php foreach ($nombres as $nombre): ?>
                    <option value="<?php echo $nombre; ?>"><?php echo $nombre; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="calificacion">Calificación</label>
            <input type="text" id="calificacion" name="calificacion" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="instancia">Instancia</label>
            <input type="text" id="instancia" name="instancia" class="form-control" value="<?php echo $instancia; ?>" readonly>
        </div>
        <button type="submit" name="save" value="add" id="saveButton">Agregar</button>
    </form>

    <?php
}

?>
</div>
<script src="actualizar_rite.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>