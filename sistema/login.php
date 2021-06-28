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
    <link href="../recursos/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Icono de la pestaña -->
    <link rel="../recursos/shortcut icon" href="../recursos/favicon.ico"/>

    <!-- Alertify -->
    <link rel="stylesheet" type="text/css" href="../recursos/alertify/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="../recursos/alertify/css/alertify.rtl.css">
    <link rel="stylesheet" type="text/css" href="../recursos/alertify/css/themes/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../recursos/alertify/css/themes/bootstrap.rtl.css">

    <!-- Bootstrap 4 -->
    <link href="../recursos/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../recursos/css/bootstrap.css.map" rel="stylesheet" type="text/css">
    <link href="../recursos/css/sb-admin.css" rel="stylesheet" type="text/css">
    <link href="../recursos/css/sicenapyme.css" rel="stylesheet" type="text/css">

    <!-- JQuery -->
    <script src="../recursos/js/jquery-3.4.1.js"></script>

    <!-- DropItemps -->
    <script src="../recursos/js/bootstrap.bundle.js"></script>

    <!-- Alertify -->
    <script src="../recursos/alertify/alertify.js"></script>

    <!-- Direcciones del sistema-->
    <script src="../sistema/recursos/body.js"></script>

  </head>

  <body style="background:#272A5C">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header bg-banner-loggin">
          <b style="color: white">&nbsp; Administración</b>
        </div>
        <div class="card-body">
          <div class="col-lg-12 form-row" style="margin-top: 10px;">
            <form name="frm_acceso" method='POST' action='../modulos/ControlAcceso.php'>
              <div class="form-group">
                <div class="form-label-group" align="center">
                  <h4>Programa Permanente de Capacitación a Distancia para Profesores de la FCA(PPCDP)</h4>
                </div>
              </div>
              <hr>
              <div class="form-group" align="center">
                <label style="color: #545454;"><b>Inicio de sesión</b></label>
              </div>
              <?php
                if (count($arr_Mensaje) > 0) {
                  $arr_Campos = array_keys($arr_Mensaje);
                  foreach ($arr_Campos as $campo) {
              ?>
                <div class="col-12 alert alert-danger text-center" role="alert">
                  <b>Error:</b> <?php print_r($arr_Mensaje[$campo]); ?>
                </div>
                <br>
              <?php
                  }
                }
              ?>
              <div class="form-group">
                <div class="form-label-group">
                  <input type="text" name="strUsuario" id="strUsuario" class="form-control" placeholder="Usuario" required="required" autofocus="autofocus">
                  <label for="strUsuario"><i class="fas fa-user" style="color: orange"></i>&nbsp; Usuario</label>
                </div>
              </div>
              <div class="form-group">
                <div class="form-label-group">
                  <input type="password" name="strContrasena" id="strContrasena" class="form-control" placeholder="Contraseña" required="required">
                  <label for="strContrasena"><i class="fas fa-key" style="color: orange"></i>&nbsp; Contraseña</label>
                </div>
              </div>
              <div class="form-group" style="text-align: center;">
                <input type="checkbox" id="ver1" class="ver" onChange="hideOrShowPassword()" />
                <label class="text" style="color:#0C4590">&nbsp;Mostrar contraseña</label>
              </div>
              <button type="submit" class="btn btn-sy01 btn-block" id="btn-inicio">Ingresar</button>
            </form>
            <div class="col-12 text-center">
              <br>
              <?php //TODO: Hacer que funcione el olvidaste tu contraseña ?>
              <!-- <a class="d-block small" href="#">¿Olvidaste tu contraseña?</a>  -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>