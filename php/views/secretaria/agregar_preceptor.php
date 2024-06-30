<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Preceptor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="agregar_preceptor.css">
</head>
<body>
<?php
include "./navbar_secretaria.php";
include 'autenticacion_secretaria.php';
include '../../conn.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $nacionalidad = $_POST['nacionalidad'];
    $num_tel = $_POST['num_tel'];
    $num_cel = $_POST['num_cel'];
    $domicilio = $_POST['domicilio'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $mail_institucional = $_POST['mail_institucional'];
    $mail_personal = $_POST['mail_personal'];
    $titulo_que_posee = $_POST['titulo_que_posee'];
    $antiguedad = $_POST['antiguedad'];

    // Crear nombre de usuario
    $nombreUsuario = strtolower($nombre) . '.' . strtolower($apellido);
    $contrasenia = password_hash($dni, PASSWORD_DEFAULT);
    $rol = 'preceptor';

    // Verificar si el DNI ya está registrado en la tabla de preceptores
    $check_dni_sql = "SELECT dni FROM preceptores WHERE dni = ?";
    $stmt_check = $conn->prepare($check_dni_sql);
    $stmt_check->bind_param("i", $dni);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<div class='alert alert-danger'>El DNI ya está registrado.</div>";
    } else {
        // Insertar usuario en la tabla de usuarios
        $sql_usuario = "INSERT INTO usuario (nombre_usuario, mail, contrasenia, rol) VALUES (?, ?, ?, ?)";
        $stmt_usuario = $conn->prepare($sql_usuario);
        $stmt_usuario->bind_param("ssss", $nombreUsuario, $mail_institucional, $contrasenia, $rol);

        if ($stmt_usuario->execute()) {
            // Obtener el id del usuario insertado
            $id_usuario = $stmt_usuario->insert_id;

            // Insertar datos del preceptor en la tabla de preceptores
            $sql_preceptor = "INSERT INTO preceptores (nombre, apellido, dni, nacionalidad, num_tel, num_cel, domicilio, fecha_nacimiento, fecha_ingreso, mail_institucional, mail_personal, titulo_que_posee, antiguedad, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_preceptor = $conn->prepare($sql_preceptor);
            $stmt_preceptor->bind_param("sssssssssssssi", $nombre, $apellido, $dni, $nacionalidad, $num_tel, $num_cel, $domicilio, $fecha_nacimiento, $fecha_ingreso, $mail_institucional, $mail_personal, $titulo_que_posee, $antiguedad, $id_usuario);

            if ($stmt_preceptor->execute()) {
                echo "<div class='alert alert-success'>Preceptor agregado exitosamente</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al agregar el preceptor: " . $stmt_preceptor->error . "</div>";
            }
            $stmt_preceptor->close();
        } else {
            echo "<div class='alert alert-danger'>Error al agregar el usuario: " . $stmt_usuario->error . "</div>";
        }
        $stmt_usuario->close();
    }
    $stmt_check->close();
    $conn->close();
}
?>
<div class="container">
    <h2>Agregar Preceptor</h2>
    <form action="" method="post">
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="mb-3">
            <label for="nacionalidad" class="form-label">Nacionalidad</label>
            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" required>
        </div>
        <div class="mb-3">
            <label for="num_tel" class="form-label">Número de Teléfono</label>
            <input type="text" class="form-control" id="num_tel" name="num_tel" required>
        </div>
        <div class="mb-3">
            <label for="num_cel" class="form-label">Número de Celular</label>
            <input type="text" class="form-control" id="num_cel" name="num_cel" required>
        </div>
        <div class="mb-3">
            <label for="domicilio" class="form-label">Domicilio</label>
            <input type="text" class="form-control" id="domicilio" name="domicilio" required>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
        </div>
        <div class="mb-3">
            <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
        </div>
        <div class="mb-3">
            <label for="mail_institucional" class="form-label">Mail Institucional</label>
            <input type="email" class="form-control" id="mail_institucional" name="mail_institucional" required>
        </div>
        <div class="mb-3">
            <label for="mail_personal" class="form-label">Mail Personal</label>
            <input type="email" class="form-control" id="mail_personal" name="mail_personal" required>
        </div>
        <div class="mb-3">
            <label for="titulo_que_posee" class="form-label">Título que Posee</label>
            <input type="text" class="form-control" id="titulo_que_posee" name="titulo_que_posee" required>
        </div>
        <div class="mb-3">
            <label for="antiguedad" class="form-label">Antigüedad</label>
            <input type="text" class="form-control" id="antiguedad" name="antiguedad" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeo5sa1GsBCF9yJp4gyU06G1YLgKpZ1a6wr9kkF706LIKDeQ" crossorigin="anonymous"></script>
</body>
</html>
