// Enlace a los formularios

$(document).ready(function () {
  
  $("#btn-registro-nombramiento").click(function () {
    $("#container").load("../sistema/nombramientos/frm_nombramientos.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  $('#btn-inicio-nombramientos').click(function () {
    $('html, body').animate({ scrollTop: 0 }, 0);
    $('#container').load('../sistema/nombramientos/frm_inicio_nombramientos.php');
  });

  $('#btn-regresar-nombramientos').click(function () {
      $('html, body').animate({ scrollTop: 0 }, 0);
      $('#container').load('../sistema/nombramientos/frm_inicio_nombramientos.php');
  });

});

//Validar el formulario de nombramientos
function validarFormularioNombramientos() {
  if ($('#NombreNombramiento').val() == '') {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    document.getElementById('NombreNombramiento').focus();
    alertify.error('Se debe ingresar el nombre de la nombramiento');
    return false;
  } else {
    if ($('#NombreNombramiento').val().length > 50) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('NombreNombramiento').focus();
        alertify.error('El nombre de la nombramiento debe tener máximo 50 caracteres');
        return false;
    }
    if (
        $('#NombreNombramiento').val().includes('@') ||
        $('#NombreNombramiento').val().includes('.') ||
        $('#NombreNombramiento').val().includes('/') ||
        $('#NombreNombramiento').val().includes('-') ||
        $('#NombreNombramiento').val().includes('*') ||
        $('#NombreNombramiento').val().includes('!') ||
        $('#NombreNombramiento').val().includes('#') ||
        $('#NombreNombramiento').val().includes('$') ||
        $('#NombreNombramiento').val().includes('%') ||
        $('#NombreNombramiento').val().includes('^') ||
        $('#NombreNombramiento').val().includes('&') ||
        $('#NombreNombramiento').val().includes('(') ||
        $('#NombreNombramiento').val().includes(')') ||
        $('#NombreNombramiento').val().includes('-') ||
        $('#NombreNombramiento').val().includes('=') ||
        $('#NombreNombramiento').val().includes('+') ||
        $('#NombreNombramiento').val().includes(':') ||
        $('#NombreNombramiento').val().includes(';')
    ) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('NombreNombramiento').focus();
        alertify.error('El nombre de la nombramiento no debe incluir caracteres especiales @, ., /, *, -, !, #, $, %, ^, &, *, (, ), -, +, =');
        return false;
    }
  }
  return true;
}

//Insertar PreguntaSeguridad
$(document).ready(function () {
  $('#btn-registrar-nombramiento').click(function () {
      if (validarFormularioNombramientos()) {
          datos = new FormData($('#form_nombramientos')[0]);
          $.ajax({
              type: 'POST',
              url: '../modulos/Control_Nombramiento.php',
              data: datos,
              contentType: false,
              processData: false,

              success: function (respuesta) {
                  console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                      alertify.success('El registro se realizó correctamente');
                      setTimeout(function () {
                          $('html, body').animate({ scrollTop: 0 }, 0);
                          $('#container').load('../sistema/nombramientos/frm_inicio_nombramientos.php');
                      }, 1500);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        alertify.error('Ya existe una nombramiento con ese nombre');
                    } else {
                      alertify.error('Hubo un problema al registrar la nombramiento' + respuesta);
                  }
              },
          });
          return false;
      }
  });
});

// Actualizar PreguntaSeguridad
function actualizarNombramiento(id) {
    var datos = {
        id: id,
        CRUD: 1,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/nombramientos/frm_nombramientos.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

$(document).ready(function () {
    $('#btn-actualizar-nombramiento').click(function () {
        if (validarFormularioNombramientos()) {
            datos = new FormData($('#form_nombramientos')[0]);

            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Nombramiento.php',
                data: datos,
                contentType: false,
                processData: false,

                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/nombramientos/frm_inicio_nombramientos.php');
                        }, 0);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        alertify.error('Ya existe una nombramiento con ese nombre');
                    } else {
                        alertify.error('Hubo un problema al actualizar la nombramiento' + respuesta);
                    }
                },
            });
            return false;
        }
    });
});


// Tabla dinámica
$(document).ready(function () {
  $('#tabla_nombramientos').DataTable({
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
