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
    }

    if ($('#strUsuarioPrimerApe').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('strUsuarioPrimerApe').focus();
        alertify.error('Se debe ingresar el primer apellido del usuario');
        return false;
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
            alertify.error('El teléfono debe ser de incluir mínimo 10 digitos.');
            return false;
        } else if (total_numeros > 10) {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioTelefono').focus();
            alertify.error('El teléfono debe ser de incluir máximo 10 digitos.');
            return false;
        } else if (total_numeros == 10) {
            var numExp = /^([0-9])*$/;
            if (numExp.test($('#strUsuarioTelefono').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('strUsuarioTelefono').focus();
                alertify.error('El teléfono debe ser de incluir solo números.');
                return false;
            }
        }
    }

    if ($('#strNombreUsuario').val() == '') {
        alertify.error('Se debe ingresar el identificador del usuario');
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('strNombreUsuario').focus();
        return false;
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

    if ($('#UsuarioRespuesta').val() == 0) {
        alertify.error('Debe una respuesta a la pregunta de seguridad');
        $('html, body').animate({ scrollTop: 250 }, 'slow');
        document.getElementById('UsuarioRespuesta').focus();
        return false;
    }

    if ($('#strContrasenia01').val() == '') {
        alertify.error('Debe ingresar una contraseña');
        $('html, body').animate({ scrollTop: 250 }, 'slow');
        document.getElementById('strContrasenia01').focus();
        return false;
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

    return true;
}

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
        rol: rol
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
    var mensaje = '¿Esta seguro de elimnar el usuario de ';
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
function cambioEstatus(id, estatus, nombre, apellido) {
    var mensaje = '¿Esta seguro de cambiar el estatus del usuario de ';
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
            };
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Usuario.php',
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('Se cambio el estatus del usuario');
                        setTimeout(function () {
                            $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
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
        $('#container').load('../sistema/usuarios/frm_inicio_usuarios.php');
    }, 1500);
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

// Tabla dinámica
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

// var variable = $('#intUsuarioRol').val($('#intUsuarioRol option:selected').text());

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
