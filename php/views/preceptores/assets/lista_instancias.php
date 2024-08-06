<h1 class="text-center p-4">Lista de instancias</h1>
<table class="table">
    <tbody>
        <?php
            $instancias = ["MAYO", "JULIO", "SEPTIEMBRE", "NOVIEMBRE"];
            foreach($instancias as $instancia){
        ?>
        <tr>
            <td class="td-size-curso px-4"><?php echo $instancia; ?></td>
            <td class="td-size-curso"><a class="text-decoration-none text-hover btn btn-dark" href="?id_curso=<?php echo $curso_id; ?>&id_materia=<?php echo $materia_id; ?>&instancia=<?php echo $instancia; ?>">Ver RITE</a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
