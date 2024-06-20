<!-- hola incluyan este archivo en sus php para que solo los usuarios con los roles pertinentes puedan entrar -->

<?php 
include "../../auth.php";
verificarAcceso(['profesor', 'master']); // Solo profesores y master pueden acceder
