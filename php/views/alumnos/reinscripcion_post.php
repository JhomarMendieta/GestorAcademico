<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once('../../conn.php');

$nombre = $conn->real_escape_string($_POST['nombre'] ?? '');
$apellido = $conn->real_escape_string($_POST['apellido'] ?? '');
$nacimiento = $_POST['nacimiento'] ?? '';

// Verificar si la fecha de nacimiento está presente y no está vacía
if (empty($nacimiento)) {
    die("Error: La fecha de nacimiento es obligatoria.");
}

$cpi = isset($_POST['cpi']) && $_POST['cpi'] === 'si' ? 1 : 0;
$dni_argentino = $conn->real_escape_string($_POST['dni_argentino'] ?? '');
$dni = $conn->real_escape_string($_POST['dni'] ?? '');
$cuil = $conn->real_escape_string($_POST['cuil'] ?? '');
$documento_extranjero = isset($_POST['documento_extranjero']) && $_POST['documento_extranjero'] === 'si' ? 1 : 0;
$tipo_documento = $conn->real_escape_string($_POST['tipo_documento'] ?? '');
$numero_documento = $conn->real_escape_string($_POST['numero_documento'] ?? '');

// Subir el archivo PDF
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}
$target_file = $target_dir . basename($_FILES["archivos"]["name"]);
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Verificar si el archivo es un PDF
if ($fileType != "pdf") {
    die("Error: Solo se permiten archivos PDF.");
}

// Verificar si el archivo se subió correctamente
if ($_FILES["archivos"]["error"] !== UPLOAD_ERR_OK) {
    die("Error al subir el archivo.");
}

// Mover el archivo subido a la carpeta destino
if (!move_uploaded_file($_FILES["archivos"]["tmp_name"], $target_file)) {
    die("Error al mover el archivo subido.");
}

// Buscar el id del alumno en la tabla alumno usando el dni
$sql_alumno = "SELECT id FROM alumno WHERE dni = '$dni'";
$result_alumno = $conn->query($sql_alumno);

if ($result_alumno->num_rows > 0) {
    $row_alumno = $result_alumno->fetch_assoc();
    $id_alumno = $row_alumno['id'];

    // Insertar datos en la tabla reinscripcion
    $sql_reinscripcion = "INSERT INTO reinscripcion (id_alumno, nombre, apellido, nacimiento, posee_pre_identificacion, posee_dni_arg, dni, cuil, posee_doc_ext, tipo_doc_ext, nro_doc_ext, archivo)
    VALUES ($id_alumno, '$nombre', '$apellido', '$nacimiento', $cpi, '$dni_argentino', '$dni', '$cuil', $documento_extranjero, '$tipo_documento', '$numero_documento', '$target_file')";

    if ($conn->query($sql_reinscripcion) === TRUE) {
        echo "Datos insertados correctamente.";
    } else {
        echo "Error al insertar datos: " . $conn->error;
    }
} else {
    echo "No se encontró un alumno con el DNI proporcionado.";
}

$conn->close();
?>
