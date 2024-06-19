function showForm(formId) {
    var forms = document.getElementsByClassName('form-container');
    for (var i = 0; i < forms.length; i++) {
        forms[i].style.display = 'none';
    }
    document.getElementById(formId).style.display = 'table-row';
}

function hideForm(formId) {
    document.getElementById(formId).style.display = 'none';
}
