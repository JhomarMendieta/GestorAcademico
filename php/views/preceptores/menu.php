<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <title>Document</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <br>
    <br>
    <div class="titulop">
        <h1>PRECEPTORES</h1>
    </div>
    <div class="container">
    <div class="opciones">
        <div class="opcion">
            <h1>R.I.T.E</h1>
            <a href="rite.php">
            <button type="button" class="btn-secondary">Ver RITE</button></a>
            <br>
            <a href="cargar-rite.php">
            <button type="button" class="btn-secondary">Cargar RITE</button>
        </a>
    </div>
        <div class="opcion">
            <h1>Materias</h1>
            <br>
            <a href="materias.php">
            <button type="button" class="btn-secondary">Ver materias</button>
            </a>
        </div>
        <div class="opcion">
            <h1>Listado</h1>
            <br>
            <a href="curso.php">
            <button type="button" class="btn-secondary">Ver alumnos por curso</button>
            </a>
        </div>
    </div>
</div>


    <script src="https://kit.fontawesome.com/d5f1649c82.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>