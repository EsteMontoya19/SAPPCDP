$(document).ready(function () {
    $('#btn-inicio').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/frm_inicio.php');
    });
    $('#btn-inicio-grupo').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
    });

    $('#btn-regresar-grupo').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
    });

    $('#btn-registro-grupo').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/grupos/frm_grupos.php');
    });

    $('#btn-inicio').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/frm_inicio.php');
    });
});
// Validar el formulario

function validarFormularioGrupo() {
    //Crea una variable y constante que serán necesarias posteriormente para la validación de las fechas.
    var objFecha = new Date();
    const objFechaHoy = new Date(objFecha.getFullYear(), objFecha.getMonth(), objFecha.getDate());

    //Validaciones generales de los grupos
    if ($('#GrupoCupo').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('GrupoCupo').focus();
        alertify.error('Debe ingresar el cupo del grupo');
        return false;
    } else {
        if ($('#GrupoCupo').val() < 5) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            document.getElementById('GrupoCupo').focus();
            alertify.error('Debe ingresar un cupo del grupo mayor a 5');
            return false;
        } else {
            if ($('#GrupoCupo').val() > 60) {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                document.getElementById('GrupoCupo').focus();
                alertify.error('Debe asignar un cupo de grupo máximo de 60');
                return false;
            }
        }
    }

    if ($('#ID_Curso').val() == '0') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('ID_Curso').focus();
        alertify.error('Debe ingresar un curso para el grupo');
        return false;
    }

    if ($('#GrupoTipo').val() == '0') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('GrupoTipo').focus();
        alertify.error('Debe ingresar el tipo del grupo: Público / Privado');
        return false;
    }

    if ($('#GrupoEstatus').val() == '0') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('GrupoEstatus').focus();
        alertify.error('Debe ingresar el estatus del grupo: Aprobado / Rechazado / Pendiente');
        return false;
    }

    if ($('#ID_Profesor').val() == '0') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('ID_Profesor').focus();
        alertify.error('Debe asignar un profesor para el grupo');
        return false;
    }

    if ($('#ID_Moderador').val() == '0') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('ID_Moderador').focus();
        alertify.error('Debe asignar un moderador para el grupo');
        return false;
    }

    //Validaciones respectivas para los campos acorde a la modalidad
    if ($('#GrupoModalidad').val() == '0') {
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('GrupoModalidad').focus();
        alertify.error('Debe ingresar la modalidad del grupo');
        return false;
    } else {
        if ($('#GrupoModalidad').val() == 'En línea') {
            if ($('#ID_Plataforma').val() == 0) {
                $('html, body').animate({ scrollTop: 200 }, 'slow');
                document.getElementById('ID_Plataforma').focus();
                alertify.error('Debe ingresar la plataforma en la que se tomará la clase');
                return false;
            }

            if ($('#URL_Acceso').val() == '') {
                $('html, body').animate({ scrollTop: 200 }, 'slow');
                document.getElementById('URL_Acceso').focus();
                alertify.error('Debe ingresar el link de acceso a la clase');
                return false;
            }

            if ($('#ID_Reunion').val() == '') {
                $('html, body').animate({ scrollTop: 250 }, 'slow');
                document.getElementById('ID_Reunion').focus();
                alertify.error('Debe ingresar el ID de la reunión');
                return false;
            }

            if ($('#Clave_Acceso').val() == '') {
                $('html, body').animate({ scrollTop: 250 }, 'slow');
                document.getElementById('Clave_Acceso').focus();
                alertify.error('Debe ingresar la clave de la reunión');
                return false;
            }
        } else {
            if ($('#GrupoModalidad').val() == 'Presencial') {
                if ($('#ID_Salon').val() == 0) {
                    $('html, body').animate({ scrollTop: 100 }, 'slow');
                    document.getElementById('ID_Salon').focus();
                    alertify.error('Debe ingresar el salon en el que se impartirá la clase');
                    return false;
                }
            }
        }
    }

    //Validaciones para las Fechas de inscripción
    if ($('#GrupoInicioInscripcion').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('GrupoInicioInscripcion').focus();
        alertify.error('Debe ingresar la fecha de inicio para el periodo de inscripciones al grupo');
        return false;
    } else {
        //Obtiene el valor de la fecha ingresada en el campo GrupoInicioInscripcion
        objFecha = new Date($('#GrupoInicioInscripcion').val());
        //Crea una nueva variable con estos valores, se agrega el +1 porque de lo contrario el valor es un día menor al ingresado en el input
        var objFecha2 = new Date(objFecha.getFullYear(), objFecha.getMonth(), objFecha.getDate() + 1);
        //Valida que la fecha ingresada en el periodo de inscripción sea minimamente igual al dia en que se registra el grupo.
        if (objFecha2 < objFechaHoy) {
            $('html, body').animate({ scrollTop: 200 }, 'slow');
            document.getElementById('GrupoInicioInscripcion').focus();
            alertify.error('La fecha de inicio para el periodo de inscripciones al grupo debe ser minimo el día en que se registra el grupo');
            return false;
        }
    }

    if ($('#GrupoFinInscripcion').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('GrupoFinInscripcion').focus();
        alertify.error('Debe ingresar la fecha de termino para el periodo de inscripciones al grupo');
        return false;
    }

    if ($('#GrupoInicioInscripcion').val() > $('#GrupoFinInscripcion').val()) {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('GrupoInicioInscripcion').focus();
        alertify.error('La fecha de inicio del periodo de inscripciones al grupo debe ser menor a la de termino');
        return false;
    }

    //Validaciones para las sesiones ingresadas acorde al grupo
    for (var iCon = 1; iCon <= $('#numSesiones').val(); iCon++) {
        if ($('#SesionFecha' + iCon).val() == '') {
            $('html, body').animate({ scrollTop: 300 }, 'slow');
            document.getElementById('SesionFecha' + iCon).focus();
            alertify.error('La fecha de la sesión ' + iCon + ' no puede estar vacía, favor de ingresar una fecha');
            return false;
        } else {
            if ($('#SesionFecha' + iCon).val() < $('#GrupoFinInscripcion').val()) {
                $('html, body').animate({ scrollTop: 300 }, 'slow');
                document.getElementById('SesionFecha' + iCon).focus();
                alertify.error('La fecha de la sesión ' + iCon + ' no puede ser menor a la fecha de termino de inscripción');
                return false;
            }

            //Se crea una variable de fecha con los datos de cada campo de fecha para validar que la sesión no esta siendo asignada en domingo
            objFecha = new Date($('#SesionFecha' + iCon).val());
            var objFecha2 = new Date(objFecha.getFullYear(), objFecha.getMonth(), objFecha.getDate() + 1);
            if (objFecha2.getDay() == 0) {
                $('html, body').animate({ scrollTop: 300 }, 'slow');
                document.getElementById('SesionFecha' + iCon).focus();
                alertify.error('La fecha de la sesión ' + iCon + ' no puede ser asignada a un día Domingo');
                return false;
            }
        }

        if ($('#SesionHoraInicio' + iCon).val() == '') {
            $('html, body').animate({ scrollTop: 300 }, 'slow');
            document.getElementById('SesionHora' + iCon).focus();
            alertify.error('El horario de la sesión ' + iCon + ' no puede estar vacío, favor de ingresar una hora de inicio');
            return false;
        }

        if (iCon > 1) {
            if ($('#SesionFecha' + iCon).val() < $('#SesionFecha' + (iCon - 1)).val()) {
                $('html, body').animate({ scrollTop: 300 }, 'slow');
                document.getElementById('SesionFecha' + iCon).focus();
                alertify.error('La fecha de la sesión ' + iCon + ' no puede ser menor a la fecha de la sesión ' + (iCon - 1));
                return false;
            }
        }
    }

    return true;
}

function validarFormularioDocumento() {
    if ($('#AlumnoEscolar').val() == '') {
        $('html, body').animate({ scrollTop: 1500 }, 'slow');
        document.getElementById('AlumnoEscolar').focus();
        alertify.error('Debe ingresar el comprobante escolar');
        return false;
    }

    if ($('#AlumnoPago').val() == '') {
        $('html, body').animate({ scrollTop: 1500 }, 'slow');
        document.getElementById('AlumnoPago').focus();
        alertify.error('Debe ingresar el comprobante escolar');
        return false;
    }
    return true;
}

// Acciones de los días

var n = 1;

function mostrarDia() {
    if (n <= 7) {
        $('#Dia' + n).show(500);
        document.getElementById('Dia' + n).focus();
        $('html, body').animate({ scrollTop: 10000 }, 'slow');
        n++;
    } else {
        n = 8;
    }
}

function mostrarDiaUPD(i) {
    if (i <= 7) {
        $('#Dia' + i).show(500);
        document.getElementById('Dia' + i).focus();
        $('html, body').animate({ scrollTop: 10000 }, 'slow');
        n = i;
        n++;
        $('#btn-agregar-horarioAct').hide(0);
        $('#btn-agregar-horario').show(0);
    } else {
        n = 8;
    }
}

function ocultarDia() {
    if (n > 1) {
        n--;
        $('#Dia' + n).hide(500);
        $('html, body').animate({ scrollTop: 10000 }, 'slow');
        $('#GrupoDia' + n).val('0');
        $('#GrupoSalon' + n).val('0');
        $('#GrupoHoraInicio' + n).val('');
        $('#GrupoHoraFin' + n).val('');
    }
}

function ocultarDiaUPD(x) {
    if (n > x) {
        n--;
        $('#Dia' + n).hide(500);
        $('html, body').animate({ scrollTop: 10000 }, 'slow');
        $('#GrupoDia' + n).val('0');
        $('#GrupoSalon' + n).val('0');
        $('#GrupoHoraInicio' + n).val('');
        $('#GrupoHoraFin' + n).val('');
    }
}

// Eliminar horario

function eliminarHorario(id, grupo) {
    var mensaje = '¿Esta seguro de elimnar el horario?';

    var titulo = 'Eliminar horario'.bold();
    alertify.confirm(
        titulo,
        mensaje,
        function () {
            var dml = 'borrar';
            var datos = {
                id: id,
                dml: dml,
            };
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Grupo.php',
                success: function (respuesta) {
                    if ((respuesta = 1)) {
                        alertify.success('Se elimino correctamente el horario');

                        var datos = { id: grupo, CRUD: 1 };

                        $.ajax({
                            data: datos,
                            type: 'POST',
                            url: '../sistema/grupos/frm_grupos.php',
                            success: function (data) {
                                $('#container').html(data);
                            },
                        });
                    } else {
                        alertify.error('Hubo un problema al eliminar el horario');
                    }
                },
            });
        },
        function () {
            alertify.confirm().close();
        }
    );
}

// Registrar grupo

$(document).ready(function () {
    $('#btn-registrar-grupo').click(function () {
        if (validarFormularioGrupo()) {
            datos = $('#form_grupo').serialize();
            console.log(datos);

            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Grupo.php',
                data: datos,
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('El registro se realizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
                        }, 1500);
                    } else {
                        $('html, body').animate({ scrollTop: 0 }, 0);
                        alertify.error('Hubo un problema al registrar el grupo');
                    }
                },
            });
            return false;
        }
    });
});

// Actualizar grupo

function actualizarGrupo(id) {
    var datos = {
        id: id,
        CRUD: 1,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/grupos/frm_grupos.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

$(document).ready(function () {
    $('#btn-actualizar-grupo').click(function () {
        if (validarFormularioGrupo()) {
            datos = $('#form_grupo').serialize();
            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Grupo.php',
                data: datos,
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
                        }, 0);
                    } else {
                        alertify.error('Hubo un problema al actualizar al grupo');
                    }
                },
            });
            return false;
        }
    });
});

// Eliminar grupo

function eliminarGrupo(id) {
    var mensaje = '¿Esta seguro de elimnar el grupo ';
    mensaje = mensaje.concat(id);
    mensaje = mensaje.concat('?');

    var titulo = 'Eliminar grupo';
    alertify.confirm(
        titulo,
        mensaje,
        function () {
            var dml = 'delete';
            var datos = {
                id: id,
                dml: dml,
            };
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Grupo.php',
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('Se elimino de manera correcta al usuario');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
                        }, 1500);
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
        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
    }, 1500);
}

// Consultar grupo

function consultarGrupo(id) {
    var datos = {
        id: id,
        CRUD: 0,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/grupos/frm_grupos.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

// Agregar alumnos

function agregarAlumnos(id) {
    var datos = { id: id };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/grupos/frm_agregar_alumnos.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

// Alumnos inscritos

function alumnosInscritos(id) {
    var datos = { id: id };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/grupos/frm_alumnos_inscritos.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

// Documentos de inscripción

function documentosAlumnos(id, persona, inscripcion) {
    var datos = { id: id, persona: persona, inscripcion: inscripcion };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/grupos/frm_documentos_alumnos.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

function subirDocumentos(id, persona, inscripcion) {
    var datos = { id: id, persona: persona, inscripcion: inscripcion };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/grupos/frm_subir_documentos.php',
        success: function (data) {
            $('#container').html(data);
            $('html, body').animate({ scrollTop: 0 }, 0);
        },
    });
}

$('#btn-estatus-archivos').click(function () {
    datos = $('#formAjaxDocumento').serialize();
    $.ajax({
        type: 'POST',
        url: '../modulos/Control_Documento.php',
        data: datos,
        success: function (respuesta) {
            if (respuesta != 'fallo') {
                console.log(respuesta);
                alertify.success('Se guardo el estatus del documento');
                var id = respuesta;
                var grupoLoad = { id: id };
                $.ajax({
                    data: grupoLoad,
                    type: 'POST',
                    url: '../sistema/grupos/frm_alumnos_inscritos.php',
                    success: function (data) {
                        $('#container').html(data);
                        $('html, body').animate({ scrollTop: 0 });
                    },
                });
            } else {
                alertify.error('Hubo un problema al guardar el registro');
            }
        },
    });
    return false;
});

// Realizar inscripción

function listaAlumnos(id) {
    var dml = 'lista';
    var datos = {
        id: id,
        dml: dml,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        contenrType: 'application/pdf',
        url: '../modulos/Control_Inscripcion.php',
        success: function (data) {
            $('#container').html(data);
        },
    });
}

// Cambiar estatus_activo del grupo
function cambioPublicacion(id, estatus, nombreCurso, modalidad) {
    var mensaje = '¿Está seguro que desea cambiar el estatus del grupo: ';
    mensaje = mensaje.concat(id);
    mensaje = mensaje.concat(' del curso: ');
    mensaje = mensaje.concat(nombreCurso);
    mensaje = mensaje.concat(' con modalidad ');
    mensaje = mensaje.concat(modalidad);
    mensaje = mensaje.concat('?');

    var titulo = 'Cambio de estatus de un grupo';
    alertify.confirm(
        titulo,
        mensaje,
        function () {
            var dml = 'actualizarEstatus';
            var datos = {
                id: id,
                dml: dml,
                estatus: estatus,
            };
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Grupo.php',
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('Se cambio el estatus del grupo');
                        setTimeout(function () {
                            $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
                        }, 1500);
                    } else {
                        alertify.error('Hubo un problema al cambiar el estatus del grupo');
                    }
                },
            });
        },
        function () {
            alertify.confirm().close();
        }
    );
    setTimeout(function () {
        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
    }, 1500);
}

// Cambiar estatus_activo del grupo
function Publicar(id, estatus) {
    var mensaje = '¿Está seguro que desea cambiar la publicación del grupo?';
    mensaje = mensaje.concat('<br>Esto alterará la visibilidad del grupo ante los profesores');
    mensaje = mensaje.concat('<br><br>NOTA: Si existen profesores inscritos en el Curso no podrán ver más su información.');

    var titulo = 'Cambio de estatus de un grupo';
    alertify.confirm(
        titulo,
        mensaje,
        function () {
            var dml = 'actualizarEstatus';
            var datos = {
                id: id,
                dml: dml,
                estatus: estatus,
            };
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Grupo.php',
                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta == 1) {
                        alertify.success('Se cambio el estatus del grupo');
                    } else {
                        alertify.error('Hubo un problema al cambiar el estatus del grupo');
                    }
                },
            });
        },
        function () {
            alertify.confirm().close();
        }
    );
}

// Tabla dinámica
$(document).ready(function () {
    $('#tabla_grupos').DataTable({
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

//! No eliminar, permite desplegar cuando es un nuevo registro de grupos
$(document).on('change', '#GrupoModalidad', function mostrarCamposModalidad() {
    var tipo_evento = $('#GrupoModalidad').val();
    if (tipo_evento.startsWith('En línea')) {
        $('#Salon').hide();
        $('#Plataforma').show();
        $('#Acceso').show();
        $('#Reunion').show();
        $('#Clave').show();
    }
    if (tipo_evento.startsWith('Presencial')) {
        $('#Salon').show();
        $('#Plataforma').hide();
        $('#Acceso').hide();
        $('#Reunion').hide();
        $('#Clave').hide();
    }
});

$(document).on('change', '#ID_Curso', function SesionesCurso() {
    var idCurso = $('#ID_Curso').val();
    var dml = 'sesiones';
    var datos = {
        idCurso: idCurso,
        dml: dml,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../modulos/Control_Grupo.php',
        success: function (respuesta) {
            $('#contenedorSesiones').load('../sistema/grupos/frm_grupos_sesiones.php', { curs_num_sesiones: respuesta });
        },
    });
});
