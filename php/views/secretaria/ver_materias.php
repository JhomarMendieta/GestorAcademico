<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="ver_materias.css">
</head>

<?php
include "./navbar_secretaria.php";
include 'autenticacion_secretaria.php';
?>
<div class="container-materia">
  <?php
  // Incluir el archivo de conexión a la base de datos 

  // Consulta para obtener los años lectivos disponibles
  $sql = "SELECT DISTINCT anio_lectivo FROM curso ORDER BY anio_lectivo DESC";
  $resultAnioLectivo = $conn->query($sql);
  ?>
  <div class="titulo-materia">
    <h1>Ver materias</h1>
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
    ?>
    <form id="cursoForm" method="POST" action="">
      <input type="hidden" name="anio_lectivo" value="<?php echo $anioLectivoSeleccionado; ?>">
      <select class='form-select' name="curso_id" required onchange="this.form.submit()">
        <option value="" disabled selected>Seleccione un Curso</option>
        <?php while ($row = $resultCursos->fetch_assoc()) : ?>
          <option value="<?php echo $row['id']; ?>">
            <?php echo "Año: " . $row['anio'] . " - División: " . $row['division'] . " - Año Lectivo: " . $row['anio_lectivo']; ?>
          </option>
        <?php endwhile; ?>
      </select>
    </form>
    <?php
    $stmtCursos->close();

    if (isset($_POST['curso_id'])) {
      $cursoId = $_POST['curso_id'];

      // Consulta para obtener el nombre del curso
      $queryCurso = "SELECT anio, division, anio_lectivo FROM curso WHERE id = ?";
      $stmtCurso = $conn->prepare($queryCurso);
      $stmtCurso->bind_param("i", $cursoId);
      $stmtCurso->execute();
      $stmtCurso->bind_result($anio, $division, $anioLectivo);
      $stmtCurso->fetch();
      $stmtCurso->close();

      echo "<div class='subtitulo-alumno'>";
      echo "<h5> Curso seleccionado: Año $anio - División $division - Año Lectivo $anioLectivo</h5>";
      echo "</div>";

      // Consulta para obtener y mostrar las materias del curso seleccionado
      $query = "SELECT nombre, horario
                FROM materia
                WHERE id_curso = ?
                ORDER BY nombre ASC";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $cursoId);
      $stmt->execute();
      $result = $stmt->get_result();

      // Verificar si se encontraron resultados
      if ($result->num_rows > 0) {
        echo "<div class='subtitulo-nombre'>";
        echo "<h2>Materias</h2>";
        echo "</div>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped'>";
        echo "<tr><th>Nombre</th><th>Horario</th></tr>";

        // Generar dinámicamente las filas de materias
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['nombre'] . "</td>";
          echo "<td>" . $row['horario'] . "</td>";
          echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
      } else {
        echo "No se encontraron materias para este curso.";
      }

      $stmt->close(); // Cerrar la consulta preparada
    }
  }

  // Cerrar la conexión a la base de datos
  $conn->close();
  ?>
</body>
</html>
