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

    document.getElementById('preguntaGeneral').style.display = 'none';
    document.getElementById('agregar').style.display = 'none';
    document.getElementById('respTipMultiple').style.display = 'none';
});

function myFunction(chosen) {
    var eleccion = $('#tipo_pregunta').val();
    if (eleccion != '') {
        document.getElementById('preguntaGeneral').style.display = '';
    }

    if (eleccion === 'Abierta') {
        document.getElementById('respTipMultiple').style.display = 'none';
        document.getElementById('agregar').style.display = 'none';
    } else if (eleccion === 'Si y no') {
        document.getElementById('respTipMultiple').style.display = 'none';
        document.getElementById('agregar').style.display = 'none';
    } else if (eleccion === 'Opción múltiple') {
        document.getElementById('respTipMultiple').style.display = '';
        document.getElementById('agregar').style.display = '';
    } else if (eleccion === 'Seleccionar una opción') {
        document.getElementById('agregar').style.display = 'none';
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
//Cambia el estatus de ACTIVO, de una pregunta
function cambioEstatus(id, estatus, nombre) {
    var mensaje = '¿Esta seguro de cambiar el estatus de la pregunta ';
    mensaje = mensaje.concat(nombre);
    mensaje = mensaje.concat('?<br>');
    if (estatus == 't') {
        mensaje = mensaje.concat('Esta acción no afectará el estado de los cuestionarios ya aplicados.');
    } else {
        mensaje = mensaje.concat('Esta acción no afectara los cuestionarios anteriores ya aplicados, solo impide que la pregunta sea utilizada en proximos cuestionarios.');
    }
    var titulo = 'Cambio de estatus de la pregunta';
    alertify.confirm(
        titulo,
        mensaje,
        function () {
            var dml = 'cambio';
            var datos = {
                id: id,
                dml: dml,
                estatus: estatus,
            };
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Cuestionario.php',
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('Se cambio el estatus de la pregunta');
                        setTimeout(function () {
                            $('#container').load('../sistema/cuestionarios/frm_inicio_cuestionarios.php');
                        }, 1500);
                    } else {
                        alertify.error('Hubo un problema al cambiar el estatus de la pregunta');
                    }
                },
            });
        },
        function () {
            alertify.confirm().close();
        }
    );
    setTimeout(function () {
        $('#container').load('../sistema/cuestionarios/frm_inicio_cuestionarios.php');
    }, 1500);

    $(document).ready(function () {
        $('.sortable').sortable({
            update: function (event, ui) {
                $(this)
                    .children()
                    .each(function (index) {
                        if ($(this).attr('data-position') != index + 1) {
                            $(this)
                                .attr('data-position', index + 1)
                                .addClass('updated');
                        }
                    });
                guardandoPosiciones();
            },
        });
    });

    function guardandoPosiciones() {
        var positions = [];
        $('.updated').each(function () {
            positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
            $(this).removeClass('updated');
        });

        $.ajax({
            url: '../modulos/Control_Cuestionario.php',
            method: 'POST',
            dataType: 'text',
            data: {
                update: 1,
                positions: positions,
            },
            success: function (response) {
                console.log(response);
            },
        });
    }
}
