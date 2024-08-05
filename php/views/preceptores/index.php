<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <?php
        include("assets/menu.php");
    ?>
    <main class="body mt-5">
        <div class="titulo-menu">
            <h1 class="text-center p-4">Menú</h1>
        </div>
        <div class="main-container container-index">
            <div class="column items-index">
                <img src="../../../img/alumno.jpeg" alt="">
                <a href="alumnos.php?id_curso=0" class="btn btn-secondary">Ver Alumnos en curso</a>
            </div>
            <div class="column items-index">
                <img src="../../../img/materias.jpeg" alt="">
                <a href="tomar_asistencia.php?id_curso=0" class="btn btn-secondary">Tomar asistencia</a>
                <a href="ver_asistencia.php" class="btn btn-secondary">Ver asistencia</a>
                <a href="ver_materia.php" class="btn btn-secondary">Ver materias</a>
                </div>
            <div class="column items-index">
                <img src="../../../img/rite.png" alt="">
                <a href="rite.php?id_curso=0" class="btn btn-secondary">Ver RITE</a>
            </div>
        </div>
    </main>


    <script src="https://kit.fontawesome.com/d5f1649c82.js" crossorigin="anonymous"></script>
</body>

</html>