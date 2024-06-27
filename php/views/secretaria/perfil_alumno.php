
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Alumno</title>
    <link rel="stylesheet" href="perfil_alumno.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
<?php

include './navbar_secretaria.php';
// include 'autenticacion_secretaria.php';
include '../../conn.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['id'])) {
    echo "No se ha proporcionado ningún ID de alumno.";
    exit();
}

$id = $_GET['id'];

// Obtener datos del alumno
$sql = "SELECT * FROM alumno WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$alumno = $result->fetch_assoc();

if (!$alumno) {
    echo "No se encontró ningún alumno con ese ID.";
    exit();
}

// Obtener cursos
$sql = "SELECT * FROM curso";
$cursos_result = $conn->query($sql);
$cursos = $cursos_result->fetch_all(MYSQLI_ASSOC);

// Obtener cursos asignados al alumno
$sql = "SELECT c.*, ac.grupo FROM curso c 
        JOIN alumno_curso ac ON c.id = ac.id_curso 
        WHERE ac.id_alumno = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$alumnoCursos = $result->fetch_all(MYSQLI_ASSOC);

// Función para verificar si un archivo ha sido subido
function archivoSubido($campo) {
    global $alumno;
    return ($alumno[$campo] !== 'PATH') ? 'Ver archivo' : 'Todavía no se subió.';
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['assign'])) {
        $id_curso = $_POST['id_curso'];
        $grupo = $_POST['grupo'];
        $sql = "INSERT INTO alumno_curso (id_alumno, id_curso, grupo) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $id, $id_curso, $grupo);
        $stmt->execute();
        header("Location: perfil_alumno.php?id=$id");
        exit();
    } elseif (isset($_POST['delete'])) {
        $id_curso = $_POST['id_curso'];
        $sql = "DELETE FROM alumno_curso WHERE id_alumno = ? AND id_curso = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id, $id_curso);
        $stmt->execute();
        header("Location: perfil_alumno.php?id=$id");
        exit();
    }
}

?>
    <div class="container-perfil-alumno">
        <div class="titulo-perfil-alumno">
        <h2>Perfil del alumno <?php echo htmlspecialchars($alumno['nombres']) . " " . htmlspecialchars($alumno['apellidos']); ?> </h2>
        </div>
        <table id="tabla-alumno"  class="table table-striped">
            <tr>
                <th>DNI</th>
                <td><?php echo htmlspecialchars($alumno['dni']); ?></td>
            </tr>
            <tr>
                <th>Legajo</th>
                <td><?php echo htmlspecialchars($alumno['legajo']); ?></td>
            </tr>
            <tr>
                <th>Nombres</th>
                <td><?php echo htmlspecialchars($alumno['nombres']); ?></td>
            </tr>
            <tr>
                <th>Apellidos</th>
                <td><?php echo htmlspecialchars($alumno['apellidos']); ?></td>
            </tr>
            <tr>
                <th>Fecha de Nacimiento</th>
                <td><?php echo htmlspecialchars($alumno['nacimiento']); ?></td>
            </tr>
            <tr>
                <th>Sexo</th>
                <td><?php echo htmlspecialchars($alumno['sexo']); ?></td>
            </tr>
            <tr>    
                <th>Año de Entrada</th>
                <td><?php echo htmlspecialchars($alumno['anio_entrada']); ?></td>
            </tr>
            <tr>
                <th>Dirección</th>
                <td><?php echo htmlspecialchars($alumno['direccion']); ?></td>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td><?php echo htmlspecialchars($alumno['telefono']); ?></td>
            </tr>
            <tr>
            <th>Ficha Médica</th>
                <td>
                    <?php        
                    $fichaMedicaSubida = archivoSubido('ficha_medica');
                    if ($fichaMedicaSubida === 'Ver archivo') {
                        echo '<a href="' . htmlspecialchars($alumno['ficha_medica']) . '" target="_blank">' . $fichaMedicaSubida . '</a>';
                    } else {
                        echo $fichaMedicaSubida;
                    } ?>
                </td>
            </tr>
            <tr>
            <th>Partida de Nacimiento</th>
                <td>
                    <?php                  
                    $partida_nacimientoSubida = archivoSubido('partida_nacimiento');
                    if ($partida_nacimientoSubida === 'Ver archivo') {
                        echo '<a href="' . htmlspecialchars($alumno['partida_nacimiento']) . '" target="_blank">' . $partida_nacimientoSubida . '</a>';
                    } else {
                        echo $partida_nacimientoSubida;
                    } ?>
                </td>
            </tr>
            <tr>
            <th>Certificado de Pase Primaria</th>
                <td>
                    <?php        
                    $certificado_pase_primariaSubida = archivoSubido('certificado_pase_primaria');
                    if ($certificado_pase_primariaSubida === 'Ver archivo') {
                        echo '<a href="' . htmlspecialchars($alumno['certificado_pase_primaria']) . '" target="_blank">' . $certificado_pase_primariaSubida . '</a>';
                    } else {
                        echo $certificado_pase_primariaSubida;
                    } ?>
                </td>
            </tr>
            <tr>
            <th>Certificado de Alumno Regular</th>
                <td>
                    <?php        
                    $certificado_alumno_regularSubida = archivoSubido('certificado_alumno_regular');
                    if ($certificado_alumno_regularSubida === 'Ver archivo') {
                        echo '<a href="' . htmlspecialchars($alumno['certificado_alumno_regular']) . '" target="_blank">' . $certificado_alumno_regularSubida . '</a>';
                    } else {
                        echo $certificado_alumno_regularSubida;
                    } ?>
                </td>
            </tr>
            <tr>
            <th>Fotocopia de DNI</th>
                <td>
                    <?php        
                    $fotocopia_dniSubida = archivoSubido('fotocopia_dni');
                    if ($fotocopia_dniSubida === 'Ver archivo') {
                        echo '<a href="' . htmlspecialchars($alumno['fotocopia_dni']) . '" target="_blank">' . $fotocopia_dniSubida . '</a>';
                    } else {
                        echo $fotocopia_dniSubida;
                    } ?>
                </td>
            </tr>
        </table>
        <button id="boton-editar" class="btn btn-primary" onclick="mostrarFormulario()">Editar</button>

        <div id="formulario-actualizar" style="display:none;">
            <h3>Actualizar Alumno</h3>
            <form action="actualizar_alumno.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($alumno['id']); ?>">
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" value="<?php echo htmlspecialchars($alumno['dni']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="legajo">Legajo</label>
                    <input type="text" class="form-control" id="legajo" name="legajo" value="<?php echo htmlspecialchars($alumno['legajo']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo htmlspecialchars($alumno['nombres']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($alumno['apellidos']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="nacimiento">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="nacimiento" name="nacimiento" value="<?php echo htmlspecialchars($alumno['nacimiento']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select class="form-control" id="sexo" name="sexo" required>
                        <option value="masculino" <?php if ($alumno['sexo'] == 'masculino') echo 'selected'; ?>>Masculino</option>
                        <option value="femenino" <?php if ($alumno['sexo'] == 'femenino') echo 'selected'; ?>>Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="anio_entrada">Año de Entrada</label>
                    <input type="number" class="form-control" id="anio_entrada" name="anio_entrada" value="<?php echo htmlspecialchars($alumno['anio_entrada']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($alumno['direccion']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($alumno['telefono']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="ficha_medica">Ficha Médica</label>
                    <input type="file" class="form-control" id="ficha_medica" name="ficha_medica">
                </div>
                <div class="form-group">
                    <label for="partida_nacimiento">Partida de Nacimiento</label>
                    <input type="file" class="form-control" id="partida_nacimiento" name="partida_nacimiento">
                </div>
                <div class="form-group">
                    <label for="certificado_pase_primaria">Certificado de Pase Primaria</label>
                    <input type="file" class="form-control" id="certificado_pase_primaria" name="certificado_pase_primaria">
                </div>
                <div class="form-group">
                    <label for="certificado_alumno_regular">Certificado de Alumno Regular</label>
                    <input type="file" class="form-control" id="certificado_alumno_regular" name="certificado_alumno_regular">
                </div>
                <div class="form-group">
                    <label for="fotocopia_dni">Fotocopia de DNI</label>
                    <input type="file" class="form-control" id="fotocopia_dni" name="fotocopia_dni">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Guardar</button>
            </form>
        </div>
        
        <div class="asignar-curso">
            <h3>Asignar Curso al Alumno</h3>
            <form method="POST" action="">
    <div class="form-group">
        <label for="anio_lectivo">Año Lectivo</label>
        <select class="form-control" id="anio_lectivo" name="anio_lectivo" onchange="filterCoursesByYear(this.value)" required>
            <option value="">Seleccione un año lectivo</option>
            <?php
            $anioLectivos = array_unique(array_column($cursos, 'anio_lectivo'));
            foreach ($anioLectivos as $anio) {
                echo "<option value=\"$anio\">$anio</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="id_curso">Curso</label>
        <select class="form-control" id="id_curso" name="id_curso" required>
            <option value="">Seleccione un curso</option>
        </select>
    </div>
    <div class="form-group">
        <label for="grupo">Grupo</label>
        <select class="form-control" id="grupo" name="grupo" required>
            <option value="">Seleccione un grupo</option>
            <option value="a">A</option>
            <option value="b">B</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success" name="assign">Asignar Curso</button>
</form>


        </div>

        <div class="cursos-asignados mt-4">
            <h3>Cursos Asignados</h3>
            <?php if (count($alumnoCursos) > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Año</th>
                            <th>División</th>
                            <th>Año Lectivo</th>
                            <th>Grupo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alumnoCursos as $curso): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($curso['anio']); ?></td>
                                <td><?php echo htmlspecialchars($curso['division']); ?></td>
                                <td><?php echo htmlspecialchars($curso['anio_lectivo']); ?></td>
                                <td><?php echo htmlspecialchars($curso['grupo']); ?></td>
                                <td>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="id_curso" value="<?php echo $curso['id']; ?>">
                                        <button type="submit" class="btn btn-danger" name="delete">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay cursos asignados.</p>
            <?php endif; ?>
        </div>
    </div>



    <!-- PASE ESTO DEL HEAD A ACA -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function mostrarFormulario() {
            document.getElementById('formulario-actualizar').style.display = 'block';
            document.getElementById('boton-editar').style.display = 'none';
        }

        function filterCoursesByYear(anio_lectivo) {
            var cursos = <?php echo json_encode($cursos); ?>;
            var cursoSelect = document.getElementById('id_curso');
            cursoSelect.innerHTML = '<option value="">Seleccione un curso</option>';
            cursos.forEach(function(curso) {
                if (curso.anio_lectivo == anio_lectivo) {
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