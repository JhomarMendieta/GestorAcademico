document.getElementById('person_type').addEventListener('change', function() {
    var type = this.value;
    var personSelect = document.getElementById('person_id');
    personSelect.innerHTML = ''; // Limpiar opciones anteriores

    // Eliminar la alerta Bootstrap si existe
    var alertDiv = document.querySelector('.alert');
    if (alertDiv) {
        alertDiv.parentNode.removeChild(alertDiv);
    }

    if (type) {
        fetch(`get_persona.php?type=${type}`)
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    // Mostrar mensaje de no hay personas disponibles usando Bootstrap alert
                    var alertDiv = document.createElement('div');
                    alertDiv.classList.add('alert', 'alert-warning');
                    alertDiv.textContent = data.message;
                    personSelect.parentNode.insertBefore(alertDiv, personSelect.nextSibling);
                } else {
                    data.forEach(person => {
                        var option = document.createElement('option');
                        option.value = person.id;
                        option.textContent = person.name;
                        personSelect.appendChild(option);
                    });
                    $('#person_id').selectpicker('refresh');
                }
            });
    }
});
