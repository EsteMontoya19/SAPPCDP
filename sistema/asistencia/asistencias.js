//? Acciones de los botónes
$('#btn-regresar').click(function () {
  $('html, body').animate({ scrollTop: 0 }, 0);
  $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
});


// Enlace a los formularios
$(document).ready(function () {
  
  $("#btn_lista").click(function () {
    $("#container").load("../sistema/asistencia/frm_asistencia.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });


  //Tabla inicio dinamica
  $('#tabla_asistencia').DataTable({
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



//! Funciones

function asistenciaGrupo (grupo) {
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