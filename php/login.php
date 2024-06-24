<?php
// Iniciar la sesión
session_start();

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./conn.php";

    // Obtener los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta con sentencia preparada
    $sql = "SELECT id, nombre_usuario, mail, rol, contrasenia FROM usuario WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // "s" indica que es un valor de tipo string
    $stmt->execute();
    $result = $stmt->get_result();

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
            exit; // Importante: salir del script después de redirigir
        } else {
            echo "Credenciales inválidas"; // Mensaje genérico
        }
    } else {
        echo "Credenciales inválidas"; // Mensaje genérico
    }

    $stmt->close();
    $conn->close();
}
