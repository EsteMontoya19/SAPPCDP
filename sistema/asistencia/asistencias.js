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


  //! Funciones botónes 

  $('#btn-registrar-asistencia').click(function () {
          datos = $('#form_asistencia').serialize();
          console.log(datos);

          //? Adaptar para que registre asistencias
          $.ajax({
              type: 'POST',
              url: '../modulos/Control_Asistencia.php',
              data : datos,

              success: function (respuesta) {
                  console.log(respuesta);
                  if (respuesta == 1) {
                      alertify.success('El registro se realizó correctamente');
                      setTimeout(function () {
                          $('html, body').animate({ scrollTop: 0 }, 0);
                          $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
                      }, 1500);
                  } else if (respuesta == 2){
                      alertify.error('No hay Profesores inscritos en el grupo.');
                  } else if (respuesta == 3){
                      alertify.error('No se puede registrar un grupo con sesiones en dias inhabiles o festivos');
                  } else if (respuesta == 4){
                      alertify.error('No se puede registrar un grupo con sesiones en el periodo de vacaciones administrativas');
                  } else if (respuesta == 5){
                      alertify.error('No se puede registrar un grupo con sesiones en asueto academico');
                  } else {
                      $('html, body').animate({ scrollTop: 0 }, 0);
                      alertify.error('Hubo un problema al registrar el grupo' + respuesta);
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