// Enlace a los formularios

$(document).ready(function () {
  
  $("#btn-registrar-curso").click(function () {
    $("#container").load("../sistema/cursos/frm_cursos.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });
});
