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
            $curso_id = $_GET['id_curso'];
            if ($curso_id == 0){
                include("assets/lista_cursos.php");
            }
            else{
                include("lista_alumnos_curso.php");
            }
        ?>
    </main>
</body>
</html>