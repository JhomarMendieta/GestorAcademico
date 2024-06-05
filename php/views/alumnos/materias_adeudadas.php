<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = ""; // Si tienes una contraseña, colócala aquí
$dbname = "proyecto_academicas"; // Reemplaza con el nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del alumno desde la URL
if (isset($_GET['id_alumno']) && is_numeric($_GET['id_alumno'])) {
    $id_alumno = (int)$_GET['id_alumno'];

    // Consulta SQL para obtener las materias con promedio menor a 4 y el apellido del alumno
    $sql = "
        SELECT 
            a.nombres AS alumno,
            a.apellidos AS apellido,
            c.anio_lectivo,
            c.anio,
            c.division,
            m.nombre AS materia,
            AVG(CASE WHEN n.instancia = 'JULIO' THEN n.calificacion ELSE NULL END) AS promedio_julio,
            AVG(CASE WHEN n.instancia = 'NOVIEMBRE' THEN n.calificacion ELSE NULL END) AS promedio_noviembre
        FROM 
            alumno a
        JOIN 
            alumno_curso ac ON a.id = ac.id_alumno
        JOIN 
            curso c ON ac.id_curso = c.id
        JOIN 
            materia m ON m.id_curso = c.id
        JOIN 
            nota n ON n.id_alumno = a.id AND n.id_materia = m.id
        WHERE 
            a.id = $id_alumno
        GROUP BY 
            a.nombres, a.apellidos, c.anio_lectivo, c.anio, c.division, m.nombre
        HAVING 
            (AVG(CASE WHEN n.instancia = 'JULIO' THEN n.calificacion ELSE NULL END) < 4 OR
            AVG(CASE WHEN n.instancia = 'NOVIEMBRE' THEN n.calificacion ELSE NULL END) < 4);
    ";

    $result = $conn->query($sql);
    if (!$result) {
        die("Error en la consulta SQL: " . $conn->error);
    }
} else {
    $result = false;
    $error = "ID de alumno no válido.";
}

$conn->close();

// Función para agregar las etiquetas según el promedio
function agregarEtiqueta($promedio) {
    if ($promedio >= 0 && $promedio < 3) {
        return number_format($promedio, 2) . " (TED)";
    } elseif ($promedio >= 3 && $promedio < 4) {
        return number_format($promedio, 2) . " (TEP)";
    } elseif ($promedio >= 4 && $promedio <= 5) {
        return number_format($promedio, 2) . " (TEA)";
    } else {
        return number_format($promedio, 2);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias Adeudadas</title>
    <link rel="stylesheet" href="materias_adeudadas.css">
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
                        <a class="nav-link active" aria-current="page" href="materias_adeudadas.php?id_alumno=1">Ver materias adeudadas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Aquí se insertará la tabla con las materias adeudadas -->
    <div class="container mt-5">
    <h6>*Las notas se promedian teniendo en cuenta los indicadores de JULIO para el primer cuatrimestre y de NOVIEMBRE para el segundo, ya que las instancias de MAYO y SEPTIEMBRE son simplemente avances.</h6>
    <h2>Materias Adeudadas</h2>
    <div class="table-container">
        <?php if ($result && $result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Año Lectivo</th>
                        <th>Año</th>
                        <th>División</th>
                        <th>Materia</th>
                        <th>1er cuatrimestre</th>
                        <th>2do cuatrimestre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["alumno"])." ".htmlspecialchars($row["apellido"]); ?></td>
                            <td><?php echo htmlspecialchars($row["anio_lectivo"]); ?></td>
                            <td><?php echo htmlspecialchars($row["anio"]); ?></td>
                            <td><?php echo htmlspecialchars($row["division"]); ?></td>
                            <td><?php echo htmlspecialchars($row["materia"]); ?></td>
                            <td><?php echo htmlspecialchars(agregarEtiqueta($row["promedio_julio"])); ?></td>
                            <td><?php echo htmlspecialchars(agregarEtiqueta($row["promedio_noviembre"])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php else: ?>
            <div class="alert alert-warning">No se encontraron materias adeudadas.</div>
        <?php endif; ?>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
