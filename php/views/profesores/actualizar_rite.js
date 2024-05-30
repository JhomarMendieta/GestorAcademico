function showForm(formId) {
    document.querySelectorAll('.form-container').forEach(function (form) {
        form.style.display = 'none';
    });
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