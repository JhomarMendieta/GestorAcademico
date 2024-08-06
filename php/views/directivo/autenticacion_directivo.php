<?php 
    include "../../auth.php";
    verificarAcceso(['directivo', 'master']); // Solo directivos y master pueden acceder
?>