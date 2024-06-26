<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="agregar_profesores.css">
</head>
<body><?php
include "./navbar_secretaria.php";
include 'autenticacion_secretaria.php';
include '../../conn.php'; 
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];

    // Verificar si el DNI ya está registrado
    $check_dni_sql = "SELECT dni FROM profesores WHERE dni = ?";
    $stmt_check = $conn->prepare($check_dni_sql);
    $stmt_check->bind_param("i", $dni);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<div class='alert alert-danger'>El DNI ya está registrado.</div>";
    } else {
        // Si el DNI no está registrado, proceder con la inserción
        $numLegajo = $_POST['numLegajo'];
        $prof_nombre = $_POST['prof_nombre'];
        $prof_apellido = $_POST['prof_apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $domicilio = $_POST['domicilio'];
        $num_tel = !empty($_POST['num_tel']) ? $_POST['num_tel'] : null;
        $num_cel = !empty($_POST['num_cel']) ? $_POST['num_cel'] : null;
        $tel_alternativo = !empty($_POST['tel_alternativo']) ? $_POST['tel_alternativo'] : null;
        $edad = $_POST['edad'];
        $mail = $_POST['mail'];
        $titulo = $_POST['titulo'];

        $fields = [
            'dni' => $dni,
            'numLegajo' => $numLegajo,
            'prof_nombre' => $prof_nombre,
            'prof_apellido' => $prof_apellido,
            'fecha_nacimiento' => $fecha_nacimiento,
            'fecha_ingreso' => $fecha_ingreso,
            'domicilio' => $domicilio,
            'num_tel' => $num_tel,
            'num_cel' => $num_cel,
            'tel_alternativo' => $tel_alternativo,
            'mail' => $mail,
            'edad' => $edad,
            'titulo' => $titulo,
        ];

        $fields_non_null = array_filter($fields, fn($value) => $value !== null);
        $types = str_repeat('s', count($fields_non_null));  // Asume que todos son string, ajustar si hay tipos diferentes

        $sql = "INSERT INTO profesores (" . implode(', ', array_keys($fields_non_null)) . ") VALUES (" . implode(', ', array_fill(0, count($fields_non_null), '?')) . ")";
        $stmt = $conn->prepare($sql);

        // Utilizar array_merge para pasar los parámetros por referencia
        $stmt->bind_param($types, ...array_values($fields_non_null));

        if ($stmt->execute()) {
            // Obtener el ID del último profesor insertado
            $last_id_prof = $conn->insert_id;

            // Crear el usuario asociado
            $nombres_array = explode(' ', trim($prof_nombre));
            $apellidos_array = explode(' ', trim($prof_apellido));
            $primer_nombre = strtolower($nombres_array[0]);
            $primer_apellido = strtolower($apellidos_array[0]);
            $user_date = date('d', strtotime($fecha_nacimiento));
            $username = $primer_nombre . '.' . $primer_apellido . '.' . $user_date;
            $hashed_password = password_hash($dni, PASSWORD_DEFAULT);  // Hash de la contraseña

            $user_sql = "INSERT INTO usuario (nombre_usuario, mail, contrasenia, rol) VALUES (?, ?, ?, 'profesor')";
            $stmt_user = $conn->prepare($user_sql);
            $stmt_user->bind_param("sss", $username, $mail, $hashed_password);

            if ($stmt_user->execute()) {
                // Obtener el ID del último usuario insertado
                $last_id_user = $conn->insert_id;

                // Actualizar el registro del profesor con el id_usuario correspondiente
                $update_sql = "UPDATE profesores SET id_usuario = ? WHERE numLegajo = ?";
                $stmt_update = $conn->prepare($update_sql);
                $stmt_update->bind_param("ii", $last_id_user, $numLegajo);
                $stmt_update->execute();

                echo "<div class='alert alert-success'>Profesor agregado exitosamente</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al crear el usuario: " . $stmt_user->error . "</div>";
            }

            $stmt_user->close();
        } else {
            echo "<div class='alert alert-danger'>Error al agregar el profesor: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>

<div class="container-agregar-profesores">
<div class="container mt-4"
><div class="titulo-agregar-profesores">
    <h1>Agregar profesor</h1>
</div>
    <form method="POST" action="agregar_profesores.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="number" class="form-control" id="dni" name="dni" required>
        </div>
        <div class="mb-3">
            <label for="numLegajo" class="form-label">Legajo</label>
            <input type="number" class="form-control" id="numLegajo" name="numLegajo" required>
        </div>
        <div class="mb-3">
            <label for="prof_nombre" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="prof_nombre" name="prof_nombre" required>
        </div>
        <div class="mb-3">
            <label for="prof_apellido" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="prof_apellido" name="prof_apellido" required>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
        </div>
        <div class="mb-3">
            <label for="edad" class="form-label">edad</label>
            <input type="number" class="form-control" id="edad" name="edad" required>
        </div>
        <div class="mb-3">
            <label for="domicilio" class="form-label">Domicilio</label>
            <input type="text" class="form-control" id="domicilio" name="domicilio">
        </div>
        <div class="mb-3">
            <label for="num_tel" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="num_tel" name="num_tel">
        </div>
        <div class="mb-3">
            <label for="num_cel" class="form-label">Celular</label>
            <input type="text" class="form-control" id="num_cel" name="num_cel">
        </div>
        <div class="mb-3">
            <label for="tel_alternativo" class="form-label">Teléfono Alternativo</label>
            <input type="text" class="form-control" id="tel_alternativo" name="tel_alternativo">
        </div>
        <div class="mb-3">
        <label for="mail">Correo Electrónico:</label>
        <input type="email" id="mail" name="mail" required class="form-control">
        </div>
        <div class="mb-3">
            <label for="titulo" class="form-label">Titulo(s)</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="mb-3">
            <label for="fecha_ingreso" class="form-label">Fecha de ingreso</label>
            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
        </div>

        <button type="submit" class="btn btn-primary">Agregar profesor</button>
    </form>
</div>
</div>
</body>
</html>
