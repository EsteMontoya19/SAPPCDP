// Enlace a los formularios

$(document).ready(function () {
  $("#btn-inicio").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 0);
    $("#container").load("../sistema/frm_inicio.php");
  });
  $("#btn-inicio-grupo").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 0);
    $("#container").load("../sistema/grupos/frm_inicio_grupos.php");
  });

  $("#btn-regresar-grupo").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 0);
    $("#container").load("../sistema/grupos/frm_inicio_grupos.php");
  });

  $("#btn-registro-grupo").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 0);
    $("#container").load("../sistema/grupos/frm_grupos.php");
  });

  $("#btn-inicio").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 0);
    $("#container").load("../sistema/frm_inicio.php");
  });

  $('#btn_sesiones').click(function () {
    alert("Si reconoce el boton");
    $('#contenedorSesiones').load('../sistema/grupos/frm_grupos_sesiones.php');
});
});
// Validar el formulario

function validarFormularioGrupo() {
 

  if ($("#GrupoModalidad").val() == "0") {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    document.getElementById("GrupoModalidad").focus();
    alertify.error("Debe ingresar la modalidad del grupo");
    return false;
  }

  if ($("#GrupoEstatus").val() == "0") {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    document.getElementById("GrupoEstatus").focus();
    alertify.error("Debe ingresar el estatus del grupo");
    return false;
  }

  if ($("#GrupoCupo").val() == "") {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    document.getElementById("GrupoCupo").focus();
    alertify.error("Debe ingresar el cupo del grupo");
    return false;
  }

  if ($("#GrupoCurso").val() == "0") {
    $("html, body").animate({ scrollTop: 0 }, "slow");
    document.getElementById("GrupoCurso").focus();
    alertify.error("Debe ingresar el evento del grupo");
    return false;
  }

  if (!$("#GrupoCurso").val().startsWith('4')) {
    if ($("#GrupoProfesores").val() == "0") {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      document.getElementById("GrupoProfesores").focus();
      alertify.error("Debe ingresar al profesor del grupo");
      return false;
    }

    if ($("#GrupoInsInicio").val() == "") {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      document.getElementById("GrupoInsInicio").focus();
      alertify.error("Se debe ingresar la fecha de inicio de las inscripciones");
      return false;
    }
  
    if ($("#GrupoInsFin").val() == "") {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      document.getElementById("GrupoInsFin").focus();
      alertify.error("Se debe ingresar la fecha de inicio de las inscripciones");
      return false;
    }
  
    if ($("#GrupoInsInicio").val() > $("#GrupoInsFin").val()) {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      document.getElementById("GrupoInsInicio").focus();
      alertify.error("No pueden ingresar una fecha de inicio mayor a la final");
      return false;
    }
  
    if ($("#GrupoCurInicio").val() == "") {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      document.getElementById("GrupoCurInicio").focus();
      alertify.error("Se debe ingresar la fecha de inicio del curso");
      return false;
    }
  
    if ($("#GrupoCurFin").val() == "") {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      document.getElementById("GrupoCurFin").focus();
      alertify.error("Se debe ingresar la fecha de termino del curso");
      return false;
    }
  
    if ($("#GrupoCurInicio").val() > $("#GrupoCurFin").val()) {
      $("html, body").animate({ scrollTop: 0 }, "slow");
      document.getElementById("GrupoCurInicio").focus();
      alertify.error("No pueden ingresar una fecha de inicio mayor a la final");
      return false;
    }
  }

  for (var iCon = 1; iCon < 8; iCon++) {
    if ($("#GrupoDia" + iCon).val() != "0") {
      if ($("#GrupoSalon" + iCon).val() == "0") {
        $("html, body").animate({ scrollTop: 2000 }, "slow");
        document.getElementById("GrupoSalon" + iCon).focus();
        alertify.error("Debe ingresar el salón");
        return false;
      }

      if ($("#GrupoHoraInicio" + iCon).val() == "") {
        $("html, body").animate({ scrollTop: 2000 }, "slow");
        document.getElementById("GrupoHoraInicio" + iCon).focus();
        alertify.error("Debe ingresar la hora en la que inicia la clase");
        return false;
      }

      if ($("#GrupoHoraFin" + iCon).val() == "") {
        $("html, body").animate({ scrollTop: 000 }, "slow");
        document.getElementById("GrupoHoraFin" + iCon).focus();
        alertify.error("Debe ingresar la hora en la que termina la clase");
        return false;
      }
    }
  }
  return true;
}

function validarFormularioDocumento() {
  if ($("#AlumnoEscolar").val() == "") {
    $("html, body").animate({ scrollTop: 1500 }, "slow");
    document.getElementById("AlumnoEscolar").focus();
    alertify.error("Debe ingresar el comprobante escolar");
    return false;
  }

  if ($("#AlumnoPago").val() == "") {
    $("html, body").animate({ scrollTop: 1500 }, "slow");
    document.getElementById("AlumnoPago").focus();
    alertify.error("Debe ingresar el comprobante escolar");
    return false;
  }
  return true;
}

// Acciones de los días

var n = 1;

function mostrarDia() {
  if (n <= 7) {
    $("#Dia" + n).show(500);
    document.getElementById("Dia" + n).focus();
    $("html, body").animate({ scrollTop: 10000 }, "slow");
    n++;
  } else {
    n = 8;
  }
}

function mostrarDiaUPD(i) {
  if (i <= 7) {
    $("#Dia" + i).show(500);
    document.getElementById("Dia" + i).focus();
    $("html, body").animate({ scrollTop: 10000 }, "slow");
    n = i;
    n++;
    $("#btn-agregar-horarioAct").hide(0);
    $("#btn-agregar-horario").show(0);
  } else {
    n = 8;
  }
}

function ocultarDia() {
  if (n > 1) {
    n--;
    $("#Dia" + n).hide(500);
    $("html, body").animate({ scrollTop: 10000 }, "slow");
    $("#GrupoDia" + n).val("0");
    $("#GrupoSalon" + n).val("0");
    $("#GrupoHoraInicio" + n).val("");
    $("#GrupoHoraFin" + n).val("");
  }
}

function ocultarDiaUPD(x) {
  if (n > x) {
    n--;
    $("#Dia" + n).hide(500);
    $("html, body").animate({ scrollTop: 10000 }, "slow");
    $("#GrupoDia" + n).val("0");
    $("#GrupoSalon" + n).val("0");
    $("#GrupoHoraInicio" + n).val("");
    $("#GrupoHoraFin" + n).val("");
  }
}

// Eliminar horario

function eliminarHorario(id, grupo) {
  var mensaje = "¿Esta seguro de elimnar el horario?";

  var titulo = ("Eliminar horario").bold();
  alertify.confirm(
    titulo,
    mensaje,
    function () {
      var dml = "borrar";
      var datos = {
        id: id,
        dml: dml,
      };
      $.ajax({
        data: datos,
        type: "POST",
        url: "../modulos/Control_Grupo.php",
        success: function (respuesta) {
          if (respuesta = 1) {
            alertify.success("Se elimino correctamente el horario");

            var datos = { id: grupo , CRUD: 1};

            $.ajax({
              data: datos,
              type: "POST",
              url: "../sistema/grupos/frm_grupos.php",
              success: function (data) {
                $("#container").html(data);
              },
            });
          } else {
            alertify.error("Hubo un problema al eliminar el horario");
          }
        },
      });
    },
    function () {
      alertify.confirm().close();
    }
  );
}

// Registrar grupo

$(document).ready(function () {
  $("#btn-registar-grupo").click(function () {
    if (validarFormularioGrupo()) {
      datos = $("#formAjaxGrupo").serialize();
      console.log(datos);

      $.ajax({
        type: "POST",
        url: "../modulos/Control_Grupo.php",
        data: datos,
        success: function (respuesta) {
          console.log(respuesta);
          if (respuesta == 1) {
            alertify.success("El registro se realizó correctamente");
            setTimeout(function () {
              $("html, body").animate({ scrollTop: 0 }, 0);
              $("#container").load("../sistema/grupos/frm_inicio_grupos.php");
            }, 1500);
          } else {
            $("html, body").animate({ scrollTop: 0 }, 0);
            alertify.error("Hubo un problema al registrar el grupo");
          }
        },
      });
      return false;
    }
  });
});

// Actualizar grupo

function actualizarGrupo(id) {
  var datos = { 
    id: id,
    CRUD: 1,
  };

  $.ajax({
    data: datos,
    type: "POST",
    url: "../sistema/grupos/frm_grupos.php",
    success: function (data) {
      $("html, body").animate({ scrollTop: 0 }, 0);
      $("#container").html(data);
    },
  });
}

$(document).ready(function () {
  $("#btn-actualizar-grupo").click(function () {
    if (validarFormularioGrupo()) {
      datos = $("#formAjaxGrupo").serialize();
      $.ajax({
        type: "POST",
        url: "../modulos/Control_Grupo.php",
        data: datos,
        success: function (respuesta) {
          console.log(respuesta);
          if (respuesta == 1) {
            alertify.success("El registro se actualizó correctamente");
            setTimeout(function () {
              $("html, body").animate({ scrollTop: 0 }, 0);
              $("#container").load(
                "../sistema/grupos/frm_inicio_grupos.php"
              );
            }, 0);
          } else {
            alertify.error("Hubo un problema al actualizar al grupo");
          }
        },
      });
      return false;
    }
  });
});

// Eliminar grupo

function eliminarGrupo(id) {
  var mensaje = "¿Esta seguro de elimnar el grupo ";
  mensaje = mensaje.concat(id);
  mensaje = mensaje.concat("?");

  var titulo = "Eliminar grupo";
  alertify.confirm(
    titulo,
    mensaje,
    function () {
      var dml = "delete";
      var datos = {
        id: id,
        dml: dml,
      };
      $.ajax({
        data: datos,
        type: "POST",
        url: "../modulos/Control_Grupo.php",
        success: function (respuesta) {
          console.log(respuesta);
          if (respuesta == 1) {
            alertify.success("Se elimino de manera correcta al usuario");
            setTimeout(function () {
              $("html, body").animate({ scrollTop: 0 }, 0);
              $("#container").load(
                "../sistema/grupos/frm_inicio_grupos.php"
              );
            }, 1500);
          } else {
            alertify.error("Hubo un problema al eliminar al usuario");
          }
        },
      });
    },
    function () {
      alertify.confirm().close();
    }
  );
  setTimeout(function () {
    $("html, body").animate({ scrollTop: 0 }, 0);
    $("#container").load("../sistema/grupos/frm_inicio_grupos.php");
  }, 1500);
}

// Consultar grupo

function consultarGrupo(id) {
  var datos = { 
    id: id,
    CRUD: 0,
  };

  $.ajax({
    data: datos,
    type: "POST",
    url: "../sistema/grupos/frm_grupos.php",
    success: function (data) {
      $("html, body").animate({ scrollTop: 0 }, 0);
      $("#container").html(data);
    },
  });
}

// Agregar alumnos

function agregarAlumnos(id) {
  var datos = { id: id };

  $.ajax({
    data: datos,
    type: "POST",
    url: "../sistema/grupos/frm_agregar_alumnos.php",
    success: function (data) {
      $("html, body").animate({ scrollTop: 0 }, 0);
      $("#container").html(data);
    },
  });
}

// Alumnos inscritos

function alumnosInscritos(id) {
  var datos = { id: id };

  $.ajax({
    data: datos,
    type: "POST",
    url: "../sistema/grupos/frm_alumnos_inscritos.php",
    success: function (data) {
      $("html, body").animate({ scrollTop: 0 }, 0);
      $("#container").html(data);
    },
  });
}

// Documentos de inscripción

function documentosAlumnos(id, persona, inscripcion) {
  var datos = { id: id, persona: persona, inscripcion: inscripcion };

  $.ajax({
    data: datos,
    type: "POST",
    url: "../sistema/grupos/frm_documentos_alumnos.php",
    success: function (data) {
      $("html, body").animate({ scrollTop: 0 }, 0);
      $("#container").html(data);
    },
  });
}

function subirDocumentos(id, persona, inscripcion) {
  var datos = { id: id, persona: persona, inscripcion: inscripcion };

  $.ajax({
    data: datos,
    type: "POST",
    url: "../sistema/grupos/frm_subir_documentos.php",
    success: function (data) {
      $("#container").html(data);
      $("html, body").animate({ scrollTop: 0 }, 0);
    },
  });
}

$("#btn-estatus-archivos").click(function () {
  datos = $("#formAjaxDocumento").serialize();
  $.ajax({
    type: "POST",
    url: "../modulos/Control_Documento.php",
    data: datos,
    success: function (respuesta) {
      if (respuesta != "fallo") {
        console.log(respuesta);
        alertify.success("Se guardo el estatus del documento");
        var id = respuesta;
        var grupoLoad = { id: id };
        $.ajax({
          data: grupoLoad,
          type: "POST",
          url: "../sistema/grupos/frm_alumnos_inscritos.php",
          success: function (data) {
            $("#container").html(data);
            $("html, body").animate({ scrollTop: 0 });
          },
        });
      } else {
        alertify.error("Hubo un problema al guardar el registro");
      }
    },
  });
  return false;
});

// Realizar inscripción

function listaAlumnos(id) {
  var dml = "lista";
  var datos = {
    id: id,
    dml: dml,
  };

  $.ajax({
    data: datos,
    type: "POST",
    contenrType: "application/pdf",
    url: "../modulos/Control_Inscripcion.php",
    success: function (data) {
      $("#container").html(data);
    },
  });
}

// Cambiar estatus_activo del grupo
function cambioEstatus(id, estatus, nombreCurso, modalidad){
  
  var mensaje = '¿Está seguro que desea cambiar el estatus del grupo: ';
  mensaje = mensaje.concat(id);
  mensaje = mensaje.concat(' del curso: ');
  mensaje = mensaje.concat(nombreCurso);
  mensaje = mensaje.concat(' con modalidad ');
  mensaje = mensaje.concat(modalidad);
  mensaje = mensaje.concat('?');
  
  var titulo = 'Cambio de estatus de un grupo';
  alertify.confirm(
    titulo, 
    mensaje,
    function () {
      var dml = 'actualizarEstatus';
      var datos = {
        id: id,
        dml: dml,
        estatus: estatus,
      };
      $.ajax({
        data: datos,
        type: 'POST',
        url: '../modulos/Control_Grupo.php',
        success: function (respuesta) {
          console.log(respuesta);
          if(respuesta == 1){
            alertify.success('Se cambio el estatus del grupo');
            setTimeout(function (){
              $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
            }, 1500);
          } else {
            alertify.error('Hubo un problema al cambiar el estatus del grupo');
          }
        },
      });
    }, function (){
      alertify.confirm().close();
    }
  );
  setTimeout(function (){
    $('#container').load('../sistema/grupos/frm_inicio_grupos.php');
  }, 1500);
}

// Tabla dinámica
$(document).ready( function () {
  $('#tabla_grupos').DataTable({
    language: {
      "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    pageLength : 10,
    lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, 'Todos']]
  });
});

//! No eliminar, permite desplegar cuando es un nuevo registro de grupos
$(document).on('change', '#GrupoModalidad', function mostrarCamposModalidad() {
  var tipo_evento = $('#GrupoModalidad').val();
  if (tipo_evento.startsWith('En línea')) {
      $('#ID_Salon').hide();
      $('#ID_Plataforma').show();
      $('#URL_Acceso').show();
      $('#ID_Reunion').show();
      $('#Clave_Acceso').show();
  }
  if (tipo_evento.startsWith('Presencial')) {
    $('#ID_Salon').show();
    $('#ID_Plataforma').hide();
    $('#URL_Acceso').hide();
    $('#ID_Reunion').hide();
    $('#Clave_Acceso').hide();
  }
});


$(document).on('change', '#ID_Curso', function SesionesCurso() {
  var idCurso = $('#ID_Curso').val();

  alert("Entra al seleccionar 3");

  $.ajax({
    data: idCurso,
    type: "POST",
    url: "../sistema/grupos/frm_grupos_sesiones.php",
    success: function () {
      $('#contenedorSesiones').load('../sistema/grupos/frm_grupos_sesiones.php', { "idCurso": idCurso });
      
    },
    
  });

  
});