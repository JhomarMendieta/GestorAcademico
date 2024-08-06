<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../css/profesores/ver_rite.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
  <title>Ver RITEs</title>
</head>
<?php
include "./components/navbar_profesores.php";
include '../../conn.php';
include 'autenticacion_profesor.php';
?>
<div class="container-rite">
  <?php

  // Obtener las materias que enseña el profesor
  $query = "SELECT materia.id, materia.nombre FROM profesor_materia INNER JOIN materia ON profesor_materia.id_materia = materia.id WHERE profesor_materia.id_profesor = (SELECT numLegajo FROM profesores WHERE id_usuario = ?);";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();
  ?>

  <div class="titulo-rite">
    <h1>Ver RITEs</h1>
  </div>
  <form id="materiaForm" method="POST" action="">
    <select class='form-select' name="materia_id" required onchange="this.form.submit()">
      <option value="" disabled selected>Seleccione una Materia</option>
      <?php while ($row = $result->fetch_assoc()) : ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
      <?php endwhile; ?>
    </select>
  </form>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['materia_id'])) {
    $materiaId = $_POST['materia_id'];
    $instanciaFiltro = isset($_POST['instancia']) ? $_POST['instancia'] : '';

    // Consulta para obtener el nombre de la materia
    $queryMateria = "SELECT nombre FROM materia WHERE id = ?";
    $stmtMateria = $conn->prepare($queryMateria);
    $stmtMateria->bind_param("i", $materiaId);
    $stmtMateria->execute();
    $stmtMateria->bind_result($nombreMateria);
    $stmtMateria->fetch();
    $stmtMateria->close();

    echo "<h4>$nombreMateria</h4>";

    // Mostrar selector de instancia
    echo /*html*/ "<form method='POST' action=''>
    <input type='hidden' name='materia_id' value='$materiaId'>
    <div class= 'form-instancia'>
    <select class='form-select' name='instancia' onchange='this.form.submit()'>
    <option value='' disabled selected>Seleccione una Instancia</option>";
    $instancias = ["MAYO", "JULIO", "SEPTIEMBRE", "NOVIEMBRE"];

    foreach ($instancias as $instancia) {
      $selected = ($instanciaFiltro == $instancia) ? "selected" : "";
      echo "<option value='$instancia' $selected>$instancia</option>";
    }
    echo "</select></div></form>";

    // Mostrar la instancia actualmente seleccionada
    if (!empty($instanciaFiltro)) {
      echo "<h4>Instancia Seleccionada: $instanciaFiltro</h4>";

      // Consulta para obtener y mostrar los alumnos inscritos en la materia seleccionada junto con sus notas y nombres de indicadores
      $query = "SELECT alumno.*, 
                GROUP_CONCAT(CASE WHEN nota.instancia = ? THEN nota.calificacion ELSE NULL END ORDER BY nota.id) AS calificaciones,
                AVG(CASE WHEN nota.instancia = ? THEN nota.calificacion ELSE NULL END) AS promedio,
                GROUP_CONCAT(CASE WHEN nota.instancia = ? THEN nota.nombre ELSE NULL END ORDER BY nota.id) AS nombres_indicadores
                FROM alumno
                INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno
                INNER JOIN curso ON alumno_curso.id_curso = curso.id
                INNER JOIN materia ON curso.id = materia.id_curso
                LEFT JOIN nota ON alumno.id = nota.id_alumno AND materia.id = nota.id_materia
                WHERE materia.id = ?
                GROUP BY alumno.id
                ORDER BY alumno.apellidos, alumno.nombres";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("sssi", $instanciaFiltro, $instanciaFiltro, $instanciaFiltro, $materiaId);
      $stmt->execute();
      $result = $stmt->get_result();

      // Verificar si se encontraron resultados
      if ($result->num_rows > 0) {
        // Inicializar variables para rastrear la cantidad máxima de notas
        $maxNotas = 0;
        $alumnos = [];

        while ($row = $result->fetch_assoc()) {
          $calificaciones = array_filter(explode(",", $row['calificaciones']));
          $nombresIndicadores = array_filter(explode(",", $row['nombres_indicadores']));
          $row['calificaciones'] = $calificaciones;
          $row['nombres_indicadores'] = $nombresIndicadores;
          $alumnos[] = $row;

          // Actualizar la cantidad máxima de notas
          $maxNotas = max($maxNotas, count($calificaciones));
        } ?>
        <div class='table-responsive'>
          <?php
          echo "<table class='table table-striped'><tr><th>Apellido</th><th>Nombre</th>";

          // Generar dinámicamente los encabezados de las notas usando los nombres de indicadores
          for ($i = 0; $i < $maxNotas; $i++) {
            echo "<th>" . (isset($alumnos[0]['nombres_indicadores'][$i]) ? $alumnos[0]['nombres_indicadores'][$i] : "Indicador " . ($i + 1)) . "</th>";
          }
          echo "<th>Promedio</th></tr>";

          // Generar dinámicamente las filas de alumnos y sus notas
          foreach ($alumnos as $alumno) {
            echo "<tr><td>" . $alumno['apellidos'] . "</td><td>" . $alumno['nombres'] . "</td>";

            // Imprimir las notas del alumno
            for ($i = 0; $i < $maxNotas; $i++) {
              echo "<td>" . (isset($alumno['calificaciones'][$i]) ? $alumno['calificaciones'][$i] : "-") . "</td>";
            }

            // Mostrar guiones si no hay promedio calculado
            echo "<td>" . (is_null($alumno['promedio']) ? "-" : number_format($alumno['promedio'], 2)) . "</td></tr>";
          }
          echo "</table>";
          ?>
        </div>
  <?php
      } else {
        echo "No se encontraron alumnos inscritos en esta materia.";
      }

      $stmt->close(); // Cerrar la consulta preparada
    }
  }

  // Cerrar la conexión a la base de datos
  $conn->close();
  ?>
</div>
</body>

</html>