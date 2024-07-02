<?php 
include './navbar_secretaria.php';
include 'autenticacion_secretaria.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="agregar_alumnos.css">
</head>
<body>
<?php
include '../../conn.php'; 
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];

    // Verificar si el DNI ya está registrado
    $check_dni_sql = "SELECT dni FROM alumno WHERE dni = ?";
    $stmt_check = $conn->prepare($check_dni_sql);
    $stmt_check->bind_param("i", $dni);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<div class='alert alert-danger'>El DNI ya está registrado.</div>";
    } else {
        // Si el DNI no está registrado, proceder con la inserción
        $legajo = $_POST['legajo'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $nacimiento = $_POST['nacimiento'];
        $direccion = $_POST['direccion'] ?? null;
        $telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : null;
        $tel_alternativo = !empty($_POST['tel_alternativo']) ? $_POST['tel_alternativo'] : null;
        $nacionalidad = $_POST['nacionalidad'];
        $sexo = $_POST['sexo'];
        $localidad = $_POST['localidad'] ?? null;
        $lugar_nacimiento = $_POST['lugar_nacimiento'] ?? null;
        $identidad_genero = $_POST['identidad_genero'] ?? null;
        $anio_entrada = $_POST['anio_entrada'];
        $id_responsable = null; // Esto se actualizará más adelante si se agrega un responsable

        // Manejo de la subida de archivos
        $foto_alumno = null;
        $ficha_medica = null;
        $partida_nacimiento = null;
        $certificado_pase_primaria = null;
        $certificado_alumno_regular = null;
        $fotocopia_dni = null;

        $upload_dir = '../../../archivos/';

        function handleFileUpload($file_input_name, $dni, $suffix, $upload_dir) {
            if (isset($_FILES[$file_input_name]) && $_FILES[$file_input_name]['error'] == UPLOAD_ERR_OK) {
                $file_tmp = $_FILES[$file_input_name]['tmp_name'];
                $file_ext = pathinfo($_FILES[$file_input_name]['name'], PATHINFO_EXTENSION);
                $file_name = $dni . $suffix . '.' . $file_ext;
                $file_path = $upload_dir . $file_name;
                if (move_uploaded_file($file_tmp, __DIR__ . '/' . $file_path)) {
                    return 'archivos/' . $file_name;
                } else {
                    return null;
                }
            }
            return null;
        }

        $foto_alumno = handleFileUpload('foto_alumno', $dni, '_foto', $upload_dir . 'fotos/');
        $ficha_medica = handleFileUpload('ficha_medica', $dni, '_medica', $upload_dir . 'fichas_medicas/');
        $partida_nacimiento = handleFileUpload('partida_nacimiento', $dni, '_partida', $upload_dir . 'partidas_nacimiento/');
        $certificado_pase_primaria = handleFileUpload('certificado_pase_primaria', $dni, '_primaria', $upload_dir . 'certificados_primaria/');
        $certificado_alumno_regular = handleFileUpload('certificado_alumno_regular', $dni, '_regular', $upload_dir . 'certificados_regular/');
        $fotocopia_dni = handleFileUpload('fotocopia_dni', $dni, '_fotocopia', $upload_dir . 'fotocopias_dni/');

        // Preparar la cadena de tipos y los parámetros para la consulta
        $fields = [
            'dni' => $dni,
            'legajo' => $legajo,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'nacimiento' => $nacimiento,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'tel_alternativo' => $tel_alternativo,
            'nacionalidad' => $nacionalidad,
            'sexo' => $sexo,
            'localidad' => $localidad,
            'lugar_nacimiento' => $lugar_nacimiento,
            'foto_alumno' => $foto_alumno,
            'identidad_genero' => $identidad_genero,
            'anio_entrada' => $anio_entrada,
            'ficha_medica' => $ficha_medica,
            'partida_nacimiento' => $partida_nacimiento,
            'certificado_pase_primaria' => $certificado_pase_primaria,
            'certificado_alumno_regular' => $certificado_alumno_regular,
            'fotocopia_dni' => $fotocopia_dni,
            'id_responsable' => $id_responsable,
            'id_usuario' => NULL
        ];

        $fields_non_null = array_filter($fields, fn($value) => $value !== null);
        $types = str_repeat('s', count($fields_non_null));  // Asume que todos son string, ajustar si hay tipos diferentes

        $sql = "INSERT INTO alumno (" . implode(', ', array_keys($fields_non_null)) . ") VALUES (" . implode(', ', array_fill(0, count($fields_non_null), '?')) . ")";
        $stmt = $conn->prepare($sql);

        // Utilizar array_merge para pasar los parámetros por referencia
        $stmt->bind_param($types, ...array_values($fields_non_null));

        if ($stmt->execute()) {
            // Obtener el id del alumno insertado
            $id_alumno = $stmt->insert_id;
            
            // Crear el nombre de usuario y hashear la contraseña
            $nombres_array = explode(' ', trim($nombres));
            $apellidos_array = explode(' ', trim($apellidos));
            $primer_nombre = strtolower($nombres_array[0]);
            $primer_apellido = strtolower($apellidos_array[0]);
            $user_date = date('d', strtotime($nacimiento));
            $nombre_usuario = $primer_nombre . '.' . $primer_apellido . '.' . $user_date;

            // Verificar si el nombre de usuario ya está registrado
            $check_username_sql = "SELECT nombre_usuario FROM usuario WHERE nombre_usuario = ?";
            $stmt_check_username = $conn->prepare($check_username_sql);
            $stmt_check_username->bind_param("s", $nombre_usuario);
            $stmt_check_username->execute();
            $stmt_check_username->store_result();

            if ($stmt_check_username->num_rows > 0) {
                // Agregar el año de nacimiento al nombre de usuario si ya existe
                $user_year = date('Y', strtotime($nacimiento));
                $nombre_usuario = $primer_nombre . '.' . $primer_apellido . '.' . $user_date . '.' . $user_year;
            }

            $contrasenia_hash = password_hash($dni, PASSWORD_DEFAULT);
            $rol = 'alumno';

            // Insertar el usuario
            $sql_usuario = "INSERT INTO usuario (nombre_usuario, mail, contrasenia, rol) VALUES (?, NULL, ?, ?)";
            $stmt_usuario = $conn->prepare($sql_usuario);
            $stmt_usuario->bind_param("sss", $nombre_usuario, $contrasenia_hash, $rol);

            if ($stmt_usuario->execute()) {
                $id_usuario = $stmt_usuario->insert_id;
                // Actualizar la tabla alumno con el id_usuario
                $sql_update_alumno = "UPDATE alumno SET id_usuario = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update_alumno);
                $stmt_update->bind_param("ii", $id_usuario, $id_alumno);
                $stmt_update->execute();
                echo "<div class='alert alert-success'>Alumno y usuario agregados exitosamente</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al agregar el usuario: " . $stmt_usuario->error . "</div>";
            }
            $stmt_usuario->close();
        } else {
            echo "<div class='alert alert-danger'>Error al agregar el alumno: " . $stmt->error . "</div>";
        }

        $stmt->close();

        // Si se agregaron datos del responsable
        if (!empty($_POST['resp_nombre']) && !empty($_POST['resp_apellido']) && !empty($_POST['resp_dni'])) {
            $resp_nombre = $_POST['resp_nombre'];
            $resp_apellido = $_POST['resp_apellido'];
            $resp_dni = $_POST['resp_dni'];
            $resp_telefono = !empty($_POST['resp_telefono']) ? $_POST['resp_telefono'] : null;
            $resp_otros_datos = null;

            $resp_otros_datos = handleFileUpload('resp_otros_datos', $resp_dni, '_otros', $upload_dir . 'otros_datos/');

            $sql_resp = "INSERT INTO responsable (nombre, apellido, dni, telefono, otros_datos) VALUES (?, ?, ?, ?, ?)";
            $stmt_resp = $conn->prepare($sql_resp);
            $stmt_resp->bind_param("ssiss", $resp_nombre, $resp_apellido, $resp_dni, $resp_telefono, $resp_otros_datos);

            if ($stmt_resp->execute()) {
                $id_responsable = $stmt_resp->insert_id;
                // Actualizar el id_responsable del alumno
                $sql_update_alumno = "UPDATE alumno SET id_responsable = ? WHERE dni = ?";
                $stmt_update = $conn->prepare($sql_update_alumno);
                $stmt_update->bind_param("ii", $id_responsable, $dni);
                $stmt_update->execute();
                echo "<div class='alert alert-success'>Responsable agregado exitosamente</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al agregar el responsable: " . $stmt_resp->error . "</div>";
            }

            $stmt_resp->close();
        }

        $conn->close();
    }

    $stmt_check->close();
}
?>


<div class="container-agregar-alumnos">
<div class="container mt-4"
><div class="titulo-agregar-alumnos">
    <h1>Agregar Alumno</h1>
</div>
    <form method="POST" action="agregar_alumnos.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="number" class="form-control" id="dni" name="dni" required>
        </div>
        <div class="mb-3">
            <label for="legajo" class="form-label">Legajo</label>
            <input type="number" class="form-control" id="legajo" name="legajo" required>
        </div>
        <div class="mb-3">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="nombres" name="nombres" required>
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
        </div>
        <div class="mb-3">
            <label for="nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="nacimiento" name="nacimiento" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>
        <div class="mb-3">
            <label for="tel_alternativo" class="form-label">Teléfono Alternativo</label>
            <input type="text" class="form-control" id="tel_alternativo" name="tel_alternativo">
        </div>
        <div class="mb-3">
            <label for="nacionalidad" class="form-label">Nacionalidad</label>
            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" required>
        </div>
        <div class="mb-3">
        <label for="sexo" class="form-label">Sexo</label>
        <select class="form-control" id="sexo" name="sexo">
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="localidad" class="form-label">Localidad</label>
            <input type="text" class="form-control" id="localidad" name="localidad">
        </div>
        <div class="mb-3">
            <label for="lugar_nacimiento" class="form-label">Lugar de Nacimiento</label>
            <input type="text" class="form-control" id="lugar_nacimiento" name="lugar_nacimiento">
        </div>
        <div class="mb-3">
            <label for="identidad_genero" class="form-label">Identidad de Género</label>
            <input type="text" class="form-control" id="identidad_genero" name="identidad_genero">
        </div>
        <div class="mb-3">
            <label for="anio_entrada" class="form-label">Año de Entrada</label>
            <input type="number" class="form-control" id="anio_entrada" name="anio_entrada" required>
        </div>
        <div class="mb-3">
            <label for="foto_alumno" class="form-label">Foto del Alumno</label>
            <input type="file" class="form-control" id="foto_alumno" name="foto_alumno">
        </div>
        <div class="mb-3">
            <label for="ficha_medica" class="form-label">Ficha Médica</label>
            <input type="file" class="form-control" id="ficha_medica" name="ficha_medica">
        </div>
        <div class="mb-3">
            <label for="partida_nacimiento" class="form-label">Partida de Nacimiento</label>
            <input type="file" class="form-control" id="partida_nacimiento" name="partida_nacimiento">
        </div>
        <div class="mb-3">
            <label for="certificado_pase_primaria" class="form-label">Certificado de Pase Primaria</label>
            <input type="file" class="form-control" id="certificado_pase_primaria" name="certificado_pase_primaria">
        </div>
        <div class="mb-3">
            <label for="certificado_alumno_regular" class="form-label">Certificado de Alumno Regular</label>
            <input type="file" class="form-control" id="certificado_alumno_regular" name="certificado_alumno_regular">
        </div>
        <div class="mb-3">
            <label for="fotocopia_dni" class="form-label">Fotocopia del DNI</label>
            <input type="file" class="form-control" id="fotocopia_dni" name="fotocopia_dni">
        </div>
        <div class="mb-3">
            <label for="resp_nombre" class="form-label">Nombre del Responsable</label>
            <input type="text" class="form-control" id="resp_nombre" name="resp_nombre">
        </div>
        <div class="mb-3">
            <label for="resp_apellido" class="form-label">Apellido del Responsable</label>
            <input type="text" class="form-control" id="resp_apellido" name="resp_apellido">
        </div>
        <div class="mb-3">
            <label for="resp_dni" class="form-label">DNI del Responsable</label>
            <input type="text" class="form-control" id="resp_dni" name="resp_dni">
        </div>
        <div class="mb-3">
            <label for="resp_telefono" class="form-label">Teléfono del Responsable</label>
            <input type="text" class="form-control" id="resp_telefono" name="resp_telefono">
        </div>
        <div class="mb-3">
            <label for="resp_otros_datos" class="form-label">Otros Datos del Responsable</label>
            <input type="file" class="form-control" id="resp_otros_datos" name="resp_otros_datos">
        </div>
        <button type="submit" class="btn btn-primary">Agregar Alumno</button>
    </form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoH7y3HazeAqv7pcpM1wB0mDlB0lr47LNvI6JZG6QADxhM5" crossorigin="anonymous"></script>
</body>
</html>
