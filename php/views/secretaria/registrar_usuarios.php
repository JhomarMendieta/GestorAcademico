<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="./registrar_usuarios.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php
include "./navbar_secretaria.php";
include 'autenticacion_secretaria.php';

// Inicializar variables para los mensajes
$message = "";
$messageType = "";

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../../conn.php";

    // Obtener los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"]; // Hashear la contraseña
    $mail = $_POST["mail"];
    $rol = $_POST["rol"];

    // Verificar si el usuario o el correo ya existen en la base de datos
    $check_sql = "SELECT * FROM usuario WHERE nombre_usuario = '$username' OR mail = '$mail'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Usuario o correo ya existen
        $message = "El nombre de usuario o correo electrónico ya existen.";
        $messageType = "warning";
    } else {
        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuario (nombre_usuario, mail, contrasenia, rol) VALUES ('$username', '$mail', '$password', '$rol')";
        if ($conn->query($sql) === TRUE) {
            $message = "Usuario registrado exitosamente.";
            $messageType = "success";
        } else {
            $message = "Error al registrar el usuario: " . $conn->error;
            $messageType = "danger";
        }
    }

    $conn->close();
}
?>

<div class="container-register">
    <div class="titulo-register">
        <h1>Registro de Usuario</h1>
    </div>
    <!-- Sección de mensajes -->

    <form method="POST" action="registrar_usuarios.php">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required class="form-control">
        <label for="mail">Correo Electrónico:</label>
        <input type="email" id="mail" name="mail" required class="form-control">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required class="form-control">
        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required class="form-control">
            <option value="profesor">Profesor</option>
            <option value="alumno">Alumno</option>
            <option value="preceptor">Preceptor</option>
            <option value="secretario">Secretario</option>
            <option value="master">Master</option>
        </select>
        <?php if (!empty($message)) { ?>
        <div class="alert alert-<?php echo $messageType; ?> mt-2" role="alert">
            <?php echo $message; ?>
        </div>
    <?php } ?>
        <button type="submit" class="btn btn-primary mt-2">Registrar</button>
    </form>

</div>
</body>
</html>
