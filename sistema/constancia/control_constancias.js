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
