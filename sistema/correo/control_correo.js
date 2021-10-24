$(document).ready(function() {
    $("#destinatario").focus();
    $("#destinatario").val("");

    $("#destinatario").keypress(function (){
        
        var datos = {
            pista: $("#destinatario").val(),
        };
        $.ajax({
            data: datos,
            type: 'POST',
            dataType : "json",
            url: '../modulos/Control_Correo.php',
            success: function (respuesta) {
                console.log(respuesta);
                $("#destinatario").autocomplete({
                    source: respuesta
                });
                    
            },
    
        });
    });
    

    $('#btn-limpiar').click(function () {
        $("#destinatario").val("");
        $("#asunto").val("");
        $("#mensaje").val("");
    });
    

    $('#btn-enviar').click(function () {
        $("#btn-enviar").prop('disabled', true);
        if (validarCorreo()) {
            datos = new FormData($('#form_correo')[0]);

            $.ajax({
                type: 'POST',
                url: '../modulos/Control_Correo.php',
                data: datos,
                contentType: false,
                processData: false,

                success: function (respuesta) {
                    console.log(respuesta);
                    if (respuesta.endsWith('1')) {
                        alertify.success('Los correos electronicos se han envido satisfactoriamente.');
                        setTimeout(function () {
                            $('html, body').animate({ scrollTop: 0 }, 0);
                            $('#container').load('../sistema/correo/frm_correo.php');
                        }, 1000);
                    } else if (respuesta.endsWith('2')) {
                        $('html, body').animate({ scrollTop: 0 }, 'slow');
                        alertify.error('Hubo un problema con el envio de correos');
                    } 
                },
            });
            $("#btn-enviar").prop('disabled', false);
            return false;
        }
        $("#btn-enviar").prop('disabled', false);
    });

  
});


function validarCorreo() {


    if($("#destinatario").val() == "" || typeof($("#destinatario").val()) == 'undefined') {
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('destinatario').focus();
        alertify.error('Debe seleccionar un grupo, ingrese su ID o nombre del curso y seleccione el deseado.');
        return false;
    } else {
        //? Se puede verificar con Regex
        var regExp = /^[\d]+\s\|\s[\w]+.+\|\s\d{4}-\d{2}-\d{2}$/;
        if (regExp.test($('#destinatario').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('destinatario').focus();
            alertify.error('Error en la estructura del destinatario, por favor seleccione uno de la lista.');
            return false;
        }
    }

    if($("#asunto").val() == "" || typeof($("#asunto").val()) == 'undefined') {
        alert($("#asunto").val());
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('asunto').focus();
        alertify.error('Debe ingresar un asunto para el correo.');
        return false;
    } else {
        regExp =/^(?![\*\>\<\+\{\}\[\]\@\$\;])/;
        if (regExp.test($('#asunto').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('asunto').focus();
            alertify.error('No puede incluir los siguientes carácteres en el asunto: * , > , <, +, {, }, [, ], @, $.');
            return false;
        }
    }
    if($("#mensaje").val() == "" || typeof($("#mensaje").val()) == 'undefined') {
        alert($("#asunto").val());
        $('html, body').animate({ scrollTop: 100 }, 'slow');
        document.getElementById('mensaje').focus();
        alertify.error('Debe ingresar un mensaje para el correo.');
        return false;
    } else {
        regExp =/^(?![\*\>\<\+\{\}\[\]\$\;])/;
        if (regExp.test($('#mensaje').val())) {
        } else {
            $('html, body').animate({ scrollTop: 100 }, 'slow');
            document.getElementById('mensaje').focus();
            alertify.error('No puede incluir los siguientes carácteres en el mensaje: * , > , <, +, {, }, [, ], $.');
            return false;
        }
    }
    return true;
}



