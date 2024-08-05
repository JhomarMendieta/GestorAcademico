<?php
// Configuración de la conexión a la base de datos
include "../../conn.php";

$curso_id = $_GET['id_curso'];
$materia_id = $_GET['id_materia'];
// Obtener la lista de alumnos
$sql = "SELECT alumno.id, alumno.nombres, alumno.apellidos 
        FROM alumno INNER JOIN alumno_curso 
        ON alumno.id = alumno_curso.id_alumno 
        INNER JOIN curso ON curso.id = alumno_curso.id_curso 
        WHERE curso.id = $curso_id;";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Asistencia</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <style>
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <?php include "menu.php";?>
    <h1>Lista de Alumnos</h1>
    <form action="resultado_r_asistencia.php" method="post">
    <input type="text" style="display:none" name="curso_id" value="<?php echo $curso_id?>">
    <input type="text" style="display:none" name="materia_id" value="<?php echo $materia_id?>">
    <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Asistencia</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $num = 0;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $num += 1;
                        echo "<tr>
                            <td>$num</td>
                            <td>{$row['nombres']}</td>
                            <td>{$row['apellidos']}</td>
                            <td>
                                <select name='asistencia[{$row['id']}]'>
                                    <option value='presente'>Presente</option>
                                    <option value='ausente'>Ausente</option>
                                    <option value='tarde'>Tarde</option>
                                    <option value='ausente con presencia'>Ausente con Presencia</option>
                                    <option value='retiro anticipado'>Retiro Anticipado</option>
                                </select>
                            </td>
                            <td><input type='text' name='observacion[{$row['id']}]'></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No hay alumnos</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <input type="hidden" name="fecha" value="<?php echo date('Y-m-d'); ?>">
        <input type="submit" value="Registrar Asistencia">
    </form>
</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>
