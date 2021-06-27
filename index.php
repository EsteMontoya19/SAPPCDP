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

<?php
// Clases
include('clases/BD.php');
include('clases/Busqueda.php');

// Catálogos
$obj_Busqueda = new Busqueda();
$arr_coordinaciones = $obj_Busqueda->selectCoordinaciones();
$arr_niveles = $obj_Busqueda->selectNiveles();
$arr_modalidades = $obj_Busqueda->selectModalidades();
$arr_preguntas = $obj_Busqueda->selectPregunta();
?>


<body style="background:#DB9501">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header bg-blue">
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
          <div class="col-12 text-center negritas">
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
            style="background: #5d2860;color: #fff;padding: 10px">Registrar Profesor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
              
              <!-- Formulario Auto-registro de profeosres -->
                <form name="form_usuario" id="form_usuario" method="POST">
                  <input type="hidden" name="dml" id="dml" value="insert">
                  <input type="hidden" name="intUsuarioRol" id="intUsuarioRol" value="3">

                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Nombre(s): *</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" id="strUsuarioNombre" name = "strUsuarioNombre" placeholder = "Juan">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Apellido Paterno: *</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" id="strUsuarioPrimerApe" name = "strUsuarioPrimerApe" placeholder = "Ramos">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Apellido Materno: </label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" id="strUsuarioSegundoApe" name = "strUsuarioSegundoApe" placeholder = "Ramos">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Correo Electrónico: *</label>
                    <div class="col-sm-12">
                      <input type="email" class="form-control" id="strUsuarioCorreo" name = "strUsuarioCorreo" placeholder = "ejemplo@gmail.com">
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Número de Teléfono: *</label>
                    <div class="col-sm-12">
                      <input type="email" class="form-control" id="strUsuarioTelefono" name = "strUsuarioTelefono" placeholder = "1234567890">
                    </div>
                  </div>

                  <h5 class="modal-title col-lg-12 negritas" id="exampleModalLabel"
                    style="background: #5d2860;color: #fff;padding: 10px">Datos de profesor</h5>

                  <div class="form-group row">
                    <label for="numTrab" class="col-sm-6 col-form-label">Número trabajador: *</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" name= "intNum_Trabajador" id="intNum_Trabajador" placeholder = "123456">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">RFC con Homoclave: *</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" id="strRFC" name = "strRFC" placeholder = "NNNN000000XXX">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Semblanza: *</label>
                    <div class="col-sm-12">
                      <textarea type="text" class="form-control" id="strSemblanza" name="strSemblanza" placeholder = "Descripción del profesor"></textarea>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="strNivel" class="col-sm-6 col-form-label">Niveles en que imparte clases *:</label>
                    <div class="col-sm-12" style="padding-left: 40px">
                      <?php foreach ($arr_niveles as $nivel) { ?>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="strNivel<?php echo ($nivel['nive_id_nivel']);?>" name="strNivel<?php echo ($nivel['nive_id_nivel']);?>"
                                  value="<?php echo ($nivel['nive_id_nivel']);?>">
                          <label class="form-check-label" for="inlineCheckbox1"><?php echo ($nivel['nive_nombre']);?></label>
                        </div>
                      <?php } ?>
                    </div>
                  </div>


                  <div class="form-group row">
                  <label for="modalidadImparticion" class="col-sm-6 col-form-label"><b>Modalidad en la que imparte clases : * </b></label>
                    <div class="col-sm-12" style="padding-left: 40px">
                      <?php foreach ($arr_modalidades as $modalidad) { ?>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="strModalidad<?php echo ($modalidad['moda_id_modalidad']);?>" name="strModalidad<?php echo ($modalidad['moda_id_modalidad']);?>"
                                  value="<?php echo ($modalidad['moda_id_modalidad']);?>">
                          <label class="form-check-label" for="inlineCheckbox1"><?php echo ($modalidad['moda_nombre']);?></label>
                        </div>
                      <?php } ?> 
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="strCoordinacion" class="col-sm-6 col-form-label"><b>Coordinaciones a las que pertenece: *</b></label>
                    <div class="col-sm-12">
                      <table> <?php //*? Esto lo creo para hacer columnas con los checkbox?>
                        <tr>
                          <td>               
                            <?php foreach ($arr_coordinaciones as $coordinacion) { ?> 
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="strCoordinacion<?php echo ($coordinacion['coor_id_coordinacion']);?>" name="strCoordinacion<?php echo ($coordinacion['coor_id_coordinacion']);?>"
                                            value="<?php echo ($coordinacion['coor_id_coordinacion']);?>">
                                    <label class="form-check-label" for="inlineCheckbox1"><?php echo ($coordinacion['coor_nombre']);?></label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                      <?php //*? Esto lo creo para hacer dos columnas con las coordinaciones si se borra solo aparecen en una fila
                                        $tamano = sizeof($arr_coordinaciones);
                                        static $mostradas = 0;
                                        if ($mostradas == 12 ){
                                          echo("</td><td>"); 
                                          $mostradas = 0;
                                        } else {
                                          $mostradas++;
                                        }
                                        
                                      ?>
                                  </div>
                            <?php } ?>
                          </td>
                        </tr>         
                      </table>
  	                </div>
                  </div>

                  <h5 class="modal-title negritas" id="exampleModalLabel" style="background: #5d2860;color: #fff;padding: 10px">
                    Datos de Recuperación</h5>


                  <div class="form-group row">
                    <label for="strNombreUsuario" class="col-sm-6 col-form-label">Nombre de usuario *:</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" id="strNombreUsuario" name="strNombreUsuario" placeholder = "Usuario">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="strContrasenia01" class="col-sm-6 col-form-label">Contraseña</label>
                    <div class="col-sm-12">
                      <input type="password" class="form-control" id="strContrasenia01" name = "strContrasenia01">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Confirmar contraseña</label>
                    <div class="col-sm-12">
                      <input type="password" class="form-control" id="strContrasenia02" name= "strContrasenia02">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Pregunta secreta</label>
                    <div class="col-sm-12">
                      <select class="custom-select" id="UsuarioPregunta"name="UsuarioPregunta">
                      <option value="0">Seleccione una pregunta</option>
                      <?php foreach ($arr_preguntas as $pregunta) { if ($pregunta['prse_activo'] == 't') { ?>
                        <option value="<?php echo $pregunta['prse_id_pregunta']; ?>">
                          <?php echo $pregunta['prse_pregunta']; ?>
                        </option>
                      <?php } }?>
                    </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="rfc" class="col-sm-6 col-form-label">Respuesta</label>
                    <div class="col-sm-12">
                      <input type="text" class="form-control" id="UsuarioRespuesta" name = "UsuarioRespuesta">
                    </div>
                  </div>                    
                </form>
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

  <script src="sistema/usuarios/control_usuario.js"></script>

</body>

</html>