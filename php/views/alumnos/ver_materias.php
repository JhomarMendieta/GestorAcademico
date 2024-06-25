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
include 'navbar_alumnos.php';
include 'autenticacion_alumno.php';
include_once ('../../conn.php');

$id_usuario = $_SESSION["id"];

// Consulta para obtener el id_alumno correspondiente al id_usuario
$alumno_sql = "SELECT id FROM alumno WHERE id_usuario = ?";
$alumno_stmt = $conn->prepare($alumno_sql);
$alumno_stmt->bind_param("i", $id_usuario);
$alumno_stmt->execute();
$alumno_stmt->bind_result($id_alumno);
$alumno_stmt->fetch();
$alumno_stmt->close();

// Consulta para obtener el anio y division del curso del alumno
$curso_sql = "SELECT c.anio, c.division 
              FROM curso c
              JOIN alumno_curso ac ON c.id = ac.id_curso
              JOIN alumno a ON ac.id_alumno = a.id
              WHERE a.id_usuario = ?";
$curso_stmt = $conn->prepare($curso_sql);
$curso_stmt->bind_param("i", $id_usuario);
$curso_stmt->execute();
$curso_stmt->bind_result($anio, $division);
$curso_stmt->fetch();
$curso_stmt->close();

// Obtener el id_curso basado en la division y año
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

<h1>Ver Materias</h1>

<!-- Campos ocultos para enviar anio y division -->
<input type="hidden" id="anio" value="<?php echo htmlspecialchars($anio); ?>">
<input type="hidden" id="division" value="<?php echo htmlspecialchars($division); ?>">

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
        var anio = $('#anio').val();
        var division = $('#division').val();

        if (search.trim() === '') {
            $('#search-results').empty();
            return;
        }

        $.ajax({
            url: 'buscar_materias.php',
            type: 'GET',
            data: { search: search, anio: anio, division: division },
            success: function(data) {
                $('#search-results').html(data);
            }
        });
    });
});
</script>
</body>
</html>
