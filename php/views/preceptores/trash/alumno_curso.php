<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/alumnos.css">
    <title>Document</title>
</head>

<body>
    <?php
        include("menu.php");
    ?>
    <main class="main">
        <h1>Lista de cursos</h1>
        <div class="cursos">
    <?php
        include "../../conn.php";

        $query_all_curso = "SELECT curso.id, anio, division, anio_lectivo FROM curso";
        $r_query_all_curso = $conn->query($query_all_curso);
        $query_curso = "SELECT curso.id, curso.anio, curso.division, curso.anio_lectivo, alumno_curso.id_alumno, alumno_curso.grupo FROM curso INNER JOIN alumno_curso ON curso.id = alumno_curso.id_curso;";
        $r_query_curso = $conn->query($query_curso);

        while ($row = $r_query_all_curso->fetch_assoc()){
            ?>
            <a href="alumno_curso.php?anio=<?php echo $row['id']; ?>" class="btn-alumnos"><?php echo $row['anio'], "° ", $row['division'], "°";?></a>
            <?php
        }
        ?>
        </div>
        <?php
        if (!empty($_GET['anio'])){
            include "alumnos.php";
        }
    ?>
    </main>
</body>

</html>