$(document).ready(function () {
    $('#btn-inicio').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        $('#container').load('../sistema/frm_inicio.php');
    });
    $('#btn-regresar-grupo').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 0);
        location.reload();
    });
});

// Consultar grupo

function consultarGrupoImpartir(id, persona, modalidad) {
    var datos = {
        id: id,
        modalidad: modalidad,
        CRUD: 0,
        persona: persona,
    };
    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/instructor/frm_grupo_instructor.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

function asistenciaGrupo(grupo, instructor) {
    var datos = {
        grupo: grupo,
        instructor: instructor,
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

$(document).ready(function () {
    $('#tabla_grupos').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json',
        },
        pageLength: 10,
        order: [0, 'desc'],
        lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, 'Todos'],
        ],
    });
});

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