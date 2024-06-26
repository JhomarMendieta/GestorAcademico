<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/profesores/actualizar_rite.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="../../../js/profesores/actualizar_rite.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <title>Actualizar RITEs</title>
</head>

<body>
    <?php
    include "./components/navbar_profesores.php";
    include '../../conn.php';
    include 'autenticacion_profesor.php';
    ?>
    <div class="container-update">

        <div class="titulo-update">
            <h1>Actualizar RITE</h1>
        </div>

        <?php
        // Obtener el id del profesor basado en el id del usuario
        $query = "SELECT numLegajo FROM profesores WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($profesorId);
        $stmt->fetch();
        $stmt->close();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
            $materiaId = $_POST['materia_id'];
            $alumnoId = $_POST['alumno_id'];

            if ($_POST['save'] == 'add') {
                $nombre = $_POST['nombre'];
                $calificacion = $_POST['calificacion'];
                $instancia = $_POST['instancia'];

                // Insertar nueva nota
                $query = "INSERT INTO nota (nombre, calificacion, instancia, id_materia, id_alumno) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssii", $nombre, $calificacion, $instancia, $materiaId, $alumnoId);
                $stmt->execute();
                $stmt->close();
            } elseif ($_POST['save'] == 'edit') {
                $notaId = $_POST['nota_id'];
                $nombre = $_POST['nombre'];
                $calificacion = $_POST['calificacion'];
                $instancia = $_POST['instancia'];

                // Actualizar nota existente
                $query = "UPDATE nota SET nombre = ?, calificacion = ?, instancia = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssi", $nombre, $calificacion, $instancia, $notaId);
                $stmt->execute();
                $stmt->close();
            } elseif ($_POST['save'] == 'delete') {
                $notaId = $_POST['nota_id'];

                // Eliminar nota
                $query = "DELETE FROM nota WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $notaId);
                $stmt->execute();
                $stmt->close();
            }

            // PROBANDO ---------------------------------------------





            $conditions_sql = "
    SELECT 
        m.id AS id_materia,
        CASE 
            WHEN AVG(CASE WHEN n.instancia = 'JULIO' THEN n.calificacion ELSE NULL END) < 3 THEN 'TED'
            WHEN AVG(CASE WHEN n.instancia = 'JULIO' THEN n.calificacion ELSE NULL END) < 4 THEN 'TEP'
            WHEN AVG(CASE WHEN n.instancia = 'JULIO' THEN n.calificacion ELSE NULL END) >= 4 THEN 'TEA'
        END AS condicion_julio,
        CASE 
            WHEN AVG(CASE WHEN n.instancia IN ('SEPTIEMBRE', 'NOVIEMBRE') THEN n.calificacion ELSE NULL END) < 3 THEN 'TED'
            WHEN AVG(CASE WHEN n.instancia IN ('SEPTIEMBRE', 'NOVIEMBRE') THEN n.calificacion ELSE NULL END) < 4 THEN 'TEP'
            WHEN AVG(CASE WHEN n.instancia IN ('SEPTIEMBRE', 'NOVIEMBRE') THEN n.calificacion ELSE NULL END) >= 4 THEN 'TEA'
        END AS condicion_septiembre_noviembre
    FROM 
        alumno a
    JOIN 
        alumno_curso ac ON a.id = ac.id_alumno
    JOIN 
        curso c ON ac.id_curso = c.id
    JOIN 
        materia m ON m.id_curso = c.id
    JOIN 
        nota n ON n.id_alumno = a.id AND n.id_materia = m.id
    WHERE 
        a.id = ?
    GROUP BY 
        a.id, m.id
";

$conditions_stmt = $conn->prepare($conditions_sql);
$conditions_stmt->bind_param("i", $alumnoId);
$conditions_stmt->execute();
$conditions_result = $conditions_stmt->get_result();

if ($conditions_result) {
    while ($row = $conditions_result->fetch_assoc()) {
        $condicion_julio = $row['condicion_julio'];
        $condicion_septiembre_noviembre = $row['condicion_septiembre_noviembre'];

        // Determinar la condición final más baja
        $condicion_final = $condicion_julio;
        if ($condicion_septiembre_noviembre == 'TED' || ($condicion_septiembre_noviembre == 'TEP' && $condicion_final != 'TED') || ($condicion_septiembre_noviembre == 'TEA' && $condicion_final == 'TEA')) {
            $condicion_final = $condicion_septiembre_noviembre;
        }

        // Verificar si hay calificación en mesa que cambie la condición a TEA
        $mesa_sql = "
            SELECT 
                am.calificacion 
            FROM 
                mesa m
            JOIN 
                alumno_mesa am ON m.id = am.id_mesa
            JOIN
                materia_mesa mm ON m.id = mm.id_mesa
            WHERE 
                am.id_alumno = ? 
                AND mm.id_materia = ? 
                AND am.calificacion >= 4
        ";
        $mesa_stmt = $conn->prepare($mesa_sql);
        $mesa_stmt->bind_param("ii", $alumnoId, $materiaId);
        $mesa_stmt->execute();
        $mesa_result = $mesa_stmt->get_result();
        if ($mesa_result && $mesa_result->num_rows > 0) {
            $condicion_final = 'TEA';
        }
        $mesa_stmt->close();

        // Comprobar si ya existe una entrada en la tabla 'condicion'
        $check_sql = "SELECT * FROM condicion WHERE id_alumno = ? AND id_materia = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $alumnoId, $materiaId);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result && $check_result->num_rows > 0) {
            // Si existe, actualizar la condición
            $update_sql = "UPDATE condicion SET condicion = ? WHERE id_alumno = ? AND id_materia = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("sii", $condicion_final, $alumnoId, $materiaId);
            $update_stmt->execute();
            $update_stmt->close();
        } else {
            // Si no existe, insertar una nueva entrada
            $insert_sql = "INSERT INTO condicion (id_alumno, id_materia, condicion) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iis", $alumnoId, $materiaId, $condicion_final);
            $insert_stmt->execute();
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
    $conditions_stmt->close();
}





            //----------------------------------


        }

        // Obtener las materias que enseña el profesor
        $query = "SELECT materia.id, materia.nombre FROM profesor_materia
          INNER JOIN materia ON profesor_materia.id_materia = materia.id
          WHERE profesor_materia.id_profesor = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $profesorId);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <div class="select-materia">
            <form id="materiaForm" method="POST" action="">
                <select name="materia_id" class='form-select' required onchange="this.form.submit()">
                    <option value="" disabled selected>Seleccione una Materia</option>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                    <?php endwhile; ?>
                </select>
            </form>
        </div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['materia_id'])) {
            $materiaId = $_POST['materia_id'];
            $instancia = isset($_POST['instancia']) ? $_POST['instancia'] : '';

            $query = "SELECT alumno.id, alumno.nombres, alumno.apellidos FROM alumno
              INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno
              INNER JOIN curso ON alumno_curso.id_curso = curso.id
              INNER JOIN materia ON curso.id = materia.id_curso
              WHERE materia.id = ?
              ORDER BY alumno.apellidos ASC, alumno.nombres ASC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $materiaId);
            $stmt->execute();
            $result = $stmt->get_result();

            $queryMateria = "SELECT nombre FROM materia WHERE id = ?";
            $stmtMateria = $conn->prepare($queryMateria);
            $stmtMateria->bind_param("i", $materiaId);
            $stmtMateria->execute();
            $stmtMateria->bind_result($nombreMateria);
            $stmtMateria->fetch();
            $stmtMateria->close();

            echo /*html*/ "<div class = 'instancia-form'>
            <p>Materia: {$nombreMateria}</p>
            <form id='instanciaForm' method='POST' action=''>
                <input type='hidden' name='materia_id' value='{$materiaId}'>
                <select name='instancia' class='form-select' required onchange='this.form.submit()'>
                    <option value='' disabled selected>Seleccione una Instancia</option>
                    <option value='MAYO'" . ($instancia == 'MAYO' ? ' selected' : '') . ">MAYO</option>
                    <option value='JULIO'" . ($instancia == 'JULIO' ? ' selected' : '') . ">JULIO</option>
                    <option value='SEPTIEMBRE'" . ($instancia == 'SEPTIEMBRE' ? ' selected' : '') . ">SEPTIEMBRE</option>
                    <option value='NOVIEMBRE'" . ($instancia == 'NOVIEMBRE' ? ' selected' : '') . ">NOVIEMBRE</option>
                </select>
            </form>";
        }
        ?>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['instancia']) && isset($_POST['materia_id'])) {
            $materiaId = $_POST['materia_id'];
            $instancia = $_POST['instancia'];

            $query = "SELECT alumno.id, alumno.nombres, alumno.apellidos FROM alumno
              INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno
              INNER JOIN curso ON alumno_curso.id_curso = curso.id
              INNER JOIN materia ON curso.id = materia.id_curso
              WHERE materia.id = ?
              ORDER BY alumno.apellidos ASC, alumno.nombres ASC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $materiaId);
            $stmt->execute();
            $result = $stmt->get_result();

            $queryMateria = "SELECT nombre FROM materia WHERE id = ?";
            $stmtMateria = $conn->prepare($queryMateria);
            $stmtMateria->bind_param("i", $materiaId);
            $stmtMateria->execute();
            $stmtMateria->bind_result($nombreMateria);
            $stmtMateria->fetch();
            $stmtMateria->close();

            echo /*html*/ "<p>Materia {$nombreMateria} - Instancia {$instancia}</p>
            <form id='alumnoForm' method='POST' action=''>
                <input type='hidden' name='materia_id' value='{$materiaId}'>
                <input type='hidden' name='instancia' value='{$instancia}'>
                <select name='alumno_id' class='form-select' required onchange='this.form.submit()'>
                    <option value='' disabled selected>Seleccione un Alumno</option>";

            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['apellidos']} {$row['nombres']}</option>";
            }
            echo /*html*/ "</select></form></div>";
        }
        ?>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['alumno_id']) && isset($_POST['instancia']) && isset($_POST['materia_id'])) {
            $materiaId = $_POST['materia_id'];
            $alumnoId = $_POST['alumno_id'];
            $instancia = $_POST['instancia'];

            $queryAlumno = "SELECT nombres, apellidos FROM alumno WHERE id = ?";
            $stmtAlumno = $conn->prepare($queryAlumno);
            $stmtAlumno->bind_param("i", $alumnoId);
            $stmtAlumno->execute();
            $stmtAlumno->bind_result($nombreAlumno, $apellidoAlumno);
            $stmtAlumno->fetch();
            $stmtAlumno->close();

            $queryNombres = "SELECT DISTINCT nombre FROM nota WHERE id_materia = ? AND instancia = ? AND calificacion IS NULL AND id_alumno IS NULL";
            $stmtNombres = $conn->prepare($queryNombres);
            $stmtNombres->bind_param("is", $materiaId, $instancia);
            $stmtNombres->execute();
            $resultNombres = $stmtNombres->get_result();
            $nombres = [];
            while ($nombreRow = $resultNombres->fetch_assoc()) {
                $nombres[] = $nombreRow['nombre'];
            }

            $queryNotas = "SELECT id, nombre, calificacion, instancia FROM nota WHERE id_alumno = ? AND id_materia = ? AND instancia = ?";
            $stmtNotas = $conn->prepare($queryNotas);
            $stmtNotas->bind_param("iis", $alumnoId, $materiaId, $instancia);
            $stmtNotas->execute();
            $resultNotas = $stmtNotas->get_result();


            




        ?>

            <h5>Notas de <?php echo "{$apellidoAlumno} {$nombreAlumno}"; ?> en la Materia <?php echo $nombreMateria; ?> - Instancia <?php echo $instancia; ?></h5>
            <div class="table-responsive">
                <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Calificación</th>
                            <th>Instancia</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultNotas->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><?php echo $row['calificacion']; ?></td>
                                <td><?php echo $row['instancia']; ?></td>
                                <td>
                                    <form method="POST" action="" class="d-inline-block">
                                        <input type="hidden" name="nota_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="materia_id" value="<?php echo $materiaId; ?>">
                                        <input type="hidden" name="alumno_id" value="<?php echo $alumnoId; ?>">
                                        <input type="hidden" name="instancia" value="<?php echo $instancia; ?>">
                                        <button class="btn btn-primary " type="button" onclick="editNota(<?php echo $row['id']; ?>, '<?php echo $row['nombre']; ?>', '<?php echo $row['calificacion']; ?>', '<?php echo $row['instancia']; ?>')">Editar</button>
                                        <button class="btn btn-danger " type="submit" name="save" value="delete">Eliminar</button>

                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <h3 id="formTitle">Subir Nota </h3><a href="gestionar_indicador.php">Agregue indicadores</a>
            <form id="notaForm" method="POST" action="">
                <input type="hidden" name="materia_id" value="<?php echo $materiaId; ?>">
                <input type="hidden" name="alumno_id" value="<?php echo $alumnoId; ?>">
                <input type="hidden" name="instancia" value="<?php echo $instancia; ?>">
                <input type="hidden" name="nota_id" id="nota_id" value="">
                <div class="form-group">
                    <label for="nombre">Indicador</label>
                    <select id="nombre" name="nombre" class="form-select" required>
                        <option value="" disabled selected>Seleccione un indicador</option>
                        <?php foreach ($nombres as $nombre) : ?>
                            <option value="<?php echo $nombre; ?>"><?php echo $nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="calificacion">Calificación</label>
                    <input type="text" id="calificacion" name="calificacion" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="instancia">Instancia</label>
                    <input type="text" id="instancia" name="instancia" class="form-control" value="<?php echo $instancia; ?>" readonly>
                </div>
                <button class="btn btn-success mt-2" type="submit" name="save" value="add" id="saveButton">Guardar</button>
            </form>

        <?php
        }

        ?>
    </div>
</body>

</html>