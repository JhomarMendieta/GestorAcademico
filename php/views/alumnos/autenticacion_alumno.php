<!-- este archivo es el que evita que el usuario se meta a un archivo sin el rol necesario -->
<?php
include "../../auth.php";

verificarAcceso(['alumno', 'master']); // Solo profesores y master pueden acceder
?>