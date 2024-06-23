<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="gestionar_alumnos.css">
</head>

<body>
    <?php
    include "./navbar_secretaria.php";
    include 'autenticacion_secretaria.php';
    include '../../conn.php';
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    ?>
    <div class="container mt-4">
        <h1>Gestionar Alumnos</h1>
        <!-- Aquí va el formulario de búsqueda -->
        <div class="container mt-4">
            <h1>Gestionar Alumnos</h1>
            <form method="POST" action="gestionar_alumnos.php">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="apellido" class="form-control" placeholder="Buscar por Apellido">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="nombre" class="form-control" placeholder="Buscar por Nombre">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="dni" class="form-control" placeholder="Buscar por DNI">
                    </div>
                    <div class="col-md-3">
                        <select name="anio_lectivo" class="form-control">
                            <option value="">Buscar por Año Lectivo</option>
                            <?php
                            // Consultar años lectivos
                            $sql = "SELECT DISTINCT anio_lectivo FROM curso ORDER BY anio_lectivo DESC";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['anio_lectivo']}'>{$row['anio_lectivo']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
            <hr>
            <!-- Aquí va la tabla de resultados de búsqueda -->
        </div>

        <!-- Aquí va la tabla de resultados de búsqueda -->

        <div class="container mt-4">
            <!-- Código del formulario -->
            <hr>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Año Lectivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $apellido = $_POST['apellido'] ?? '';
                            $nombre = $_POST['nombre'] ?? '';
                            $dni = $_POST['dni'] ?? '';
                            $anio_lectivo = $_POST['anio_lectivo'] ?? '';

                            $sql = "SELECT alumno.id, alumno.apellidos, alumno.nombres, alumno.dni, curso.anio_lectivo 
                            FROM alumno 
                            LEFT JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno 
                            LEFT JOIN curso ON alumno_curso.id_curso = curso.id 
                            WHERE 1=1";

                            if ($apellido) {
                                $sql .= " AND alumno.apellidos LIKE '%$apellido%'";
                            }
                            if ($nombre) {
                                $sql .= " AND alumno.nombres LIKE '%$nombre%'";
                            }
                            if ($dni) {
                                $sql .= " AND alumno.dni = '$dni'";
                            }
                            if ($anio_lectivo) {
                                $sql .= " AND curso.anio_lectivo = '$anio_lectivo'";
                            }

                            $sql .= " ORDER BY alumno.apellidos, alumno.nombres";

                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['apellidos']}</td>";
                                    echo "<td>{$row['nombres']}</td>";
                                    echo "<td>{$row['dni']}</td>";
                                    echo "<td>{$row['anio_lectivo']}</td>";
                                    echo "<td><a href='perfil_alumno.php?id={$row['id']}' class='btn btn-info'>Ver Perfil</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No se encontraron resultados</td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoH7y3HazeAqv7pcpM1wB0mDlB0lr47LNvI6JZG6QADxhM5"
        crossorigin="anonymous"></script>
</body>

</html>