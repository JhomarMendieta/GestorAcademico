<div id="materias">
    <?php
        $id_curso = $_GET['id_curso'];
        $query_materias = "SELECT materia.nombre, materia.id FROM materia WHERE id_curso = $id_curso;";
        $r_materias = $conn->query($query_materias);
        if ($r_materias->fetch_object()){
            $r_materias = $conn->query($query_materias);
            while ($row_materia = $r_materias->fetch_array()){
                ?>
                <a href="registrar_asistencia.php?id_curso=<?php echo $id_curso;?>&id_materia=<?php echo $row_materia['id'];?>"><?php echo $row_materia['nombre'];?></a>
                <?php
            }
        }else{
            echo "nada";
        }
    ?>
</div>