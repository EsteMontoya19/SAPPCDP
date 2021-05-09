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

$(document).ready(function () {
    $('#btn-actualizar-curso').click(function () {
        if (validarFormularioCursos()) {
            datos = $('#form_cursos').serialize();
            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Curso.php',
                data: datos,
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/cursos/frm_inicio_cursos.php');
                        }, 0);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 200 }, 'slow');
                        document.getElementById('strNombreCurso').focus();
                        alertify.error('El nombre del curso ya existe');
                    } else {
                        alertify.error('Hubo un problema al registrar el curso');
                    }
                },
            });
            return false;
        }
    });
});

//TODO: Modificar
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
