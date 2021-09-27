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

    document.getElementById('respTipMultiple').style.display = 'none';
    document.getElementById('preguntaGeneral').style.display = 'none';
});

function myFunction(chosen) {
    var eleccion = $('#tipo_pregunta').val();
    if (eleccion != '') {
        document.getElementById('preguntaGeneral').style.display = '';
    }

    if (eleccion === 'Abierta') {
        document.getElementById('respTipMultiple').style.display = 'none';
    } else if (eleccion === 'Si y no') {
        document.getElementById('respTipMultiple').style.display = 'none';
    } else if (eleccion === 'Opción múltiple') {
        document.getElementById('respTipMultiple').style.display = '';
    } else if (eleccion === 'Seleccionar una opción') {
        document.getElementById('preguntaGeneral').style.display = 'none';
        document.getElementById('respTipMultiple').style.display = 'none';
    }
}

// $(document).on('change', '#tipoPregunta', () => {
//     var tipoPregunta = $('tipoPregunta').val();

//     if (tipoPregunta == 'Abierta') {
//         $('#Salon').hide();
//     }
//     $('#TipoPregunta').load('..sistema/cuestionarios/campos_pregunta.php', { tipoPregunta: respuesta });
// });
