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
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
        } else
            require "./php/home.php";
        break;
    case 'login':
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
        } else
        require "./php/home.php";
        break;
    default:
        require "./php/404.php";
        break;
}
?>