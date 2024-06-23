<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
include './navbar_secretaria.php';
include 'autenticacion_secretaria.php';
include '../../conn.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$id = $_GET['id'];
$sql = "SELECT * FROM alumno WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$alumno = $result->fetch_assoc();
?>

<div class="container mt-4">
    <h1>Perfil del Alumno</h1>
    <form method="POST" action="actualizar_alumno.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <input type="number" class="form-control" id="dni" name="dni" value="<?php echo $alumno['dni']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="legajo" class="form-label">Legajo</label>
            <input type="number" class="form-control" id="legajo" name="legajo" value="<?php echo $alumno['legajo']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="nombres" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo $alumno['nombres']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="apellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $alumno['apellidos']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $alumno['fecha_nacimiento']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="sexo" class="form-label">Sexo</label>
            <select class="form-control" id="sexo" name="sexo" required>
                <option value="F" <?php if ($alumno['sexo'] == 'F') echo 'selected'; ?>>Femenino</option>
                <option value="M" <?php if ($alumno['sexo'] == 'M') echo 'selected'; ?>>Masculino</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="anio_ingreso" class="form-label">Año de Ingreso</label>
            <input type="number" class="form-control" id="anio_ingreso" name="anio_ingreso" value="<?php echo $alumno['anio_ingreso']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="domicilio" class="form-label">Domicilio</label>
            <input type="text" class="form-control" id="domicilio" name="domicilio" value="<?php echo $alumno['domicilio']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $alumno['telefono']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario Conectado</label>
            <?php
            $usuario_sql = "SELECT id, usuario FROM usuario WHERE id = ?";
            $usuario_stmt = $conn->prepare($usuario_sql);
            $usuario_stmt->bind_param("i", $alumno['id_usuario']);
            $usuario_stmt->execute();
            $usuario_result = $usuario_stmt->get_result();
            $usuario_data = $usuario_result->fetch_assoc();

            if ($usuario_data) {
                echo '<input type="text" class="form-control" value="' . $usuario_data['usuario'] . '" disabled>';
            } else {
                echo '<select class="form-control" id="id_usuario" name="id_usuario">';
                echo '<option value="">Asignar Usuario</option>';

                $usuarios_sql = "SELECT id, usuario FROM usuario WHERE id NOT IN (SELECT id_usuario FROM alumno WHERE id_usuario IS NOT NULL)";
                $usuarios_result = $conn->query($usuarios_sql);
                while ($row = $usuarios_result->fetch_assoc()) {
                    echo '<option value="' . $row['id'] . '">' . $row['usuario'] . '</option>';
                }
                echo '</select>';
            }
            ?>
        </div>

        <div class="mb-3">
            <label for="archivos" class="form-label">Archivos</label>
            <ul>
                <?php
                $archivos_sql = "SELECT id, nombre_archivo, ruta_archivo FROM archivos WHERE id_alumno = ?";
                $archivos_stmt = $conn->prepare($archivos_sql);
                $archivos_stmt->bind_param("i", $id);
                $archivos_stmt->execute();
                $archivos_result = $archivos_stmt->get_result();

                while ($archivo = $archivos_result->fetch_assoc()) {
                    echo '<li><a href="' . $archivo['ruta_archivo'] . '" download>' . $archivo['nombre_archivo'] . '</a></li>';
                }
                ?>
            </ul>
            <input type="file" class="form-control" id="archivos" name="archivos[]" multiple>
        </div>

        <div class="mb-3">
            <label for="cursos" class="form-label">Asignar Curso</label>
            <select class="form-control" id="cursos" name="cursos[]" multiple>
                <?php
                $sql = "SELECT id, nombre, anio_lectivo FROM curso ORDER BY anio_lectivo DESC, nombre";
                $result = $conn->query($sql);
                $asignados_sql = "SELECT id_curso FROM alumno_curso WHERE id_alumno = ?";
                $asignados_stmt = $conn->prepare($asignados_sql);
                $asignados_stmt->bind_param("i", $id);
                $asignados_stmt->execute();
                $asignados_result = $asignados_stmt->get_result();
                $asignados_cursos = $asignados_result->fetch_all(MYSQLI_ASSOC);
                $asignados_ids = array_column($asignados_cursos, 'id_curso');

                while ($row = $result->fetch_assoc()) {
                    $selected = in_array($row['id'], $asignados_ids) ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['nombre']} ({$row['anio_lectivo']})</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoH7y3HazeAqv7pcpM1wB0mDlB0lr47LNvI6JZG6QADxhM5" crossorigin="anonymous"></script>
</body>
</html>
