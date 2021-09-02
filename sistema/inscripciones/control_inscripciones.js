$(document).ready(function () {
    $('#btn-regresar-privados').click(function () {
        location.reload();
    });


    $('#tabla_profesores').DataTable({
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

function inscribirProfesor (persona, grupo) {
    var datos = {
        persona: persona,
        grupo: grupo,
        dml : "inscripcion",

    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../modulos/Control_Grupo.php',
        success: function (respuesta) {
            console.log(respuesta);
            if (respuesta.endsWith('1')) {
                alertify.success('Profesor inscrito de manera satisfactoria.');
                setTimeout(function () {
                    $('#contenedorProfesores').load('../sistema/inscripciones/tabla_profesores.php', { grupo: grupo });
                }, 1500);
            } else if (respuesta.endsWith('2')) {
                alertify.error('El profesor ya esta inscrito en el grupo');
            } else if (respuesta.endsWith('3')) {
                alertify.error('Los horarios de las sesiones se contraponen con otro grupo inscrito por el profesor.');
            } else if (respuesta.endsWith('4')) {
                alertify.error('Llegó al pedazo del codigo que se queria');
            } else if (respuesta.endsWith('5')) {
                alertify.success('Se ha inscrito adecuadamente');
            } else if (respuesta.endsWith('6')) {
                alertify.error('El profesor ya se ha inscrito 2 veces a este curso, aunque fuese en otro grupo y semestre, y son las máximas permitidas');
            } else if (respuesta.endsWith('7')) {
                alertify.error('El profesor ha llegado a su numero maximo de grupos inscritos.');
            } else {
                alertify.error('Ocurrio un problema con la inscripción' + respuesta);
                // alertify.error('Hubo un error al inscribirse al grupo');
            }
        },
    });

}
$('#idGrupo').change (function() {
    var grupo = $('#idGrupo').val();

    if(grupo != 0) {
        $('#contenedorProfesores').load('../sistema/inscripciones/tabla_profesores.php', { grupo: grupo });
    }
});
