<?php
// Iniciar la sesión
session_start();

// Verificar si se enviaron los datos del formulario

    include "./conn.php";

    // Obtener los datos del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta para verificar las credenciales del usuario
    $sql = "SELECT id, nombre_usuario, mail, rol FROM usuario WHERE nombre_usuario = '$username' AND contrasenia = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuario autenticado correctamente
        $row = $result->fetch_assoc();

        // Guardar información del usuario en la sesión
        $_SESSION["id"] = $row["id"];
        $_SESSION["nombre_usuario"] = $row["nombre_usuario"];
        $_SESSION["mail"] = $row["mail"];
        $_SESSION["rol"] = $row["rol"];


        // Establecer que el usuario ha iniciado sesión
         $_SESSION["logged_in"] = true;

         
        // Redireccionar según el rol del usuario
        switch ($_SESSION["rol"]) {
            case "profesor":
                header("Location: views/profesores/menu.php");
                break;
            case "alumno":
                header("Location: views/alumnos/menu.php");
                break;
            case "preceptor":
                header("Location: views/preceptores");
                break;
            case "master":
                header("Location: master.php"); 
                break;
            default:
                echo "Rol no válido";
        }
    } else {
        echo "Nombre de usuario o contraseña incorrectos";
    }

    $conn->close();
