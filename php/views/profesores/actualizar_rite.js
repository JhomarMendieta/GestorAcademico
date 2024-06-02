function showForm(formId) {
    document.querySelectorAll('.form-container').forEach(function (form) {
        form.style.display = 'none';
    });
    forms.forEach(form => form.style.display = 'none');
    document.getElementById(formId).style.display = 'block';
    // Mostrar el formulario específico según la opción seleccionada
    if (formId.startsWith('form-edit') || formId.startsWith('form-delete')) {
        document.getElementById(formId).style.display = 'block';
        } else if (formId.startsWith('form-edit') || formId.startsWith('form-delete')) {
            document.getElementById(formId).style.display = 'block';
        } else {
            document.getElementById('form-add').style.display = 'block';
        }
}
function submitForm() {
    document.getElementById("materiaForm").submit();
}
function submitAlumnoForm() {
    document.getElementById('alumnoForm').submit();
}
function editNota(id, nombre, calificacion, instancia) {
    document.getElementById('nota_id').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('calificacion').value = calificacion;
    document.getElementById('instancia').value = instancia;
    document.getElementById('saveButton').value = 'edit';
    document.getElementById('formTitle').innerText = 'Editar Nota';
}