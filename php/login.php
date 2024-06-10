<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password_user = $_POST["password"];

    require "./conn.php";

    // Verificar si el usuario existe en la base de datos
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = '$name'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // El usuario existe, verificar la contraseña
        $row = mysqli_fetch_assoc($result);
        if ($row['contrasenia'] == $password_user) {
            // Contraseña correcta, iniciar sesión
            session_start();
            $_SESSION['data_user'] = $row;
            header("Location: /GestorAcademico/");
            exit;
        } else {
            // Contraseña incorrecta
            $error_message = "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado en la base de datos
        $error_message = "Usuario no registrado.";
    }

    mysqli_close($conn);

    // header("Location: index.php");
    // $name = $_POST['name'];
    // $password = $_POST['password'];
    // $query = "SELECT id_user FROM `users` WHERE $name = users.name AND $password = users.password";
    // $result = mysqli_query($conn, $query);
    // if (mysqli_num_rows($result) > 0) {
    //     $row = mysqli_fetch_array($result);
    //     session_start();
    //     $_SESSION['user_id'] = $row[0];

    // }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link para el favicon de la pagina -->
    <link rel="shortcut icon" href="img/LogoEESTN1.png" type="image/x-icon">

    <!-- Links para los estilos css -->
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/formulario.css">
    <title>Resgistro Institucional | EEST N1 vl</title>
</head>

<body>

    <!-- Contenedor del formulario -->
    <div id="contenedor_formulario" class="contenedor_formulario">

        <!-- Contenedor del logo y el texto -->
        <div class="contenedor_logo">
            <div class="logo">
                <img src="img/LogoEESTN1.png" alt="Logo de la EEST N1 vl">
            </div>
            <p class="texto_form">Registro Institucional</p>
        </div>

        <!-- Formulario -->
        <form action="php/login.php" id="formulario" class="formulario" method="post">

            <!-- Campo del ingreso del nombre de usario -->
            <div class="usuario">
                <input type="text" name="name" id="contra" placeholder="Nombre de usuario" required>
            </div>

            <!-- Campo del ingreso de la contraseña -->
            <div class="contrasena">
                <input type="password" name="password" id="contra" placeholder="Contraseña" required>
            </div>

            <!-- Por si olvido la contraseña -->
            <p class="olvido">¿Olvido su contraseña?</p>

            <!-- Boton para ingresar -->
            <div class="enviar">
                <input type="submit" value="Ingresar">
            </div>

            <!-- Linea de decoración -->
            <div class="linea"></div>
        </form>
    </div>
</body>

</html>