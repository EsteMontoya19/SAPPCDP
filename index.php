<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="SICENAPYME">
  <meta name="author" content="">

  <!-- Título de la página -->
  <title>Inicio de sesión</title>

  <!-- Referencias -->

  <!-- Iconos -->
  <link href="recursos/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Icono de la pestaña -->
  <link rel="recursos/shortcut icon" href="recursos/favicon.ico" />

  <!-- Alertify -->
  <link rel="stylesheet" type="text/css" href="recursos/alertify/css/alertify.css">
  <link rel="stylesheet" type="text/css" href="recursos/alertify/css/alertify.rtl.css">
  <link rel="stylesheet" type="text/css" href="recursos/alertify/css/themes/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="recursos/alertify/css/themes/bootstrap.rtl.css">

  <!-- Bootstrap 4 -->
  <link href="recursos/css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="recursos/css/bootstrap.css.map" rel="stylesheet" type="text/css">
  <link href="recursos/css/sb-admin.css" rel="stylesheet" type="text/css">
  <link href="recursos/css/sicenapyme.css" rel="stylesheet" type="text/css">

  <!-- JQuery -->
  <script src="recursos/js/jquery-3.4.1.js"></script>

  <!-- DropItemps -->
  <script src="recursos/js/bootstrap.bundle.js"></script>

  <!-- Alertify -->
  <script src="recursos/alertify/alertify.js"></script>

  <!-- Direcciones del sistema-->
  <script src="sistema/recursos/body.js"></script>

  <script>
    // ! Mostrar contraseña en index.php
    function hideOrShowPassword() {
      var x = document.getElementById('strContrasena');
      if (x.type === 'password') {
        x.type = 'text';
      } else {
        x.type = 'password';
      }
    }
  </script>

</head>

<body style="background:#DB9501">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header bg-blue">
        <b style="color: white">&nbsp; Administración</b>

      </div>
      <div class="card-body">
        <div class="col-lg-12 form-row" style="margin-top: 10px;">
          <form name="frm_acceso" method='POST' action='modulos/ControlAcceso.php'>
            <div class="form-group">
              <div class="form-label-group" align="center">
                <h4>Programa Permanente de Capacitación a Distancia para Profesores de la FCA(PPCDP)</h4>
              </div>
            </div>
            <hr>
            <div class="form-group" align="center">
              <label style="color: #545454;"><b>Inicio de sesión</b></label>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" name="strUsuario" id="strUsuario" class="form-control" placeholder="Usuario"
                  required="required" autofocus="autofocus">
                <label for="strUsuario"><i class="fas fa-user" style="color: #C05805"></i>&nbsp; Usuario</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" name="strContrasena" id="strContrasena" class="form-control"
                  placeholder="Contraseña" required="required">
                <label for="strContrasena"><i class="fas fa-key" style="color: #C05805"></i>&nbsp; Contraseña</label>
              </div>
            </div>
            <div class="form-group" style="text-align: center;">
              <input type="checkbox" id="ver1" class="ver" onChange="hideOrShowPassword()" />
              <label class="text" style="color:#DB9501">&nbsp;Mostrar contraseña</label>
            </div>
            <button type="submit" class="btn btn-sy01 btn-block" id="btn-inicio">Ingresar</button>
          </form>
          <div class="col-12 text-center">
            <br>
            <a class="d-block small" href="#" style="color:#DB9501">¿Olvidaste tu contraseña?</a>
            <a class="d-block small" href="#" style="color:#DB9501" type="button" data-toggle="modal"
              data-target="#exampleModal">Registrar Profesor</a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title col-lg-12" id="exampleModalLabel"
            style="background: #2E2300;color: #fff;padding: 10px">Registrar Profesor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <form>
                  <div class="form-group row">
                    <label for="numTrab" class="col-sm-6 col-form-label">Número trabajador:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="rfc">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">RFC con Homoclave:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="rfc">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Nombre(s):</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="rfc">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Apellido Paterno</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="rfc">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Apellido Materno</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="rfc">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Correo Electrónico</label>
                    <div class="col-sm-6">
                      <input type="email" class="form-control" id="rfc">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Número de Teléfono</label>
                    <div class="col-sm-6">
                      <input type="email" class="form-control" id="rfc">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Coordinación Académica</label>
                    <div class="col-sm-6">
                      <select id="inputState" class="form-control">
                        <option selected>Seleccionar...</option>
                        <option>...</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Semblanza</label>
                    <div class="col-sm-6">
                      <textarea type="text" class="form-control" id="strSemblanza" name="strReqTec"></textarea>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Niveles en que imparte</label>
                    <div class="col-sm-6" style="padding-left: 40px">
                      <input class="form-check-input" type="checkbox" id="gridCheck1">
                      <label class="form-check-label" for="gridCheck1">
                        Licenciatura
                      </label>
                      <br>
                      <input class="form-check-input" type="checkbox" id="gridCheck2">
                      <label class="form-check-label" for="gridCheck2">
                        Posgrado
                      </label>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Sistemas en los que imparte</label>
                    <div class="col-sm-6" style="padding-left: 40px">
                      <input class="form-check-input" type="checkbox" id="gridCheck3">
                      <label class="form-check-label" for="gridCheck3">
                        Escolarizado
                      </label>
                      <br>
                      <input class="form-check-input" type="checkbox" id="gridCheck4">
                      <label class="form-check-label" for="gridCheck4">
                        Modalidad Abierta
                      </label>


                      <br>
                      <input class="form-check-input" type="checkbox" id="gridCheck4">
                      <label class="form-check-label" for="gridCheck4">
                        Modalidad a distancia
                      </label>
                    </div>
                  </div>



                  <h5 class="modal-title col-lg-12" id="exampleModalLabel"
                    style="background: #2E2300;color: #fff;padding: 10px">Datos de Acceso</h5>
                  <br>
                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Contraseña</label>
                    <div class="col-sm-6">
                      <input type="password" class="form-control" id="rfc">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Confirmar contraseña</label>
                    <div class="col-sm-6">
                      <input type="password" class="form-control" id="rfc">
                    </div>
                  </div>

                  <h5 class="modal-title" id="exampleModalLabel" style="background: #2E2300;color: #fff;padding: 10px">
                    Datos de Recuperación</h5>
                  <br>
                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Pregunta secreta</label>
                    <div class="col-sm-6">
                      <select id="inputState" class="form-control">
                        <option selected>Seleccionar...</option>
                        <option>...</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Respuesta</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="rfc">
                    </div>
                  </div>

                  
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary">Registrar</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>