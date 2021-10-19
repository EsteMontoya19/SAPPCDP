//? Acciones de los botónes
$('#btn-regresar').click(function () {
    location.reload();
});

// Enlace a los formularios
$(document).ready(function () {
    $('#btn_lista').click(function () {
        $('#container').load('../sistema/asistencia/frm_asistencia.php');
        $('html, body').animate({ scrollTop: 0 }, 'slow');
    });
    
    $('#tabla_asistencia_next').click(function () {
        alert("Siguiente");
    });

    $('#btn-regresar-constancia').click(function () {
        $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
        // $('html, body').animate({ scrollTop: 0 }, 'slow');
    });

    //! Funciones botónes

    $('#btn-registrar-asistencia').click(function () {
        datos = $('#form_asistencia').serialize();
        console.log(datos);

        //? Adaptar para que registre asistencias
        $.ajax({
            type: 'POST',
            url: '../modulos/Control_Asistencia.php',
            data: datos,

            success: function (respuesta) {
                console.log(respuesta);
                if (respuesta == 1) {
                    alertify.success('El registro se realizó correctamente');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    $('html, body').animate({ scrollTop: 0 }, 0);
                    alertify.error('Hubo un problema al registrar la asistencia');
                }
            },
        });
        return false;
    });

    //?Tabla inicio dinamica
    $('#tabla_asistencia').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json',
        },
        pageLength: 1000,
        order: [],
        lengthMenu: [
            [20, 50, 100, -1],
            [20, 50, 100, 'Todos'],
        ],
    });
});

//! Funciones
function bloqueoCambioPasado() {
    alertify.error('No tiene permiso de registrar asistencias de sesiones pasadas.');
    return false;
}

function asistenciaGrupo(grupo, moderador) {
    var datos = {
        grupo: grupo,
        moderador: moderador,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/asistencia/frm_asistencia.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

function descargaConstancia (id) {
    
    var dml = 'cambioEstadoDescargada';
    var datos = {
        dml: dml,
        consID: id,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../modulos/Control_Constancia.php',
        success: function (respuesta) {
            console.log(respuesta);
            if(respuesta == 1){
                alertify.success('Felicitaciones ha descargado su constancia');
            } else {
                alertify.error('Hubo un problema' + respuesta);
            }
        },
    });
}
