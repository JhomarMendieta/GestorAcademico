document.addEventListener('DOMContentLoaded', function () {
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nombre = button.getAttribute('data-nombre');
        var instancia = button.getAttribute('data-instancia');

        var modalIdInput = editModal.querySelector('#editNotaId');
        var modalNombreInput = editModal.querySelector('#editNombre');
        var modalInstanciaSelect = editModal.querySelector('#editInstancia');

        modalIdInput.value = id;
        modalNombreInput.value = nombre;
        modalInstanciaSelect.value = instancia;
    });
});