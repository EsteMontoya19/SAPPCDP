//? Enlace a los formularios y campos dinamicos
var i = 0;
$(document).ready(function () {
  //? Esta variable sirve para los campos dinamicos
  if (typeof($('#diasActualizacion').val()) != 'undefined') {
      i = $('#diasActualizacion').val();
  } else{
    i=0;
        
  }
    
  $("#btn-registro-calendarios").click(function () {
    $("#container").load("../sistema/calendarios/frm_calendarios.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });
  $("#boton-regresar").click(function () {
    $("#container").load("../sistema/calendarios/frm_inicio_calendarios.php");
  });

  
  $('#add').click(function(){
      i++;
      $('#dynamic_field').append('<tr id="row'+i+'"> <td> <input type="date" class="form-control" placeholder="0" id="diaFestivo'+i+'" name="diaFestivo'+i+'" value=""></td></tr>');
  });

  $(document).on('click', '.btn_remove', function(){
      $('#row'+i+'').remove();
      if(i > 0 ) {
          i--;
      }
  });

   //Tabla inicio dinamica
 $('#tabla_calendarios').DataTable({
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

//? Botones del DML
$(document).ready(function () {
    $('#boton-registrar').click(function () {
        if (validarFormulario()) {
            datos =$('#form_calendario').serialize();
            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Calendario.php',
                data: datos,
 
                success: function (respuesta) {
                    console.log(respuesta);
                      if (respuesta.endsWith('1')) {
                        alertify.success('El registro se realizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/calendarios/frm_inicio_calendarios.php');
                        }, 1500);
                      } else if (respuesta.endsWith('2')) {
                          $('html, body').animate({ scrollTop: 0 }, 'slow');
                          alertify.error('Ya existe una plataforma con ese nombre');
                      } else {
                        alertify.error('No econtrado');
                    }
                },
            });
            return false;
        }
    });

    $('#boton-actualizar').click(function () {
        if (validarFormulario()) {
            datos =$('#form_calendario').serialize();
            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Calendario.php',
                data: datos,

                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('La actualización se realizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/calendarios/frm_inicio_calendarios.php');
                        }, 1500);
                    }  else {
                        alertify.error('Ocurrio un error');
                    }
                },
            });
            return false;
        }
    });
});

//? Funciones generales 

function actualizarCalendario(id) {
    var datos = {
        id: id,
        CRUD: 2,
    };
    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/calendarios/frm_calendarios.php',
        success: function (respuesta) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(respuesta);
        },
    });
}

function consultarCalendario(id) {
    var datos = {
        id: id,
        CRUD: 1,
    };
    
    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/calendarios/frm_calendarios.php',
        success: function (respuesta) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(respuesta);
        },
    });
}




function cambioEstatus(id, estatus, semestre) {
    var titulo = 'Cambio de estatus del Calendario';

    if(estatus != "t") {
      var mensaje = '¿Está seguro de cambiar el estatus del calendario del semestre ';
      mensaje = mensaje.concat(semestre);
      mensaje = mensaje.concat(' ');
      mensaje = mensaje.concat('?');
      mensaje = mensaje.concat('<br>');
      mensaje = mensaje.concat('El estatus del calendario actual se desactivara.');

    } else {
        var mensaje = '¿Está seguro de cambiar el estatus del calendario del semestre ';
        mensaje = mensaje.concat(semestre);
        mensaje = mensaje.concat(' ');
        mensaje = mensaje.concat('?');

    }
    alertify.confirm(
        titulo,
        mensaje,
        function () {
            var dml = 'cambio';
            var datos = {
                id: id,
                dml: dml,
                estatus: estatus,
            };
            $.ajax({
                data: datos,
                type: 'POST',
                url: '../modulos/Control_Calendario.php',
                success: function (respuesta) {
                    if (respuesta == 1) {
                        alertify.success('Se cambió el estatus del calendario');
                        setTimeout(function () {
                            $('#container').load('../sistema/calendarios/frm_inicio_calendarios.php');
                        }, 1500);
                    } else if (respuesta == 2) {
                        alertify.error('No puede desactivar al único calendario activo.');
                    } else if (respuesta == 4) {
                        alertify.error('No hay calendarios activos urge activar uno.');
                    } else {
                        alertify.error('Hubo un problema al cambiar el estatus del calendario.');
                    }
                },
            });
        },
        function () {
            alertify.confirm().close();
        }
    );
  setTimeout(function () {
      $('#container').load('../sistema/calendarios/frm_inicio_calendarios.php');
  }, 1500);
}

function validarFormulario () {
    //Validación del nombre del semestre
    if ($('#NombreSem').val() == '') {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('NombreSem').focus();
        alertify.error('Debe ingresar el semestre al que correspone el calendario. Ej: 2021-2');
        return false;
    } else {
        let semExpReg = /\d{4}\-[1-2]$/;
        if (semExpReg.test($('#NombreSem').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('NombreSem').focus();
            alertify.error('El nombre del semestre debe estar escrito en el siguiente formato 0000-0 terminando en 1 o 2. Ej 2021-1');
            return false;
        }
    }

    //Validación de las fechas correspondientes al inicio y fin del ciclo escolar
    if ($('#inicioCiclo').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('inicioCiclo').focus();
        alertify.error('Debe ingresar la fecha de inicio para el semestre escolar');
        return false;
    }

    if ($('#finCiclo').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('finCiclo').focus();
        alertify.error('Debe ingresar la fecha de termino para el semestre escolar');
        return false;
    }

    if ($('#inicioCiclo').val() >= $('#finCiclo').val()) {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('inicioCiclo').focus();
        alertify.error('La fecha de inicio del ciclo escolar debe ser menor a la del fin');
        return false;
    }

    //Validación de las fechas correspondientes al periodo de examenes
    if ($('#inicioExamenes').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('inicioExamenes').focus();
        alertify.error('Debe ingresar la fecha de inicio para el periodo de exámenes');
        return false;
    }

    if ($('#finExamenes').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('finExamenes').focus();
        alertify.error('Debe ingresar la fecha de termino para el periodo de examenes');
        return false;
    }

    if ($('#inicioExamenes').val() >= $('#finExamenes').val()) {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('inicioExamenes').focus();
        alertify.error('La fecha de inicio del periodo de examenes debe ser menor a la del fin');
        return false;
    }

    //Validación de las fechas correspondientes al periodo intersemestral
    if ($('#inicioInter').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('inicioInter').focus();
        alertify.error('Debe ingresar la fecha de inicio para el periodo intersemestral');
        return false;
    }

    if ($('#finInter').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('finInter').focus();
        alertify.error('Debe ingresar la fecha de termino para el periodo intersemestral');
        return false;
    }

    if ($('#inicioInter').val() >= $('#finInter').val()) {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('inicioInter').focus();
        alertify.error('La fecha de inicio del periodo intersemestral debe ser menor a la del fin');
        return false;
    }

    //Validación de las fechas correspondientes al Asueto Académico (vacaciones de los alumnos)
    if ($('#inicioAsueto').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('inicioAsueto').focus();
        alertify.error('Debe ingresar la fecha de inicio para el asueto académico');
        return false;
    }

    if ($('#finAsueto').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('finAsueto').focus();
        alertify.error('Debe ingresar la fecha de termino para el asueto académico');
        return false;
    }

    if ($('#inicioAsueto').val() >= $('#finAsueto').val()) {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('inicioAsueto').focus();
        alertify.error('La fecha de inicio del asueto académico debe ser menor a la del fin');
        return false;
    }

    //Validación de las fechas correspondientes al periodo de vacaciones administrativas
    if ($('#inicioAdmin').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('inicioAdmin').focus();
        alertify.error('Debe ingresar la fecha de inicio para el periodo de vacaciones administrativas');
        return false;
    }

    if ($('#finAdmin').val() == '') {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('finAdmin').focus();
        alertify.error('Debe ingresar la fecha de termino para el periodo de vacaciones administrativas');
        return false;
    }

    if ($('#inicioAdmin').val() >= $('#finAdmin').val()) {
        $('html, body').animate({ scrollTop: 200 }, 'slow');
        document.getElementById('inicioAdmin').focus();
        alertify.error('La fecha de inicio del periodo de vacaciones administrativas debe ser menor a la del fin');
        return false;
    }

    //valida que los dias festivos agregados no estén vacíos
    for (var iCon = 0; iCon <= i; iCon++){
        if ($('#diaFestivo' + iCon).val() == '') {
            $('html, body').animate({ scrollTop: 300 }, 'slow');
            document.getElementById('diaFestivo' + iCon).focus();
            alertify.error('La fecha del dia inhábil ' + iCon + ' no puede estar vacía, favor de ingresar una fecha');
            return false;
        }
    }

    return true;
}
