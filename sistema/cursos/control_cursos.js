// Enlace a los formularios

// document.querySelector('.numeros_permitidos').addEventListener('keypress', function (evt) {
//     if ((evt.which != 8 && evt.which != 0 && evt.which < 48) || evt.which > 57) {
//         evt.preventDefault();
//     }
// });

$(document).ready(function () {
    $('#btn-inicio-cursos').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/cursos/frm_inicio_cursos.php');
    });

    $('#btn-regresar-curso').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/cursos/frm_inicio_cursos.php');
    });

    $('#btn-registro-curso').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/cursos/frm_cursos.php');
    });
});

//Validar el formulario de cursos
function validarFormularioCurso(){    
    if ($('#strNombreCurso').val() == ''){
        $('html, body').animate({scrollTop: 0}, 'slow');
        document.getElementById('strNombreCurso').focus();
        alertify.error('Se debe ingresar el nombre del curso');
        return false;
    } else {
        if ($('#strNombreCurso').val().length > 50){
            $('html, body').animate({scrollTop: 0}, 'slow');
            document.getElementById('strNombreCurso').focus();
            alertify.error('El nombre del curso debe tener máximo 50 caracteres');
            return false;
        }

        if($('#strNombreCurso').val().includes('@') || $('#strNombreCurso').val().includes('.') || 
        $('#strNombreCurso').val().includes('/') || $('#strNombreCurso').val().includes('-') || 
        $('#strNombreCurso').val().includes('*') || $('#strNombreCurso').val().includes('!') || 
        $('#strNombreCurso').val().includes('#') || $('#strNombreCurso').val().includes('$') ||
        $('#strNombreCurso').val().includes('%') || $('#strNombreCurso').val().includes('^') ||
        $('#strNombreCurso').val().includes('&') || $('#strNombreCurso').val().includes('(') ||
        $('#strNombreCurso').val().includes(')') || $('#strNombreCurso').val().includes('-') ||
        $('#strNombreCurso').val().includes('=') || $('#strNombreCurso').val().includes('+') || 
        $('#strNombreCurso').val().includes(':') || $('#strNombreCurso').val().includes(';')){
            $('html, body').animate({scrollTop: 0}, 'slow');
            document.getElementById('strNombreCurso').focus();
            alertify.error('El nombre del curso no debe incluir caracteres especiales @, ., /, *, -, !, #, $, %, ^, &, *, (, ), -, +, =');
            return false;
        }
    }

    if ($('#intTipoCurso').val() == 0){
        alertify.error('Debe seleccionar un tipo: curso / taller');
        $('html, body').animate({scrollTop: 0}, 'slow');
        document.getElementById('intTipoCurso').focus();
        return false;
    }

    if ($('#intNivel').val() == 0){
        alertify.error('Debe seleccionar un nivel: Basico / Intermedio / Avanzado');
        $('html, body').animate({scrollTop: 0}, 'slow');
        document.getElementById('intNivel').focus();
        return false;
    }

    if ($('#strReqTec').val().length > 150){
        alertify.error('El campo de requisitos técnicos debe ser de máximo 150 caracteres');
        $('html, body').animate({scrollTop: 150}, 'slow');
        document.getElementById('strReqTec').focus();
        return false;
    }

    if ($('#strConNeces').val().length > 150){
        alertify.error('El campo de conocimientos necesarios debe ser de máximo 150 caracteres');
        $('html, body').animate({scrollTop: 150}, 'slow');
        document.getElementById('strConNeces').focus();
        return false;
    }

    if ($('#strObjCurso').val() == ''){
        $('html, body').animate({scrollTop: 150}, 'slow');
        document.getElementById('strObjCurso').focus();
        alertify.error('Se deben ingresar los objetivos del curso');
        return false;
    } else {
        if ($('#strObjCurso').val().length > 150){
            $('html, body').animate({scrollTop: 150}, 'slow');
            document.getElementById('strObjCurso').focus();
            alertify.error('Los objetivos del curso debe tener máximo 150 caracteres');
            return false;
        }
    }

    if ($('#strNumeroSesiones').val() == ''){
        alertify.error('Debe ingresar un número de sesiones para el curso');
        $('html, body').animate({scrollTop: 150}, 'slow');
        document.getElementById('strNumeroSesiones').focus();
        return false;
    } else {
        if ($('#strNumeroSesiones').val() < 1){
            alertify.error('El número de sesiones debe ser minimo 1');
            $('html, body').animate({scrollTop: 150}, 'slow');
            document.getElementById('strNumeroSesiones').focus();
            return false;
        }
        var numExp = /^([0-9])*$/;
        if (numExp.test($('#strNumeroSesiones').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strNumeroSesiones').focus();
            alertify.error('Las sesiones solo pueden ser númericas');
            return false;
        }
    }



    return true; 

}

function consultarCursoDirecto(id) {
    var datos = {
        id: id,
        CRUD: 0,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/cursos/frm_cursos.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}
//Actualizar Curso
function actualizarCursoDirecto(id) {
    var datos = {
        id: id,
        CRUD: 1,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/cursos/frm_cursos.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

//Actualizar Curso
$(document).ready(function () {
    $('#btn-actualizar-curso').click(function () {
        if (validarFormularioCurso()) {
            datos =  new FormData ($('#form_cursos')[0]);

            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Curso.php',
                data: datos,
                contentType: false,
                processData: false,

                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/cursos/frm_inicio_cursos.php');
                        }, 0);
                    } else if (respuesta.endsWith('2')){
                        $('html, body').animate({scrollTop: 0}, 'slow');
                        alertify.error('El curso en ese nivel y tipo, ya exite');
                    } else {
                        alertify.error('Hubo un problema al registrar el curso');
                    };
                },
            });
            return false;
        }
    });
});


//Insertar Curso
$(document).ready(function () {
    $('#btn-registrar-curso').click(function () {
        if (validarFormularioCurso()){
            datos =  new FormData ($('#form_cursos')[0]);
            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Curso.php',
                data: datos,
                contentType: false,
                processData: false,

                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')){
                        alertify.success('El registro se realizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({scrollTop: 0}, 0);
                            $('#container').load('../sistema/cursos/frm_inicio_cursos.php');
                        }, 1500);
                    } else if (respuesta.endsWith('2')){
                        $('html, body').animate({scrollTop: 200}, 'slow');
                        document.getElementById('strNombreCurso').focus();
                        alertify.error('El curso en ese nivel y tipo, ya exite.');
                    } else if (respuesta.endsWith('3')) {
                        $('html, body').animate({scrollTop: 200}, 'slow');
                        document.getElementById('temario').focus();
                        alertify.error('Debe ingresar un temario del curso');
                    } else {
                        alertify.error('Hubo un problema al registrar el curso');
                    }
                },
            });
            return false;
        }
    });
});

function cambioEstatus(id, estatus, nombre) {
    var mensaje = '¿Esta seguro de cambiar el estatus del curso ';
    mensaje = mensaje.concat(nombre);
    mensaje = mensaje.concat('?<br>');
    if (estatus == 't') {
        mensaje = mensaje.concat('Esta acción no activara el estado de los grupos relacionados.');
    } else {
        mensaje = mensaje.concat('Los grupos de este curso seguiran vigentes, esta acción solo impide la creación de nuevos grupos de este curso.');
    }
    var titulo = 'Cambio de estatus del curso';
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
                url: '../modulos/Control_Curso.php',
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('Se cambio el estatus del curso');
                        setTimeout(function () {
                            $('#container').load('../sistema/cursos/frm_inicio_cursos.php');
                        }, 1500);
                    } else {
                        alertify.error('Hubo un problema al cambiar el estatus del usuario PRUEBAS');
                    }
                },
            });
        },
        function () {
            alertify.confirm().close();
            //$('#container').load('../sistema/cursos/frm_inicio_cursos.php');
        }
    );
    setTimeout(function () {
        $('#container').load('../sistema/cursos/frm_inicio_cursos.php');
    }, 1500);
}

// Tabla dinámica
$(document).ready(function () {
    $('#tabla_cursos').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json',
        },
        pageLength: 10,
        lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, 'Todos'],
        ],
    });
});

$('.custom-file-input').on('change', function () {
    var fileName = $(this).val().split('\\').pop();
    $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
});
