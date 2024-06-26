<?php
    include "./components/navbar_profesores.php";
    include '../../conn.php';
    include 'autenticacion_profesor.php';
?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../css/profesores/calificar_mesa.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <title>Crear mesas de examenes</title>
</head>

<body>
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
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

// Obtener las materias que enseña el profesor
$query = "SELECT materia.id, materia.nombre FROM profesor_materia
          INNER JOIN materia ON profesor_materia.id_materia = materia.id
          WHERE profesor_materia.id_profesor = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $profesorId);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

    <div class="container mt-5">
        <h2>Crear Mesa de Examen</h2>
        <form id="mesaExamenForm" method="POST" action="crear_mesa.php">
            <div class="form-group">
                <label for="materia_id">Seleccione una Materia:</label>
                <select name="materia_id" id="materia_id" class="form-control" required>
                    <option value="" disabled selected>Seleccione una Materia</option>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="instancia">Seleccione una Instancia:</label>
                <select name="instancia" id="instancia" class="form-control" required>
                    <option value="" disabled selected>Seleccione una Instancia</option>
                    <option value="diciembre">Diciembre</option>
                    <option value="febrero">Febrero</option>
                    <option value="previa">Previa</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha">Seleccione una Fecha:</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Mesa de Examen</button>
        </form>
    </div>
</body>
</html>
