<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once('../../conn.php');

// Obtener el ID del alumno desde la solicitud (por ejemplo, de la URL o formulario)
$alumno_id = isset($_GET['id_alumno']) ? (int)$_GET['id_alumno'] : 0;

// Consulta para obtener el nombre y apellido del alumno
$alumno_query = "SELECT nombres, apellidos FROM alumno WHERE id = $alumno_id";
$alumno_result = $conn->query($alumno_query);
$alumno = $alumno_result->fetch_assoc();

// Consulta para obtener las mesas del alumno
$mesas_query = "
    SELECT mesa.fecha, materia.nombre AS materia, mesa.calificacion
    FROM alumno_mesa 
    INNER JOIN mesa ON alumno_mesa.id_mesa = mesa.id
    INNER JOIN materia_mesa ON materia_mesa.id_mesa = mesa.id
    INNER JOIN materia ON materia_mesa.id_materia = materia.id
    WHERE alumno_mesa.id_alumno = $alumno_id
    ORDER BY mesa.fecha ASC, materia.nombre ASC";
$mesas_result = $conn->query($mesas_query);

$mesas = [];
if ($mesas_result->num_rows > 0) {
    while ($row = $mesas_result->fetch_assoc()) {
        $mesas[] = $row;
    }
} else {
    $mesas = null;
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
                <img src="../../../img/LogoEESTN1.png" alt="">
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
                        <a class="nav-link" aria-current="page" href="rite.php?id=1">Ver RITE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="ver_materias.php">Ver materias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="materias_adeudadas.php?id_alumno=1">Ver materias adeudadas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="mesas.php?id_alumno=1">Gestionar mesas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-5">Mesas de <?php echo htmlspecialchars($alumno['nombres'] . ' ' . htmlspecialchars($alumno['apellidos'])); ?></h1>
        
        <?php if ($mesas): ?>
            <table class="table table-light mt-3">
                <thead>
                    <tr class="table-secondary">
                        <th scope="col">Fecha</th>
                        <th scope="col">Materia</th>
                        <th scope="col">Calificación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mesas as $mesa): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($mesa['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($mesa['materia']); ?></td>
                            <td><?php echo htmlspecialchars($mesa['calificacion']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron mesas para este alumno.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
