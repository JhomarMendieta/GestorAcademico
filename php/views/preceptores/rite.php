<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/rite.css">
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
            <h2>RITE</h2>
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
    <div class="opc1">
    <h2 class="titu">Selecciona el Curso que desee ver</h2>
    <label for="select" class="select">
    <input type="radio" name="list" value="not_changed" id="bg" checked />
    <input type="radio" name="list" value="not_changed" id="select">
    <label class="bg" for="bg"></label>
    <div class="items">
      <input type="radio" name="list" value="first_value" id="list[0]">
      <label for="list[0]">7°2</label>
      <input type="radio" name="list" value="second_value" id="list[1]">
      <label for="list[1]">7°1</label>
      <span id="text">Cursos...</span>
    </div>
</label>

<center><a class="riteing" href="#"  onclick="alert(document.querySelector('input[name=list]:checked').value)">Mostrar Curso seleccionado</a></div></center>
</body>
</html>