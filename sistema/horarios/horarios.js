// Enlace a los formularios

$(document).ready(function () {
  
  $("#btn-registro-horario").click(function () {
    $("#container").load("../sistema/horarios/frm_horarios.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });
});
