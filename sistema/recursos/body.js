//? Cambios de estados automaticos
// window.onload = function () {
//     alert ("Al cargar esta funcionando.");

//     setTimeout(function () {
//         alert("Esto se agregó a la fila y se muestra despues de un tiempo");
//     }, 5000);
// }

if (document.getElementById('idRol') != null) {
    if (document.getElementById('idRol').value == 4) {
        window.onload = $('#container').load('../sistema/inicio/frm_grupos_inicio.php', { persona: document.getElementById('idPersona').value });
    } else {
        window.onload = $('#container').load('../sistema/inicio/frm_inicio.php');
    }

}

//? Rutas
$(document).ready(function () {
    $('#btn_inicio').click(function () {
        location.reload();
    });

    $('#btn_cursos').click(function () {
        $('#container').load('../sistema/cursos/frm_inicio_cursos.php');
    });

    $('#btn_grupos').click(function () {
        var datos = {
            origen: 'grupos',
        };

        $.ajax({
            data: datos,
            type: 'POST',
            url: '../modulos/Control_Automatico.php',
            success: function (respuesta) {
                // console.log(respuesta);
                if (respuesta.endsWith('1')) {
                    alertify.success('Grupos actualizados.');
                } else if (respuesta == 2) {
                    alertify.error('Error al actualizar estados grupo.');
                }
                $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
            },
        });
    });

    $('#btn_propuestas').click(function () {
        $('#container').load('../sistema/propuestas/frm_inicio_propuestas.php');
    });

    $('#btn_reportes').click(function () {
        $('#container').load('../sistema/reportes/frm_inicio_reportes.php');
    });

    $('#btn_usuarios').click(function () {
        $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
    });

    $('#btn_DescargarExcel').click(function () {
        $('#container').load('../sistema/constancia/frm_constancia.php');
    });
    $('#btn_gruposPrivados').click(function () {
        $('#container').load('../sistema/inscripciones/frm_privados.php');
    });

    $('#btn_SubirConstancias').click(function () {
        $('#container').load('../sistema/constancia/frm_registrar_constancias_personal.php');
    });

    $('#btn_profesor_grupos').click(function () {
        $('#container').load('../sistema/profesor/frm_inicio_profesores.php');
    });

    $('#btn_profesor_grupos_inscritos').click(function () {
        $('#container').load('../sistema/profesor/frm_profesor_inscripciones.php');
    });

    $('#btn_instructor_grupos_impartir').click(function () {
        $('#container').load('../sistema/instructor/frm_inicio_instructor.php');
    });

    $('#btn_regProp').click(function () {
        $('#container').load('../sistema/propuestas/frm_propuestas.php');
    });

    $('#btn_horario').click(function () {
        $('#container').load('../sistema/horarios/frm_inicio_horarios.php');
    });

    $('#btn_preguntaseguridad').click(function () {
        $('#container').load('../sistema/preguntasseguridad/frm_inicio_preguntasseguridad.php');
    });

    $('#btn_plataforma').click(function () {
        $('#container').load('../sistema/plataformas/frm_inicio_plataformas.php');
    });

    $('#btn_coordinacion').click(function () {
        $('#container').load('../sistema/coordinaciones/frm_inicio_coordinaciones.php');
    });

    $('#btn_nombramiento').click(function () {
        $('#container').load('../sistema/nombramientos/frm_inicio_nombramientos.php');
    });

    $('#btn_cuestionarios').click(function () {
        $('#container').load('../sistema/cuestionarios/frm_inicio_cuestionarios.php');
    });

    $('#btn_calendario').click(function () {
        $('#container').load('../sistema/calendarios/frm_inicio_calendarios.php');
    });
});

function FormularioAutoRegistro() {
    $('#Auto-registro').load('sistema/usuarios/frm_autoregistro.php');
    //$('#container').load('../usuario/frm_autoregistro.php');
}
// Ir a mi cuenta
function miCuenta(id, persona) {
    var datos = {
        id: id,
        persona: persona,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/cuenta/frm_mi_cuenta.php',
        success: function (data) {
            $('#container').html(data);
        },
    });
}
//? Permite ver los cursos a moderar
function asistenciasModerador(idUsuario) {
    var datos = {
        origen: 'constancias',
    };

    //?     El primer AJAX busca actualizar los estados de las contancias
    $.ajax({
        data: datos,
        type: 'POST',
        url: '../modulos/Control_Automatico.php',
        success: function () {
            var datos2 = {
                idUsuario: idUsuario,
            };

            $.ajax({
                data: datos2,
                type: 'POST',
                url: '../sistema/asistencia/frm_inicio_asistencia.php',
                success: function (data) {
                    $('#container').html(data);
                },
            });
        },
    });
}

// Cambio de contraseña y datos de usuario
function cambiarContrasena(id, persona) {
    var datos = {
        id: id,
        persona: persona,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/cuenta/frm_validacion.php',
        success: function (data) {
            $('#container').html(data);
        },
    });
}

//Listar Grupos publicados
function gruposPublicados(persona) {
    var datos = {
        persona: persona,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/profesor/frm_inicio_profesores.php',
        success: function (data) {
            $('#container').html(data);
        },
    });
}

//Listar Grupos inscritos en Curso o Pendientes
function gruposInscritos(persona) {
    var datos = {
        persona: persona,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/profesor/frm_profesor_inscripciones.php',
        success: function (data) {
            $('#container').html(data);
        },
    });
}

//Listar Grupos inscritos Históricos
function gruposInscritosHistoricos(persona) {
    var datos = {
        origen: 'constancias',
    };

    //?     El primer AJAX busca actualizar los estados de las contancias
    $.ajax({
        data: datos,
        type: 'POST',
        url: '../modulos/Control_Automatico.php',
        success: function () {
            var datos2 = {
                persona: persona,
            };

            $.ajax({
                data: datos2,
                type: 'POST',
                url: '../sistema/profesor/frm_profesor_historicos.php',
                success: function (data) {
                    $('#container').html(data);
                },
            });
        },
    });
}

function gruposImpartir(persona) {
    var datos = {
        persona: persona,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/instructor/frm_inicio_instructor.php',
        success: function (data) {
            $('#container').html(data);
        },
    });
}

//Listar grupos historicos de un instructor
function gruposImpartirHistoricos(persona) {
    var datos = {
        origen: 'constancias',
    };

    //?     El primer AJAX busca actualizar los estados de las contancias
    $.ajax({
        data: datos,
        type: 'POST',
        url: '../modulos/Control_Automatico.php',
        success: function (respuesta) {
            var datos2 = {
                persona: persona,
            };

            $.ajax({
                data: datos2,
                type: 'POST',
                url: '../sistema/instructor/frm_historicos_instructor.php',
                success: function (data) {
                    $('#container').html(data);
                },
            });
        },
    });
}

//Mostrar contraseña de la comprobación
function hideOrShowPassword() {
    var x = document.getElementById('strContrasena');
    if (x.type === 'password') {
        x.type = 'text';
    } else {
        x.type = 'password';
    }
}
