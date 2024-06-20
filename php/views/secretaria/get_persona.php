<?php
// esto lo que hace es basicamente buscar a la persona segun el tipo que hayas elegido en asignar curso. no hay que tocar nada.
include "../../conn.php";

$type = $_GET['type'];
$persons = [];

switch ($type) {
    case "alumno":
        $sql = "SELECT id, CONCAT(nombres, ' ', apellidos) AS name FROM alumno WHERE id_usuario IS NULL ORDER BY nombres, apellidos";
        break;
    case "preceptor":
        $sql = "SELECT id, CONCAT(nombre, ' ', apellido) AS name FROM preceptores WHERE id_usuario IS NULL ORDER BY nombre, apellido";
        break;
    case "profesor":
        $sql = "SELECT numLegajo AS id, CONCAT(prof_nombre, ' ', prof_apellido) AS name FROM profesores WHERE id_usuario IS NULL ORDER BY prof_nombre, prof_apellido";
        break;
    default:
        echo json_encode([]);
        exit();
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $persons[] = $row;
    }
}

$conn->close();
if (empty($persons)) {
    echo json_encode(["message" => "No hay personas disponibles para asignar usuario"]);
} else {
    echo json_encode($persons);
}
