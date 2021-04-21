// Enlace a los formularios

$(document).ready(function () {
  
  $("#btn_lista").click(function () {
    $("#container").load("../sistema/asistencia/frm_asistencia.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });
});
