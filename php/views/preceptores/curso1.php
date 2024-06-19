<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../../img/LogoEESTN1.png" type="image/x-icon">
    <title>Document</title>
    <link rel="stylesheet" href="css/navStyle.css">
</head>
<body>
    <?php
        include("menu.php");
    ?>
    <h1>Seleccionar un Curso</h1>
    <label for="select" class="select">
    <input type="radio" name="list" value="not_changed" id="bg" checked />
    <input type="radio" name="list" value="not_changed" id="select">
    <label class="bg" for="bg"></label>
    <div class="items">
      <input type="radio" name="list" value="first_value" id="list[0]">
      <label for="list[0]">7°2</label>
      <input type="radio" name="list" value="second_value" id="list[1]">
      <label for="list[1]">7°1</label>
      <span id="text">Cursos...</span>
        </div>
    </label>
    <h1>Ver alumnos por curso</h1> 
    <?php include 'alumnos.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
            $(document).ready(function(){
    $('input[name="list"]').change(function(){
        var selectedValue = $(this).val();
        if(selectedValue === "first_value" || selectedValue === "second_value") {
            $.ajax({
                url: 'alumnos.php',
                type: 'GET',
                success: function(data) {
                    // Aquí puedes mostrar o hacer algo con la respuesta de la consulta PHP
                    console.log(data);
                },
                error: function() {
                    console.log('Error al ejecutar la consulta PHP');
                }
            });
        }
    });
    });
    </script>
    
</body>
</html>