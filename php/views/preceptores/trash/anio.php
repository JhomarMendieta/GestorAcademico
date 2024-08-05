// anio.php
<?php
include_once('../../conn.php');

// Consulta para obtener los cursos
$query = "SELECT division, anio FROM curso";
$result = mysqli_query($conn, $query);

// Verificar si hay resultados
if (mysql   i_num_rows($result) > 0) {
    echo "<form action='listado.php' method='post'>";
    echo "<label for='curso'>Seleccione el curso que desee ver:</label>";
    echo "<select name='curso' id='curso'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['division'] . " " . $row['anio'] . "'>" . $row['division'] . " " . $row['anio'] . "</option>";
    }
    echo "</select>";
    echo "<input type='submit' value='Ver lista de alumnos'>";
    echo "</form>";
} else {
    echo "No hay cursos disponibles";
}

mysqli_close($conn);
?>