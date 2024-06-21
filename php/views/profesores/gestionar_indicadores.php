<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../css/profesores/gestionar_indicador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Gestionar indicadores</title>
</head>

<body>
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------- -->
    <?php 
    include "navbar_profesores.php";
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
        $query = "SELECT nota.id, nota.nombre, nota.instancia, materia.nombre AS nombre_materia, curso.anio, curso.division 
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

        <label class="labelForm" for="idncadorForm">Seleccione materia</label>
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
                            <td><?php echo $row['anio'] . '°'; ?></td>
                            <td><?php echo $row['division'] . '°'; ?></td>
                            <td>
                                <button class="btn btn-success button-responsive" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?php echo $row['id']; ?>" data-nombre="<?php echo $row['nombre']; ?>" data-instancia="<?php echo $row['instancia']; ?>">Editar</button>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="nota_id" value="<?php echo $row['id']; ?>">
                                    <button class="btn btn-danger button-responsive" type="submit" name="delete_indicator">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal para editar indicador -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Indicador</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" action="">
                            <input type="hidden" name="nota_id" id="editNotaId">
                            <div class="mb-3">
                                <label for="editNombre" class="form-label">Nombre del Indicador</label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="editInstancia" class="form-label">Instancia</label>
                                <select class="form-select" id="editInstancia" name="instancia" required>
                                    <option value="MAYO">MAYO</option>
                                    <option value="JULIO">JULIO</option>
                                    <option value="SEPTIEMBRE">SEPTIEMBRE</option>
                                    <option value="NOVIEMBRE">NOVIEMBRE</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="edit_indicator">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="../../../js/profesores/gestionar_indicador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
