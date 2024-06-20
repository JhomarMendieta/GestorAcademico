<!-- este archivo es el que evita que el usuario se meta a un archivo sin el rol necesario -->
<?php
function verificarAcceso($rolesPermitidos) {
    if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
        header("Location: ../index.html"); // Redirigir a la página de login si no tiene cuenta
        exit;
    }

    if (!in_array($_SESSION["rol"], $rolesPermitidos)) {
        header("Location: ../../no_autorizado.php"); // Redirigir a una página de acceso denegado si no tiene el rol adecuado
        exit;
    }
}

