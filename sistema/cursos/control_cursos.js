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
//TODO: Modificar
function cambioEstatus(id, estatus, nombre) {
    var mensaje = '¿Esta seguro de cambiar el estatus del curso ';
    mensaje = mensaje.concat(nombre);
    mensaje = mensaje.concat('?<br>');
    if(estatus == 't') {
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
