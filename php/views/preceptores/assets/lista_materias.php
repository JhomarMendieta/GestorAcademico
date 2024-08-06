<h1 class="text-center p-4">Lista de materias</h1>
<table class="table">
    <tbody>
        <?php
            $query_materias = "SELECT id, nombre FROM materia WHERE id_curso = $curso_id";
            $r_query_materias = $conn->query($query_materias);

            while($row = $r_query_materias->fetch_assoc()){
        ?>
        <tr>
            <td class="td-size-curso px-4"><?php echo $row['nombre']; ?></td>
            <td class="td-size-curso"><a class="text-decoration-none text-hover btn btn-dark" href="?id_curso=<?php echo $curso_id; ?>&id_materia=<?php echo $row['id']; ?>">Ver instancias</a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
