// Enlace a los formularios

$(document).ready(function () {
  
  $("#btn-registro-plataforma").click(function () {
    $("#container").load("../sistema/plataformas/frm_plataformas.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });
});
