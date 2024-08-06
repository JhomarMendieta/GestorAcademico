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
            <p>ALUMNOS</p>
            <svg width="100" height="100" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M1.5 9 12 3l10.5 6L12 15 1.5 9Z"></path>
              <path d="M5.25 11.25v6L12 21l6.75-3.75v-6"></path>
              <path d="M22.5 17.25V9"></path>
              <path d="M12 15v6"></path>
            </svg>
                <a href="alumnos.php?id_curso=0" class="btn btn-secondary">Ver Alumnos en curso</a>
            </div>
            <div class="column items-index">
            <p>MATERIAS</p>
            <svg width="100" height="100" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M18 3.75H6c-1.219 0-2.016.656-2.25 1.875l-1.5 7.125V18a2.257 2.257 0 0 0 2.25 2.25h15A2.256 2.256 0 0 0 21.75 18v-5.25l-1.5-7.125C20.016 4.359 19.172 3.75 18 3.75Z"></path>
              <path d="M2.25 12.75H9"></path>
              <path d="M15 12.75h6.75"></path>
              <path d="M9 12.75a3 3 0 0 0 6 0"></path>
              <path d="M6.75 6.75h10.5"></path>
              <path d="M6 9.75h12"></path>
            </svg>
                <a href="tomar_asistencia.php?id_curso=0" class="btn btn-secondary">Tomar asistencia</a>
                <a href="ver_asistencia.php" class="btn btn-secondary">Ver asistencia</a>
                <a href="ver_materia.php" class="btn btn-secondary">Ver materias</a>
                </div>
            <div class="column items-index">
                <p>RITE</p>
                <svg width="100" height="100" fill="none" stroke="#000000" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17.25 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-15a2.25 2.25 0 0 0-2.25-2.25Z"></path>
                  <path d="M15 2.25v19.5"></path>
                </svg>
                <a href="rite.php?id_curso=0" class="btn btn-secondary">Ver RITE</a>
            </div>
        </div>
    </main>


    <script src="https://kit.fontawesome.com/d5f1649c82.js" crossorigin="anonymous"></script>
</body>

</html>