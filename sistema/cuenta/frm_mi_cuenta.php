<?php
  // Clases
include('../../clases/BD.php');
include('../../clases/Busqueda.php');
include('../../clases/Rol.php');
include('../../clases/Usuario.php');
include('../../clases/Persona.php');
include('../../clases/Administrador.php');
include('../../clases/Moderador.php');
include('../../clases/Profesor.php');

//*! Se inicializan variables para evitar el Notice en PHP en caso de afectar en algo eliminar
$usuario = new Usuario();
$usuario->pers_id_persona = null;
$usuario->rol_id_rol = null;
$usuario->prse_id_pregunta = null;
$usuario->usua_num_usuario = null;
$usuario->usua_contrasena = null;
$usuario->usua_respuesta = null;
$usuario->usua_activo = null;

$persona = new Persona();
$persona->pers_id_persona = null;
$persona->pers_nombre = null;
$persona->pers_apellido_materno = null;
$persona->pers_apellido_paterno = null;
$persona->pers_correo = null;
$persona->pers_telefono = null;

$profesor = null;
$profesor_coordinacion = null;
$moderador_dia = null;


// Catálogos
$obj_Busqueda = new Busqueda();
$obj_Profesor = new Profesor();
$arr_roles = $obj_Busqueda->selectRoles();
$arr_preguntas = $obj_Busqueda->selectPregunta();
$arr_dias = $obj_Busqueda->selectDias();
$arr_niveles = $obj_Busqueda->selectNiveles();
$arr_modalidades = $obj_Busqueda->selectModalidades();
$arr_coordinaciones = $obj_Busqueda->selectCoordinaciones();


// Validar entidad  //*? Se crean las variables para consultar en caso de no ser un nuevo registro.
if (isset($_POST['persona']) && isset($_POST['id'])) {
    // Recuperar información de consulta
    $obj_Persona = new Persona();
    $persona = $obj_Persona->buscarPersona($_POST['persona']);

    $obj_Usuario = new Usuario();
    $usuario = $obj_Usuario->buscarUsuario($_POST['id']);

    switch ($usuario->rol_id_rol) {
        case 1: //Administrador
            $obj_Administrador = new Administrador();
            $administrador = $obj_Administrador->buscarAdministrador($_POST['persona']);
            break;

        case 3: //Moderador
            $obj_Moderador = new Moderador();
            $moderador = $obj_Moderador->buscarModerador($_POST['persona']);
            $moderadorCuenta = $obj_Moderador -> buscarServidorSocial($_POST['persona']);
            
            //? Puede ser que no haya un servidor social
            if(!isset($moderadorCuenta)) {
              $profesor = $obj_Profesor -> buscarProfesor($_POST['persona']);
            }
            $moderador_dia = $obj_Moderador->buscarModeradorDias($_POST['persona']);
            break;
          // Case 2: Instructor
        case 2:
        case 4: //Profesor
            $profesor = $obj_Profesor->buscarProfesor($_POST['persona']);
            $profesor_nivel = $obj_Profesor->buscarProfesorNiveles($profesor->prof_id_profesor);
            $profesor_modalidad = $obj_Profesor->buscarProfesorModalidades($profesor->prof_id_profesor);
            $profesor_coordinacion = $obj_Profesor->buscarProfesorCoordinaciones($profesor->prof_id_profesor);
            break;
    }
}
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-usuario" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Mi cuenta</a>
        </li>
      </ol>
      <p>
        <hr>
      </p>

      <!-- Formulario -->
      <form name="form_usuario" id="form_usuario" method="POST">
          <!-- Datos generales -->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-card fa-lg"></i>
                <b>&nbsp;&nbsp;Datos generales</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <!-- Define los campos que estarán en una fila -->
                <div class="col-lg-4 form-group">
                  <label for="strUsuarioNombre" class = "negritas">Nombre(s): *</label>
                  <input readonly type="text" class="form-control" id="strUsuarioNombre" name="strUsuarioNombre"
                    value="<?php echo isset($persona) ? $persona->pers_nombre : ""; ?>">
                </div>
                <div class="col-lg-4 form-group">
                  <label for="strUsuarioPrimerApe" class = "negritas">Apellido Paterno: *</label>
                  <input readonly type="text" class="form-control" id="strUsuarioPrimerApe" name="strUsuarioPrimerApe"
                    value="<?php echo isset($persona) ? $persona->pers_apellido_paterno : ""; ?>">
                </div>
                <div class="col-lg-4 form-group">
                  <label for="strUsuarioSegundoApe" class = "negritas">Apellido Materno:</label>
                  <input readonly type="text" class="form-control" id="strUsuarioSegundoApe" name="strUsuarioSegundoApe"
                    value="<?php echo isset($persona) ? $persona->pers_apellido_materno : ""; ?>">
                </div>
              </div>

              <div class="col-lg-12 form-row">
                <div class="col-lg-6 form-group">
                  <label for="strUsuarioCorreo" class = "negritas">Correo electrónico: *</label>
                  <input readonly type="text" class="form-control" id="strUsuarioCorreo" name="strUsuarioCorreo"
                    placeholder="ej. ejemplo@dominio.com"
                    value="<?php echo isset($persona) ? $persona->pers_correo : ""; ?>">
                </div>
                <div class="col-lg-6 form-group">
                  <label for="strUsuarioTelefono" class = "negritas">Teléfono: *</label>
                  <input readonly type="text" class="form-control" id="strUsuarioTelefono" name="strUsuarioTelefono"
                    placeholder="ej. 5511223344" value="<?php echo isset($persona) ? $persona->pers_telefono : ""; ?>">
                </div>
              </div>
            </div>
          </div>

          <!-- Datos de cuenta según rol -->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-badge fa-lg"></i>
                <b>&nbsp;Datos de la cuenta</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if (isset($usuario) && isset($profesor) || $usuario->rol_id_rol == 1 || $usuario->rol_id_rol == 2 || $usuario->rol_id_rol == 4) { ?>
                  <div id="num_trabajador" class="col-lg-6 form-group">
                <?php } else { ?>
                  <div id="num_trabajador" class="col-lg-6 form-group" style="display: none;">
                <?php } ?>
                    <label for="num_trabajador" class = "negritas">Número de trabajador:*</label>
                    <input readonly value="<?php if (isset($administrador)) {
                                          echo($administrador-> prof_num_trabajador);
                                           } else {
                                               if (isset($profesor)) {
                                                     echo($profesor-> prof_num_trabajador);
                                               } else {
                                                   echo("");
                                               }
                                           } ?>" id="intNum_Trabajador" type="text" class="form-control" name="intNum_Trabajador">
                  </div>
                  <?php if (isset($usuario) && $usuario->rol_id_rol == 2 || $usuario->rol_id_rol == 1 || $usuario->rol_id_rol == 4) { ?>
                    <div id="rfc" class="col-lg-6 form-group">
                  <?php } else { ?>
                    <div id="rfc" class="col-lg-6 form-group" style="display: none;">
                  <?php } ?>
                    <label for="rfc" class = "negritas">RFC: *</label>
                    <input readonly value="<?php if (isset($administrador)) {
                                          echo($persona-> pers_rfc);
                                           } else {
                                               if (isset($profesor)) {
                                                     echo($persona-> pers_rfc);
                                               } else {
                                                   echo("");
                                               }
                                           }?>"  type="text"
                        class="form-control" name="strRFC" id="strRFC">
                    </div>
              </div> <!-- Cierre div de datos row -->

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if (isset($usuario) && isset($moderadorCuenta) && $usuario->rol_id_rol == 3) { ?>
                  <div id="numCuenta" class="col-lg-6 form-group">
                <?php } else { ?>
                  <div id="numCuenta" class="col-lg-6 form-group" style="display: none;">
                <?php } ?>
                    <label for="numCuenta" class = "negritas">Número de cuenta:*</label>
                      <input readonly value="<?php echo isset($moderadorCuenta) ? $moderadorCuenta-> seso_num_cuenta : "Trabajador";?>" type="text"
                        class="form-control" name="lbNumCuenta"  id="intNumCuenta" disabled>
                  </div>
                <?php if (isset($usuario) && $usuario->rol_id_rol == 3) { ?>
                  <div id="diasServicio" class="col-lg-6 form-group">
                <?php } else { ?>
                  <div id="diasServicio" class="col-lg-6 form-group" style="display: none;">
                <?php } ?>
                    <label for="diasServicio" class = "negritas">Dias del servicio:*</label><br>
                    <?php foreach ($arr_dias as $dia) { ?>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="strDiaServicio<?php echo ($dia['dia_id_dia']);?>" value="<?php echo ($dia['dia_id_dia']);?>" name="strDiaServicio<?php echo ($dia['dia_id_dia']);?>" 
                          <?php if (isset($moderador_dia) && is_array($moderador_dia) || is_object($moderador_dia)) {
                                foreach ($moderador_dia as $diaModerador) {
                                    if ($diaModerador['dia_id_dia'] == $dia['dia_id_dia']) {
                                        ?> checked<?php
                                    }
                                }
                          }?> disabled>
                        <label class="form-check-label" for="inlineCheckbox1"><?php echo ($dia['dia_nombre']);?></label>
                      </div>
                    <?php } ?>
              </div>  <!-- Cierre div de datos row -->

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if (isset($usuario) && $usuario->rol_id_rol == 3) { ?>
                  <div id="fechaInicio" class="col-lg-3 form-group">
                <?php } else { ?>
                  <div id="fechaInicio" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="fechaInicio" class = "negritas">Fecha de inicio del servicio: *</label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_fecha_inicio: ""; ?>" type="date" class="form-control" name="strFechaInicio" id="strFechaInicio" disabled>
                  </div>
                <?php if ($usuario->rol_id_rol == 3) { ?>
                  <div id="fechaFin" class="col-lg-3 form-group">
                <?php } else { ?>
                  <div id="fechaFin" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="fechaFin" class = "negritas">Fecha de fin del servicio:*</label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_fecha_fin: ""; ?>" type="date" class="form-control" name="strFechaFin" id="strFechaFin" disabled>
                  </div>
                <?php if ($usuario->rol_id_rol == 3) { ?>
                  <div id="horaInicio" class="col-lg-3 form-group">
                <?php } else { ?>
                  <div id="horaInicio" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="horaInicio" class = "negritas">Hora de inicio del servicio: *</label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_hora_inicio: ""; ?>" type="time" class="form-control" name="strHoraInicio" id="strHoraInicio" disabled>
                  </div>
                <?php if ($usuario->rol_id_rol == 3) { ?>
                  <div id="horaFin" class="col-lg-3 form-group">
                <?php } else { ?>
                  <div id="horaFin" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="horaFin" class = "negritas">Hora de fin del servicio: *</label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_hora_fin: ""; ?>" type="time" class="form-control" name="strHoraFin" id="strHoraFin" disabled> 
              </div>  <!-- Cierre div de datos row -->

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if ($usuario->rol_id_rol == 2) { ?>
                  <div id="semblanza" class="col-lg-12 form-group">
                <?php } else { ?>
                  <div id="semblanza" class="col-lg-12 form-group" style="display: none;">
                <?php } ?>
                  <label for="strSemblanza" class = "negritas">Semblanza:*</label>
                  <textarea readonly type="text" class="form-control" id="strSemblanza" name="strSemblanza"><?php echo isset($profesor) ? $profesor-> prof_semblanza: ""; ?></textarea>           
                  </div>
              </div> <!-- Cierre div de datos row -->

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if ($usuario->rol_id_rol == 2) { ?>
                  <div id="nivelImparticion" class="col-lg-6 form-group">
                <?php } else { ?>
                  <div id="nivelImparticion" class="col-lg-6 form-group" style="display: none;">
                <?php } ?>
                  <label for="nivelImparticion" class = "negritas">Nivel de impartición:*</label><br>
                    <?php foreach ($arr_niveles as $nivel) { ?>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="strNivel<?php echo ($nivel['nive_id_nivel']);?>" name="strNivel<?php echo ($nivel['nive_id_nivel']);?>"
                                value="<?php echo ($nivel['nive_id_nivel']);?>"
                          <?php if (isset($nivel) && isset($usuario) && is_array($profesor_coordinacion) || is_object($profesor_coordinacion)) {
                                foreach ($profesor_nivel as $nivelProfesor) {
                                    if ($nivelProfesor['nive_id_nivel'] == $nivel['nive_id_nivel']) { ?>
                                checked
                                    <?php }
                                }
                          }?>>
                        <label class="form-check-label" for="inlineCheckbox1"><?php echo ($nivel['nive_nombre']);?></label>
                      </div>
                    <?php } ?>
                  </div>
              <?php if ($usuario->rol_id_rol == 2) { ?>
                  <div id="modalidadImparticion" class="col-lg-6 form-group">
              <?php } else { ?>
                  <div id="modalidadImparticion" class="col-lg-6 form-group" style="display: none;">
              <?php } ?>
                  <label for="modalidadImparticion" class = "negritas">Modalidad en la que imparte clases : *</label><br>
                  <?php foreach ($arr_modalidades as $modalidad) { ?>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="strModalidad<?php echo ($modalidad['moda_id_modalidad']);?>" name="strModalidad<?php echo ($modalidad['moda_id_modalidad']);?>"
                                value="<?php echo ($modalidad['moda_id_modalidad']);?>"
                          <?php if (isset($modalidad) && isset($usuario) && is_array($profesor_coordinacion) || is_object($profesor_coordinacion)) {
                                foreach ($profesor_modalidad as $modalidadProfesor) {
                                    if ($modalidadProfesor['moda_id_modalidad'] == $modalidad['moda_id_modalidad']) { ?>
                                checked
                                    <?php }
                                }
                          }?>>
                        <label class="form-check-label" for="inlineCheckbox1"><?php echo ($modalidad['moda_nombre']);?></label>
                      </div>
                  <?php } ?>
                  </div>  <!-- Fin del campo-->
              </div> <!-- Fin del row-->

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if ($usuario->rol_id_rol == 2) { ?>
                  <div id="coordinaciones" class="col-lg-12 form-group">
                <?php } else { ?>
                  <div id="coordinaciones" class="col-lg-12 form-group" style="display: none;">
                <?php } ?>
                <label for="coordinaciones" class = "negritas">Coordinaciones a las que pertenece: *</label><br>
                <table> <?php //*? Esto lo creo para hacer columnas con los checkbox?>
                  <tr>
                    <td>
                      <?php foreach ($arr_coordinaciones as $coordinacion) { ?>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="strCoordinacion<?php echo ($coordinacion['coor_id_coordinacion']);?>" name="strCoordinacion<?php echo ($coordinacion['coor_id_coordinacion']);?>"
                                      value="<?php echo ($coordinacion['coor_id_coordinacion']);?>"
                                <?php //? Lo de is_array e is_object es para eliminar warnings
                                if (isset($coordinacion) && isset($usuario) && is_array($profesor_coordinacion) || is_object($profesor_coordinacion)) {
                                    foreach ($profesor_coordinacion as $coordinacionProfesor) {
                                        if ($coordinacionProfesor['coor_id_coordinacion'] == $coordinacion['coor_id_coordinacion']) { ?> 
                                      checked
                                        <?php }
                                    }
                                }?>>
                              <label class="form-check-label" for="inlineCheckbox1"><?php echo ($coordinacion['coor_nombre']);?></label> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                <?php //*? Esto lo creo para hacer dos columnas con las coordinaciones si se borra solo aparecen en una fila
                                  $tamano = sizeof($arr_coordinaciones);
                                  static $mostradas = 0;
                                if ($mostradas == 7) {
                                    echo("</td><td>");
                                    $mostradas = 0;
                                } else {
                                    $mostradas++;
                                }?>
                            </div>
                      <?php } ?>
                    </td>
                  </tr>
                </table>
              </div>  <!-- Fin del campo-->
            </div>  <!-- Fin del card-->
          </div> <!-- Este es cierra todo el grupo de Datos de cuenta -->


        <!-- Necesarios para actualizar -->
        <input type="hidden" name="dml" value="update">
        <input type="hidden" name="procedencia" value="mi_cuenta">
        <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $_POST['id']; ?>">
        <input type="hidden" id="idPersona" name="idPersona" value="<?php echo $persona->pers_id_persona; ?>">
        <input type="hidden" name="hideRol" id="hideRol" value="<?php echo $usuario->rol_id_rol; ?>">
      </form>
      <!-- Botones -->
      <div class="col-lg-12" style="text-align: center;">
        <button id="btn-regresar-usuario" type="button" class="btn btn-success btn-footer btn-regresar">Regresar</button>
        <button id="btn-actualizar-usuario-mi-cuenta" type="button" class="btn btn-success btn-footer btn-aceptar">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script src="../sistema/cuenta/control_cuenta.js"></script>
