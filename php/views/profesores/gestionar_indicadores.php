<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../css/profesores/gestionar_indicador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="../../../js/profesores/gestionar_indicador.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <title>Gestionar indicadores</title>
</head>

<body>
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------- -->
    <?php
    include "./components/navbar_profesores.php";
    include '../../conn.php';
    include 'autenticacion_profesor.php';
    ?>
    <div class="container-indicador">
        <?php
        // Obtener el id del profesor basado en el id del usuario
        $query = "SELECT numLegajo FROM profesores WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($profesorId);
        $stmt->fetch();
        $stmt->close();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['add_indicator'])) {
                $materiaId = $_POST['materia_id'];
                $nombre = $_POST['nombre'];
                $instancia = $_POST['instancia'];

                // Insertar nombre de indicador predeterminado
                $query = "INSERT INTO nota (nombre, instancia, id_materia) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssi", $nombre, $instancia, $materiaId);
                $stmt->execute();
                $stmt->close();
            } elseif (isset($_POST['edit_indicator'])) {
                $notaId = $_POST['nota_id'];
                $nombre = $_POST['nombre'];
                $instancia = $_POST['instancia'];

                // Actualizar nombre de indicador predeterminado
                $query = "UPDATE nota SET nombre = ?, instancia = ? WHERE id = ?";
                $stmt = $conn->prepare($query); // Cambiar aquí a $stmt
                $stmt->bind_param("ssi", $nombre, $instancia, $notaId);
                $stmt->execute();
                $stmt->close();
            } elseif (isset($_POST['delete_indicator'])) {
                $notaId = $_POST['nota_id'];

                // Eliminar nombre de indicador predeterminado
                $query = "DELETE FROM nota WHERE id = ?";
                $stmt = $conn->prepare($query); // Cambiar aquí a $stmt
                $stmt->bind_param("i", $notaId);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Obtener las materias que enseña el profesor
        $query = "SELECT materia.id, materia.nombre, curso.anio, curso.division FROM profesor_materia
          INNER JOIN materia ON profesor_materia.id_materia = materia.id
          INNER JOIN curso ON materia.id_curso = curso.id
          WHERE profesor_materia.id_profesor = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $profesorId);
        $stmt->execute();
        $materias = $stmt->get_result();
        $stmt->close();

        // Obtener el filtro de materia seleccionado, si existe
        $materiaFilter = isset($_GET['materia_id']) ? $_GET['materia_id'] : '';

        // Obtener todos los nombres de notas e instancias filtrados por materia si se selecciona un filtro
        $query = "SELECT nota.id, nota.nombre, nota.instancia, materia.nombre AS nombre_materia, curso.anio, curso.division,
          IF(TIMESTAMPDIFF(HOUR, nota.fecha_creacion, NOW()) > 48, TRUE, FALSE) AS ha_pasado_48hs
          FROM nota
          INNER JOIN materia ON nota.id_materia = materia.id
          INNER JOIN curso ON materia.id_curso = curso.id
          WHERE nota.id_materia IN (SELECT id_materia FROM profesor_materia WHERE id_profesor = ?)";
        if ($materiaFilter) {
            $query .= " AND nota.id_materia = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $profesorId, $materiaFilter);
        } else {
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $profesorId);
        }
        $stmt->execute();
        $nombresNotas = $stmt->get_result();
        $stmt->close();
        ?>
        <div class="titulo-indicador">
            <h1>Gestionar indicadores</h1>
        </div>

        <label class="labelForm" for="idncadorForm"> Seleccione materia</label>
        <form id="indicatorForm" method="POST" action="">
            <select class='form-select' name="materia_id" required>
                <option value="" disabled selected>Seleccione una Materia</option>
                <?php while ($row = $materias->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                <?php endwhile; ?>
            </select>

            <label class="labelNombre" for="nombre">Nombre del Indicador:</label>
            <div class="input-group">
                <input class="form-control" type="text" name="nombre" required>
            </div>

            <label class="labelForm" for="instancia">Instancia:</label>
            <select class='form-select' name="instancia" required>
                <option value="" disabled selected>Seleccione una Instancia</option>
                <option value="MAYO">MAYO</option>
                <option value="JULIO">JULIO</option>
                <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                <option value="NOVIEMBRE">NOVIEMBRE</option>
            </select>

            <button class="btn btn-primary mt-2 mb-2" type="submit" name="add_indicator">Agregar Indicador</button>
        </form>

        <h2>Filtrar indicadores por materia</h2>
        <form method="GET" action="">
            <select class='form-select' name="materia_id" onchange="this.form.submit()">
                <option value="">Todas las Materias</option>
                <?php
                $materias->data_seek(0);
                while ($row = $materias->fetch_assoc()) : ?>
                    <option value="<?php echo $row['id']; ?>" <?php if ($materiaFilter == $row['id']) echo 'selected'; ?>><?php echo $row['nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </form>

        <h2>Indicadores</h2>
        <div class="table-responsive">
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Instancia</th>
                        <th>Materia</th>
                        <th>Año</th>
                        <th>División</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $nombresNotas->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['instancia']; ?></td>
                            <td><?php echo $row['nombre_materia']; ?></td>
                            <td><?php echo $row['anio'] . '°';  ?></td>
                            <td><?php echo $row['division'] . '°'; ?></td>
                            <!-- <td>
                                <?php if (!$row['ha_pasado_48hs']) : ?>
                                    <button class="btn btn-success w-45 button-responsive2" onclick="showForm('form-edit-<?php echo $row['id']; ?>')">
                                        Editar
                                    </button>
                                    <button class="btn btn-danger button-responsive" onclick="showForm('form-delete-<?php echo $row['id']; ?>')">
                                        Borrar
                                    </button>
                                <?php else : ?>
                                    <button class="btn btn-secondary" disabled>No editable</button>
                                <?php endif; ?>
                            </td> -->
                            <td>
                                <button class="btn btn-success w-45 button-responsive2" onclick="showForm('form-edit-<?php echo $row['id']; ?>')" <?php if ($row['ha_pasado_48hs']) echo 'disabled'; ?>>
                                    Editar
                                </button>
                                <button class="btn btn-danger button-responsive" onclick="showForm('form-delete-<?php echo $row['id']; ?>')" <?php if ($row['ha_pasado_48hs']) echo 'disabled'; ?>>
                                    Borrar
                                </button>
                            </td>
                        </tr>
                        <?php if (!$row['ha_pasado_48hs']) : ?>
                            <!-- Formulario para editar -->
                            <tr id="form-edit-<?php echo $row['id']; ?>" class="form-container" style="display:none;">
                                <td colspan="6">
                                    <form method="POST" action="">
                                        <input type="hidden" name="nota_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="materia_id" value='<?php echo $row['id_materia']; ?>'>
                                        <input type="hidden" name="edit_indicator" value="edit">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required>
                                        <label for="instancia">Instancia:</label>
                                        <select name="instancia" required>
                                            <option value="" disabled selected>Seleccione una Instancia</option>
                                            <option value="MAYO" <?php if ($row['instancia'] == 'MAYO') echo 'selected'; ?>>MAYO</option>
                                            <option value="JULIO" <?php if ($row['instancia'] == 'JULIO') echo 'selected'; ?>>JULIO</option>
                                            <option value="SEPTIEMBRE" <?php if ($row['instancia'] == 'SEPTIEMBRE') echo 'selected'; ?>>SEPTIEMBRE</option>
                                            <option value="NOVIEMBRE" <?php if ($row['instancia'] == 'NOVIEMBRE') echo 'selected'; ?>>NOVIEMBRE</option>
                                        </select>
                                        <button class="btn btn-primary" type="submit">Actualizar</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Formulario para borrar -->
                            <tr id="form-delete-<?php echo $row['id']; ?>" class="form-container" style="display:none;">
                                <td colspan="6">
                                    <form method="POST" action="">
                                        <input type="hidden" name="nota_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="delete_indicator" value="delete">
                                        <p>¿Está seguro de que desea eliminar este indicador?</p>
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                        <button class="btn btn-primary" type="button" onclick="hideForm('form-delete-<?php echo $row['id']; ?>')">Cancelar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>