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

function asistenciaGrupo (grupo ) {
    var datos = {
      grupo: grupo,
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
        lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, 'Todos'],
        ],
    });
});
