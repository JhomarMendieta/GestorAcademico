var editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    var nombre = button.getAttribute('data-nombre');
    var horario = button.getAttribute('data-horario');

    var modalTitle = editModal.querySelector('.modal-title');
    var modalBodyInputId = editModal.querySelector('#editMateriaId');
    var modalBodyInputNombre = editModal.querySelector('#editNombre');
    var modalBodyInputHorario = editModal.querySelector('#editHorario');

    modalBodyInputId.value = id;
    modalBodyInputNombre.value = nombre;
    modalBodyInputHorario.value = horario;
});