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
  <link href="recursos/css/bootstrap-modificado.css" rel="stylesheet" type="text/css">

  <!-- JQuery -->
  <script src="recursos/js/jquery-3.4.1.js"></script>

  <!-- DropItemps -->
  <script src="recursos/js/bootstrap.bundle.js"></script>

  <!-- Alertify -->
  <script src="recursos/alertify/alertify.js"></script>

  <!-- Direcciones del sistema-->
  <script src="sistema/recursos/body.js"></script>
</head>
<body style="background:#F8FCFB">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header bg-banner-loggin">
      <p class = "centrado negritas">&nbsp; Administración </p>
      </div>

      <div class="card-body">
        <div class="col-lg-12 form-row" style="margin-top: 10px;">
          <form name="frm_acceso" method='POST' action='modulos/ControlAcceso.php'>
            <div class="form-group">
              <div class="form-label-group centrado">
                <h4>Programa Permanente de Capacitación a Distancia para Profesores de la FCA (PPCDP)</h4>
              </div>
            </div>
            <hr>
            <div class="form-group centrado">
              <label style="color: #545454;"><b>Inicio de sesión</b></label>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" name="strUsuario" id="strUsuario" class="form-control" placeholder="Usuario"
                  required="required" autofocus="autofocus">
                <label for="strUsuario"><i class="fas fa-user" style="color: #126E82"></i>&nbsp; Usuario</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" name="strContrasena" id="strContrasena" class="form-control"
                  placeholder="Contraseña" required="required">
                <label for="strContrasena"><i class="fas fa-key" style="color: #126E82"></i>&nbsp; Contraseña</label>
              </div>
            </div>
            <div class="form-group" style="text-align: center;">
              <input type="checkbox" id="ver1" class="ver" onChange="hideOrShowPassword()" />
              <label class="text" style="color:#126E82">&nbsp;Mostrar contraseña</label>
            </div>
            <button type="submit" class="btn btn-sy01 btn-block" id="btn-inicio">Ingresar</button>
          </form>
          <div class="col-12 text-center negritas">
            <?php //TODO: Hacer que funcione el olvidaste tu contraseña ?>
          <!--  <a class="d-block small" href="#" style="color:#DB9501">¿Olvidaste tu contraseña?</a> -->
            <a id="Auto-regstro-profesor"  onClick='FormularioAutoRegistro()' class="d-block small" href="#" style="color:#126E82" type="button" data-toggle="modal"
            data-target="#exampleModal" >Registrar Profesor</a>
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
            style="background: #132c33;color: #fff;padding: 10px">Registrar Profesor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
              <section id = "Auto-registro">
              </section>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-regresar" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary btn-aceptar" id = "btn-registrar-profesor">Registrar</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
