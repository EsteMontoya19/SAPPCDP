//? Rutas y acciones de todos los botones de Gestionar Usuarios desde el Coordinador
$(document).ready(function () {
    //? Rutas
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

    //? Acciones

    //Botón para registrar un usuario por el Coordinador
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
                    } else if (respuesta.endsWith('3')) {
                        $('html, body').animate({ scrollTop: 200 }, 'slow');
                        document.getElementById('intNum_Trabajador').focus();
                        alertify.error('El número de trabajador ya tiene un usuario con ese rol');
                    } else if (respuesta.endsWith('4')) {
                        $('html, body').animate({ scrollTop: 200 }, 'slow');
                        document.getElementById('intNum_Trabajador').focus();
                        alertify.error('Ya existe un moderador registrado con ese número de cuenta');
                    } else if (respuesta.endsWith('5')) {
                        $('html, body').animate({ scrollTop: 200 }, 'slow');
                        document.getElementById('intNum_Trabajador').focus();
                        alertify.error('La extensión del número de cuenta o trabajador no es correcta.');
                    } else {
                        alertify.error('Hubo un problema al registrar al usuario');
                    }
                },
            });
            return false;
        }
    });

    //Botón para actualizar usuarios por el Coordinador
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
                    } else if (respuesta.endsWith('10')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            location.reload();
                        }, 1500);
                    } else if (respuesta.endsWith('3')) {
                        alertify.error('El número de trabjador debe de ser de 6 digitos.');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            location.reload();
                        }, 1500);
                    } else if (respuesta.endsWith('4')) {
                        alertify.error('El número de cuenta debe de ser de 9 digitos.');
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

    //Tabla inicio dinamica
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

//? Acciones de los botones del Auto-Registro de profesor que este en el index.html
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
                    } else if (respuesta.endsWith('3')) {
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

//? Funciones de los botones
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
// Consulta usuarios desde la pagina de listado de usuarios
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

//? Evita al Coordinador escribir la contraseña cuando se crea un Profesor
function AsignarContrasena() {
    var extension = document.getElementById('strContrasenia01').value;
    if (extension.length < 13) {
        document.getElementById('strContrasenia01').value = document.getElementById('strRFC').value;
        document.getElementById('strContrasenia02').value = document.getElementById('strRFC').value;
    }
}

//? Rellena y bloquea los campos de profesor y persona cuando se ingresa un número de trabajador que ya este registrado previamente
function buscarProfesor() {
    var dml = 'llenadoProfesor';
    var numTrabajador = document.getElementById('intNum_Trabajador').value;

    //? Esto solo va a aplicar con numeros de trabjador que son los de 6 cifras
    if (numTrabajador.length == 6) {
        var datos = {
            numTrabajador: numTrabajador,
            dml: dml,
        };
        $.ajax({
            data: datos,
            type: 'POST',
            dataType: 'json',
            url: '../modulos/Control_Usuario.php',
            success: function (respuesta) {
                if (respuesta.estado == 'Encontrado') {
                    var titulo = 'Se encontró un profesor registrado en el sistema con el mismo Número de trabajador.';
                    var mensaje = 'Los campos del profesor se bloquearán con los datos encontrados. \n Para actualizar estos datos hagalo desde la opción de actualizar.';

                    alertify.alert(titulo, mensaje, function () {
                        alertify.success('Datos cargados');
                    });

                    $('#semblanza').val(respuesta.semblanza);
                    $('#strRFC').val(respuesta.rfc);
                    $('#strUsuarioNombre').val(respuesta.nombre);
                    $('#strUsuarioPrimerApe').val(respuesta.apellidoPaterno);
                    $('#strUsuarioSegundoApe').val(respuesta.apellidoMaterno);
                    $('#strUsuarioCorreo').val(respuesta.correo);
                    $('#strUsuarioTelefono').val(respuesta.telefono);
                    if (respuesta.sexo == 'Hombre') {
                        $('#strSexoH').prop('checked', true);
                    } else {
                        $('#strSexoM').prop('checked', true);
                    }

                    $('#strRFC').focus();
                    $('#strRFC').prop('disabled', true);
                    $('#strUsuarioNombre').prop('disabled', true);
                    $('#strUsuarioPrimerApe').prop('disabled', true);
                    $('#strUsuarioSegundoApe').prop('disabled', true);
                    $('#strUsuarioCorreo').prop('disabled', true);
                    $('#strUsuarioTelefono').prop('disabled', true);
                    $('#semblanza').prop('disabled', true);
                    $('#strSexoH').prop('disabled', true);
                    $('#strSexoM').prop('disabled', true);
                } else if (respuesta.estado == 'Nulo') {
                    $('#strRFC').focus();
                    $('#strRFC').prop('disabled', false);
                    $('#strUsuarioNombre').prop('disabled', false);
                    $('#strUsuarioPrimerApe').prop('disabled', false);
                    $('#strUsuarioSegundoApe').prop('disabled', false);
                    $('#strUsuarioCorreo').prop('disabled', false);
                    $('#strUsuarioTelefono').prop('disabled', false);
                    $('#semblanza').prop('disabled', false);
                    $('#strSexoM').prop('disabled', false);
                    $('#strSexoH').prop('disabled', false);

                    $('#semblanza').val('');
                    $('#strRFC').val('');
                    $('#strUsuarioNombre').val('');
                    $('#strUsuarioPrimerApe').val('');
                    $('#strUsuarioSegundoApe').val('');
                    $('#strUsuarioCorreo').val('');
                    $('#strUsuarioTelefono').val('');
                    $('#strContrasenia01').val('');
                    $('#strContrasenia02').val('');
                    $('#strSexoM').prop('checked', false);
                    $('#strSexoH').prop('checked', false);

                    alertify.success('No se encontró otro profesor con ese Número de trabajador.');
                }
            },
        });
    }
}

//? Validaciones y animaciones de campos
// Validación del formulario para usuario
function validarFormularioUsuario() {
    //! Validaciones de Persona
    //? Con esto sabemos si acaban de registrar a alguien.
    if (typeof $('#hideRol').val() == 'undefined') {
        //? Solo el Moderador puede tener 6
        if ($('#intUsuarioRol').val() != 3) {
            if ($('#intNum_Trabajador').val().length < 6 || $('#intNum_Trabajador').val().length > 6) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El número de trabjador no puede ser menor a 6 cifras.');
                return false;
            }
        } else {
            if ($('#intNum_Trabajador').val() == '') {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('Se debe ingresar el Número de trabajador o Número de cuenta.');
                return false;
            } else {
                if ($('#intNum_Trabajador').val().length < 6) {
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    document.getElementById('intNum_Trabajador').focus();
                    alertify.error('El número de cuenta o trabjador no puede ser menor a 6 cifras.');
                    return false;
                }

                if ($('#intNum_Trabajador').val().length > 6 && $('#intNum_Trabajador').val().length < 9) {
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    document.getElementById('intNum_Trabajador').focus();
                    alertify.error('La extensión del número de cuenta o trabajador es incorrecta.');
                    return false;
                }

                if ($('#intNum_Trabajador').val().length > 9) {
                    $('html, body').animate({ scrollTop: 0 }, 'slow');
                    document.getElementById('intNum_Trabajador').focus();
                    alertify.error('El número de trabajador debe de ser mayor a 9 cifras.');
                    return false;
                }

                var numExp = /^([0-9])*$/;
                if (numExp.test($('#intNum_Trabajador').val())) {
                } else {
                    $('html, body').animate({ scrollTop: 100 }, 'slow');
                    document.getElementById('intNum_Trabajador').focus();
                    alertify.error('El Número de trabajador o de cuenta debe de incluir solo números.');
                    return false;
                }
            }
        }
    }

    if (typeof $('#intNum_Trabajador').val() != 'undefined' && typeof $('#intNumCuenta').val() == 'undefined') {
        if ($('#intNum_Trabajador').val() == '') {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('intNum_Trabajador').focus();
            alertify.error('Se debe ingresar el Número de trabajador o Número de cuenta.');
            return false;
        } else {
            if ($('#intNum_Trabajador').val().length < 6 || $('#intNum_Trabajador').val().length > 6) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El número de trabjador debe ser de  6 cifras.');
                return false;
            }

            var numExp = /^([0-9])*$/;
            if (numExp.test($('#intNum_Trabajador').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('intNum_Trabajador').focus();
                alertify.error('El Número de trabajador debe de incluir solo números.');
                return false;
            }
        }
    } else if (typeof $('#intNum_Trabajador').val() == 'undefined' && typeof $('#intNumCuenta').val() != 'undefined') {
        if ($('#intNumCuenta').val() == '') {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('intNumCuenta').focus();
            alertify.error('Se debe ingresar el número de cuenta.');
            return false;
        } else {
            if ($('#intNumCuenta').val().length < 9 || $('#intNumCuenta').val().length > 9) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('intNumCuenta').focus();
                alertify.error('El número de cuenta debe ser de  6 cifras.');
                return false;
            }

            var numExp = /^([0-9])*$/;
            if (numExp.test($('#intNumCuenta').val())) {
            } else {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('intNumCuenta').focus();
                alertify.error('El Número de cuenta debe de incluir solo números.');
                return false;
            }
        }
    } else {
        alertify.error('Hubo un error al realizar la operación.');
        return false;
    }

    if ($('#strRFC').val() == '') {
        alertify.error('Debe ingresar su RFC con homoclave.  <br> En caso de no tenerla rellenar con 0.');
        $('html, body').animate({ scrollTop: 250 }, 'slow');
        document.getElementById('strRFC').focus();
        return false;
    } else {
        var rfcExp = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
        if (rfcExp.test($('#strRFC').val())) {
        } else {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strRFC').focus();
            alertify.error('El RFC debe incluir homoclave. <br> El formato es (NNNN000000XXX).');
            return false;
        }
    }

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

        var letExp = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\.?]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
        if (letExp.test($('#strUsuarioNombre').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioNombre').focus();
            alertify.error('El nombre debe estar compuesto unicamente por letras y sin espacios al final.');
            return false;
        }
    }

    if ($('#strUsuarioPrimerApe').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('strUsuarioPrimerApe').focus();
        alertify.error('Se debe ingresar el primer apellido del usuario');
        return false;
    } else {
        if ($('#strUsuarioPrimerApe').val().length > 30) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strUsuarioPrimerApe').focus();
            alertify.error('El apellido paterno debe tener máximo 30 caracteres');
            return false;
        }

        var letExp = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
        if (letExp.test($('#strUsuarioPrimerApe').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioPrimerApe').focus();
            alertify.error('El apellido paterno debe estar compuesto unicamente por letras y sin espacios al final.');
            return false;
        }
    }

    if ($('#strUsuarioSegundoApe').val() != '') {
        if ($('#strUsuarioSegundoApe').val().length > 30) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('strUsuarioSegundoApe').focus();
            alertify.error('El apellido materno debe tener máximo 30 caracteres');
            return false;
        }
        var letExp = /^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/g;
        if (letExp.test($('#strUsuarioSegundoApe').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioSegundoApe').focus();
            alertify.error('El apellido materno debe estar compuesto unicamente por letras y sin espacios al final.');
            return false;
        }
    }
/*
    if ($('#strUsuarioCorreo').val() == '') {
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('strUsuarioCorreo').focus();
        alertify.error('Se debe ingresar el correo del usuario.');
        return false;
    } else {
        var emailExp = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/;
        if (emailExp.test($('#strUsuarioCorreo').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioCorreo').focus();
            alertify.error('La formato del correo es inválida');
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
        alertify.error('Se debe ingresar el teléfono del usuario.');
        return false;
    } else {
        var tel = $('#strUsuarioTelefono').val();
        var total_numeros = tel.length;

        if (total_numeros < 10 || total_numeros > 10) {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strUsuarioTelefono').focus();
            alertify.error('El teléfono debe incluir unicamente 10 dígitos.');
            return false;
        }

        if (total_numeros == 10) {
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

    */
    if ($('#strSexoM').is(':checked') == false && $('#strSexoH').is(':checked') == false) {
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('strSexoM').focus();
        alertify.error('Se debe ingresar el sexo del usuario.');
        return false;
    }

    //! Validaciones de Usuario
    if ($('#intUsuarioRol').val() == 0) {
        alertify.error('Debe seleccionar un rol de usuario');
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('intUsuarioRol').focus();
        return false;
    }

    //? Si no esta definido viene de auto registro
    if (typeof $('#strNombreUsuario').val() != 'undefined') {
        if ($('#strNombreUsuario').val() == '') {
            alertify.error('Se debe ingresar el identificador del usuario.');
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strNombreUsuario').focus();
            return false;
        } else if ($('#strNombreUsuario').val().length > 15) {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strNombreUsuario').focus();
            alertify.error('El nombre de usuario debe tener máximo 15 caracteres.');
            return false;
        }
    }

    if (typeof $('#strContrasenia01').val() != 'undefined') {
        if ($('#strContrasenia01').val() == '') {
            alertify.error('Debe ingresar una contraseña');
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strContrasenia01').focus();
            return false;
        } else {
            if ($('#strContrasenia01').val().length > 20) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strContrasenia01').focus();
                alertify.error('La contraseña debe tener máximo 20 caracteres.');
                return false;
            }

            if ($('#strContrasenia01').val().length < 6) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('strContrasenia01').focus();
                alertify.error('La contraseña debe tener mínimo 6 caracteres.');
                return false;
            }
        }

        if ($('#strContrasenia02').val() == '') {
            alertify.error('Debe ingresar la confirmación de la contraseña');
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strContrasenia02').focus();
            return false;
        }

        if ($('#strContrasenia01').val() != $('#strContrasenia02').val()) {
            alertify.error('Las contraseña no coinciden.');
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strContrasenia01').focus();
            return false;
        }
    }

    //! Validaciones según el rol

    //? Instructor
    if ($('#hideRol').val() == 2 || $('#intUsuarioRol').val() == 2) {
        if ($('#strSemblanza').val() == '') {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('strSemblanza').focus();
            alertify.error('Debe ingresar la semblanza del instructor.');
            return false;
        } else {
            if ($('#strSemblanza').val().length > 500) {
                $('html, body').animate({ scrollTop: 100 }, 'slow');
                document.getElementById('strSemblanza').focus();
                alertify.error('Solo cuenta con 500 caractéres para su semblanza.');
                return false;
            }
        }
    }

    //? Moderador
    if ($('#hideRol').val() == 3 || $('#intUsuarioRol').val() == 3) {
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

        if ($('#strFechaInicio').val() > $('#strFechaFin').val()) {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('strFechaInicio').focus();
            alertify.error('La fecha inicial no puede ser mayor a la fecha final.');
            return false;
        }
    }

    //? Profesor
    if ($('#hideRol').val() == 4 || $('#intUsuarioRol').val() == 4) {
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
        while (iCont <= $('#numCoordinaciones').val()) {
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
         if ($("#nombramiento").val() == "0") {
            $("html, body").animate({ scrollTop: 900 }, "slow");
            document.getElementById("nombramiento").focus();
            alertify.error("Debe de seleccionar un nombramiento principal para el profesor.");
            return false;
          }
    }
    return true;
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
// Mostrar o ocultar contraseña
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

// Despliegue de campos según su rol.
$(document).on('change', '#intUsuarioRol', function mostrarCamposPorRol() {
    //? Constantes para indicar el rol
    const ADMINISTRADOR = 1;
    const INSTRUCTOR = 2;
    const MODERADOR = 3;
    const PROFESOR = 4;

    document.getElementById('strContrasenia01').value = $('#strRFC').val().substr(0, 13);
    document.getElementById('strContrasenia02').value = $('#strRFC').val().substr(0, 13);

    var tipo_evento = $('#intUsuarioRol').val();
    if (tipo_evento.startsWith(ADMINISTRADOR)) {
        /* $('#num_trabajador').show();
        $('#rfc').show(); 
        $('#numCuenta').hide();
        Ahora son campos obligatorios*/
        $('#datosCuenta').hide();
        $('#fechaInicio').hide();
        $('#fechaFin').hide();
        $('#horaInicio').hide();
        $('#horaFin').hide();
        $('#diasServicio').hide();
        $('#semblanza').hide();
        $('#nivelImparticion').hide();
        $('#modalidadImparticion').hide();
        $('#coordinaciones').hide();
        $('#nombramientos').hide();
    } else if (tipo_evento.startsWith(PROFESOR) || tipo_evento.startsWith(INSTRUCTOR)) {
        /*$('#num_trabajador').show();
        $('#rfc').show();
        $('#numCuenta').hide();
        Ahora son campos obligatorios*/
        $('#datosCuenta').show();
        $('#fechaInicio').hide();
        $('#fechaFin').hide();
        $('#horaInicio').hide();
        $('#horaFin').hide();
        $('#diasServicio').hide();
        $('#nivelImparticion').show();
        $('#modalidadImparticion').show();
        $('#coordinaciones').show();
        $('#nombramientos').show();
        //?En caso de que si sea Instructor
        if (tipo_evento.startsWith(INSTRUCTOR)) {
            $('#semblanza').show();
            $('#nivelImparticion').hide();
            $('#modalidadImparticion').hide();
            $('#coordinaciones').hide();
            $('#nombramientos').hide();
            //?En caso de que sea un profesor su usuario y contraseña se auto asignans
        } else {
            $('#semblanza').hide();
            document.getElementById('strNombreUsuario').value = $('#intNum_Trabajador').val();
            //? Aqui estaba las lineas de autocpmpletado de contraseña
        }
    } else if (tipo_evento.startsWith(MODERADOR)) {
        /*$('#num_trabajador').hide();
        $('#rfc').hide();
        $('#numCuenta').show();
        Ahora son campos obligatorios*/
        $('#datosCuenta').show();
        $('#fechaInicio').show();
        $('#fechaFin').show();
        $('#horaInicio').show();
        $('#horaFin').show();
        $('#diasServicio').show();
        $('#semblanza').hide();
        $('#nivelImparticion').hide();
        $('#modalidadImparticion').hide();
        $('#coordinaciones').hide();
    } else {
        $('#datosCuenta').hide();
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
});
