<h1 class="text-center p-4">RITE del curso</h1>
<table class="table">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>DNI</th>
            <th>Calificaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $query_alumnos = "SELECT a.id, a.dni FROM alumno a INNER JOIN alumno_curso ac ON a.id = ac.id_alumno WHERE ac.id_curso = $curso_id;";
            $r_query_alumnos = $conn->query($query_alumnos);
            $cont = 0;
            while($row = $r_query_alumnos->fetch_assoc()){
                $cont++;
                $alumno_id = $row['id'];
        ?>
        <tr>
            <td class="td-size-alumno_curso px-4"><?php echo $cont; ?></td>
            <td><?php echo $row['dni']; ?></td>
            <td>
                <ul>
                    <?php
                        $query_notas = "SELECT calificacion FROM nota WHERE id_alumno = $alumno_id AND id_materia = $materia_id AND instancia = '$instancia'";
                        $r_query_notas = $conn->query($query_notas);
                        while($nota = $r_query_notas->fetch_assoc()){
                            echo "<li>{$nota['calificacion']}</li>";
                        }
                    ?>
                </ul>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
