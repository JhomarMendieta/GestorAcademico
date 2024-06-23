<?php
include 'autenticacion_secretaria.php';
include '../../conn.php';

$id = $_POST['id'];
$dni = $_POST['dni'];
$legajo = $_POST['legajo'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$sexo = $_POST['sexo'];
$anio_ingreso = $_POST['anio_ingreso'];
$domicilio = $_POST['domicilio'];
$telefono = $_POST['telefono'];
$id_usuario = $_POST['id_usuario'];

$sql = "UPDATE alumno SET dni=?, legajo=?, nombres=?, apellidos=?, fecha_nacimiento=?, sexo=?, anio_ingreso=?, domicilio=?, telefono=?, id_usuario=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissssissii", $dni, $legajo, $nombres, $apellidos, $fecha_nacimiento, $sexo, $anio_ingreso, $domicilio, $telefono, $id_usuario, $id);
$stmt->execute();

// Actualizar cursos
if (isset($_POST['cursos'])) {
    $cursos = $_POST['cursos'];
    $delete_cursos_sql = "DELETE FROM alumno_curso WHERE id_alumno = ?";
    $delete_cursos_stmt = $conn->prepare($delete_cursos_sql);
    $delete_cursos_stmt->bind_param("i", $id);
    $delete_cursos_stmt->execute();

    foreach ($cursos as $curso_id) {
        $insert_curso_sql = "INSERT INTO alumno_curso (id_alumno, id_curso) VALUES (?, ?)";
        $insert_curso_stmt = $conn->prepare($insert_curso_sql);
        $insert_curso_stmt->bind_param("ii", $id, $curso_id);
        $insert_curso_stmt->execute();
    }
}

// Manejar archivos subidos
if (!empty($_FILES['archivos']['name'][0])) {
    $archivo_sql = "INSERT INTO archivos (id_alumno, nombre_archivo, ruta_archivo) VALUES (?, ?, ?)";
    $archivo_stmt = $conn->prepare($archivo_sql);

    foreach ($_FILES['archivos']['name'] as $key => $filename) {
        $ruta_archivo = '../../archivos/' . basename($filename);
        if (move_uploaded_file($_FILES['archivos']['tmp_name'][$key], $ruta_archivo)) {
            $archivo_stmt->bind_param("iss", $id, $filename, $ruta_archivo);
            $archivo_stmt->execute();
        }
    }
}

header("Location: perfil_alumno.php?id=$id");
exit();
?>
