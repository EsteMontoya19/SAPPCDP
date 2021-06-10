// Enlace a los formularios

$(document).ready(function () {
  
  $("#btn-registro-plataforma").click(function () {
    $("#container").load("../sistema/plataformas/frm_plataformas.php");
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  $('#btn-inicio-plataforma').click(function () {
    $('html, body').animate({ scrollTop: 0 }, 0);
    $('#container').load('../sistema/plataformas/frm_inicio_plataformas.php');
  });

  $('#btn-regresar-plataforma').click(function () {
      $('html, body').animate({ scrollTop: 0 }, 0);
      $('#container').load('../sistema/plataformas/frm_inicio_plataformas.php');
  });

});

//Validar el formulario de plataformas
function validarFormularioPlataforma() {
  if ($('#NombrePlataforma').val() == '') {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
    document.getElementById('NombrePlataforma').focus();
    alertify.error('Se debe ingresar el nombre de la plataforma');
    return false;
  } else {
    if ($('#NombrePlataforma').val().length > 30) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('NombrePlataforma').focus();
        alertify.error('El nombre de la plataforma debe tener máximo 30 caracteres');
        return false;
    }
    if (
        $('#NombrePlataforma').val().includes('@') ||
        $('#NombrePlataforma').val().includes('.') ||
        $('#NombrePlataforma').val().includes('/') ||
        $('#NombrePlataforma').val().includes('-') ||
        $('#NombrePlataforma').val().includes('*') ||
        $('#NombrePlataforma').val().includes('!') ||
        $('#NombrePlataforma').val().includes('#') ||
        $('#NombrePlataforma').val().includes('$') ||
        $('#NombrePlataforma').val().includes('%') ||
        $('#NombrePlataforma').val().includes('^') ||
        $('#NombrePlataforma').val().includes('&') ||
        $('#NombrePlataforma').val().includes('(') ||
        $('#NombrePlataforma').val().includes(')') ||
        $('#NombrePlataforma').val().includes('-') ||
        $('#NombrePlataforma').val().includes('=') ||
        $('#NombrePlataforma').val().includes('+') ||
        $('#NombrePlataforma').val().includes(':') ||
        $('#NombrePlataforma').val().includes(';')
    ) {
        $('html, body').animate({ scrollTop: 0 }, 'slow');
        document.getElementById('NombrePlataforma').focus();
        alertify.error('El nombre de la plataforma no debe incluir caracteres especiales @, ., /, *, -, !, #, $, %, ^, &, *, (, ), -, +, =');
        return false;
    }
  }
  return true;
}

//Insertar Plataforma
$(document).ready(function () {
  $('#btn-registrar-plataforma').click(function () {
      if (validarFormularioPlataforma()) {
          datos = new FormData($('#form_plataformas')[0]);
          $.ajax({
              type: 'POST',
              url: '../modulos/Control_Plataforma.php',
              data: datos,
              contentType: false,
              processData: false,

              success: function (respuesta) {
                  console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                      alertify.success('El registro se realizó correctamente');
                      setTimeout(function () {
                          $('html, body').animate({ scrollTop: 0 }, 0);
                          $('#container').load('../sistema/plataformas/frm_inicio_plataformas.php');
                      }, 1500);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        alertify.error('Ya existe una plataforma con ese nombre');
                    } else {
                      alertify.error('Hubo un problema al registrar la plataforma');
                  }
              },
          });
          return false;
      }
  });
});

// Actualizar Plataforma
function actualizarPlataforma(id) {
    var datos = {
        id: id,
        CRUD: 1,
    };

    $.ajax({
        data: datos,
        type: 'POST',
        url: '../sistema/plataformas/frm_plataformas.php',
        success: function (data) {
            $('html, body').animate({ scrollTop: 0 }, 0);
            $('#container').html(data);
        },
    });
}

$(document).ready(function () {
    $('#btn-actualizar-plataforma').click(function () {
        if (validarFormularioPlataforma()) {
            datos = new FormData($('#form_plataformas')[0]);

            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Plataforma.php',
                data: datos,
                contentType: false,
                processData: false,

                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('El registro se actualizó correctamente');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/plataformas/frm_inicio_plataformas.php');
                        }, 0);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        alertify.error('Ya existe una plataforma con ese nombre');
                    } else {
                        alertify.error('Hubo un problema al registrar la plataforma');
                    }
                },
            });
            return false;
        }
    });
});

// Tabla dinámica
$(document).ready(function () {
  $('#tabla_plataformas').DataTable({
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
