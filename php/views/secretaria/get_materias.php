<?php
// get_materias.php

include '../../conn.php';

// Verificar que se recibió el ID del curso
if (isset($_POST['curso_id'])) {
    $curso_id = $_POST['curso_id'];

    // Obtener materias disponibles para el curso seleccionado
    $sql = "SELECT id, nombre FROM materia WHERE id_curso = $curso_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
        }
    } else {
        echo "<option value=''>No hay materias cargadas</option>";
    }
} else {
    echo "<option value=''>Seleccione un Curso</option>";
}

// Cerrar la conexión
$conn->close();
?>
