<!DOCTYPE html>
<html>
<head>
    <title>Asignar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./asignar_usuarios.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php
include "./navbar_secretaria.php";
include "../../conn.php";

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $person_id = $_POST["person_id"];
    $person_type = $_POST["person_type"];
    // Determinar la tabla y campo correctos según el tipo de persona
    switch ($person_type) {
        case "alumno":
            $sql = "UPDATE alumno SET id_usuario = '$user_id' WHERE id = '$person_id'";
            break;
        case "preceptor":
            $sql = "UPDATE preceptores SET id_usuario = '$user_id' WHERE id = '$person_id'";
            break;
        case "profesor":
            $sql = "UPDATE profesores SET id_usuario = '$user_id' WHERE numLegajo = '$person_id'";
            break;
        default:
            echo "Tipo de persona no válido";
            exit();
    }
    if ($conn->query($sql) === TRUE) {
        echo "Asignación exitosa.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Consultar los usuarios que no han sido asignados y excluir 'master' y 'secretario'
$sql_users = "SELECT id, nombre_usuario FROM usuario WHERE rol NOT IN ('master', 'secretario') AND id NOT IN (
    SELECT id_usuario FROM alumno WHERE id_usuario IS NOT NULL
    UNION
    SELECT id_usuario FROM preceptores WHERE id_usuario IS NOT NULL
    UNION
    SELECT id_usuario FROM profesores WHERE id_usuario IS NOT NULL
)";
$result_users = $conn->query($sql_users);
$users_available = $result_users->num_rows > 0;

// Consultar personas sin usuario asignado
$tables = [
    "alumno" => "SELECT id, CONCAT(nombres, ' ', apellidos) AS name FROM alumno WHERE id_usuario IS NULL ORDER BY nombres, apellidos",
    "preceptor" => "SELECT id, CONCAT(nombre, ' ', apellido) AS name FROM preceptores WHERE id_usuario IS NULL ORDER BY nombre, apellido",
    "profesor" => "SELECT numLegajo AS id, CONCAT(prof_nombre, ' ', prof_apellido) AS name FROM profesores WHERE id_usuario IS NULL ORDER BY prof_nombre, prof_apellido"
];

$persons = [];
foreach ($tables as $type => $query) {
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['type'] = $type;
            $persons[] = $row;
        }
    }
}

// Cerrar la conexión después de ejecutar todas las consultas
$conn->close();
?>
<div class="container-asignar">
    <div class="titulo-asignar">
        <h1>Asignar Usuarios</h1>
    </div>
    <?php if ($users_available && !empty($persons)) { ?>
        <form method="POST" action="asignar_usuarios.php">
            <label for="user_id">Usuario:</label>
            <select id="user_id" name="user_id" required class="form-control">
                <option value="" disabled selected>Seleccione un usuario</option>
                <?php while($row = $result_users->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre_usuario']; ?></option>
                <?php } ?>
            </select>
            <label for="person_type">Tipo de Persona:</label>
            <select id="person_type" name="person_type" required class="form-control">
                <option value="">Seleccione un tipo</option>
                <option value="alumno">Alumno</option>
                <option value="preceptor">Preceptor</option>
                <option value="profesor">Profesor</option>
            </select>
            <label for="person_id">Persona:</label>
            <select id="person_id" name="person_id" required class="form-control mb-2" disabled>
                <option value="" disabled selected>Seleccione una persona</option>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Asignar</button>
        </form>
    <?php } ?>
    <?php if (!$users_available) { ?>
        <div class="alert alert-warning mt-2" role="alert">
            Todos los usuarios ya han sido asignados, registre un nuevo usuario.
        </div>
    <?php } ?>
    <div id="personTable" class="mt-2">
        <?php if (!empty($persons)) { ?>
            <h3>Personas sin usuario:</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($persons as $person) { ?>
                        <tr>
                            <td><?php echo ucfirst($person['type']); ?></td>
                            <td><?php echo $person['name']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-info" role="alert">
                No hay personas sin usuario asignado.
            </div>
        <?php } ?>
    </div>

</div>
<script src="asignar_usuarios.js"></script>
<script>
</script>
</body>
</html>
