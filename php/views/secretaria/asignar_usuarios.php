<!DOCTYPE html>
<html>
<head>
<title>Asignar Usuario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php
include "./navbar_secretaria.php";
include 'autenticacion_secretaria.php';
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

// Consultar los usuarios
$sql_users = "SELECT id, nombre_usuario FROM usuario";
$result_users = $conn->query($sql_users);

// Cerrar la conexión después de ejecutar todas las consultas
$conn->close();
?>


    <h2>Asignar Usuarios</h2>
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
        <select id="person_id" name="person_id" required class="form-control">
            <option value="" disabled selected>Seleccione una persona</option>
        </select>

        <button type="submit" class="btn btn-primary mt-2" >Asignar</button>
    </form>

    <script src = "asignar_usuarios.js"></script>
</body>
</html>