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
  <?php
    include("menu.php");
  ?>
  <main class="body">
    <div class="items">
      <div class="apartado alumnos">
        <div class="seccion">
          <div class="icon"><i class="fa-solid fa-graduation-cap"></i></div>
          <p class="text_icon">Alumnos</p>
        </div>
        <div class="secciones">
          <a href="alumno_curso.php" class="opcion">Ver alumnos por curso</a>
          <span class="separacion">
            <div class="circulo"></div>
            <div class="linea"></div>
            <div class="circulo"></div>
          </span>
          <a href="#" class="opcion">Tomar asistencia</a>
          <span class="separacion">
            <div class="circulo"></div>
            <div class="linea"></div>
            <div class="circulo"></div>
          </span>
          <a href="#" class="opcion">Ver asistencia</a>
        </div>
      </div>
      <div class="apartado rites">
        <div class="seccion">
          <div class="icon"><i class="fa-solid fa-folder-tree"></i></div>
          <p class="text_icon">R.I.T.E.</p>
        </div>
        <div class="secciones">
          <a href="curso.php" class="opcion">Ver R.I.T.E.</a>
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