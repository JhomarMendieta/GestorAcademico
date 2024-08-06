<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/display.css">
</head>
<body class='<?php echo "alumnos_none"; ?>'>
    <div id="alumnos">

        <?php
            $anio = $_GET['anio'];
            $query_alumnos = "SELECT alumno.nombres, alumno.apellidos, alumno.dni, alumno_curso.grupo FROM alumno INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno WHERE alumno_curso.id_curso = $anio;";
            $r_query_alumnos = $conn->query($query_alumnos);
            $cont = 0;
            if($r_query_alumnos->fetch_object()){
                ?>
                <div class="tabla_alumnos">
                <p class="ta num"></p>
                <p class="ta grupo">Grupo</p>
                <p class="ta dni">DNI</p>
                <p class="ta nombre">Nombre</p>
                <p class="ta apellido">Apellido</p>
                <?php
                $r_query_alumnos = $conn->query($query_alumnos);
                while($row_a = $r_query_alumnos->fetch_array()){
                    $cont++;
                    ?>
                    <p class="num"><?php echo $cont;?></p>
                    <p class="grupo"><?php echo $row_a['grupo'];?></p>
                    <p class="dni"><?php echo $row_a['dni'];?></p>
                    <p class="nombre"><?php echo $row_a['nombres'];?></p>
                    <p class="apellido"><?php echo $row_a['apellidos'];?></p>
                    <?php
                }
                ?>
                </div>
                <?php
            }
            else{
                ?>
                <style type="css">
                    #alumnos{
                        display: none;
                    }
                </style>
                <div class="sin_alumnos">
                    <p>No hay alumnos cargados</p>
                </div>
                <?php
            }
        ?>
    </div>
</body>
</html>