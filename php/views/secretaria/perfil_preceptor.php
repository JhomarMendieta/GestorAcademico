<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Preceptor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
include "./navbar_secretaria.php";
include 'autenticacion_secretaria.php';
include '../../conn.php'; 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$id = $_GET['id'] ?? null;
$preceptor = null;

if ($id) {
    $sql = "SELECT * FROM preceptores WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $preceptor = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-warning'>Preceptor no encontrado.</div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $nacionalidad = $_POST['nacionalidad'];
    $num_tel = $_POST['num_tel'];
    $num_cel = $_POST['num_cel'];
    $domicilio = $_POST['domicilio'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $mail_institucional = $_POST['mail_institucional'];
    $mail_personal = $_POST['mail_personal'];
    $titulo_que_posee = $_POST['titulo_que_posee'];
    $antiguedad = $_POST['antiguedad'];

    $sql = "UPDATE preceptores SET 
        dni='$dni',
        nombre='$nombre', 
        apellido='$apellido', 
        nacionalidad='$nacionalidad', 
        num_tel='$num_tel', 
        num_cel='$num_cel', 
        domicilio='$domicilio', 
        fecha_nacimiento='$fecha_nacimiento', 
        fecha_ingreso='$fecha_ingreso', 
        mail_institucional='$mail_institucional', 
        mail_personal='$mail_personal', 
        titulo_que_posee='$titulo_que_posee', 
        antiguedad='$antiguedad' 
    WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Datos del preceptor actualizados exitosamente</div>";
        $preceptor = [
            'id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'nacionalidad' => $nacionalidad,
            'num_tel' => $num_tel,
            'num_cel' => $num_cel,
            'domicilio' => $domicilio,
            'fecha_nacimiento' => $fecha_nacimiento,
            'fecha_ingreso' => $fecha_ingreso,
            'mail_institucional' => $mail_institucional,
            'mail_personal' => $mail_personal,
            'titulo_que_posee' => $titulo_que_posee,
            'antiguedad' => $antiguedad
        ];
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign'])) {
    $id_preceptor = $_POST['id_preceptor'];
    $id_curso = $_POST['id_curso'];

    $sql = "INSERT INTO preceptor_curso (id_preceptor, id_curso) VALUES ('$id_preceptor', '$id_curso')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Curso asignado exitosamente</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id_preceptor = $_POST['id_preceptor'];
    $id_curso = $_POST['id_curso'];

    $sql = "DELETE FROM preceptor_curso WHERE id_preceptor='$id_preceptor' AND id_curso='$id_curso'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Curso eliminado exitosamente</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$cursos = [];
$sql = "SELECT * FROM curso";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cursos[] = $row;
    }
}

$preceptorCursos = [];
if ($id) {
    $sql = "SELECT c.* FROM curso c
            JOIN preceptor_curso pc ON c.id = pc.id_curso
            WHERE pc.id_preceptor='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $preceptorCursos[] = $row;
        }
    }
}

$conn->close();
?>

<div class="container">
    <h2>Perfil del Preceptor</h2>
    <?php if ($preceptor): ?>
        <table class="table table-bordered">
        <tr>
                <th>DNI</th>
                <td><?php echo $preceptor['dni']; ?></td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td><?php echo $preceptor['nombre']; ?></td>
            </tr>
            <tr>
                <th>Apellido</th>
                <td><?php echo $preceptor['apellido']; ?></td>
            </tr>
            <tr>
                <th>Nacionalidad</th>
                <td><?php echo $preceptor['nacionalidad']; ?></td>
            </tr>
            <tr>
                <th>Número de Teléfono</th>
                <td><?php echo $preceptor['num_tel']; ?></td>
            </tr>
            <tr>
                <th>Número de Celular</th>
                <td><?php echo $preceptor['num_cel']; ?></td>
            </tr>
            <tr>
                <th>Domicilio</th>
                <td><?php echo $preceptor['domicilio']; ?></td>
            </tr>
            <tr>
                <th>Fecha de Nacimiento</th>
                <td><?php echo $preceptor['fecha_nacimiento']; ?></td>
            </tr>
            <tr>
                <th>Fecha de Ingreso</th>
                <td><?php echo $preceptor['fecha_ingreso']; ?></td>
            </tr>
            <tr>
                <th>Mail Institucional</th>
                <td><?php echo $preceptor['mail_institucional']; ?></td>
            </tr>
            <tr>
                <th>Mail Personal</th>
                <td><?php echo $preceptor['mail_personal']; ?></td>
            </tr>
            <tr>
                <th>Título que Posee</th>
                <td><?php echo $preceptor['titulo_que_posee']; ?></td>
            </tr>
            <tr>
                <th>Antigüedad</th>
                <td><?php echo $preceptor['antiguedad']; ?></td>
            </tr>
        </table>

        <button class="btn btn-primary" onclick="document.getElementById('editForm').style.display='block'">Editar</button>

        <form id="editForm" action="" method="post" style="display:none;">
            <input type="hidden" name="id" value="<?php echo $preceptor['id']; ?>">
            <div class="mb-3">
                <label for="dni" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $preceptor['dni']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $preceptor['nombre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $preceptor['apellido']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nacionalidad" class="form-label">Nacionalidad</label>
                <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" value="<?php echo $preceptor['nacionalidad']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="num_tel" class="form-label">Número de Teléfono</label>
                <input type="text" class="form-control" id="num_tel" name="num_tel" value="<?php echo $preceptor['num_tel']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="num_cel" class="form-label">Número de Celular</label>
                <input type="text" class="form-control" id="num_cel" name="num_cel" value="<?php echo $preceptor['num_cel']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="domicilio" class="form-label">Domicilio</label>
                <input type="text" class="form-control" id="domicilio" name="domicilio" value="<?php echo $preceptor['domicilio']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $preceptor['fecha_nacimiento']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $preceptor['fecha_ingreso']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="mail_institucional" class="form-label">Mail Institucional</label>
                <input type="email" class="form-control" id="mail_institucional" name="mail_institucional" value="<?php echo $preceptor['mail_institucional']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="mail_personal" class="form-label">Mail Personal</label>
                <input type="email" class="form-control" id="mail_personal" name="mail_personal" value="<?php echo $preceptor['mail_personal']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="titulo_que_posee" class="form-label">Título que Posee</label>
                <input type="text" class="form-control" id="titulo_que_posee" name="titulo_que_posee" value="<?php echo $preceptor['titulo_que_posee']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="antiguedad" class="form-label">Antigüedad</label>
                <input type="text" class="form-control" id="antiguedad" name="antiguedad" value="<?php echo $preceptor['antiguedad']; ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Guardar</button>
        </form>

        <h3>Asignar Curso</h3>
        <form action="" method="post">
            <input type="hidden" name="id_preceptor" value="<?php echo $preceptor['id']; ?>">
            <div class="mb-3">
                <label for="anio_lectivo" class="form-label">Año Lectivo</label>
                <select class="form-select" id="anio_lectivo" name="anio_lectivo" onchange="filterCoursesByYear(this.value)" required>
                    <option value="">Seleccione un año lectivo</option>
                    <?php
                    $anioLectivoList = array_unique(array_column($cursos, 'anio_lectivo'));
                    foreach ($anioLectivoList as $anio_lectivo): ?>
                        <option value="<?php echo $anio_lectivo; ?>"><?php echo $anio_lectivo; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="id_curso" class="form-label">Curso</label>
                <select class="form-select" id="id_curso" name="id_curso" required>
                    <option value="">Seleccione un curso</option>
                </select>
            </div>
            <button type="submit" name="assign" class="btn btn-primary">Asignar Curso</button>
        </form>

        <h3>Cursos Asignados</h3>
        <?php if (count($preceptorCursos) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Año</th>
                        <th>División</th>
                        <th>Año Lectivo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($preceptorCursos as $curso): ?>
                        <tr>
                            <td><?php echo $curso['anio']; ?></td>
                            <td><?php echo $curso['division']; ?></td>
                            <td><?php echo $curso['anio_lectivo']; ?></td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="id_preceptor" value="<?php echo $preceptor['id']; ?>">
                                    <input type="hidden" name="id_curso" value="<?php echo $curso['id']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay cursos asignados.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeo5sa1GsBCF9yJp4gyU06G1YLgKpZ1a6wr9kkF706LIKDeQ" crossorigin="anonymous"></script>
<script>
function filterCoursesByYear(anio_lectivo) {
    var cursos = <?php echo json_encode($cursos); ?>;
    var cursoSelect = document.getElementById('id_curso');
    cursoSelect.innerHTML = '<option value="">Seleccione un curso</option>';
    cursos.forEach(function(curso) {
        if (curso.anio_lectivo === anio_lectivo) {
            var option = document.createElement('option');
            option.value = curso.id;
            option.text = curso.anio + ' - ' + curso.division + ' (' + curso.anio_lectivo + ')';
            cursoSelect.add(option);
        }
    });
}
</script>
</body>
</html>
