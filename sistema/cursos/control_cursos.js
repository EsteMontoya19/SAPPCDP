// Enlace a los formularios

// function ocultar(id) {
//     if (id == '1') {
//         $('#nivel').show();
//         $('#nombre').hide();
//     }

//     if (id == '2') {
//         $('#nivel').hide();
//         $('#nombre').hide();
//     }

//     if (id == '0') {
//         $('#nivel').show();
//         $('#nombre').show();
//     }
// }

document.querySelector('.numeros_permitidos').addEventListener('keypress', function (evt) {
    if ((evt.which != 8 && evt.which != 0 && evt.which < 48) || evt.which > 57) {
        evt.preventDefault();
    }
});
