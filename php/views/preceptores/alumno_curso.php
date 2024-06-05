<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <link rel="stylesheet" href="css/navStyle.css">
    <title>Document</title>
</head>

<body>
    <header class="header">
        <input type="checkbox" name="navlateral" id="navlateral">
        <nav class="navbar">
            <div class="logo">
                <img src="../../../img/LogoEESTN1.png" alt="Logo de la EEST 1">
                <label for="navlateral">
                    <div class="lineas">
                        <div class="linea l1"></div>
                        <div class="linea l2"></div>
                        <div class="linea l3"></div>
                    </div>

                </label>
            </div>
            <h2>INICIO</h2>
            <div class="usuario">
                <p class="tipo_usuario">Preceptor</p>
                <div class="icon">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </nav>
        <label for="navlateral" class="gris"></label>
        <nav class="navlateral">
            <div class="logo">
                <img src="../../../img/LogoEESTN1.png" alt="">
                <label for="navlateral" class="cruz">
                    <div class="linea l1"></div>
                    <div class="linea l2"></div>
                </label>
            </div>
            <div class="opciones">
                <p class="principal">Alumnos</p>
                <p></p>
                <p></p>
                <p class="principal">Profesores</p>
                <p></p>
                <p></p>
                <p class="principal">Materias</p>
                <p></p>
                <p></p>
            </div>
        </nav>
    </header>
    <?php
        include "../../conn.php";
        $query_alumnos = "SELECT alumno.nombres, alumno.apellidos alumno_curso.id_curso FROM alumno INNER JOIN alumno_curso ON alumno.id = ;";
        $r_query_alumnos = $conn->query($query_alumnos);
        while ($row = $r_query_alumnos->fetch_assoc()){
            $query_curso = "SELECT alumno"
            ?>
            <p>Nombre: <?php echo $row['nombres'];?></p>+
            <p></p>
            <?php
        }
    ?>

</body>

</html>