<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body class='<?php echo "materias_none"; ?>'>
    <div id="a">

        <?php
            $id_curso = $_GET['id_curso'];
            $query_alumnos_materias = "SELECT  FROM materia WHERE id_curso = $id_curso;";
            $r_materias = $conn->query($query_materias);
            if ($r_materias->fetch_object()){
                $r_materias = $conn->query($query_materias);
                while ($row_materia = $r_materias->fetch_array()){
                    ?>
                    <?php
                }
            }else{
                echo "nada";
            }
        ?>
    </div>
</body>
</html>