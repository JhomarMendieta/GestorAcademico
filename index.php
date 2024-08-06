<?php
session_start();
function obtenerUltimoSegmentoDeRuta($url)
{
    $urlObjeto = parse_url($url);
    $ruta = $urlObjeto['path'];
    $segmentos = explode('/', trim($ruta, '/'));
    return end($segmentos);
}
$urlEjemplo = $_SERVER['REQUEST_URI'];
$ultimoSegmento = obtenerUltimoSegmentoDeRuta($urlEjemplo);

if ($ultimoSegmento == "index.php" || $ultimoSegmento == "GestorAcademico") {
    $ultimoSegmento = "";
}

switch ($ultimoSegmento) {
    case '':
        if (!isset($_SESSION['logged_in'])) {
            header("Location: index.html");
        } else {
            // Redireccionar según el rol del usuario
            switch ($_SESSION["rol"]) {
                case "profesor":
                    header("Location: php/views/profesores/menu.php");
                    break;
                case "directivo":
                    header("Location: php/views/directivo/menu.php");
                    break;
                case "alumno":
                    header("Location: php/views/alumnos/menu.php");
                    break;
                case "preceptor":
                    header("Location: php/views/preceptores");
                    break;
                case "secretario":
                    header("Location: php/views/secretaria/menu.php");
                    break;
                case "master":
                    header("Location: php/master.php");
                    break;
                default:
                    echo "Rol no válido";
            }
        }

        break;
    case 'login':
        require "./php/login.php";
        break;
    default:
        require "./php/404.php";
        break;
}
