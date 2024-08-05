<h1 class="text-center p-4">Lista de cursos</h1>
<?php?>
<table class="table">
    <tbody>
        <?php
            $query_cursos = "SELECT curso.id, anio, division, anio_lectivo FROM curso WHERE anio_lectivo = 2024";
            $r_query_cursos = $conn->query($query_cursos);

            while($row = $r_query_cursos->fetch_assoc()){
        ?>
        <tr>
            <td class="td-size-curso px-4"><?php echo $row['anio'], "° ", $row['division'], "°"; ?></td>
            <td class="td-size-curso"><a class="text-decoration-none text-hover btn btn-dark" href="?id_curso=<?php echo $row['id']; ?>">Ver lista de materias</a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php?>