<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f0f0f0;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    /* Add some extra spacing between rows */
    tr {
        margin-bottom: 10px;
    }
    /* Make the textarea and select elements wider */
    textarea, select {
        width: 100%;
    }
</style>

<?php
include_once('../../conn.php');

// Consulta para obtener los datos de los alumnos y su grupo
$query = "SELECT a.id, a.nombres, a.apellidos, ac.grupo 
          FROM alumno a 
          INNER JOIN alumno_curso ac ON a.id = ac.id_alumno";

$result = mysqli_query($conn, $query);

// Consulta para obtener las opciones del enum de asistencia
$query_asistencia = "SHOW COLUMNS FROM asistencia WHERE Field = 'asistencia'";
$result_asistencia = mysqli_query($conn, $query_asistencia);
$row_asistencia = mysqli_fetch_assoc($result_asistencia);
$enum_asistencia = $row_asistencia['Type'];
$enum_asistencia = str_replace("enum('", "", $enum_asistencia);
$enum_asistencia = str_replace("')", "", $enum_asistencia);
$enum_asistencia = explode("','", $enum_asistencia);

// Verificar si hay resultados  
if (mysqli_num_rows($result) > 0) {
    // Mostrar la tabla de asistencias
    echo "<table>";
    echo "<tr><th>Nombre</th><th>Grupo</th><th>Asistencia</th><th>Observaciones (Opcional)</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td><b>" . $row["nombres"] . " " . $row["apellidos"] . "</b></td>";
        echo "<td><b>" . $row["grupo"] . "</b></td>";
        echo "<td>";
        // Opciones de asistencia
        echo "<select name='asistencia[]'>";
        foreach ($enum_asistencia as $option) {
            echo "<option value='" . $option . "'>" . $option . "</option>";
        }
        echo "</select>";
        echo "</td>";
        echo "<td>";
        // Cuadricula de observaciones
        echo "<textarea name='observaciones[]' cols='20' rows='5'></textarea>";
        echo "<input type='hidden' name='id_alumno[]' value='" . $row['id'] . "'>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No hay resultados";
}

mysqli_close($conn);
?>
