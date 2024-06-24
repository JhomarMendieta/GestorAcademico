<?php
// Iniciar la sesión
session_start();

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./conn.php";

    // Obtener los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta para verificar las credenciales del usuario
    $sql = "SELECT id, nombre_usuario, mail, rol, contrasenia FROM usuario WHERE nombre_usuario = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHash = $row["contrasenia"];

        if (password_verify($password, $storedHash)) {
            $_SESSION["id"] = $row["id"];
            $_SESSION["nombre_usuario"] = $row["nombre_usuario"];
            $_SESSION["mail"] = $row["mail"];
            $_SESSION["rol"] = $row["rol"];
            $_SESSION["logged_in"] = true;
            header("Location: ../index.php");
        } else {
            echo "Nombre de usuario o contraseña incorrectos";
        }
    }

    $conn->close();
}
