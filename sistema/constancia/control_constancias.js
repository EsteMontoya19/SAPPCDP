$(document).ready(function () {
    $('#btn-regresar-constancia').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        location.reload();
    });
    $('#btn-consultar-constancias').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
    });
});

function validarFormularioConstancia() {
    return true;
}

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

//Insertar Cosntancia
$(document).ready(function () {
    $('#btn-registrar-constancia').click(function () {
        if (validarFormularioConstancia()) {
            datos = new FormData($('#form_constancia')[0]);
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
                    } else {
                        alertify.error('Hubo un problema al registrar el constancia');
                    }
                },
            });
            return false;
        }
    });
});
