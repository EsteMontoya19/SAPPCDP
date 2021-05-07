// Enlace a los formularios

document.querySelector('.numeros_permitidos').addEventListener('keypress', function (evt) {
    if ((evt.which != 8 && evt.which != 0 && evt.which < 48) || evt.which > 57) {
        evt.preventDefault();
    }
});
