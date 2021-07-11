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

function validarInscripcion(inscritos, cupo) {
    if (cupo <= inscritos) {
        return false;
    }

    return true;
}

// Consultar grupo
function consultarGrupo(id, persona, modalidad) {
    var datos = {
        id: id,
        CRUD: 0,
        persona: persona,
        modalidad:modalidad,
    };
    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/profesor/frm_grupo_profesor.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

function consultarGrupoInscrito(id, persona, modalidad) {
    var datos = {
        id: id,
        CRUD: 1,
        persona: persona,
        modalidad:modalidad,
    };
    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/profesor/frm_grupo_profesor.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

// Inscripcion curso
function inscribirGrupo(grupo, inscritos, cupo, persona, nombre, tipo, nivel) {
    if (validarInscripcion(inscritos, cupo)) {
        var mensaje = '¿Esta seguro que desea inscribirse al ';
        mensaje = mensaje.concat(tipo);
        mensaje = mensaje.concat(' ');
        mensaje = mensaje.concat(nombre);
        mensaje = mensaje.concat('<br> Nivel ');
        mensaje = mensaje.concat(nivel);
        mensaje = mensaje.concat('?');

        var titulo = 'Inscripción a grupo';
        alertify.confirm(
            titulo,
            mensaje,
            function () {
                var dml = 'inscripcion';
                var datos = {
                    grupo: grupo,
                    persona: persona,
                    dml: dml,
                };
                $.ajax({
                    data: datos,
                    type: 'POST',
                    url: '../modulos/Control_Grupo.php',
                    success: function (respuesta) {
                        console.log(respuesta);
                        if (respuesta.endsWith('1')) {
                            alertify.success('¡Felicidades! Se inscribio correctamente al grupo.');
                            setTimeout(function () {
                                location.reload();
                                //TODO: Hacer cursos publicados para todos y pantalla de inicio, ver como hacer el id
                                //$('#container').load('../sistema/profesor/frm_inicio_profesores.php');
                            }, 1500);
                        } else if (respuesta.endsWith('2')) {
                            alertify.error('Usted ya esta inscrito a este grupo.');
                        } else if (respuesta.endsWith('3')) {
                            alertify.error('Los horarios de las sesiones del grupo se contraponen con otro grupo previamente inscrito.');
                        } else if (respuesta.endsWith('4')) {
                            alertify.error('Llegó al pedazo del codigo que se queria');
                        } else if (respuesta.endsWith('5')) {
                            alertify.success('Se ha inscrito adecuadamente');
                        } else if (respuesta.endsWith('6')) {
                            alertify.error('Lo siento ya se ha inscrito 2 veces a este curso, aunque fuese en otro grupo y semestre, y son las máximas permitidas');
                        } else if (respuesta.endsWith('7')) {
                            alertify.error('Ya no te puedes inscribir a más grupos este semestre, el máximo son 5');
                        } else {
                            alertify.error('Ocurrio un problema con la inscripción' + respuesta);
                            // alertify.error('Hubo un error al inscribirse al grupo');
                        }
                        /*setTimeout(function () {
                            $('#container').load('../sistema/profesor/frm_inicio_profesores.php');
                        }, 1500);*/
                    },
                });
            },
            function () {
                alertify.confirm().close();
            }
        );
    } else {
        alertify.error('Ya no existen lugares disponibles');
    }
}

function listaInscritos(idGrupo, tipoLista) {
    alert("entra");
    var datos = {
        idGrupo: idGrupo,
        tipoLista: tipoLista
    };
    alert(tipoLista);
    $.ajax({
        data: datos,
        type: 'POST',
        url: '../modulos/Control_PDF.php',
        success: function (respuesta) {
            alertify.success("Si entra y sale" + respuesta);
            console.log(respuesta);
            
        },
    });
}


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
