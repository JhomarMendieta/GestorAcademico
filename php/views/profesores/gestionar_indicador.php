<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <link rel="stylesheet" href="actualizar_rite.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Gestionar indicadores</title>
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
          <a class="nav-link " href="actualizar_rite.php">Actualizar RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ver_rite.php">Ver RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ver_materia.php">Ver materias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="gestionar_indicador.php">Gestionar indicadores</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_indicator'])) {
        $materiaId = $_POST['materia_id'];
        $nombre = $_POST['nombre'];
        $instancia = $_POST['instancia'];

        // Insertar nombre de indicador predeterminado
        $query = "INSERT INTO nota (nombre, instancia, id_materia) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $nombre, $instancia, $materiaId);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['edit_indicator'])) {
        $notaId = $_POST['nota_id'];
        $nombre = $_POST['nombre'];
        $instancia = $_POST['instancia'];

        // Actualizar nombre de indicador predeterminado
        $query = "UPDATE nota SET nombre = ?, instancia = ? WHERE id = ?";
        $stmt = $conn->prepare($query); // Cambiar aquí a $stmt
        $stmt->bind_param("ssi", $nombre, $instancia, $notaId);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_indicator'])) {
        $notaId = $_POST['nota_id'];

        // Eliminar nombre de indicador predeterminado
        $query = "DELETE FROM nota WHERE id = ?";
        $stmt = $conn->prepare($query); // Cambiar aquí a $stmt
        $stmt->bind_param("i", $notaId);
        $stmt->execute();
        $stmt->close();
    }
}

// Obtener las materias que enseña el profesor
$query = "SELECT materia.id, materia.nombre, curso.anio, curso.division FROM profesor_materia
          INNER JOIN materia ON profesor_materia.id_materia = materia.id
          INNER JOIN curso ON materia.id_curso = curso.id
          WHERE profesor_materia.id_profesor = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $profesorId);
$stmt->execute();
$materias = $stmt->get_result();
$stmt->close();

// Obtener el filtro de materia seleccionado, si existe
$materiaFilter = isset($_GET['materia_id']) ? $_GET['materia_id'] : '';

// Obtener todos los nombres de notas e instancias filtrados por materia si se selecciona un filtro
$query = "SELECT nota.id, nota.nombre, nota.instancia, materia.nombre AS nombre_materia, curso.anio, curso.division 
          FROM nota
          INNER JOIN materia ON nota.id_materia = materia.id
          INNER JOIN curso ON materia.id_curso = curso.id
          WHERE nota.id_materia IN (SELECT id_materia FROM profesor_materia WHERE id_profesor = ?)";
if ($materiaFilter) {
    $query .= " AND nota.id_materia = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $profesorId, $materiaFilter);
} else {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $profesorId);
}
$stmt->execute();
$nombresNotas = $stmt->get_result();
$stmt->close();
?>
<h1>Gestionar indicadores</h1>

<h2>Seleccionar Materia</h2>
<form id="indicatorForm" method="POST" action="">
    <select name="materia_id" required>
        <option value="" disabled selected>Seleccione una Materia</option>
        <?php while($row = $materias->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
        <?php endwhile; ?>
    </select>

    <label for="nombre">Nombre del Indicador:</label>
    <input type="text" name="nombre" required>

    <label for="instancia">Instancia:</label>
    <select name="instancia" required>
        <option value="" disabled selected>Seleccione una Instancia</option>
        <option value="MAYO">MAYO</option>
        <option value="JULIO">JULIO</option>
        <option value="SEPTIEMBRE">SEPTIEMBRE</option>
        <option value="NOVIEMBRE">NOVIEMBRE</option>
    </select>

    <button type="submit" name="add_indicator">Agregar Indicador</button>
</form>

<h2>Filtrar indicadores por materia</h2>
<form method="GET" action="">
    <select name="materia_id" onchange="this.form.submit()">
        <option value="">Todas las Materias</option>
        <?php 
        $materias->data_seek(0);
        while($row = $materias->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>" <?php if ($materiaFilter == $row['id']) echo 'selected'; ?>><?php echo $row['nombre']; ?></option>
        <?php endwhile; ?>
    </select>
</form>

<h2>Indicadores</h2>
<table class='table table-striped'>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Instancia</th>
            <th>Materia</th>
            <th>Año</th>
            <th>División</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $nombresNotas->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['instancia']; ?></td>
                <td><?php echo $row['nombre_materia']; ?></td>
                <td><?php echo $row['anio']; ?></td>
                <td><?php echo $row['division']; ?></td>
                <td>
                    <button onclick="showForm('form-edit-<?php echo $row['id']; ?>')">Editar</button>
                    <button onclick="showForm('form-delete-<?php echo $row['id']; ?>')">Borrar</button>
                </td>
            </tr>
            <tr id="form-edit-<?php echo $row['id']; ?>" class="form-container" style="display:none;">
                <td colspan="6">
                    <form method="POST" action="">
                        <input type="hidden" name="nota_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="materia_id" value='<?php echo $row['id_materia']; ?>'>
                        <input type="hidden" name="edit_indicator" value="edit">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required>
                        <label for="instancia">Instancia:</label>
                        <select name="instancia" required>
                            <option value="" disabled selected>Seleccione una Instancia</option>
                            <option value="MAYO" <?php if($row['instancia'] == 'MAYO') echo 'selected'; ?>>MAYO</option>
                            <option value="JULIO" <?php if($row['instancia'] == 'JULIO') echo 'selected'; ?>>JULIO</option>
                            <option value="SEPTIEMBRE" <?php if($row['instancia'] == 'SEPTIEMBRE') echo 'selected'; ?>>SEPTIEMBRE</option>
                            <option value="NOVIEMBRE" <?php if($row['instancia'] == 'NOVIEMBRE') echo 'selected'; ?>>NOVIEMBRE</option>
                        </select>
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
            </tr>
            <tr id="form-delete-<?php echo $row['id']; ?>" class="form-container" style="display:none;">
                <td colspan="6">
                    <form method="POST" action="">
                        <input type="hidden" name="nota_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="delete_indicator" value="delete">
                        <p>¿Está seguro de que desea eliminar este indicador?</p>
                        <button type="submit">Eliminar</button>
                        <button type="button" onclick="hideForm('form-delete-<?php echo $row['id']; ?>')">Cancelar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>


<script src="gestionar_indicador.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
