//? Enlace a los formularios y campos dinamicos
$(document).ready(function () {
  //? Esta variable sirve para los campos dinamicos
  if (typeof($('#diasActualizacion').val()) != 'undefined') {
      var i = $('#diasActualizacion').val();
  } else{
    var i=0;
        
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
    return true;
}
