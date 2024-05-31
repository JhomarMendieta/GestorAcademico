function selectMateria(id) {
    document.getElementById('materia_id').value = id;
    document.getElementById('materiaForm').submit();
    document.getElementById('botonOcultar').style.display = 'block';
}

function ocultarMateria() {
    document.getElementById('materiaMostrada').style.display = 'none';
    document.getElementById('alumnosMostrados').style.display = 'none';
    document.getElementById('botonOcultar').style.display = 'none';
}
function mostrarBotonOcultar() {
    if (document.getElementById('materiaMostrada').style.display === 'none' && document.getElementById('alumnosMostrados').style.display === 'none') {
        document.getElementById('botonOcultar').style.display = 'block';
    }
}

// Llamar a la función para mostrar el botón de ocultar al cargar la página
window.onload = mostrarBotonOcultar;
