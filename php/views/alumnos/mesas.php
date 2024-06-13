<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once('../../conn.php');
include('../../getUserId.php');

$id_usuario = $_SESSION["id"];

// Consulta para obtener el id_alumno correspondiente al id_usuario
$alumno_sql = "SELECT id FROM alumno WHERE id_usuario = ?";
$alumno_stmt = $conn->prepare($alumno_sql);
$alumno_stmt->bind_param("i", $id_usuario);
$alumno_stmt->execute();
$alumno_stmt->bind_result($alumno_id);
$alumno_stmt->fetch();
$alumno_stmt->close();

// Consulta para obtener el nombre y apellido del alumno
$alumno_query = "SELECT nombres, apellidos FROM alumno WHERE id = $alumno_id";
$alumno_result = $conn->query($alumno_query);
$alumno = $alumno_result->fetch_assoc();

// Consultas para obtener las mesas del alumno
// Mesas Disponibles: Mesas a las que el alumno no ha aplicado
$mesas_disponibles_query = "
    SELECT mesa.id AS mesa_id, mesa.fecha, materia.nombre AS materia
    FROM mesa
    INNER JOIN materia_mesa ON materia_mesa.id_mesa = mesa.id
    INNER JOIN materia ON materia_mesa.id_materia = materia.id
    WHERE materia.id IN (
        SELECT id_materia FROM condicion 
        WHERE id_alumno = $alumno_id AND (condicion = 'TED' OR condicion = 'TEP')
    )
    AND mesa.id NOT IN (
        SELECT id_mesa FROM alumno_mesa WHERE id_alumno = $alumno_id
    )
    ORDER BY mesa.fecha ASC, materia.nombre ASC";
$mesas_disponibles_result = $conn->query($mesas_disponibles_query);

$mesas_disponibles = [];
if ($mesas_disponibles_result->num_rows > 0) {
    while ($row = $mesas_disponibles_result->fetch_assoc()) {
        $mesas_disponibles[] = $row;
    }
} else {
    $mesas_disponibles = null;
}

// Mesas Registradas: Mesas a las que el alumno se ha registrado pero no ha rendido
$mesas_registradas_query = "
    SELECT mesa.id AS mesa_id, mesa.fecha, materia.nombre AS materia, alumno_mesa.calificacion
    FROM mesa
    INNER JOIN materia_mesa ON materia_mesa.id_mesa = mesa.id
    INNER JOIN materia ON materia_mesa.id_materia = materia.id
    INNER JOIN alumno_mesa ON alumno_mesa.id_mesa = mesa.id
    WHERE alumno_mesa.id_alumno = $alumno_id
    AND alumno_mesa.calificacion IS NULL
    ORDER BY mesa.fecha ASC, materia.nombre ASC";
$mesas_registradas_result = $conn->query($mesas_registradas_query);

$mesas_registradas = [];
if ($mesas_registradas_result->num_rows > 0) {
    while ($row = $mesas_registradas_result->fetch_assoc()) {
        $mesas_registradas[] = $row;
    }
} else {
    $mesas_registradas = null;
}

// Mesas Rendidas: Mesas a las que el alumno se ha registrado y ha rendido
$mesas_rendidas_query = "
    SELECT mesa.fecha, materia.nombre AS materia, alumno_mesa.calificacion
    FROM mesa
    INNER JOIN materia_mesa ON materia_mesa.id_mesa = mesa.id
    INNER JOIN materia ON materia_mesa.id_materia = materia.id
    INNER JOIN alumno_mesa ON alumno_mesa.id_mesa = mesa.id
    WHERE alumno_mesa.id_alumno = $alumno_id
    AND alumno_mesa.calificacion IS NOT NULL
    ORDER BY mesa.fecha ASC, materia.nombre ASC";
$mesas_rendidas_result = $conn->query($mesas_rendidas_query);

$mesas_rendidas = [];
if ($mesas_rendidas_result->num_rows > 0) {
    while ($row = $mesas_rendidas_result->fetch_assoc()) {
        $mesas_rendidas[] = $row;
    }
} else {
    $mesas_rendidas = null;
}

// Manejo de la solicitud de aplicación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aplicar']) && isset($_POST['mesa_id'])) {
    $mesa_id = (int)$_POST['mesa_id'];
    
    // Verificar si ya existe el registro en alumno_mesa
    $check_sql = "SELECT COUNT(*) FROM alumno_mesa WHERE id_alumno = ? AND id_mesa = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $alumno_id, $mesa_id);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();
    
    if ($count == 0) {
        // Inserción de la solicitud del alumno a la mesa
        $aplicar_sql = "INSERT INTO alumno_mesa (id_alumno, id_mesa, calificacion) VALUES (?, ?, NULL)";
        $aplicar_stmt = $conn->prepare($aplicar_sql);
        $aplicar_stmt->bind_param("ii", $alumno_id, $mesa_id);
        if ($aplicar_stmt->execute()) {
            $mensaje = "Solicitud enviada con éxito.";
        } else {
            $mensaje = "Error al enviar la solicitud.";
        }
        $aplicar_stmt->close();
    } else {
        $mensaje = "Ya has aplicado a esta mesa.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesas</title>
    <link rel="stylesheet" href="mesas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a id="logo" class="navbar-brand" href="menu.php">
        <img  src="../../../img/LogoEESTN1.png" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="reinscripcion.php">Solicitud de reinscripción</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="rite.php">Ver RITE</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="ver_materias.php">Ver materias</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" aria-current="page" href="materias_adeudadas.php">Ver materias adeudadas</a>
        </li>
        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="mesas.php">Gestionar mesas</a>
                    </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container">
        <h1 class="mt-5">Mesas de <?php echo htmlspecialchars($alumno['nombres'] . ' ' . htmlspecialchars($alumno['apellidos'])); ?></h1>
        
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>
        
        <div class="mt-5">
            <h2>Mesas Disponibles</h2>
            <?php if ($mesas_disponibles): ?>
                <table class="table table-light mt-3">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">Fecha</th>
                            <th scope="col">Materia</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mesas_disponibles as $mesa): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($mesa['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($mesa['materia']); ?></td>
                                <td>
                                    <form method="post" action="">
                                        <input type="hidden" name="mesa_id" value="<?php echo htmlspecialchars($mesa['mesa_id']); ?>">
                                        <button type="submit" name="aplicar" class="btn btn-primary">Aplicar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay mesas disponibles para aplicar.</p>
            <?php endif; ?>
        </div>

        <div class="mt-5">
            <h2>Mesas Registradas</h2>
            <?php if ($mesas_registradas): ?>
                <table class="table table-light mt-3">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">Fecha</th>
                            <th scope="col">Materia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mesas_registradas as $mesa): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($mesa['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($mesa['materia']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay mesas registradas.</p>
            <?php endif; ?>
        </div>

        <div class="mt-5">
            <h2>Mesas Rendidas</h2>
            <?php if ($mesas_rendidas): ?>
                <table class="table table-light mt-3">
                    <thead>
                        <tr class="table-secondary">
                            <th scope="col">Fecha</th>
                            <th scope="col">Materia</th>
                            <th scope="col">Calificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mesas_rendidas as $mesa): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($mesa['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($mesa['materia']); ?></td>
                                <td><?php echo htmlspecialchars($mesa['calificacion']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay mesas rendidas.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
// Cerrar la conexión
$conn->close();
?>