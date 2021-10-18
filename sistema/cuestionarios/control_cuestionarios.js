//? Enlace a los formularios y campos dinamicos
var inciso = 1;

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

    // $('#button_detalles').click(function () {
    //     $('html, body').animate({ scrollTop: 0 }, 0);
    //     $('#container').load('../sistema/cuestionarios/frm_cuestionarios.php');
    //     consultarPreguntaDirecto;
    // });

    //? Esta variable sirve para los campos dinamicos
    if (typeof $('#diasActualizacion').val() != 'undefined') {
        inciso = $('#diasActualizacion').val();
    } else {
        inciso = 1;
    }

    $('#add').click(function () {
        if(inciso == 6) {
            alertify.error("No se pueden generar más de 7 opciones para una pregunta");
        } else {
            inciso++;
            $('#dynamic_field').append('<tr id="row' + inciso + '"> <td> <input type="text" class="form-control" id="opcion' + inciso + '" name="opcion' + inciso + '" value="" placeholder="Opcion  '+ (inciso + 1) + '" td></tr>');
        }
    });

    $('#remove').click(function () {
        if (inciso > 1) {
            inciso--;
        }
        $('#row' + (inciso + 1)).remove();
    });

    document.getElementById('respuestaMultiple').style.display = 'none';
    document.getElementById('preguntaGeneral').style.display = 'none';
});

function myFunction(chosen) {
    var eleccion = $('#tipo_pregunta').val();
    if (eleccion != '') {
        document.getElementById('preguntaGeneral').style.display = '';
    }
    if (eleccion === 'Abierta') {
        document.getElementById('respuestaMultiple').style.display = 'none';
        document.getElementById('agregar').style.display = 'none';
    } else if (eleccion === 'Si y no') {
        document.getElementById('respuestaMultiple').style.display = 'none';
        document.getElementById('agregar').style.display = 'none';
    } else if (eleccion === 'Opción múltiple') {
        document.getElementById('respuestaMultiple').style.display = '';
        document.getElementById('agregar').style.display = '';
    } else if (eleccion === 'Seleccionar una opción') {
        document.getElementById('preguntaGeneral').style.display = 'none';
        document.getElementById('respuestaMultiple').style.display = 'none';
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
    if (estatus == 'f') {
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
}

//Actualizar Pregunta
$(document).ready(function () {
    $('#btn-actualizar-cuestionario').click(function () {
        if (validarFormularioPregunta()) {
            datos = new FormData($('#form_preguntas')[0]);

            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Cuestionario.php',
                data: datos,
                contentType: false,
                processData: false,

                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/cuestionarios/frm_inicio_cuestionarios.php');
                        }, 0);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        alertify.error('La pregunta ya ha sido respondida por al menos un profesor y puede se modificada.');
                    } else {
                        alertify.error('Hubo un problema al actualizar la pregunta');
                    }
                },
            });
            return false;
        }
    });
});

//Insertar Pregunta
$(document).ready(function () {
    $('#btn-registrar-cuestionario').click(function () {
        if (validarFormularioCuestionario()) {
            datos = new FormData($('#form_preguntas')[0]);
            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Cuestionario.php',
                data: datos,
                contentType: false,
                processData: false,

                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se realizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../cuestionarios/frm_inicio_cuestionarios.php');
                        }, 1500);
                    } else {
                        alertify.error('Hubo un problema al registrar la pregunta');
                    }
                },
            });
            return false;
        }
    });
});

//Botón
function consultarPreguntaDirecto(id) {
    var datos = {
        id: id,
        CRUD: 0,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/cuestionarios/frm_cuestionarios.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}
//Actualizar Pregunta
function actualizarPreguntaDirecto(id) {
    var datos = {
        id: id,
        CRUD: 1,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/cuestionarios/frm_cuestionarios.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

//Elimina una pregunta
function eliminarPreguntaDirecto(id, tipo, nombre) {
    var mensaje = '¿Esta seguro de eliminar la pregunta ';
    mensaje = mensaje.concat(nombre);
    mensaje = mensaje.concat('?<br>');
    mensaje = mensaje.concat('Esta acción no afectará el estado de los cuestionarios ya aplicados.');

    var titulo = 'Eliminar pregunta';
    alertify.confirm(
        titulo,
        mensaje,
        function () {
            var dml = 'delete';
            var datos = {
                id: id,
                dml: dml,
                tipo: tipo,
            };
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Cuestionario.php',
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('Se eliminó la pregunta');
                        setTimeout(function () {
                            $('#container').load('../sistema/cuestionarios/frm_inicio_cuestionarios.php');
                        }, 1500);
                    } else if (respuesta == 2) {
                        alertify.error('Esta pregunta ya ha sido respondida y forma parte del hisótico por lo que no puede eliminarse ni actualizarse');
                    } else {
                        alertify.error('Hubo un problema al eliminar la pregunta');
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
}

function validarFormularioCuestionario() {
    if ($('#tipo_pregunta').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('tipo_pregunta').focus();
        alertify.error('Se debe ingresar la descripción de la pregunta');
        return false;
    } else {
        if ($('#tipo_pregunta').val().length >= 300) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('tipo_pregunta').focus();
            alertify.error('El nombre del curso debe tener máximo 300 caracteres');
            return false;
        }
    }

    if ($('#pregunta').val() == 0) {
        alertify.error('Debe ingresar una pregunta');
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('pregunta').focus();
        return false;
    }
    if ($('#opcion0').val() == '' || typeof($('#opcion0').val()) == 'undefined' || $('#opcion0').val() == ' ') {
        alertify.error('Debe ingresar al menos 2 opciones.');
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('opcion0').focus();
        return false;
    }

    if ($('#opcion1').val() == '' || typeof($('#opcion1').val()) == 'undefined' || $('#opcion1').val() == ' ') {
        alertify.error('Debe ingresar al menos 2 opciones.');
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('opcion1').focus();
        return false;
    }
    for (let iCont = 2; typeof($('#opcion' + iCont).val()) != 'undefined' ; iCont++) {
        if ($('#opcion' + iCont).val() == '' ||  $('#opcion'  + iCont).val() == ' ') {
            alertify.error('Debe ingresar al menos 2 opciones.');
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('opcion'  + iCont).focus();
            return false;
        }
        
    }

    //Debe validar que minimo sean dos opciones

    return true;
}

function validarFormularioPregunta() {
    if ($('#tipo_pregunta').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('tipo_pregunta').focus();
        alertify.error('Se debe ingresar la descripción de la pregunta');
        return false;
    } else {
        if ($('#tipo_pregunta').val().length >= 300) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('tipo_pregunta').focus();
            alertify.error('El nombre del curso debe tener máximo 300 caracteres');
            return false;
        }
    }

    return true;
}
