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
    include 'navbar_secretaria.php';
    include 'autenticacion_secretaria.php';
    ?>
    <!-- funcionalidad -->
    <main class="body">
        <div class="titulo-menu">
            <h1 class="text-center p-4">Menú</h1>
        </div>
        <div class="main-container container-index">
            <div class="column items-index">
            <p>PROFESORES</p>
            <svg width="100" height="100" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M20.25 6H3.75A2.25 2.25 0 0 0 1.5 8.25v10.5A2.25 2.25 0 0 0 3.75 21h16.5a2.25 2.25 0 0 0 2.25-2.25V8.25A2.25 2.25 0 0 0 20.25 6Z"></path>
              <path d="M6.75 6V4.5A1.5 1.5 0 0 1 8.25 3h7.5a1.5 1.5 0 0 1 1.5 1.5V6"></path>
              <path d="M22.5 11.25h-21"></path>
              <path d="M15 11.25v1.125a.375.375 0 0 1-.375.375h-5.25A.375.375 0 0 1 9 12.375V11.25"></path>
            </svg>
                <a type="button" class="btn btn-secondary" href="agregar_profesores.php">Registrar profesores</a>
                <a type="button" class="btn btn-secondary" href="gestionar_profesores.php">Gestionar profesores</a>
                <a type="button" class="btn btn-secondary" href="asignar_materiass.php">Asignar materias</a>
            </div>
            <div class="column items-index">
            <p>ALUMNOS</p>
            <svg width="100" height="100" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M1.5 9 12 3l10.5 6L12 15 1.5 9Z"></path>
              <path d="M5.25 11.25v6L12 21l6.75-3.75v-6"></path>
              <path d="M22.5 17.25V9"></path>
              <path d="M12 15v6"></path>
            </svg>
                <a type="button" class="btn btn-secondary" href="agregar_alumnos.php">Agregar alumnos</a>
                <a type="button" class="btn btn-secondary" href="gestionar_alumnos.php">Gestionar alumnos</a>
            </div>
            <div class="column items-index">
            <p>PRECEPTORES</p>
            <svg width="100" height="100" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M6 6.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"></path>
              <path d="M12 21.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"></path>
              <path d="M12 12v5.25"></path>
              <path d="M18 6.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z"></path>
              <path d="M6 6.75C6 10.25 9.23 12 12 12"></path>
              <path d="M18 6.75c0 3.5-3.23 5.25-6 5.25"></path>
            </svg>
                <a type="button" class="btn btn-secondary" href="agregar_preceptor.php">Registrar preceptores</a>
                <a type="button" class="btn btn-secondary" href="gestionar_preceptor.php">Gestionar preceptores</a>
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
                <a type="button" class="btn btn-secondary" href="ver_materias.php">Agregar materias</a>
                <a type="button" class="btn btn-secondary" href="ver_materias.php">Ver materias</a>
            </div>
            <div class="column items-index">
            <p>CURSOS</p>
            <svg width="100" height="100" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 7.5c.75-2.96 3.583-4.472 9.75-4.5a.747.747 0 0 1 .75.75v13.5a.75.75 0 0 1-.75.75c-6 0-8.318 1.21-9.75 3-1.424-1.781-3.75-3-9.75-3-.463 0-.75-.377-.75-.84V3.75A.747.747 0 0 1 2.25 3c6.167.028 9 1.54 9.75 4.5Z"></path>
              <path d="M12 7.5V21"></path>
            </svg>
                <a type="button" class="btn btn-secondary" href="agregar_cursos.php">Agregar cursos</a>
                <a type="button" class="btn btn-secondary" href="ver_cursos.php">Ver cursos</a>
            </div>
            <div class="column items-index">
            <p>USUARIOS</p>
            <svg width="100" height="100" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M18.844 7.875c-.138 1.906-1.552 3.375-3.094 3.375-1.542 0-2.959-1.468-3.094-3.375-.14-1.983 1.236-3.375 3.094-3.375 1.858 0 3.235 1.428 3.094 3.375Z"></path>
                  <path d="M15.75 14.25c-3.055 0-5.993 1.517-6.729 4.472-.097.391.148.778.55.778h12.358c.402 0 .646-.387.55-.778-.736-3.002-3.674-4.472-6.73-4.472Z"></path>
                  <path d="M9.375 8.716c-.11 1.522-1.253 2.722-2.484 2.722-1.232 0-2.377-1.2-2.485-2.722C4.294 7.132 5.406 6 6.891 6c1.484 0 2.596 1.161 2.484 2.716Z"></path>
                  <path d="M9.657 14.341c-.846-.387-1.778-.536-2.766-.536-2.437 0-4.786 1.211-5.374 3.572-.077.312.118.62.44.62h5.262"></path>
                </svg>
                <a type="button" class="btn btn-secondary" href="registrar_usuarios.php">Registrar usuarios</a>
                <a type="button" class="btn btn-secondary" href="asignar_usuarios.php">Asignar usuarios</a>
            </div>

        </div>
    </main>

</body>

</html>