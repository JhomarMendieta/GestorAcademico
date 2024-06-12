<?php
session_start();

// Destruir todas las variables de sesión
session_unset();
session_destroy();

// Redirigir a la página de inicio
header("Location: ../index.html");
exit;
