$(document).ready(function () {
    $('#btn-registro-cuestionario').click(function () {
        $('#container').load('../sistema/cuestionarios/frm_cuestionarios.php');
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    });

    $('#btn-inicio-cuestionario').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/cuestionarios/frm_inicio_cuestionarios.php');
    });

    $('#btn-regresar-cuestionario').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/cuestionarios/frm_inicio_cuestionarios.php');
    });
});
