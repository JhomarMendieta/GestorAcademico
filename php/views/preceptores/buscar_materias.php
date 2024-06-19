<?php
$servername = 'localhost';
$dbname = 'proyecto_academicas';
$username = 'root';
$password = '';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Obtener el id_curso basado en la división y año
$division = 1;
$anio = 1;

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

$conn->close();

echo $output;
?>
