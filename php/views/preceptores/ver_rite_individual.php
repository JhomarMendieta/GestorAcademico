<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RITE del Alumno</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php include("assets/menu.php"); ?>
    <main class="body mt-5">
        <?php
        include("../../conn.php");
        $alumno_id = $_GET['id_alumno'];
        $materia_id = $_GET['id_materia'];
        $instancia = $_GET['instancia'];

        // Consulta para obtener la información del alumno
        $query_alumno = "SELECT nombres, apellidos, dni FROM alumno WHERE id = ?";
        $stmt_alumno = $conn->prepare($query_alumno);
        $stmt_alumno->bind_param("i", $alumno_id);
        $stmt_alumno->execute();
        $result_alumno = $stmt_alumno->get_result();
        $alumno = $result_alumno->fetch_assoc();

        // Consulta para obtener todos los nombres de los indicadores
        $query_todos_indicadores = "SELECT DISTINCT nombre FROM nota WHERE id_materia = ? AND instancia = ?";
        $stmt_todos_indicadores = $conn->prepare($query_todos_indicadores);
        $stmt_todos_indicadores->bind_param("is", $materia_id, $instancia);
        $stmt_todos_indicadores->execute();
        $result_todos_indicadores = $stmt_todos_indicadores->get_result();

        $todos_indicadores = [];
        while ($indicador = $result_todos_indicadores->fetch_assoc()) {
            $todos_indicadores[] = $indicador['nombre'];
        }

        // Consulta para obtener los nombres de los indicadores y sus calificaciones del alumno
        $query_notas = "SELECT nombre, calificacion FROM nota WHERE id_alumno = ? AND id_materia = ? AND instancia = ?";
        $stmt_notas = $conn->prepare($query_notas);
        $stmt_notas->bind_param("iis", $alumno_id, $materia_id, $instancia);
        $stmt_notas->execute();
        $result_notas = $stmt_notas->get_result();

        $indicadores = [];
        while ($nota = $result_notas->fetch_assoc()) {
            $indicadores[$nota['nombre']] = $nota['calificacion'];
        }

        $promedio = 0;
        $cantidad = count($todos_indicadores);
        ?>

        <h2>RITE del Alumno</h2>
        <h3><?php echo $alumno['nombres'] . " " . $alumno['apellidos'] . " (DNI: " . $alumno['dni'] . ")"; ?></h3>

        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Indicador</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($todos_indicadores as $indicador): 
                    $calificacion = isset($indicadores[$indicador]) ? $indicadores[$indicador] : '-';
                    if ($calificacion !== '-') {
                        $promedio += $calificacion;
                    }
                ?>
                    <tr>
                        <td><?php echo $indicador; ?></td>
                        <td><?php echo $calificacion; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Promedio</th>
                    <th><?php echo $cantidad > 0 ? round($promedio / $cantidad, 2) : "-"; ?></th>
                </tr>
                <tr>
                    <th>Estado</th>
                    <th>
                        <?php 
                        if ($cantidad === 0) {
                            echo "-";
                        } else {
                            $promedio_final = round($promedio / $cantidad, 2);
                            if ($promedio_final >= 4) {
                                echo "TEA";
                            } elseif ($promedio_final >= 3) {
                                echo "TEP";
                            } else {
                                echo "TED";
                            }
                        }
                        ?>
                    </th>
                </tr>
            </tfoot>
        </table>
        <a class="btn btn-secondary mt-3" href="javascript:history.back()">Volver</a>
    </main>
</body>
</html>
