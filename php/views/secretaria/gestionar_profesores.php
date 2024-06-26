<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar profesores</title>
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
<div class="container-gestionar-alumnos">
    <div class="container mt-4">
        <!-- Aquí va el formulario de búsqueda -->
        <div class="container mt-4">
            <h1>Gestionar profesores</h1>
            <form method="POST" action="gestionar_profesores.php">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="apellido" class="form-control" placeholder="Buscar por Apellido">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="nombre" class="form-control" placeholder="Buscar por Nombre">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="dni" class="form-control" placeholder="Buscar por DNI">
                    </div>

                <div class="row mt-3">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
                </div>
            </form>
            <hr>
        </div>

        <!-- Aquí va la tabla de resultados de búsqueda -->
        <div class="container mt-4">
            <hr>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT profesores.numLegajo, profesores.prof_apellido, profesores.prof_nombre, profesores.dni 
                                FROM profesores
                                WHERE 1=1";
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $apellido = $_POST['apellido'] ?? '';
                            $nombre = $_POST['nombre'] ?? '';
                            $dni = $_POST['dni'] ?? '';

                            if ($apellido) {
                                $sql .= " AND profesores.prof_apellido LIKE '%$apellido%'";
                            }
                            if ($nombre) {
                                $sql .= " AND profesores.prof_nombre LIKE '%$nombre%'";
                            }
                            if ($dni) {
                                $sql .= " AND profesores.dni = '$dni'";
                            }
                        }

                        $sql .= " ORDER BY profesores.prof_apellido, profesores.prof_nombre";

                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['prof_apellido']}</td>";
                                echo "<td>{$row['prof_nombre']}</td>";
                                echo "<td>{$row['dni']}</td>";
                                echo "<td><a href='perfil_profesor.php?numLegajo={$row['numLegajo']}' class='btn btn-info'>Ver Perfil</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No se encontraron resultados</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoH7y3HazeAqv7pcpM1wB0mDlB0lr47LNvI6JZG6QADxhM5"
        crossorigin="anonymous"></script>
</body>
</html>
