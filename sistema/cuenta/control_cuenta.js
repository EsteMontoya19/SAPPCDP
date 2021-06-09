function validarFormulario() {
    if ($('#strUsuario').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('strUsuario').focus();
        alertify.error('Debe ingresar un usuario');
        return false;
    }

    if ($('#strContrasena').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('strContrasena').focus();
        alertify.error('Debe ingresar una contraseña');
        return false;
    }

    return true;
}

alert("Entra a su control");

$(document).ready(function () {

    $('#btn-comprobar-usuario').click(function () {
        if (validarFormulario()) {
            datos = $('#validacion_acceso').serialize();
            console.log(datos);
            //var idCurso = $('#ID_Curso').val();
            var dml = 'contrasena';
            var datos = {
                dml: dml,
            };
    
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Contrasena.php',
                success: function (respuesta) {
                    alert($('#idPersona').val());
                    //$('#contenedorContrasena').load('../sistema/cuenta/frm_contrasena.php', { otro: respuesta });
                    $('#container').load('../sistema/cuenta/frm_contrasena.php', {id: $('#idUsuario').val(), persona: $('#idPersona').val() });
                },
            });
        }
    });

});

function validarUsuario () {

}