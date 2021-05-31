// Rutas
$(document).ready(function () {
    $('#btn-inicio-usuario').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
    });

    $('#btn-regresar-usuario').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
    });

    $('#btn-registro-usuario').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/usuarios/frm_usuarios.php');
    });
});

// Validar el formulario alumnos
function validarFormularioUsuario() {
    if ($('#strUsuarioNombre').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('strUsuarioNombre').focus();
        alertify.error('Se debe ingresar el nombre del usuario');
        return false;
    } else {
        if ($('#strUsuarioNombre').val().length > 50) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strUsuarioNombre').focus();
            alertify.error('El nombre de usuario debe tener máximo 50 caracteres');
            return false;
        }

        var letExp = /^([a-zA-Z\s])*$/;
        if (letExp.test($('#strUsuarioNombre').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioNombre').focus();
            alertify.error('El nombre debe estar compuesto unicamente por letras (a-z, A-Z).');
            return false;
        }
    }

    if ($('#strUsuarioPrimerApe').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('strUsuarioPrimerApe').focus();
        alertify.error('Se debe ingresar el primer apellido del usuario');
        return false;
    } else {
        if ($('#strUsuarioPrimerApe').val().length > 50) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strUsuarioPrimerApe').focus();
            alertify.error('El apellido paterno debe tener máximo 50 caracteres');
            return false;
        }

        var letExp = /^([a-zA-Z])*$/;
        if (letExp.test($('#strUsuarioPrimerApe').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioPrimerApe').focus();
            alertify.error('El apellido paterno debe estar compuesto unicamente por letras (a-z, A-Z).');
            return false;
        }
    }

    if ($('#strUsuarioSegundoApe').val() != '') {
        if ($('#strUsuarioSegundoApe').val().length > 50) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strUsuarioSegundoApe').focus();
            alertify.error('El apellido materno debe tener máximo 50 caracteres');
            return false;
        }
        var letExp = /^([a-zA-Z])*$/;
        if (letExp.test($('#strUsuarioSegundoApe').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioSegundoApe').focus();
            alertify.error('El apellido materno debe estar compuesto unicamente por letras (a-z, A-Z).');
            return false;
        }
    }


    if ($('#strUsuarioCorreo').val() == '') {
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('strUsuarioCorreo').focus();
        alertify.error('Se debe ingresar el correo del usuario');
        return false;
    } else {
        var emailExp = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/;
        if (emailExp.test($('#strUsuarioCorreo').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioCorreo').focus();
            alertify.error('La direccion del correo es inválida');
            return false;
        }
        if ($('#strUsuarioCorreo').val().length > 30) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strUsuarioCorreo').focus();
            alertify.error('El correo electronico debe tener máximo 30 caracteres');
            return false;
        }
    }

    if ($('#strUsuarioTelefono').val() == '') {
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('strUsuarioTelefono').focus();
        alertify.error('Se debe ingresar el teléfono del usuario');
        return false;
    } else {
        var tel = $('#strUsuarioTelefono').val();
        var total_numeros = tel.length;

        if (total_numeros < 10) {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioTelefono').focus();
            alertify.error('El teléfono debe incluir mínimo 10 dígitos.');
            return false;
        } else if (total_numeros > 10) {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioTelefono').focus();
            alertify.error('El teléfono debe incluir máximo 10 dígitos.');
            return false;
        } else if (total_numeros == 10) {
            var numExp = /^([0-9])*$/;
            if (numExp.test($('#strUsuarioTelefono').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('strUsuarioTelefono').focus();
                alertify.error('El teléfono debe de incluir solo números.');
                return false;
            }
        }
    }

    //? Validación datos de usuario
    if ($('#strNombreUsuario').val() == '') {
        alertify.error('Se debe ingresar el identificador del usuario');
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('strNombreUsuario').focus();
        return false;
    } else {
        if ($('#strNombreUsuario').val().length > 15) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strNombreUsuario').focus();
            alertify.error('El nombre de usuario debe tener máximo 15 caracteres');
            return false;
        }
    }

    if ($('#intUsuarioRol').val() == 0) {
        alertify.error('Debe seleccionar un rol de usuario');
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('intUsuarioRol').focus();
        return false;
    }

    if ($('#UsuarioPregunta').val() == 0) {
        alertify.error('Debe seleccionar una pregunta de seguridad');
        $('html, body').animate({ scrollTop: 250 }, 'slow');
        document.getElementById('UsuarioPregunta').focus();
        return false;
    }

    if ($('#UsuarioRespuesta').val() == '') {
        alertify.error('Se debe ingresar una respuesta a la pregunta');
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('UsuarioRespuesta').focus();
        return false;
    } else {
        if ($('#UsuarioRespuesta').val().length > 30) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('UsuarioRespuesta').focus();
            alertify.error('La respuesta debe tener máximo 15 caracteres');
            return false;
        }
    }

    if ($('#strContrasenia01').val() == '') {
        alertify.error('Debe ingresar una contraseña');
        $('html, body').animate({ scrollTop: 250 }, 'slow');
        document.getElementById('strContrasenia01').focus();
        return false;
    } else {
        if ($('#strContrasenia01').val().length > 20) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strContrasenia01').focus();
            alertify.error('La contraseña debe tener máximo 20 caracteres.');
            return false;
        }
    }

    if ($('#strContrasenia02').val() == '') {
        alertify.error('Debe ingresar la confirmación de la contraseña');
        $('html, body').animate({ scrollTop: 250 }, 'slow');
        document.getElementById('strContrasenia02').focus();
        return false;
    }

    if ($('#strContrasenia01').val() != $('#strContrasenia02').val()) {
        alertify.error('Las contraseña no coinciden en alguno de los campos');
        $('html, body').animate({ scrollTop: 300 }, 'slow');
        document.getElementById('strContrasenia01').focus();
        return false;
    }

    //? Validación datos de cuenta según rol
    if ($('#intUsuarioRol').val() == 1) {
        if ($('#intNum_Trabajador').val() == '') {
            alertify.error('Debe ingresar un número de trabajador');
            $('html, body').animate({ scrollTop: 250 }, 'slow');
            document.getElementById('intNum_Trabajador').focus();
            return false;
        } else {
            var numExp = /^([0-9])*$/;
            if (numExp.test($('#intNum_Trabajador').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El numero de trabajador de incluir unicamente números.');
                return false;
            }
            if ($('#intNum_Trabajador').val().length > 10) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El número de trabajador debe tener máximo 10 caracteres.');
                return false;
            }
        }

        if ($('#strRFC').val() == '') {
            alertify.error('Debe ingresar su RFC');
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strRFC').focus();
            return false;
        } else {
            if ($('#strRFC').val().length > 13) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strRFC').focus();
                alertify.error('El RFC debe tener máximo 13 caracteres.');
                return false;
            }
            var rfcExp = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            if (rfcExp.test($('#strRFC').val())) {
            } else {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strRFC').focus();
                alertify.error('El RFC de ser con homoclave y mayusculas <br> El formato es (NNNN000000XXX).');
                return false;
            }
        }
    }

    //? Los de moderador

    if ($('#intUsuarioRol').val() == 2) {
        var algunSeleccionado = 0;
        var iCont = 1;
        while (iCont < 7) {
            var isChecked = document.getElementById('strDiaServicio' + iCont).checked;
            if (isChecked) {
                algunSeleccionado++;
            }
            iCont++;
        }
        if (algunSeleccionado == 0) {
            alertify.error('Debe seleccionar al menos un día para realizar el servicio social.');
            return false;
        }

        if ($('#intNumCuenta').val() == '') {
            alertify.error('Debe ingresar su número de cuenta.');
            $('html, body').animate({ scrollTop: 250 }, 'slow');
            document.getElementById('intNumCuenta').focus();
            return false;
        } else {
            if ($('#intNumCuenta').val().length < 6) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNumCuenta').focus();
                alertify.error('El número de cuenta debe tener al menos 6 cifras');
                return false;
            }

            if ($('#intNumCuenta').val().length > 6 && $('#intNumCuenta').val().length < 9) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNumCuenta').focus();
                alertify.error('El número de cuenta debe tener al menos 6 cifras y máximo 9');
                return false;
            }

            if ($('#intNumCuenta').val().length > 9) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNumCuenta').focus();
                alertify.error('El número de cuenta debe tener máximo 10 cifras.');
                return false;
            }

            var numExp = /^([0-9])*$/;
            if (numExp.test($('#intNumCuenta').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('intNumCuenta').focus();
                alertify.error('El numero de cuenta de incluir unicamente números.');
                return false;
            }
        }

        if ($('#strFechaInicio').val() == '') {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strFechaInicio').focus();
            alertify.error('Debe ingresar una fecha de inicio de servicio social');
            return false;
        }
        if ($('#strFechaFin').val() == '') {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strFechaFin').focus();
            alertify.error('Debe ingresar una fecha de fin de servicio social');
            return false;
        }
        if ($('#strHoraInicio').val() == '') {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strHoraInicio').focus();
            alertify.error('Debe ingresar una hora de inicio de servicio social');
            return false;
        }
        if ($('#strHoraFin').val() == '') {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strHoraFin').focus();
            alertify.error('Debe ingresar una hora de fin de servicio social');
            return false;
        }

        if ($('#strHoraFin').val() <= $('#strHoraInicio').val()) {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strHoraFin').focus();
            alertify.error('La hora de fin no puede ser menor o igual a la inicial.');
            return false;
        }
    }

    if ($('#intUsuarioRol').val() == 3) {
        if ($('#intNum_Trabajador').val() == '') {
            alertify.error('Debe ingresar un número de trabajador');
            $('html, body').animate({ scrollTop: 250 }, 'slow');
            document.getElementById('intNum_Trabajador').focus();
            return false;
        } else {
            var numExp = /^([0-9])*$/;
            if (numExp.test($('#intNum_Trabajador').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El numero de trabajador de incluir unicamente números.');
                return false;
            }
            if ($('#intNum_Trabajador').val().length > 10) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El número de trabajador debe tener máximo 10 caracteres.');
                return false;
            }
        }
        if ($('#strRFC').val() == '') {
            alertify.error('Debe ingresar su RFC');
            $('html, body').animate({ scrollTop: 250 }, 'slow');
            document.getElementById('strRFC').focus();
            return false;
        } else {
            if ($('#strRFC').val().length > 13) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strRFC').focus();
                alertify.error('El RFC debe tener máximo 13 caracteres.');
                return false;
            }
            var rfcExp = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            if (rfcExp.test($('#strRFC').val())) {
            } else {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strRFC').focus();
                alertify.error('El RFC de ser con homoclave y mayusculas <br> El formato es (NNNN000000XXX).');
                return false;
            }
        }

        if ($('#strSemblanza').val() == '') {
            alertify.error('Debe ingresar su semblanza');
            $('html, body').animate({ scrollTop: 250 }, 'slow');
            document.getElementById('strSemblanza').focus();
            return false;
        } else {
            if ($('#strSemblanza').val().length > 500) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strSemblanza').focus();
                alertify.error('Solo cuenta con 500 caractéres para su semblanza.');
                return false;
            }
        }
        var algunSeleccionado = 0;
        var iCont = 1;
        while (iCont <= 2) {
            var isChecked = document.getElementById('strNivel' + iCont).checked;
            if (isChecked) {
                algunSeleccionado++;
            }
            iCont++;
        }
        if (algunSeleccionado == 0) {
            alertify.error('Debe seleccionar al menos un nivel en el que se imparte clases.');
            return false;
        }

        var algunSeleccionado = 0;
        var iCont = 1;
        while (iCont <= 3) {
            var isChecked = document.getElementById('strModalidad' + iCont).checked;
            if (isChecked) {
                algunSeleccionado++;
            }
            iCont++;
        }
        if (algunSeleccionado == 0) {
            alertify.error('Debe seleccionar al menos una modalidad en la que imparta clases.');
            return false;
        }

        var algunSeleccionado = 0;
        var iCont = 1;
        while (iCont <= 24) {
            var isChecked = document.getElementById('strCoordinacion' + iCont).checked;
            if (isChecked) {
                algunSeleccionado++;
            }
            iCont++;
        }
        if (algunSeleccionado == 0) {
            alertify.error('Debe seleccionar al menos una coordinación en la que participe.');
            return false;
        }
    }
    return true;
}
// Validar el formulario mi cuenta
function validarFormularioUsuarioMiCuenta() {
    if ($('#strUsuarioNombre').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('strUsuarioNombre').focus();
        alertify.error('Se debe ingresar el nombre del usuario');
        return false;
    } else {
        if ($('#strUsuarioNombre').val().length > 50) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strUsuarioNombre').focus();
            alertify.error('El nombre de usuario debe tener máximo 50 caracteres');
            return false;
        }

        var letExp = /^([a-zA-Z\s])*$/;
        if (letExp.test($('#strUsuarioNombre').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioNombre').focus();
            alertify.error('El nombre debe estar compuesto unicamente por letras (a-z, A-Z).');
            return false;
        }
    }

    if ($('#strUsuarioPrimerApe').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('strUsuarioPrimerApe').focus();
        alertify.error('Se debe ingresar el primer apellido del usuario');
        return false;
    } else {
        if ($('#strUsuarioPrimerApe').val().length > 50) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strUsuarioPrimerApe').focus();
            alertify.error('El apellido paterno debe tener máximo 50 caracteres');
            return false;
        }

        var letExp = /^([a-zA-Z])*$/;
        if (letExp.test($('#strUsuarioPrimerApe').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioPrimerApe').focus();
            alertify.error('El apellido paterno debe estar compuesto unicamente por letras (a-z, A-Z).');
            return false;
        }
    }

    if ($('#strUsuarioSegundoApe').val() != '') {
        if ($('#strUsuarioSegundoApe').val().length > 50) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strUsuarioSegundoApe').focus();
            alertify.error('El apellido materno debe tener máximo 50 caracteres');
            return false;
        }
        var letExp = /^([a-zA-Z])*$/;
        if (letExp.test($('#strUsuarioSegundoApe').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioSegundoApe').focus();
            alertify.error('El apellido materno debe estar compuesto unicamente por letras (a-z, A-Z).');
            return false;
        }
    }


    if ($('#strUsuarioCorreo').val() == '') {
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('strUsuarioCorreo').focus();
        alertify.error('Se debe ingresar el correo del usuario');
        return false;
    } else {
        var emailExp = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/;
        if (emailExp.test($('#strUsuarioCorreo').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioCorreo').focus();
            alertify.error('La direccion del correo es inválida');
            return false;
        }
        if ($('#strUsuarioCorreo').val().length > 30) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strUsuarioCorreo').focus();
            alertify.error('El correo electronico debe tener máximo 30 caracteres');
            return false;
        }
    }

    if ($('#strUsuarioTelefono').val() == '') {
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('strUsuarioTelefono').focus();
        alertify.error('Se debe ingresar el teléfono del usuario');
        return false;
    } else {
        var tel = $('#strUsuarioTelefono').val();
        var total_numeros = tel.length;

        if (total_numeros < 10) {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioTelefono').focus();
            alertify.error('El teléfono debe incluir mínimo 10 dígitos.');
            return false;
        } else if (total_numeros > 10) {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioTelefono').focus();
            alertify.error('El teléfono debe incluir máximo 10 dígitos.');
            return false;
        } else if (total_numeros == 10) {
            var numExp = /^([0-9])*$/;
            if (numExp.test($('#strUsuarioTelefono').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('strUsuarioTelefono').focus();
                alertify.error('El teléfono debe de incluir solo números.');
                return false;
            }
        }
    }

    //? Validación datos de usuario

    if ($('#intUsuarioRol').val() == 0) {
        alertify.error('Debe seleccionar un rol de usuario');
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('intUsuarioRol').focus();
        return false;
    }


    //? Validación datos de cuenta según rol
    if ($('#intUsuarioRol').val() == 1) {
        if ($('#intNum_Trabajador').val() == '') {
            alertify.error('Debe ingresar un número de trabajador');
            $('html, body').animate({ scrollTop: 250 }, 'slow');
            document.getElementById('intNum_Trabajador').focus();
            return false;
        } else {
            var numExp = /^([0-9])*$/;
            if (numExp.test($('#intNum_Trabajador').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El numero de trabajador de incluir unicamente números.');
                return false;
            }
            if ($('#intNum_Trabajador').val().length > 10) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El número de trabajador debe tener máximo 10 caracteres.');
                return false;
            }
        }

        if ($('#strRFC').val() == '') {
            alertify.error('Debe ingresar su RFC');
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strRFC').focus();
            return false;
        } else {
            if ($('#strRFC').val().length > 13) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strRFC').focus();
                alertify.error('El RFC debe tener máximo 13 caracteres.');
                return false;
            }
            var rfcExp = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            if (rfcExp.test($('#strRFC').val())) {
            } else {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strRFC').focus();
                alertify.error('El RFC de ser con homoclave y mayusculas <br> El formato es (NNNN000000XXX).');
                return false;
            }
        }
    }

    //? Los de moderador

    if ($('#intUsuarioRol').val() == 2) {
        var algunSeleccionado = 0;
        var iCont = 1;
        while (iCont < 7) {
            var isChecked = document.getElementById('strDiaServicio' + iCont).checked;
            if (isChecked) {
                algunSeleccionado++;
            }
            iCont++;
        }
        if (algunSeleccionado == 0) {
            alertify.error('Debe seleccionar al menos un día para realizar el servicio social.');
            return false;
        }

        if ($('#intNumCuenta').val() == '') {
            alertify.error('Debe ingresar su número de cuenta.');
            $('html, body').animate({ scrollTop: 250 }, 'slow');
            document.getElementById('intNumCuenta').focus();
            return false;
        } else {
            if ($('#intNumCuenta').val().length < 6) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNumCuenta').focus();
                alertify.error('El número de cuenta debe tener al menos 6 cifras');
                return false;
            }

            if ($('#intNumCuenta').val().length > 6 && $('#intNumCuenta').val().length < 9) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNumCuenta').focus();
                alertify.error('El número de cuenta debe tener al menos 6 cifras y máximo 9');
                return false;
            }

            if ($('#intNumCuenta').val().length > 9) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNumCuenta').focus();
                alertify.error('El número de cuenta debe tener máximo 10 cifras.');
                return false;
            }

            var numExp = /^([0-9])*$/;
            if (numExp.test($('#intNumCuenta').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('intNumCuenta').focus();
                alertify.error('El numero de cuenta de incluir unicamente números.');
                return false;
            }
        }

        if ($('#strFechaInicio').val() == '') {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strFechaInicio').focus();
            alertify.error('Debe ingresar una fecha de inicio de servicio social');
            return false;
        }
        if ($('#strFechaFin').val() == '') {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strFechaFin').focus();
            alertify.error('Debe ingresar una fecha de fin de servicio social');
            return false;
        }
        if ($('#strHoraInicio').val() == '') {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strHoraInicio').focus();
            alertify.error('Debe ingresar una hora de inicio de servicio social');
            return false;
        }
        if ($('#strHoraFin').val() == '') {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strHoraFin').focus();
            alertify.error('Debe ingresar una hora de fin de servicio social');
            return false;
        }

        if ($('#strHoraFin').val() <= $('#strHoraInicio').val()) {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strHoraFin').focus();
            alertify.error('La hora de fin no puede ser menor o igual a la inicial.');
            return false;
        }
    }

    if ($('#intUsuarioRol').val() == 3) {
        if ($('#intNum_Trabajador').val() == '') {
            alertify.error('Debe ingresar un número de trabajador');
            $('html, body').animate({ scrollTop: 250 }, 'slow');
            document.getElementById('intNum_Trabajador').focus();
            return false;
        } else {
            var numExp = /^([0-9])*$/;
            if (numExp.test($('#intNum_Trabajador').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El numero de trabajador de incluir unicamente números.');
                return false;
            }
            if ($('#intNum_Trabajador').val().length > 10) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El número de trabajador debe tener máximo 10 caracteres.');
                return false;
            }
        }
        if ($('#strRFC').val() == '') {
            alertify.error('Debe ingresar su RFC');
            $('html, body').animate({ scrollTop: 250 }, 'slow');
            document.getElementById('strRFC').focus();
            return false;
        } else {
            if ($('#strRFC').val().length > 13) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strRFC').focus();
                alertify.error('El RFC debe tener máximo 13 caracteres.');
                return false;
            }
            var rfcExp = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
            if (rfcExp.test($('#strRFC').val())) {
            } else {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strRFC').focus();
                alertify.error('El RFC de ser con homoclave y mayusculas <br> El formato es (NNNN000000XXX).');
                return false;
            }
        }

        if ($('#strSemblanza').val() == '') {
            alertify.error('Debe ingresar su semblanza');
            $('html, body').animate({ scrollTop: 250 }, 'slow');
            document.getElementById('strSemblanza').focus();
            return false;
        } else {
            if ($('#strSemblanza').val().length > 500) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strSemblanza').focus();
                alertify.error('Solo cuenta con 500 caractéres para su semblanza.');
                return false;
            }
        }
        var algunSeleccionado = 0;
        var iCont = 1;
        while (iCont <= 2) {
            var isChecked = document.getElementById('strNivel' + iCont).checked;
            if (isChecked) {
                algunSeleccionado++;
            }
            iCont++;
        }
        if (algunSeleccionado == 0) {
            alertify.error('Debe seleccionar al menos un nivel en el que se imparte clases.');
            return false;
        }

        var algunSeleccionado = 0;
        var iCont = 1;
        while (iCont <= 3) {
            var isChecked = document.getElementById('strModalidad' + iCont).checked;
            if (isChecked) {
                algunSeleccionado++;
            }
            iCont++;
        }
        if (algunSeleccionado == 0) {
            alertify.error('Debe seleccionar al menos una modalidad en la que imparta clases.');
            return false;
        }

        var algunSeleccionado = 0;
        var iCont = 1;
        while (iCont <= 24) {
            var isChecked = document.getElementById('strCoordinacion' + iCont).checked;
            if (isChecked) {
                algunSeleccionado++;
            }
            iCont++;
        }
        if (algunSeleccionado == 0) {
            alertify.error('Debe seleccionar al menos una coordinación en la que participe.');
            return false;
        }
    }
    return true;
}

// Auto registro profesor
$(document).ready(function () {
    $('#btn-registrar-profesor').click(function () {
        if (validarFormularioUsuario()) {
            datos = $('#form_usuario').serialize();

            $.ajax({
                type: 'POST',
                url: 'modulos/Control_Usuario.php',
                data: datos,
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se realizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            location.reload();
                        }, 1500);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 200 }, 'slow');
                        document.getElementById('strNombreUsuario').focus();
                        alertify.error('El nombre de usuario ya existe');
                    } else  if (respuesta.endsWith('3')) {
                        $('html, body').animate({ scrollTop: 200 }, 'slow');
                        document.getElementById('intNum_Trabajador').focus();
                        alertify.error('Ya existe un profesor con ese número de trabajador');
                    } else {
                        alertify.error('Hubo un problema al registrar al usuario');
                    }
                },
            });
            return false;
        }
    });
});


// Registrar usuario
$(document).ready(function () {
    $('#btn-registrar-usuario').click(function () {
        if (validarFormularioUsuario()) {
            datos = $('#form_usuario').serialize();

            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Usuario.php',
                data: datos,
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se realizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
                        }, 1500);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 200 }, 'slow');
                        document.getElementById('strNombreUsuario').focus();
                        alertify.error('El nombre de usuario ya existe');
                    } else  if (respuesta.endsWith('3')) {
                        $('html, body').animate({ scrollTop: 200 }, 'slow');
                        document.getElementById('intNum_Trabajador').focus();
                        alertify.error('Ya existe un profesor con ese número de trabajador');
                    } else {
                        alertify.error('Hubo un problema al registrar al usuario');
                    }
                },
            });
            return false;
        }
    });
});

// Actualizar usuario
function actualizarUsuario(id, persona, rol) {
    var datos = {
        id: id,
        persona: persona,
        CRUD: 1,
        rol: rol,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/usuarios/frm_usuarios.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}
$(document).ready(function () {
    $('#btn-actualizar-usuario').click(function () {
        if (validarFormularioUsuario()) {
            datos = $('#form_usuario').serialize();
            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Usuario.php',
                data: datos,
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
                        }, 0);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 200 }, 'slow');
                        document.getElementById('strNombreUsuario').focus();
                        alertify.error('El nombre de usuario ya existe');

                    } else if(respuesta.endsWith('10')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            location.reload();
                        }, 1500);
                    } else {
                        alertify.error('Hubo un problema al registrar al usuario');
                    }
                },
            });
            return false;
        }
    });
});
$(document).ready(function () {
    $('#btn-actualizar-usuario-mi-cuenta').click(function () {
        if (validarFormularioUsuarioMiCuenta()) {
            datos = $('#form_usuario').serialize();
            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Usuario.php',
                data: datos,
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
                        }, 0);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 200 }, 'slow');
                        document.getElementById('strNombreUsuario').focus();
                        alertify.error('El nombre de usuario ya existe');

                    } else if(respuesta.endsWith('10')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            location.reload();
                        }, 1500);
                    } else {
                        alertify.error('Hubo un problema al registrar al usuario');
                    }
                },
            });
            return false;
        }
    });
});

// Consultar usuario
function consultarUsuario(id, persona) {
    var datos = {
        id: id,
        persona: persona,
        CRUD: 0,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/usuarios/frm_usuarios.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

function consultarUsuarioDirecto(id, persona, rol) {
    var datos = {
        id: id,
        persona: persona,
        CRUD: 0,
        rol: rol,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/usuarios/frm_usuarios.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

// Eliminar usuario
function eliminarUsuario(id, persona, nombre, apellido) {
    var mensaje = '¿Está seguro de eliminar el usuario de ';
    mensaje = mensaje.concat(nombre);
    mensaje = mensaje.concat(' ');
    mensaje = mensaje.concat(apellido);
    mensaje = mensaje.concat('?');

    var titulo = 'Eliminar usuario';
    alertify.confirm(
        titulo,
        mensaje,
        function () {
            var dml = 'delete';
            var datos = {
                id: id,
                persona: persona,
                dml: dml,
            };
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Usuario.php',
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('Se elimino de manera correcta al usuario');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
                        }, 0);
                    } else {
                        alertify.error('Hubo un problema al eliminar al usuario');
                    }
                },
            });
        },
        function () {
            alertify.confirm().close();
        }
    );
    setTimeout(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
    }, 1500);
}

// Cambiar Estatus
function cambioEstatus(id, estatus, nombre, apellido, rol) {
    var mensaje = '¿Está seguro de cambiar el estatus del usuario de ';
    mensaje = mensaje.concat(nombre);
    mensaje = mensaje.concat(' ');
    mensaje = mensaje.concat(apellido);
    mensaje = mensaje.concat('?');

    var titulo = 'Cambio de estatus del usuario';
    alertify.confirm(
        titulo,
        mensaje,
        function () {
            var dml = 'cambio';
            var datos = {
                id: id,
                dml: dml,
                estatus: estatus,
                rol: rol,
            };
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Usuario.php',
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('Se cambió el estatus del usuario');
                        setTimeout(function () {
                            $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
                        }, 1500);
                    } else if (respuesta == 2) {
                        alertify.error('No puede desactivar al único administrador activo.');
                    } else {
                        alertify.error('Hubo un problema al cambiar el estatus del usuario.');
                    }
                },
            });
        },
        function () {
            alertify.confirm().close();
        }
    );
    setTimeout(function () {
        $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
    }, 1500);
}

//Mostrar contraseña index.php
function hideOrShowPassword() {
  var x = document.getElementById('strContrasena');
  if (x.type === 'password') {
    x.type = 'text';
  } else {
    x.type = 'password';
  }
}


// Mostrar o ocultar contraseña
function hideOrShowPassword1() {
    var password1, check;

    password1 = document.getElementById('strContrasenia01');
    check = document.getElementById('ver1');

    if (check.checked == true) {
        // Si la checkbox de mostrar contraseña está activada
        password1.type = 'text';
    } // Si no está activada
    else {
        password1.type = 'password';
    }
}

function hideOrShowPassword2() {
    var password2, check;

    password2 = document.getElementById('strContrasenia02');
    check = document.getElementById('ver2');

    if (check.checked == true) {
        // Si la checkbox de mostrar contraseña está activada
        password2.type = 'text';
    } // Si no está activada
    else {
        password2.type = 'password';
    }
}

//? Este código permite buscar y mostrar resultados en las tables

$(document).ready(function () {
    $('#tabla_usuarios').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json',
        },
        pageLength: 10,
        lengthMenu: [
            [5, 10, 20, -1],
            [5, 10, 20, 'Todos'],
        ],
    });
});


$(document).on('change', '#intUsuarioRol', function mostrarCamposPorRol() {
    var tipo_evento = $('#intUsuarioRol').val();
    if (tipo_evento.startsWith('1')) {
        $('#num_trabajador').show();
        $('#rfc').show();
        $('#numCuenta').hide();
        $('#fechaInicio').hide();
        $('#fechaFin').hide();
        $('#horaInicio').hide();
        $('#horaFin').hide();
        $('#diasServicio').hide();
        $('#semblanza').hide();
        $('#nivelImparticion').hide();
        $('#modalidadImparticion').hide();
        $('#coordinaciones').hide();
    }
    if (tipo_evento.startsWith('3')) {
        $('#num_trabajador').show();
        $('#rfc').show();
        $('#numCuenta').hide();
        $('#fechaInicio').hide();
        $('#fechaFin').hide();
        $('#horaInicio').hide();
        $('#horaFin').hide();
        $('#diasServicio').hide();
        $('#semblanza').show();
        $('#nivelImparticion').show();
        $('#modalidadImparticion').show();
        $('#coordinaciones').show();
    }
    if (tipo_evento.startsWith('2')) {
        $('#num_trabajador').hide();
        $('#rfc').hide();
        $('#numCuenta').show();
        $('#fechaInicio').show();
        $('#fechaFin').show();
        $('#horaInicio').show();
        $('#horaFin').show();
        $('#diasServicio').show();
        $('#semblanza').hide();
        $('#nivelImparticion').hide();
        $('#modalidadImparticion').hide();
        $('#coordinaciones').hide();
    }
});
