<?php
    include "../../getUserId.php";
    include '../../conn.php';
    include 'autenticacion_profesor.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $materiaId = $_POST['materia_id'];
    $instancia = $_POST['instancia'];
    $fecha = $_POST['fecha'];

    // Obtener el numLegajo del profesor
    $query = "SELECT numLegajo FROM profesores WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($profesorId);
    $stmt->fetch();
    $stmt->close();

    // Verificar si se obtuvo el numLegajo
    if (!$profesorId) {
        die('Error: No se encontró el profesor correspondiente al usuario.');
    }

    // Validar los datos
    if (!empty($materiaId) && !empty($instancia) && !empty($fecha)) {
        // Insertar la nueva mesa en la tabla 'mesa'
        $query = "INSERT INTO mesa (instancia, fecha) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $instancia, $fecha);

        if ($stmt->execute()) {
            $mesaId = $stmt->insert_id;

            // Insertar en la tabla 'materia_mesa'
            $query = "INSERT INTO materia_mesa (id_materia, id_mesa) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $materiaId, $mesaId);
            $stmt->execute();

            // Insertar en la tabla 'mesa_profesores'
            $query = "INSERT INTO profesor_mesa (id_mesa, id_profesor) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $mesaId, $profesorId);
            $stmt->execute();
            
            echo "Mesa de examen creada con éxito.";
            header('Location: crear_mesa_form.php'); // Redirigir al formulario si se intenta acceder directamente a este script
            echo "Mesa de examen creada con éxito.";
            exit();
        } else {
            echo "Error al crear la mesa de examen: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Todos los campos son obligatorios.";
    }
} else {
    header('Location: crear_mesa_form.php'); // Redirigir al formulario si se intenta acceder directamente a este script
    exit();
}
?>
