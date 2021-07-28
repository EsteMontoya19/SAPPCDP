// Enlace a los formularios

$(document).ready(function () {
  
  $("#btn-registro-coordinacion").click(function () {
    $("#container").load("../sistema/coordinaciones/frm_coordinaciones.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  $('#btn-inicio-coordinaciones').click(function () {
    $('html, body').animate({ scrollTop: 0 }, 0);
    $('#container').load('../sistema/coordinaciones/frm_inicio_coordinaciones.php');
  });

  $('#btn-regresar-coordinacion').click(function () {
      $('html, body').animate({ scrollTop: 0 }, 0);
      $('#container').load('../sistema/coordinaciones/frm_inicio_coordinaciones.php');
  });

});

//Validar el formulario de Coordinaciones
function validarFormularioCoordinaciones() {
  if ($('#NombreCoordinacion').val() == '') {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    document.getElementById('NombreCoordinacion').focus();
    alertify.error('Se debe ingresar el nombre de la coordinacion');
    return false;
  } else {
    if ($('#NombreCoordinacion').val().length > 50) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('NombreCoordinacion').focus();
        alertify.error('El nombre de la coordinacion debe tener máximo 50 caracteres');
        return false;
    }
    if (
        $('#NombreCoordinacion').val().includes('@') ||
        $('#NombreCoordinacion').val().includes('.') ||
        $('#NombreCoordinacion').val().includes('/') ||
        $('#NombreCoordinacion').val().includes('-') ||
        $('#NombreCoordinacion').val().includes('*') ||
        $('#NombreCoordinacion').val().includes('!') ||
        $('#NombreCoordinacion').val().includes('#') ||
        $('#NombreCoordinacion').val().includes('$') ||
        $('#NombreCoordinacion').val().includes('%') ||
        $('#NombreCoordinacion').val().includes('^') ||
        $('#NombreCoordinacion').val().includes('&') ||
        $('#NombreCoordinacion').val().includes('(') ||
        $('#NombreCoordinacion').val().includes(')') ||
        $('#NombreCoordinacion').val().includes('-') ||
        $('#NombreCoordinacion').val().includes('=') ||
        $('#NombreCoordinacion').val().includes('+') ||
        $('#NombreCoordinacion').val().includes(':') ||
        $('#NombreCoordinacion').val().includes(';')
    ) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('NombreCoordinacion').focus();
        alertify.error('El nombre de la coordinacion no debe incluir caracteres especiales @, ., /, *, -, !, #, $, %, ^, &, *, (, ), -, +, =');
        return false;
    }
  }
  return true;
}

//Insertar PreguntaSeguridad
$(document).ready(function () {
  $('#btn-registrar-coordinacion').click(function () {
      if (validarFormularioCoordinaciones()) {
          datos = new FormData($('#form_coordinaciones')[0]);
          $.ajax({
              type: 'POST',
              url: '../modulos/Control_Coordinacion.php',
              data: datos,
              contentType: false,
              processData: false,

              success: function (respuesta) {
                  console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                      alertify.success('El registro se realizó correctamente');
                      setTimeout(function () {
                          $('html, body').animate({ scrollTop: 0 }, 0);
                          $('#container').load('../sistema/coordinaciones/frm_inicio_coordinaciones.php');
                      }, 1500);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        alertify.error('Ya existe una coordinacion con ese nombre');
                    } else {
                      alertify.error('Hubo un problema al registrar la coordinacion' + respuesta);
                  }
              },
          });
          return false;
      }
  });
});

// Actualizar PreguntaSeguridad
function actualizarCoordinacion(id) {
    var datos = {
        id: id,
        CRUD: 1,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/coordinaciones/frm_coordinaciones.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

$(document).ready(function () {
    $('#btn-actualizar-coordinacion').click(function () {
        if (validarFormularioCoordinaciones()) {
            datos = new FormData($('#form_coordinaciones')[0]);

            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Coordinacion.php',
                data: datos,
                contentType: false,
                processData: false,

                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/coordinaciones/frm_inicio_coordinaciones.php');
                        }, 0);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        alertify.error('Ya existe una coordinacion con ese nombre');
                    } else {
                        alertify.error('Hubo un problema al actualizar la coordinacion' + respuesta);
                    }
                },
            });
            return false;
        }
    });
});


// Tabla dinámica
$(document).ready(function () {
  $('#tabla_coordinaciones').DataTable({
      language: {
          url: '//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json',
      },
      pageLength: 10,
      lengthMenu: [
          [5, 10, 20, 50, -1],
          [5, 10, 20, 50, 'Todos'],
      ],
  });
});

$('.custom-file-input').on('change', function () {
  var fileName = $(this).val().split('\\').pop();
  $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
});
