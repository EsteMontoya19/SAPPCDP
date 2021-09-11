$(document).ready(function () {
    $('#btn-regresar-constancia').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
    });
    $('#btn-consultar-constancias').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/constancia/frm_constancia.php');
        alertify.success('Lista de constancias generadas.');
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
                    alertify.error('El número de constancias dentro del zip es diferente al número de acreedores. Verifique el documento.');
                }
            },
        });
        return false;
    });
});

//Insertar Constancia Personal
$(document).ready(function () {
    $('#btn-registrar-constancia_personal').click(function () {
        
        datos = new FormData($('#form_constancias_personal')[0]);
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
                    alertify.error('Hubo un problema al cargar el archivo zip.');
                } else if (respuesta.endsWith('5')) {
                    alertify.error('El zip tiene un número de archivos diferente, del que fue solicitado.');
                }
            },
        });
        return false;
    });
});

//Actualizar constancia Manual
$(document).ready(function () {
    $('#btn-registrar-constancia-manual').click(function (){

        datos = new FormData($('#form_constancias_ds')[0]);
        $.ajax({
            type: 'POST',
            url: '../modulos/Control_Constancia.php',
            data: datos,
            contentType: false, 
            processData: false,

            success: function (respuesta) {
                console.log(respuesta);
                if(respuesta.endsWith('1')){
                    alertify.success('Se han asignado correctamente las constancias');
                    setTimeout(function () {
                        $('html, body').animate({ scrollTop: 0 }, 0);
                        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
                    }, 1500);
                } else if (respuesta.endsWith('2')) {
                    alertify.error('Debe seleccionar un profesor para poderle asignar constancia');
                } else if (respuesta.endsWith('3')) {
                    alertify.error('El archivo cargado para la constancia del profesor no tiene extensión .pdf');
                } else if(respuesta.endsWith('4')) {
                    alertitfy.error('El profesor al que intenta asignar una constancia no merece constancia, verifique sus asistencias primero.');
                } else if (respuesta.endsWith('5')) {
                    alertify.error('El archivo cargado para la constancia del instructor no tiene extensión .pdf');
                } else if (respuesta.endsWith('6')) {
                    alertify.error('El moderador al que intenta asignar constancia no es un profesor, por lo tanto no está permitido.')
                } else if(respuesta.endsWith('7')){
                    alertify.error('El archivo cargado para la constancia del moderador no tiene extensión .pdf')
                } else {
                    alertify.error('No se pudieron asignar las constancias' + respuesta);
                }
            },
        });
    });
});

//! Importante, sin esto el archivo no se puede cargar
$('.custom-file-input').on('change', function () {
    var fileName = $(this).val().split('\\').pop();
    $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
});