<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RITE de los Alumnos</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php include("assets/menu.php"); ?>
    <main class="body mt-5">
        <?php
        include("../../conn.php");
        $curso_id = $_GET['id_curso'];
        $materia_id = $_GET['id_materia'];
        $instancia = $_GET['instancia'];

        $query_anio = "SELECT anio, division FROM curso WHERE curso.id = '$curso_id'";
        $r_query_anio = $conn->query($query_anio);
        $curso = $r_query_anio->fetch_assoc();
        ?>

        <h1 class="text-center p-4">Lista de los alumnos del curso <?php echo $curso['anio'], "° ", $curso['division'], "°"; ?></h1>

        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="px-4">#</th>
                    <th scope="col">DNI</th>
                    <th scope="col">Apellido/s</th>
                    <th scope="col">Nombre/s</th>
                    <th scope="col">Grupo</th>
                    <th scope="col">RITE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query_alumnos = "SELECT alumno.id, alumno.nombres, alumno.apellidos, alumno.dni, alumno_curso.grupo 
                                  FROM alumno 
                                  INNER JOIN alumno_curso ON alumno.id = alumno_curso.id_alumno 
                                  WHERE alumno_curso.id_curso = $curso_id;";
                $r_query_alumnos = $conn->query($query_alumnos);
                $cont = 0;
                if (isset($r_query_alumnos)) {
                    while ($row = $r_query_alumnos->fetch_assoc()) {
                        $cont++;
                        ?>
                        <tr>
                            <td class="td-size-alumno_curso px-4"><?php echo $cont; ?></td>
                            <td><?php echo $row['dni']; ?></td>
                            <td><?php echo $row['apellidos']; ?></td>
                            <td><?php echo $row['nombres']; ?></td>
                            <td><?php echo $row['grupo']; ?></td>
                            <td><a class="btn btn-primary" href="ver_rite_individual.php?id_alumno=<?php echo $row['id']; ?>&id_materia=<?php echo $materia_id; ?>&instancia=<?php echo $instancia; ?>">Ver RITE</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron alumnos en el curso seleccionado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a class="btn btn-secondary mt-3" href="javascript:history.back()">Volver</a>
    </main>
</body>
</html>
