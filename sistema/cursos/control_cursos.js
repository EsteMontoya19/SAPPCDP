// Enlace a los formularios

// document.querySelector('.numeros_permitidos').addEventListener('keypress', function (evt) {
//     if ((evt.which != 8 && evt.which != 0 && evt.which < 48) || evt.which > 57) {
//         evt.preventDefault();
//     }
// });

$(document).ready(function () {
    $('#btn-inicio-cursos').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/cursos/frm_cursos_vigentes.php');
    });

    $('#btn-regresar-curso').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/cursos/frm_cursos_vigentes.php');
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

function cambsioEstatus(id, estatus, nombre) {
    alert('Presionado');

    var mensaje = '¿Esta seguro de cambiar el estatus del curso ';
    mensaje = mensaje.concat(nombre);
    mensaje = mensaje.concat('?');

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
                        alertify.success('Se cambio el estatus del usuario');
                        setTimeout(function () {
                            $('#container').load('../sistema/usuarios/frm_cursos_vigentes.php');
                        }, 1500);
                    } else {
                        alertify.error('Hubo un problema al cambiar el estatus del usuario PRUEBAS');
                    }
                },
            });
        },
        function () {
            alertify.confirm().close();
        }
    );
    setTimeout(function () {
        $('#container').load('../sistema/usuarios/frm_cursos_vigentes.php');
    }, 1500);
}
