function selectMateria(id) {
    document.getElementById('materia_id').value = id;
    document.getElementById('materiaForm').submit();

}
function ocultarMateria() {
    document.getElementById('materiaMostrada').style.display = 'none';
    document.getElementById('alumnosMostrados').style.display = 'none';
    document.getElementById('botonOcultar').style.display = 'none';
}

