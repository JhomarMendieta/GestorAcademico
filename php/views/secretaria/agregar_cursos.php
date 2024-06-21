<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="agregar_cursos.css" rel="stylesheet">
</head>
<body>
<?php
include "./navbar_secretaria.php";
include 'autenticacion_secretaria.php';

// Conectar a la base de datos
include '../../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $anio_lectivo = $_POST['anio_lectivo'];
    $anio = $_POST['anio'];
    $division = $_POST['division'];
    $especialidad = ($anio >= 4) ? $_POST['especialidad'] : NULL;

    // Insertar el curso en la base de datos
    $sql = "INSERT INTO curso (anio_lectivo, anio, division, especialidad) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $anio_lectivo, $anio, $division, $especialidad);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Curso agregado exitosamente</div>";
    } else {
        echo "<div class='alert alert-danger'>Error al agregar el curso: " . $stmt->error . "</div>";
    }
    $stmt->close();
    $conn->close();
}
?>

<div class="container mt-4">
    <h1>Agregar Curso</h1>
    <form method="POST" action="agregar_cursos.php">
        <div class="mb-3">
            <label for="anio_lectivo" class="form-label">Año Lectivo</label>
            <input type="number" class="form-control" id="anio_lectivo" name="anio_lectivo" required>
        </div>
        <div class="mb-3">
            <label for="anio" class="form-label">Año</label>
            <input type="number" class="form-control" id="anio" name="anio" required>
        </div>
        <div class="mb-3">
            <label for="division" class="form-label">División</label>
            <input type="text" class="form-control" id="division" name="division" required>
        </div>
        <div class="mb-3" id="especialidad-group" style="display: none;">
            <label for="especialidad" class="form-label">Especialidad</label>
            <select class="form-control" id="especialidad" name="especialidad">
                <option value="">Seleccione una especialidad</option>
                <option value="Programación">Programación</option>
                <option value="Electrónica">Electrónica</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Curso</button>
    </form>
</div>

<script>
    document.getElementById('anio').addEventListener('input', function () {
        var anio = this.value;
        var especialidadGroup = document.getElementById('especialidad-group');
        if (anio >= 4) {
            especialidadGroup.style.display = 'block';
        } else {
            especialidadGroup.style.display = 'none';
        }
    });
</script>
</body>
</html>
