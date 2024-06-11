<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <title>Document</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/main.css">
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
    <main class="body">
        <div class="items">
            <div class="apartado alumnos">
                <div class="seccion">
                    <div class="icon"><i class="fa-solid fa-graduation-cap"></i></div>
                    <p class="text_icon">Alumnos</p>
                </div>
                <div class="secciones">
                    <a href="alumno_curso.php" class="opcion">Ver alumnos por curso</a>
                </div>
            </div>
            <div class="apartado rites">
                <div class="seccion">
                    <div class="icon"><i class="fa-solid fa-folder-tree"></i></div>
                    <p class="text_icon">R.I.T.E.</p>
                </div>
                <div class="secciones">
                    <a href="rite.php" class="opcion">Ver R.I.T.E.</a>
                    <span class="separacion">
                        <div class="circulo"></div>
                        <div class="linea"></div>
                        <div class="circulo"></div>
                    </span>
                    <a href="cargar-rite.php" class="opcion">Cargar R.I.T.E.</a>
                </div>
            </div>
            <div class="apartado materias">
                <div class="seccion">
                    <div class="icon"><i class="fa-solid fa-book"></i></div>
                    <p class="text_icon">Materias</p>
                </div>
                <div class="secciones">
                    <a href="materias.php" class="opcion">Ver materias</a>
                </div>
            </div>
        </div>
    </main>


    <script src="https://kit.fontawesome.com/d5f1649c82.js" crossorigin="anonymous"></script>
</body>

</html>