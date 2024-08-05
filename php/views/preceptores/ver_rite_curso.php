<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RITE del Curso</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php include("assets/menu.php"); ?>
    <main class="body mt-5">
        <?php
        include("../../conn.php");
        $curso_id = $_GET['id_curso'];
        $materia_id = $_GET['id_materia'];
        $instancia = $_GET['instancia'];

        // Consulta para obtener los alumnos del curso
        $query_alumnos = "SELECT a.id, a.dni, a.apellidos, a.nombres 
                          FROM alumno a 
                          INNER JOIN alumno_curso ac ON a.id = ac.id_alumno 
                          WHERE ac.id_curso = ?";
        $stmt_alumnos = $conn->prepare($query_alumnos);
        $stmt_alumnos->bind_param("i", $curso_id);
        $stmt_alumnos->execute();
        $result_alumnos = $stmt_alumnos->get_result();

        // Consulta para obtener los nombres de los indicadores
        $query_indicadores = "SELECT DISTINCT n.nombre 
                              FROM nota n 
                              WHERE n.id_materia = ? AND n.instancia = ?";
        $stmt_indicadores = $conn->prepare($query_indicadores);
        $stmt_indicadores->bind_param("is", $materia_id, $instancia);
        $stmt_indicadores->execute();
        $result_indicadores = $stmt_indicadores->get_result();

        $indicadores = [];
        while ($row = $result_indicadores->fetch_assoc()) {
            $indicadores[] = $row['nombre'];
        }
        ?>

        <h2>RITE del Curso</h2>
        <?php if ($result_alumnos->num_rows > 0): ?>
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>DNI</th>
                        <?php foreach ($indicadores as $indicador): ?>
                            <th><?php echo $indicador; ?></th>
                        <?php endforeach; ?>
                        <th>Promedio</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $cont = 0;
                    $hayNotas = false;
                    while ($row = $result_alumnos->fetch_assoc()): 
                        $cont++;
                        $alumno_id = $row['id'];

                        // Consulta para obtener las notas del alumno en la materia del curso para la instancia seleccionada
                        $query_notas = "SELECT n.nombre, n.calificacion 
                                        FROM nota n 
                                        WHERE n.id_alumno = ? AND n.id_materia = ? AND n.instancia = ?";
                        $stmt_notas = $conn->prepare($query_notas);
                        $stmt_notas->bind_param("iis", $alumno_id, $materia_id, $instancia);
                        $stmt_notas->execute();
                        $result_notas = $stmt_notas->get_result();

                        $notas = [];
                        while ($nota = $result_notas->fetch_assoc()) {
                            $notas[$nota['nombre']] = $nota['calificacion'];
                            $hayNotas = true;
                        }

                        $promedio = 0;
                        $cantidad = count($indicadores);
                    ?>
                        <tr>
                            <td><?php echo $cont; ?></td>
                            <td><?php echo $row['dni']; ?></td>
                            <?php foreach ($indicadores as $indicador): ?>
                                <td>
                                    <?php 
                                    if (isset($notas[$indicador])) {
                                        echo $notas[$indicador];
                                        $promedio += $notas[$indicador];
                                    } else {
                                        echo "-";
                                        $cantidad--;
                                    }
                                    ?>
                                </td>
                            <?php endforeach; ?>
                            <?php 
                            $promedio_final = $cantidad > 0 ? round($promedio / $cantidad, 2) : "-";
                            ?>
                            <td><?php echo $promedio_final; ?></td>
                            <td>
                                <?php 
                                if ($promedio_final === "-") {
                                    echo "-";
                                } elseif ($promedio_final >= 4) {
                                    echo "TEA";
                                } elseif ($promedio_final >= 3) {
                                    echo "TEP";
                                } else {
                                    echo "TED";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php if (!$hayNotas): ?>
                <p>Aún no se subió ninguna nota para la instancia seleccionada.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>No se encontraron alumnos en el curso seleccionado.</p>
        <?php endif; ?>
        <a class="btn btn-secondary mt-3" href="javascript:history.back()">Volver</a>
    </main>
</body>
</html>
