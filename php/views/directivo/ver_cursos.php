<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./ver_cursos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./menu.css">
</head>
<body>

<?php
include "./nav_directivos.php";
include 'autenticacion_directivo.php';
?>
<div class="container-cursos">
  <?php

  // Consulta para obtener los años lectivos disponibles
  $sql = "SELECT DISTINCT anio_lectivo FROM curso ORDER BY anio_lectivo DESC";
  $resultAnioLectivo = $conn->query($sql);
  ?>
  <div class="titulo-cursos">
    <h1>Ver cursos</h1>
  </div>
  <form id="anioLectivoForm" method="POST" action="">
    <select class='form-select' name="anio_lectivo" required onchange="this.form.submit()">
      <option value="" disabled selected>Seleccione un Año Lectivo</option>
      <?php while ($row = $resultAnioLectivo->fetch_assoc()) : ?>
        <option value="<?php echo $row['anio_lectivo']; ?>"><?php echo $row['anio_lectivo']; ?></option>
      <?php endwhile; ?>
    </select>
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['anio_lectivo'])) {
    $anioLectivoSeleccionado = $_POST['anio_lectivo'];

    // Consulta para obtener los cursos del año lectivo seleccionado
    $queryCursos = "SELECT id, anio, division, anio_lectivo FROM curso WHERE anio_lectivo = ?";
    $stmtCursos = $conn->prepare($queryCursos);
    $stmtCursos->bind_param("i", $anioLectivoSeleccionado);
    $stmtCursos->execute();
    $resultCursos = $stmtCursos->get_result();

    // Verificar si se encontraron resultados
    if ($resultCursos->num_rows > 0) {
      echo "<div class='subtitulo-nombre'>";
      echo "<h5>Cursos del Año Lectivo $anioLectivoSeleccionado</h5>";
      echo "</div>";
      echo "<div class='table-responsive'>";
      echo "<table class='table table-striped'>";
      echo "<tr><th>Año</th><th>División</th><th>Año Lectivo</th></tr>";

      // Generar dinámicamente las filas de cursos
      while ($row = $resultCursos->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['anio'] . "</td>";
        echo "<td>" . $row['division'] . "</td>";
        echo "<td>" . $row['anio_lectivo'] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
      echo "</div>";
    } else {
      echo "No se encontraron cursos para este año lectivo.";
    }

    $stmtCursos->close();
  }

  // Cerrar la conexión a la base de datos
  $conn->close();
  ?>
</div>
</body>
</html>
