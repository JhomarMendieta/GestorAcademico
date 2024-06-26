<?php 
include './navbar_secretaria.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del profesor</title>
    <link rel="stylesheet" href="perfil_alumno.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function mostrarFormulario() {
            document.getElementById('formulario-actualizar').style.display = 'block';
            document.getElementById('boton-editar').style.display = 'none';
        }
    </script>
</head>
<body>
<?php
include '../../conn.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['numLegajo'])) {
    echo "No se ha proporcionado ningún ID de alumno.";
    exit();
}

$numLegajo = $_GET['numLegajo'];

// Obtener datos del alumno
$sql = "SELECT * FROM profesores WHERE numLegajo=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $numLegajo);
$stmt->execute();
$result = $stmt->get_result();
$profesores = $result->fetch_assoc();

if (!$profesores) {
    echo "No se encontró ningún profesor con ese numero de legajo.";
    exit();
}

?>
    <div class="container-perfil-alumno">
        <div class="titulo-perfil-alumno">
        <h2>Perfil del profesor <?php echo htmlspecialchars($profesores['prof_nombre']) . " " . htmlspecialchars($profesores['prof_apellido']); ?> </h2>
        </div>
        <table id="tabla-alumno"  class="table table-striped">
            <tr>
                <th>DNI</th>
                <td><?php echo htmlspecialchars($profesores['dni']); ?></td>
            </tr>
            <tr>
                <th>Legajo</th>
                <td><?php echo htmlspecialchars($profesores['numLegajo']); ?></td>
            </tr>
            <tr>
                <th>Nombres</th>
                <td><?php echo htmlspecialchars($profesores['prof_nombre']); ?></td>
            </tr>
            <tr>
                <th>Apellidos</th>
                <td><?php echo htmlspecialchars($profesores['prof_apellido']); ?></td>
            </tr>
            <tr>
                <th>Título</th>
                <td><?php echo htmlspecialchars($profesores['titulo']); ?></td>
            </tr>
            <tr>
                <th>Fecha de Nacimiento</th>
                <td><?php echo htmlspecialchars($profesores['fecha_nacimiento']); ?></td>
            </tr>
            <tr>
                <th>Edad</th>
                <td><?php echo htmlspecialchars($profesores['edad']); ?></td>
            </tr>
            <tr>    
                <th>Fecha de ingreso</th>
                <td><?php echo htmlspecialchars($profesores['fecha_ingreso']); ?></td>
            </tr>
            <tr>
                <th>Domicilio</th>
                <td><?php echo htmlspecialchars($profesores['domicilio']); ?></td>
            </tr>
            <tr>
                <th>Celular</th>
                <td><?php echo htmlspecialchars($profesores['num_cel']); ?></td>
            </tr>
            <tr>
                <th>Telefono</th>
                <td><?php echo htmlspecialchars($profesores['num_tel']); ?></td>
            </tr>
            <tr>
                <th>Telefono alternativo</th>
                <td><?php echo htmlspecialchars($profesores['tel_alternativo']); ?></td>
            </tr>
        </table>

        <button id="boton-editar" class="btn btn-primary" onclick="mostrarFormulario()">Editar</button>

        <div id="formulario-actualizar" style="display: none;">
    <h3>Actualizar Datos del Profesor</h3>
    <form action="actualizar_profesor.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($profesores['id'] ?? ''); ?>">
        <div class="form-group">
            <label for="dni">DNI</label>
            <input type="text" class="form-control" id="dni" name="dni" value="<?php echo htmlspecialchars($profesores['dni'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="numLegajo">Legajo</label>
            <input type="text" class="form-control" id="numLegajo" name="numLegajo" value="<?php echo htmlspecialchars($profesores['numLegajo'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="prof_nombre">Nombres</label>
            <input type="text" class="form-control" id="prof_nombre" name="prof_nombre" value="<?php echo htmlspecialchars($profesores['prof_nombre'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="prof_apellido">Apellidos</label>
            <input type="text" class="form-control" id="prof_apellido" name="prof_apellido" value="<?php echo htmlspecialchars($profesores['prof_apellido'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($profesores['fecha_nacimiento'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="edad">Edad</label>
            <input type="number" class="form-control" id="edad" name="edad" value="<?php echo htmlspecialchars($profesores['edad'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha_ingreso">Fecha de Ingreso</label>
            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo htmlspecialchars($profesores['fecha_ingreso'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="domicilio">Domicilio</label>
            <input type="text" class="form-control" id="domicilio" name="domicilio" value="<?php echo htmlspecialchars($profesores['domicilio'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="num_tel">Teléfono</label>
            <input type="tel" class="form-control" id="num_tel" name="num_tel" value="<?php echo htmlspecialchars($profesores['num_tel'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="num_cel">Celular</label>
            <input type="tel" class="form-control" id="num_cel" name="num_cel" value="<?php echo htmlspecialchars($profesores['num_cel'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="tel_alternativo">Teléfono Alternativo</label>
            <input type="tel" class="form-control" id="tel_alternativo" name="tel_alternativo" value="<?php echo htmlspecialchars($profesores['tel_alternativo'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="mail">Email</label>
            <input type="email" class="form-control" id="mail" name="mail" value="<?php echo htmlspecialchars($profesores['mail'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($profesores['titulo'] ?? ''); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Guardar</button>
    </form>
</div>

    <script>
        function mostrarFormulario() {
    document.getElementById('formulario-actualizar').style.display = 'block';
    document.getElementById('boton-editar').style.display = 'none';
    document.getElementById('tabla-alumno').style.display = 'none';
}
    </script>
</body>
</html>
