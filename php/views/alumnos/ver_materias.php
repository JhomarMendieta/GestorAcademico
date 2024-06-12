<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="./ver_materias.css">
</head>
<body>

<!-- PHP para obtener los datos de la base de datos -->
<?php
$servername = 'localhost';
$dbname = 'proyecto_academicas';
$username = 'root';
$password = '';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el id_curso basado en la división y año
$division = 1;
$anio = 1;

$sqlCurso = "SELECT id FROM curso WHERE division = ? AND anio = ?";
$stmtCurso = $conn->prepare($sqlCurso);

if (!$stmtCurso) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmtCurso->bind_param("ii", $division, $anio);
$stmtCurso->execute();
$resultCurso = $stmtCurso->get_result();

if ($resultCurso->num_rows > 0) {
    $curso = $resultCurso->fetch_assoc();
    $id_curso = $curso['id'];

    // Obtener las materias que corresponden al id_curso
    $sqlMaterias = "SELECT nombre FROM materia WHERE id_curso = ?";
    $stmtMaterias = $conn->prepare($sqlMaterias);

    if (!$stmtMaterias) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmtMaterias->bind_param("i", $id_curso);
    $stmtMaterias->execute();
    $resultMaterias = $stmtMaterias->get_result();

    $materias = array();
    while ($row = $resultMaterias->fetch_assoc()) {
        $materias[] = $row;
    }

    $stmtMaterias->close();
} else {
    echo "No se encontró el curso con la división y año especificados.";
}

$stmtCurso->close();
$conn->close();
?>

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
          <a class="nav-link active" aria-current="page" href="ver_materias.php">Ver materias</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" aria-current="page" href="materias_adeudadas.php?id_alumno=1">Ver materias adeudadas</a>
        </li>
        <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="mesas.php?id_alumno=1">Gestionar mesas</a>
                    </li>
      </ul>
    </div>
  </div>
</nav>

<h1>Ver Materias</h1>

<!-- Barra de búsqueda -->
<div class="container mt-3">
    <input type="text" id="search" class="form-control" placeholder="Buscar materias...">
</div>

<!-- Resultados de búsqueda -->
<div class="container mt-3">
    <h2>Resultados de la búsqueda</h2>
    <br>
    <div id="search-results" class="materias"></div>
</div>

<!-- Materias generales -->
<div class="container">
    <h2>Materias</h2>
    <br>
    <div class="materias" id="materias">
        <!-- Insertar las materias obtenidas de la base de datos -->
        <?php 
        $images = ["ejemplo1.png", "ejemplo2.png", "ejemplo3.png", "ejemplo4.png", "ejemplo5.png", "ejemplo6.png", "ejemplo7.png", "ejemplo8.png", "ejemplo9.png", "ejemplo10.png","ejemplo11.png", "ejemplo12.png", "ejemplo13.png", "ejemplo14.png"];
        foreach ($materias as $materia): 
            $image = $images[array_rand($images)]; // Selecciona una imagen de forma aleatoria
        ?>
            <div class="materia" data-name="<?php echo htmlspecialchars($materia['nombre']); ?>">
                <button type="button" class="btn btn-secondary"></button>
                <img src="../../../img/<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($materia['nombre']); ?>">
                <div class="espacio"><?php echo htmlspecialchars($materia['nombre']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    $('#search').on('input', function() {
        var search = $(this).val();
        if (search.trim() === '') {
            $('#search-results').empty();
            return;
        }

        $.ajax({
            url: 'buscar_materias.php',
            type: 'GET',
            data: { search: search },
            success: function(data) {
                $('#search-results').html(data);
            }
        });
    });
});
</script>
</body>
</html>
