<?php
include '../../conn.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numLegajo = $_POST['numLegajo'];
    $prof_nombre = $_POST['prof_nombre'];
    $prof_apellido = $_POST['prof_apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $domicilio = $_POST['domicilio'];
    $num_tel = $_POST['num_tel'];
    $num_cel = $_POST['num_cel'];
    $tel_alternativo = $_POST['tel_alternativo'];
    $edad = $_POST['edad'];
    $mail = $_POST['mail'] ?? ''; // Verifica si el campo existe
    $titulo = $_POST['titulo'] ?? ''; // Verifica si el campo existe

    // Asumiendo que $id_profesor se obtiene correctamente del formulario
    $id_profesor = $numLegajo;

    // Preparar y ejecutar la consulta de actualización
    $sql = "UPDATE profesores SET prof_nombre=?, prof_apellido=?, fecha_nacimiento=?, fecha_ingreso=?, domicilio=?, num_tel=?, num_cel=?, tel_alternativo=?, edad=?, mail=?, titulo=? WHERE numLegajo=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssi", $prof_nombre, $prof_apellido, $fecha_nacimiento, $fecha_ingreso, $domicilio, $num_tel, $num_cel, $tel_alternativo, $edad, $mail, $titulo, $id_profesor);

    if ($stmt->execute()) {
        echo "Actualización exitosa";
        header("Location: ./perfil_profesor.php?numLegajo=" . $id_profesor);
        exit();
    } else {
        echo "Error al actualizar: " . $conn->error;
    }

    $stmt->close();
}
?>


    // if ($stmt->execute()) {
    //     echo "Datos del alumno actualizados correctamente.";

    //     // Manejo de la subida de archivos
    //     $upload_dir = '../../../archivos/';
    //     $foto_alumno = handleFileUpload('foto_alumno', $dni, '_foto', $upload_dir . 'fotos/', $foto_alumno_existing);
    //     $ficha_medica = handleFileUpload('ficha_medica', $dni, '_medica', $upload_dir . 'fichas_medicas/', $ficha_medica_existing);
    //     $partida_nacimiento = handleFileUpload('partida_nacimiento', $dni, '_partida', $upload_dir . 'partidas_nacimiento/', $partida_nacimiento_existing);
    //     $certificado_pase_primaria = handleFileUpload('certificado_pase_primaria', $dni, '_primaria', $upload_dir . 'certificados_primaria/', $certificado_pase_primaria_existing);
    //     $certificado_alumno_regular = handleFileUpload('certificado_alumno_regular', $dni, '_regular', $upload_dir . 'certificados_regular/', $certificado_alumno_regular_existing);
    //     $fotocopia_dni = handleFileUpload('fotocopia_dni', $dni, '_fotocopia', $upload_dir . 'fotocopias_dni/', $fotocopia_dni_existing);

    //     // Actualizar la base de datos con las rutas de los archivos
    //     $sql_update_files = "UPDATE alumno SET foto_alumno=?, ficha_medica=?, partida_nacimiento=?, certificado_pase_primaria=?, certificado_alumno_regular=?, fotocopia_dni=? WHERE id=?";
    //     $stmt_update_files = $conn->prepare($sql_update_files);
    //     $stmt_update_files->bind_param("ssssssi", $foto_alumno, $ficha_medica, $partida_nacimiento, $certificado_pase_primaria, $certificado_alumno_regular, $fotocopia_dni, $id);
    //     if ($stmt_update_files->execute()) {
    //         echo "Archivos actualizados correctamente en la base de datos.";
    //     } else {
    //         echo "Error al actualizar los archivos en la base de datos: " . $stmt_update_files->error;
    //     }

    //     header("Location: ./perfil_alumno.php?id=" . $id);
    //     exit();
    // } else {
    //     echo "Error al actualizar los datos del alumno: " . $stmt->error;
    // }

