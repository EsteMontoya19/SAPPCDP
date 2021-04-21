// Enlace a los formularios

$(document).ready(function () {
  
  $("#btn-registro-calendarios").click(function () {
    $("#container").load("../sistema/calendarios/frm_calendarios.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });
});
