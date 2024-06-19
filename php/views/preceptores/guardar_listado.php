<?php
include_once('../../conn.php');

$asistencias = isset($_POST['asistencia']) ? $_POST['asistencia'] : [];
$observaciones = isset($_POST['observaciones']) ? $_POST['observaciones'] : [];
$ids_alumno = isset($_POST['id_alumno']) ? $_POST['id_alumno'] : [];

$id_materia = isset($_POST['id_materia']) ? $_POST['id_materia'] : 0;
$id_preceptor = isset($_POST['id_preceptor']) ? $_POST['id_preceptor'] : 0;
$id_profesor = isset($_POST['id_profesor']) ? $_POST['id_profesor'] : 0;
$fecha = isset($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d');

// Verificar que el ID de la materia existe
$materia_query = "SELECT id FROM materia WHERE id = '$id_materia'";
$materia_result = mysqli_query($conn, $materia_query);
if (mysqli_num_rows($materia_result) == 0) {
    die("Error: El ID de la materia no es válido.");
}

// Verificar los IDs de los alumnos
foreach ($ids_alumno as $id_alumno) {
    $alumno_query = "SELECT id FROM alumno WHERE id = '$id_alumno'";
    $alumno_result = mysqli_query($conn, $alumno_query);
    if (mysqli_num_rows($alumno_result) == 0) {
        die("Error: El ID del alumno $id_alumno no es válido.");
    }
}

// Verifica que los arrays tienen la misma longitud
if (count($asistencias) == count($observaciones) && count($observaciones) == count($ids_alumno)) {
    for ($i = 0; $i < count($asistencias); $i++) {
        $asistencia = mysqli_real_escape_string($conn, $asistencias[$i]);
        $observacion = mysqli_real_escape_string($conn, $observaciones[$i]);
        $id_alumno = mysqli_real_escape_string($conn, $ids_alumno[$i]);
        
        $query = "INSERT INTO asistencia (asistencia, Fecha, id_materias, id_preceptores, id_alumno, id_profesor, observaciones) 
                  VALUES ('$asistencia', '$fecha', '$id_materia', '$id_preceptor', '$id_alumno', '$id_profesor', '$observacion')";
        if (!mysqli_query($conn, $query)) {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "Error: Los datos enviados no son consistentes.";
}

mysqli_close($conn);

header('Location: curso.php');
?>
