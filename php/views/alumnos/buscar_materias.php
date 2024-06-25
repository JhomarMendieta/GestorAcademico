<?php

session_start();

include_once ('../../conn.php');

$id_usuario = $_SESSION["id"];

// Consulta para obtener el id_alumno correspondiente al id_usuario
$alumno_sql = "SELECT id FROM alumno WHERE id_usuario = ?";
$alumno_stmt = $conn->prepare($alumno_sql);
$alumno_stmt->bind_param("i", $id_usuario);
$alumno_stmt->execute();
$alumno_stmt->bind_result($id_alumno);
$alumno_stmt->fetch();
$alumno_stmt->close();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$anio = isset($_GET['anio']) ? intval($_GET['anio']) : 0;
$division = isset($_GET['division']) ? intval($_GET['division']) : 0;

if ($anio > 0 && $division > 0) {
    // Consulta para obtener el id_curso basado en la division y anio
    $sqlCurso = "SELECT id FROM curso WHERE division = ? AND anio = ?";
    $stmtCurso = $conn->prepare($sqlCurso);

    if (!$stmtCurso) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmtCurso->bind_param("ii", $division, $anio);
    $stmtCurso->execute();
    $resultCurso = $stmtCurso->get_result();

    if ($resultCurso->num_rows > 0) {
        $curso = $resultCurso->fetch_assoc();
        $id_curso = $curso['id'];

        if (trim($search) !== '') {
            $sql = "SELECT DISTINCT nombre FROM materia WHERE nombre LIKE ? AND id_curso = ?";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                die("Error en la preparación de la consulta: " . $conn->error);
            }

            $searchTerm = '%' . $search . '%';
            $stmt->bind_param("si", $searchTerm, $id_curso);
            $stmt->execute();
            $result = $stmt->get_result();

            $images = ["ejemplo1.png", "ejemplo2.png", "ejemplo3.png", "ejemplo4.png", "ejemplo5.png", "ejemplo6.png", "ejemplo7.png", "ejemplo8.png", "ejemplo9.png", "ejemplo10.png","ejemplo11.png", "ejemplo12.png", "ejemplo13.png", "ejemplo14.png"];
            $output = '';

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $image = $images[array_rand($images)]; // Selecciona una imagen de forma aleatoria
                    $output .= '<div class="materia" data-name="' . htmlspecialchars($row['nombre']) . '">';
                    $output .= '<button type="button" class="btn btn-secondary"></button>';
                    $output .= '<img src="../../../img/' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($row['nombre']) . '">';
                    $output .= '<div class="espacio">' . htmlspecialchars($row['nombre']) . '</div>';
                    $output .= '</div>';
                }
            } else {
                $output = '<div class="col-12">No se encontraron resultados</div>';
            }

            $stmt->close();
        } else {
            $output = '';
        }
    } else {
        $output = '<div class="col-12">No se encontró el curso con la división y año especificados.</div>';
    }

    $stmtCurso->close();
} else {
    $output = '<div class="col-12">Faltan parámetros de búsqueda.</div>';
}

$conn->close();

echo $output;
?>
