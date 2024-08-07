<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./menu.css">
</head>
<body>

<!-- navbar -->


<?php
include 'navbar_alumnos.php';
include 'autenticacion_alumno.php';
?>
<!-- funcionalidad -->
<!-- <div class="container">
    <div class="opciones">
        <div class="column">
            <img src="../../../img/estudiante.png" alt="">
            <a type="button" class="btn btn-secondary" href="reinscripcion.php">Solicitud de reinscripción</a>
        </div>
        <div class="column">
        <img src="../../../img/materia.png" alt="">
            <div class="materias-buttons">
                <a type="button" class="btn btn-secondary" href="ver_materias.php">Ver materias</a>
                <a type="button" class="btn btn-secondary" href="materias_adeudadas.php">Ver materias adeudadas</a>
                <a type="button" class="btn btn-secondary" href="mesas.php">Gestionar mesas</a>
            </div>
        </div>
        <div class="column">
            <img src="../../../img/rite.png" alt="">
            <a type="button" class="btn btn-secondary" href="rite.php">Ver RITE</a>
        </div>
        
    </div>
</div> -->
<main class="body">
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
            <a type="button" class="btn btn-secondary" href="reinscripcion.php">Solicitud de reinscripción</a>
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
                <a type="button" class="btn btn-secondary" href="ver_materias.php">Ver materias</a>
                <a type="button" class="btn btn-secondary" href="materias_adeudadas.php">Ver materias adeudadas</a>
                <a type="button" class="btn btn-secondary" href="mesas.php">Gestionar mesas</a>
            </div>
            <div class="column items-index">
            <p>RITE</p>
            <svg width="100" height="100" fill="none" stroke="#000000" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17.25 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-15a2.25 2.25 0 0 0-2.25-2.25Z"></path>
                  <path d="M15 2.25v19.5"></path>
                </svg>
            <a type="button" class="btn btn-secondary" href="rite.php">Ver RITE</a>
            </div>

        </div>
    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
