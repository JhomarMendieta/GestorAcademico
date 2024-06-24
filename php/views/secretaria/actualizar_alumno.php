<?php
include '../../conn.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Función para manejar la subida de archivos
function handleFileUpload($file_input_name, $dni, $suffix, $upload_dir, $existing_file = null) {
    if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES[$file_input_name]['tmp_name'];
        $file_ext = pathinfo($_FILES[$file_input_name]['name'], PATHINFO_EXTENSION);
        $file_name = $dni . $suffix . '.' . $file_ext;
        $file_path = $upload_dir . $file_name;
        if (move_uploaded_file($file_tmp, $file_path)) {
            return $file_path; // Cambiado para devolver la ruta completa
        } else {
            return null;
        }
    } elseif ($existing_file != null) {
        // Si no se sube un nuevo archivo pero hay un archivo existente, se devuelve la ruta existente
        return $existing_file;
    }
    return null;
}

function obtenerRutaArchivoExistente($id_alumno, $tipo_archivo) {
    include '../../conn.php'; 

    $sql = "SELECT $tipo_archivo FROM alumno WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_alumno);
    $stmt->execute();
    $stmt->bind_result($ruta_archivo);
    $stmt->fetch();

    $stmt->close();
    $conn->close();

    if ($ruta_archivo !== null) {
        return $ruta_archivo;
    } else {
        return 'PATH'; 
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $dni = $_POST['dni'];
    $legajo = $_POST['legajo'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $nacimiento = $_POST['nacimiento'];
    $sexo = $_POST['sexo'];
    $anio_entrada = $_POST['anio_entrada'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $id_usuario = $_POST['id_usuario'];

    $id_alumno = $id; // Asegúrate de que $id_alumno se obtenga correctamente del formulario

    $foto_alumno_existing = obtenerRutaArchivoExistente($id_alumno, 'foto_alumno');
    $ficha_medica_existing = obtenerRutaArchivoExistente($id_alumno, 'ficha_medica');
    $partida_nacimiento_existing = obtenerRutaArchivoExistente($id_alumno, 'partida_nacimiento');
    $certificado_pase_primaria_existing = obtenerRutaArchivoExistente($id_alumno, 'certificado_pase_primaria');
    $certificado_alumno_regular_existing = obtenerRutaArchivoExistente($id_alumno, 'certificado_alumno_regular');
    $fotocopia_dni_existing = obtenerRutaArchivoExistente($id_alumno, 'fotocopia_dni');

    // Prepare and execute the update query
    $sql = "UPDATE alumno SET dni=?, legajo=?, nombres=?, apellidos=?, nacimiento=?, sexo=?, anio_entrada=?, direccion=?, telefono=?, id_usuario=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssi", $dni, $legajo, $nombres, $apellidos, $nacimiento, $sexo, $anio_entrada, $direccion, $telefono, $id_usuario, $id);

    if ($stmt->execute()) {
        echo "Datos del alumno actualizados correctamente.";

        // Manejo de la subida de archivos
        $upload_dir = '../../../archivos/';
        $foto_alumno = handleFileUpload('foto_alumno', $dni, '_foto', $upload_dir . 'fotos/', $foto_alumno_existing);
        $ficha_medica = handleFileUpload('ficha_medica', $dni, '_medica', $upload_dir . 'fichas_medicas/', $ficha_medica_existing);
        $partida_nacimiento = handleFileUpload('partida_nacimiento', $dni, '_partida', $upload_dir . 'partidas_nacimiento/', $partida_nacimiento_existing);
        $certificado_pase_primaria = handleFileUpload('certificado_pase_primaria', $dni, '_primaria', $upload_dir . 'certificados_primaria/', $certificado_pase_primaria_existing);
        $certificado_alumno_regular = handleFileUpload('certificado_alumno_regular', $dni, '_regular', $upload_dir . 'certificados_regular/', $certificado_alumno_regular_existing);
        $fotocopia_dni = handleFileUpload('fotocopia_dni', $dni, '_fotocopia', $upload_dir . 'fotocopias_dni/', $fotocopia_dni_existing);

        // Actualizar la base de datos con las rutas de los archivos
        $sql_update_files = "UPDATE alumno SET foto_alumno=?, ficha_medica=?, partida_nacimiento=?, certificado_pase_primaria=?, certificado_alumno_regular=?, fotocopia_dni=? WHERE id=?";
        $stmt_update_files = $conn->prepare($sql_update_files);
        $stmt_update_files->bind_param("ssssssi", $foto_alumno, $ficha_medica, $partida_nacimiento, $certificado_pase_primaria, $certificado_alumno_regular, $fotocopia_dni, $id);
        if ($stmt_update_files->execute()) {
            echo "Archivos actualizados correctamente en la base de datos.";
        } else {
            echo "Error al actualizar los archivos en la base de datos: " . $stmt_update_files->error;
        }

        header("Location: ./perfil_alumno.php?id=" . $id);
        exit();
    } else {
        echo "Error al actualizar los datos del alumno: " . $stmt->error;
    }
}
