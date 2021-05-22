// Rutas
$(document).ready(function () {
    $('#btn_inicio').click(function () {
        $('#container').load('../sistema/inicio/frm_inicio.php');
    });

    $('#btn_cursos').click(function () {
        $('#container').load('../sistema/cursos/frm_inicio_cursos.php');
    });

    $('#btn_grupos').click(function () {
        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
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

    $('#btn_asist').click(function () {
        $('#container').load('../sistema/asistencia/frm_inicio_asistencia.php');
    });

    $('#btn_profesor').click(function () {
        $('#container').load('../sistema/profesor/frm_inicio_profesores.php');
    });
    
    $('#btn_regProp').click(function () {
        $('#container').load('../sistema/propuestas/frm_propuestas.php');
    });

    $('#btn_horario').click(function () {
        $('#container').load('../sistema/horarios/frm_inicio_horarios.php');
    });

    $('#btn_plataforma').click(function () {
        $('#container').load('../sistema/plataformas/frm_inicio_plataformas.php');
    });

    $('#btn_calendario').click(function () {
        $('#container').load('../sistema/calendarios/frm_inicio_calendarios.php');
    });
});

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

// Cambiar contraseña
function cambiarContraseña(id, persona) {
    var datos = {
        id: id,
        persona: persona,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/cuenta/frm_cambiar_contrasena.php',
        success: function (data) {
            $('#container').html(data);
        },
    });
}
