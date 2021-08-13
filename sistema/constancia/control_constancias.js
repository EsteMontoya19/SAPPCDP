$(document).ready(function () {
    $('#btn-regresar-constancia').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
    });
    $('#btn-consultar-constancias').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
    });
});

function generarConstancia(fechaInicio, fechaFin) {
    var datos = {
        fechaInicio: fechaInicio,
        fechaFin: fechaFin,
        CRUD: 1,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/plataformas/frm_plataformas.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

//Insertar Constancia
$(document).ready(function () {
    $('#btn-registrar-constancia').click(function () {
        
        datos = new FormData($('#form_constancias')[0]);
        $.ajax({
            type: 'POST',
            url: '../modulos/Control_Constancia.php',
            data: datos,
            contentType: false,
            processData: false,

            success: function (respuesta) {
                console.log(respuesta);
                if (respuesta.endsWith('1')) {
                    alertify.success('El registro se realizó correctamente');
                    setTimeout(function () {
                        $('html, body').animate({ scrollTop: 0 }, 0);
                        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
                    }, 1500);
                } else if (respuesta.endsWith('2')) {
                    alertify.error('Debe seleccionar un archivo .zip');
                } else if (respuesta.endsWith('3')) {
                    alertify.error('Solo se aceptan archivos con extensión .zip');
                } else if (respuesta.endsWith('4')) {
                    alertify.error('Ya se han cargado constancias para este curso.');
                }
            },
        });
        return false;
    });
});

//! Importante, sin esto el archivo no se puede cargar
$('.custom-file-input').on('change', function () {
    var fileName = $(this).val().split('\\').pop();
    $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
});