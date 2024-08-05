<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/navStyle.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php include("assets/menu.php"); ?>
    <main class="body mt-5">
        <?php 
            include("../../conn.php");
            $curso_id = isset($_GET['id_curso']) ? $_GET['id_curso'] : 0;
            $materia_id = isset($_GET['id_materia']) ? $_GET['id_materia'] : 0;
            $instancia = isset($_GET['instancia']) ? $_GET['instancia'] : '';

            if ($curso_id == 0) {
                include("assets/lista_curso_rite.php");
            } elseif ($materia_id == 0) {
                include("assets/lista_materias.php");
            } elseif (empty($instancia)) {
                include("assets/lista_instancias.php");
            } else {
                include("opciones_rite.php");
            }
        ?>
    </main>
</body>
</html>
