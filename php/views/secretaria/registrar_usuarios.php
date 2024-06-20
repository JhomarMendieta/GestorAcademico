<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php
// Iniciar la sesión
session_start();

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../../conn.php";

    // Obtener los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];
    $mail = $_POST["mail"];
    $rol = $_POST["rol"];

    // Hashear la contraseña

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuario (nombre_usuario, mail, contrasenia, rol) VALUES ('$username', '$mail', '$password', '$rol')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


    <h2>Registro de Usuario</h2>
    <form method="POST" action="registrar_usuario.php">
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
            <option value="master">Secretario</option>
            <option value="master">Master</option>
            
        </select>
        <button type="submit" class="btn btn-primary mt-2" >Registrar</button>
    </form>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
