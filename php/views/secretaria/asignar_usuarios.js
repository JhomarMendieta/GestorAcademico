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
                    alertDiv.classList.add('alert', 'alert-warning', 'mt-2');
                    alertDiv.textContent = data.message;
                    personSelect.parentNode.insertBefore(alertDiv, personSelect.nextSibling);

                    // Deshabilitar el select de personas
                    personSelect.disabled = true;
                } else {
                    // Habilitar el select de personas si hay datos
                    personSelect.disabled = false;
                    data.forEach(person => {
                        var option = document.createElement('option');
                        option.value = person.id;
                        option.textContent = person.name;
                        personSelect.appendChild(option);
                    });
                }
            });
    }
});
