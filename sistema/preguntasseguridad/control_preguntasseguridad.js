// Enlace a los formularios

$(document).ready(function () {
  
  $("#btn-registro-preguntaseguridad").click(function () {
    $("#container").load("../sistema/preguntasseguridad/frm_preguntasseguridad.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  $('#btn-inicio-preguntaseguridad').click(function () {
    $('html, body').animate({ scrollTop: 0 }, 0);
    $('#container').load('../sistema/preguntasseguridad/frm_inicio_preguntasseguridad.php');
  });

  $('#btn-regresar-preguntaseguridad').click(function () {
      $('html, body').animate({ scrollTop: 0 }, 0);
      $('#container').load('../sistema/preguntasseguridad/frm_inicio_preguntasseguridad.php');
  });

});

//Validar el formulario de preguntasseguridad
function validarFormularioPreguntaSeguridad() {
  if ($('#NombrePreguntaSeguridad').val() == '') {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    document.getElementById('NombrePreguntaSeguridad').focus();
    alertify.error('Se debe ingresar el nombre de la pregunta de seguridad');
    return false;
  } else {
    if ($('#NombrePreguntaSeguridad').val().length > 100) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('NombrePreguntaSeguridad').focus();
        alertify.error('El nombre de la pregunta de seguridad debe tener máximo 100 caracteres');
        return false;
    }
    if (
        $('#NombrePreguntaSeguridad').val().includes('@') ||
        $('#NombrePreguntaSeguridad').val().includes('.') ||
        $('#NombrePreguntaSeguridad').val().includes('/') ||
        $('#NombrePreguntaSeguridad').val().includes('-') ||
        $('#NombrePreguntaSeguridad').val().includes('*') ||
        $('#NombrePreguntaSeguridad').val().includes('!') ||
        $('#NombrePreguntaSeguridad').val().includes('#') ||
        $('#NombrePreguntaSeguridad').val().includes('$') ||
        $('#NombrePreguntaSeguridad').val().includes('%') ||
        $('#NombrePreguntaSeguridad').val().includes('^') ||
        $('#NombrePreguntaSeguridad').val().includes('&') ||
        $('#NombrePreguntaSeguridad').val().includes('(') ||
        $('#NombrePreguntaSeguridad').val().includes(')') ||
        $('#NombrePreguntaSeguridad').val().includes('-') ||
        $('#NombrePreguntaSeguridad').val().includes('=') ||
        $('#NombrePreguntaSeguridad').val().includes('+') ||
        $('#NombrePreguntaSeguridad').val().includes(':') ||
        $('#NombrePreguntaSeguridad').val().includes(';')
    ) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('NombrePreguntaSeguridad').focus();
        alertify.error('El nombre de la pregunta de seguridad no debe incluir caracteres especiales @, ., /, *, -, !, #, $, %, ^, &, *, (, ), -, +, =');
        return false;
    }
  }
  return true;
}

//Insertar PreguntaSeguridad
$(document).ready(function () {
  $('#btn-registrar-preguntaseguridad').click(function () {
      if (validarFormularioPreguntaSeguridad()) {
          datos = new FormData($('#form_preguntasseguridad')[0]);
          $.ajax({
              type: 'POST',
              url: '../modulos/Control_PreguntaSeguridad.php',
              data: datos,
              contentType: false,
              processData: false,

              success: function (respuesta) {
                  console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                      alertify.success('El registro se realizó correctamente');
                      setTimeout(function () {
                          $('html, body').animate({ scrollTop: 0 }, 0);
                          $('#container').load('../sistema/preguntasseguridad/frm_inicio_preguntasseguridad.php');
                      }, 1500);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        alertify.error('Ya existe una pregunta de seguridad con ese nombre');
                    } else {
                      alertify.error('Hubo un problema al registrar la pregunta de seguridad');
                  }
              },
          });
          return false;
      }
  });
});

// Actualizar PreguntaSeguridad
function actualizarPreguntaSeguridad(id) {
    var datos = {
        id: id,
        CRUD: 1,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/preguntasseguridad/frm_preguntasseguridad.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

$(document).ready(function () {
    $('#btn-actualizar-preguntaseguridad').click(function () {
        if (validarFormularioPreguntaSeguridad()) {
            datos = new FormData($('#form_preguntasseguridad')[0]);

            $.ajax({
                type: 'POST',
                url: '../modulos/Control_PreguntaSeguridad.php',
                data: datos,
                contentType: false,
                processData: false,

                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/preguntasseguridad/frm_inicio_preguntasseguridad.php');
                        }, 0);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        alertify.error('Ya existe una pregunta de seguridad con ese nombre');
                    } else {
                        alertify.error('Hubo un problema al registrar la pregunta de seguridad');
                    }
                },
            });
            return false;
        }
    });
});

// Tabla dinámica
$(document).ready(function () {
  $('#tabla_preguntasseguridad').DataTable({
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
