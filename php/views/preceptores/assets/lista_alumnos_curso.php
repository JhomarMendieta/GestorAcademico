<?php
    $query_anio = "SELECT anio, division FROM curso WHERE curso.id = '$curso_id'";
    $r_query_anio = $conn->query($query_anio);
    $curso = $r_query_anio->fetch_assoc();
?>
<h1 class="text-center p-4">Lista de los alumnos del curso <?php echo $curso['anio'], "° ", $curso['division'], "°"; ?></h1>
<?php?>
<table class="table">
    <thead class="table-dark">
        <tr>
            <th scope="col" class="px-4">#</th>
            <th scope="col">DNI</th>
            <th scope="col">Apellido/s</th>
            <th scope="col">Nombre/s</th>
            <th scope="col">Grupo</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $query_alumnos = "SELECT alumno.nombres, alumno.apellidos, alumno.dni, alumno_curso.grupo FROM alumno INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno WHERE alumno_curso.id_curso = $curso_id;";
            $r_query_alumnos = $conn->query($query_alumnos);
            $cont = 0;
            if (isset($r_query_alumnos)){
                while($row = $r_query_alumnos->fetch_assoc()){
                $cont ++;
                ?>
                <tr>
                    <td class="td-size-alumno_curso px-4"><?php echo $cont; ?></td>
                    <td><?php echo $row['dni'];?></td>
                    <td><?php echo $row['apellidos'];?></td>
                    <td><?php echo $row['nombres'];?></td>
                    <td><?php echo $row['grupo'];?></td>
                </tr>
                <?php
            }}
            else{
                echo "NADA";
            }
        ?>
    </tbody>
</table>
<?php?>