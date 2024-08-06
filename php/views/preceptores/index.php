<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="css/navStyle.css">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>

  <!-- navbar -->
  <?php include 'nav_preseptor.php'; ?>

  <!-- funcionalidad -->
  <div class="container">
    <div class="opciones">
      <div class="column">
        <img src="../../../img/estudiante.png" alt="">
        <h2>Alumnos</h2>
        <a type="button" class="btn btn-secondary" href="alumno_curso.php">Ver alumnos por curso</a>
      </div>
      <div class="column">
        <img src="../../../img/asistensia.png" alt="">
        <h2>Preceptor</h2>
        <a type="button" class="btn btn-secondary" href="listado.php">Tomar lista</a>
        <a type="button" class="btn btn-secondary" href=".php">Ver asistencia</a>
      </div>
      <div class="column">
        <img src="../../../img/rite.png" alt="">
        <h2>R.I.T.E</h2>
        <div class="materias-buttons">
          <a type="button" class="btn btn-secondary" href="rite.php">R.I.T.E</a>
        </div>
      </div>
      <div class="column">
        <img src="../../../img/materias.png" alt="">
        <h2>Materias</h2>
        <a type="button" class="btn btn-secondary" href="materias.php">Ver materias</a>
      </div>
    </div>
  </div>

</body>

</html>