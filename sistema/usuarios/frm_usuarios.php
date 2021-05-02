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
 
 
  
  // Catálogos
  $obj_Busqueda = new Busqueda();
  $arr_roles = $obj_Busqueda->selectRoles();
  $arr_preguntas = $obj_Busqueda->selectPregunta();
  $arr_dias = $obj_Busqueda->selectDias();
  
  // Validar entidad  //*? Se crean las variables para consultar en caso de no ser un nuevo registro.
  if (isset($_POST['persona']) && isset($_POST['id'])) { 

    // Recuperar información de consulta
    $obj_Persona = new Persona();
    $persona = $obj_Persona->buscarPersona($_POST['persona']);

    $obj_Usuario = new Usuario();
    $usuario = $obj_Usuario->buscarUsuario($_POST['id']);

    $obj_Rol = new Rol();
    $rol = $obj_Rol->rolUsuario($_POST['id']);

    switch ($usuario->rol_id_rol) {
      case 1: //Administrador
        $obj_Administrador = new Administrador();
        $administrador = $obj_Administrador->buscarAdministrador($_POST['persona']);
      break;

      case 2: //Moderador
        $obj_Moderador = new Moderador();
        $moderador = $obj_Moderador->buscarModerador($_POST['persona']);
        $moderador_dia = $obj_Moderador->buscarModeradorDias($moderador->mode_id_moderador);
      break;

      case 3: //Profesor
        $obj_Profesor = new Profesor();
        $profesor = $obj_Profesor->buscarProfesor($_POST['persona']);
      break;

    }
    

    
  }
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-usuario" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Usuarios</a>
        </li>
        <!-- Validación de la ruta -->
        <?php if (isset($_POST['CRUD'])) { ?>
          <?php if ($_POST['CRUD'] == 1) { ?>
            <li class="breadcrumb-item active"><i class="fas fa-edit"></i>&nbsp; Actualizar registro</li>
          <?php } elseif ($_POST['CRUD'] == 0) { ?>
            <li class="breadcrumb-item active"><i class="fas fa-search-plus"></i>&nbsp; Consultar registro</li>
          <?php } ?>
        <?php } else { ?>
          <li class="breadcrumb-item active"><i class="fas fa-folder-plus"></i>&nbsp; Nuevo registro</li>
        <?php } ?>
      </ol>
      <p>
        <hr>
      </p>

      <!-- Formulario -->
      <form name="form_usuario" id="form_usuario" method="POST">

        <!-- Desactivar formulario INICIO en caso de no ser un registro--> 
        <?php if (isset($_POST['CRUD'])) { ?>
          <?php if ($_POST['CRUD'] == 0) { ?>
            <fieldset disable>
          <?php } ?>
        <?php } ?>

          
          <!-- Datos generales -->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-card fa-lg"></i>
                <b>&nbsp;&nbsp;Datos generales</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;"> <!-- Define los campos que estaran en una fila -->
                <div class="col-lg-4 form-group">
                  <label
                    for="strUsuarioNombre"><b>Nombre(s):<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <input type="text" class="form-control" id="strUsuarioNombre" name="strUsuarioNombre"
                    value="<?php echo isset($persona) ? $persona->pers_nombre : ""; ?>">
                </div>
                <div class="col-lg-4 form-group">
                  <label for="strUsuarioPrimerApe"><b>Apellido Paterno:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <input type="text" class="form-control" id="strUsuarioPrimerApe" name="strUsuarioPrimerApe"
                    value="<?php echo isset($persona) ? $persona->pers_apellido_paterno : ""; ?>">
                </div>
                <div class="col-lg-4 form-group">
                  <label for="strUsuarioSegundoApe"><b>Apellido Materno:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <input type="text" class="form-control" id="strUsuarioSegundoApe" name="strUsuarioSegundoApe"
                    value="<?php echo isset($persona) ? $persona->pers_apellido_materno : ""; ?>">
                </div>
              </div>

              <div class="col-lg-12 form-row">
                <div class="col-lg-6 form-group">
                  <label for="strUsuarioCorreo"><b>Correo
                      electrónico:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <input type="text" class="form-control" id="strUsuarioCorreo" name="strUsuarioCorreo"
                    placeholder="ej. ejemplo@dominio.com" value="<?php echo isset($persona) ? $persona->pers_correo : ""; ?>">
                </div>
                <div class="col-lg-6 form-group">
                  <label
                    for="strUsuarioTelefono"><b>Teléfono:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <input type="text" class="form-control" id="strUsuarioTelefono" name="strUsuarioTelefono"
                    placeholder="ej. 5511223344" value="<?php echo isset($persona) ? $persona->pers_telefono : ""; ?>">
                </div>
              </div>
            </div>
          </div>

          <!-- Datos de la usuario -->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-badge fa-lg"></i>
                <b>&nbsp;Datos de usaurio</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-6 form-group">
                  <label for="strNombreUsuario"><b>Nombre de usuario:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <input type="text" class="form-control" id="strNombreUsuario" name="strNombreUsuario"
                    value="<?php echo isset($usuario) ? $usuario->usua_num_usuario : ""; ?>">
                </div>
                <div class="col-lg-6 form-group">
                  <label
                    for="lbintUsuarioRol"><b>Rol:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <select required='required' class="custom-select" id="intUsuarioRol" name="intUsuarioRol">
                    <option value="0">Seleccionar rol</option>
                    <?php foreach ($arr_roles as $rol) { ?>
                      <option value="<?php echo $rol['rol_id_rol']; ?>"
                        <?php if(isset($usuario)) { if ($usuario->rol_id_rol == $rol['rol_id_rol']) { ?> selected
                        <?php } }?>>
                        <?php echo $rol['rol_nombre']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Datos de cuenta segun rol -->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-badge fa-lg"></i>
                <b>&nbsp;Datos de la cuenta</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if (isset($usuario) && $usuario->rol_id_rol == 1 || $usuario->rol_id_rol == 3) { ?>
                  <div id="num_trabajador" class="col-lg-6 form-group">
                <?php }  else { ?>
                  <div id="num_trabajador" class="col-lg-6 form-group" style="display: none;">
                <?php } ?>
                    <label for="num_trabajador"><b>Número de trabajador:*</b></label>
                    <input value="<?php if (isset($administrador)) { 
                                          echo($administrador-> admi_num_trabajador);
                                        } else {
                                          if(isset($profesor)){ 
                                            echo($profesor-> prof_num_trabajador);
                                          } else {
                                            echo("");
                                          }
                                        } ?>" type="text" class="form-control" name="lbNum_trabajador">
                  </div> 
                  <?php if (isset($usuario) && $usuario->rol_id_rol == 1 || $usuario->rol_id_rol == 3) { ?>
                    <div id="rfc" class="col-lg-6 form-group">
                  <?php }  else { ?>
                    <div id="rfc" class="col-lg-6 form-group" style="display: none;">
                  <?php } ?>
                    <label for="rfc"><b>RFC: *</b></label>
                    <input value="<?php if (isset($administrador)) { 
                                          echo($administrador-> admi_rfc);
                                        } else {
                                          if(isset($profesor)){ 
                                            echo($profesor-> prof_rfc);
                                          } else {
                                            echo("");
                                          }
                                        }?>"  type="text"
                        class="form-control" name="lbRfc">
                    </div>
              </div> <!-- Cierre div de datos row -->
              
              <div class="col-lg-12 form-row" style="margin-top: 15px;"> 
                <?php if (isset($usuario) && $usuario->rol_id_rol == 2) { ?>
                  <div id="numCuenta" class="col-lg-6 form-group">
                <?php }  else { ?>
                  <div id="numCuenta" class="col-lg-6 form-group" style="display: none;">
                <?php } ?>
                    <label for="numCuenta"><b>Número de cuenta:*</b></label>
                      <input value="<?php echo isset($moderador) ? $moderador-> mode_num_cuenta : ""; ?>" type="text" 
                        class="form-control" name="lbNumCuenta">
                  </div> 
                <?php if (isset($usuario) && $usuario->rol_id_rol == 2) { ?>
                  <div id="diasServicio" class="col-lg-6 form-group">
                <?php }  else { ?>
                  <div id="diasServicio" class="col-lg-6 form-group" style="display: none;">
                <?php } ?>
                    <label for="diasServicio"><b>Dias del servicio:*</b></label><br>
                    <?php foreach ($arr_dias as $dia) { ?>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="ilc1" value="<?php echo ($dia['dia_id_dia']);?>" 
                          <?php if(isset($moderador_dia)) { 
                            foreach ($moderador_dia as $diaModerador) {
                              if ($diaModerador['dia_id_dia'] == $dia['dia_id_dia']) { ?> 
                                checked 
                              <?php } 
                            }
                          }?>>
                        <label class="form-check-label" for="inlineCheckbox1"><?php echo ($dia['dia_nombre']);?></label>
                      </div>
                    <?php } ?>
              </div>  <!-- Cierre div de datos row -->

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if (isset($usuario) && $usuario->rol_id_rol == 2) { ?>
                  <div id="fechaInicio" class="col-lg-3 form-group">
                <?php }  else { ?>
                  <div id="fechaInicio" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="fechaInicio"><b>Fecha de inicio del servicio: *</b></label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_fecha_inicio: ""; ?>" type="text" class="form-control" name="lbFechaInicio">
                  </div>
                <?php if ($usuario->rol_id_rol == 2) { ?>
                  <div id="fechaFin" class="col-lg-3 form-group">
                <?php }  else { ?>
                  <div id="fechaFin" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="fechaFin"><b>Fecha de fin del servicio:*</b></label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_fecha_fin: ""; ?>" type="text" class="form-control" name="lbFechaFin">
                  </div>
                <?php if ($usuario->rol_id_rol == 2) { ?>
                  <div id="horaInicio" class="col-lg-3 form-group">
                <?php }  else { ?>
                  <div id="horaInicio" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="horaInicio"><b>Hora de inicio del servicio: *</b></label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_hora_inicio: ""; ?>" type="text" class="form-control" name="lbHoraFin">
                  </div>
                <?php if ($usuario->rol_id_rol == 2) { ?>
                  <div id="horaInicio" class="col-lg-3 form-group">
                <?php }  else { ?>
                  <div id="horaInicio" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="horaInicio"><b>Hora de fin del servicio: *</b></label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_hora_fin: ""; ?>" type="text" class="form-control" name="lbHoraFin">
                  </div>
              </div>  <!-- Cierre div de datos row -->
              
              <div class="col-lg-12 form-row" style="margin-top: 15px;">  
                <?php if ($usuario->rol_id_rol == 3) { ?>
                  <div id="semblanza" class="col-lg-12 form-group">
                <?php }  else { ?>
                  <div id="semblanza" class="col-lg-12 form-group" style="display: none;">
                <?php } ?>
                  <label for="strSemblanza"><b>Semblanza:*</b></label>
                  <textarea type="text" class="form-control" id="strSemblanza" name="strReqTec"><?php echo isset($profesor) ? $profesor-> prof_semblanza: ""; ?></textarea>
              
              
              </div> <!-- Cierre div de datos row -->

          </div>  <!-- Este es cierra todo el grupo de Datos de cuenata -->                              

                                                  <?php if ($usuario->rol_id_rol == 2) { ?>
                                                  <div id="nivelImparticion" class="col-lg-6 form-group">
                                                    <?php }  else { ?>
                                                    <div id="nivelImparticion" class="col-lg-6 form-group"
                                                      style="display: none;">
                                                      <?php } ?>

                                                      <div id="nivelImparticion" class="col-lg-6 form-group"
                                                        style="display: none;">
                                                        <label for="nivelImparticion"><b>Nivel en el que
                                                            impartirá clases : *</b></label>
                                                        <select class="custom-select" id="slcNivelImparticion"
                                                          name="NivelImparticion">

                                                          <option value="lic">Licenciatura</option>
                                                          <option value="postg">Postgrado</option>
                                                        </select>

                                                        <?php if ($usuario->rol_id_rol == 2) { ?>
                                                        <div id="modalidadImparticion" class="col-lg-6 form-group">
                                                          <?php }  else { ?>
                                                          <div id="modalidadImparticion" class="col-lg-6 form-group"
                                                            style="display: none;">
                                                            <?php } ?>

                                                            <div id="modalidadImparticion" class="col-lg-6 form-group"
                                                              style="display: none;">
                                                              <label for="modalidadImparticion"><b>Modalidad en la
                                                                  que imparte clases : *</b></label>
                                                              <select class="custom-select" id="slcModalidadImparticion"
                                                                name="ModalidadImparticion">

                                                                <option value="presencial">Presencial</option>
                                                                <option value="enLinea">En línea</option>
                                                              </select>
                                                            </div>


                                                            <?php if ($usuario->rol_id_rol == 2) { ?>
                                                            <div id="coordinaciones" class="col-lg-6 form-group">
                                                              <?php }  else { ?>
                                                              <div id="coordinaciones" class="col-lg-6 form-group"
                                                                style="display: none;">
                                                                <?php } ?>

                                                                <div id="coordinaciones" class="col-lg-6 form-group"
                                                                  style="display: none;">
                                                                  <label for="coordinaciones"><b>Coordinaciones a las
                                                                      que pertenece: *</b></label>
                                                                  <select class="custom-select"
                                                                    id="slcModalidadImparticion"
                                                                    name="ModalidadImparticion">
                                                                    <!-- Todo: Adaptar este campo para que busque en la base -->
                                                                    <?php foreach ($arr_preguntas as $pregunta) { ?>
                                                                    <option
                                                                      value="<?php echo $pregunta['preg_id_preg']; ?>">
                                                                      <?php echo $pregunta['preg_nombre']; ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                    <option value="Fiscal">Opción Alternativa</option>
                                                                  </select>
                                                                </div>


                                                              </div>
                                                              <div class="col-lg-12 form-row">
                                                                <div class="col-lg-6 form-group">
                                                                  <label for="UsuarioPregunta"><b>Pregunta de
                                                                      seguridad:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                                                                  <select class="custom-select" id="UsuarioPregunta"
                                                                    name="UsuarioPregunta">
                                                                    <option value="0">Seleccione una pregunta</option>
                                                                    <?php foreach ($arr_preguntas as $pregunta) { ?>
                                                                    <option
                                                                      value="<?php echo $pregunta['prse_id_pregunta']; ?>"
                                                                      <?php if(isset($usuario)) { if ($usuario->prse_id_pregunta == $pregunta['prse_id_pregunta']) { ?>
                                                                      selected <?php } }?>>
                                                                      <?php echo $pregunta['prse_pregunta']; ?>
                                                                    </option>
                                                                    <?php } ?>
                                                                  </select>
                                                                </div>
                                                                <div class="col-lg-6 form-group">
                                                                  <label
                                                                    for="UsuarioRespuesta"><b><?php if (isset($_POST['CRUD']) == false) { echo "Proporcione la respuesta: *"; } else { echo "Respuesta";}?></b></label>
                                                                  <input type="text" class="form-control"
                                                                    id="UsuarioRespuesta" name="UsuarioRespuesta"
                                                                    <?php if (isset($_POST['CRUD']) == false){echo('placeholder=""');} else {echo('value= "' . $usuario->usua_respuesta . '"');} ?>>
                                                                </div>
                                                              </div>
                                                              <div class="col-lg-12 form-row">
                                                                <div class="col-lg-6 form-group">
                                                                  <label
                                                                    for="strContrasenia01"><b><?php if (isset($_POST['CRUD']) == false)  {echo "Ingrese contraseña:*";} else {echo "Contraseña: ";} ?></b></label>
                                                                  <input type="password" class="form-control"
                                                                    id="strContrasenia01" name="strContrasenia01"
                                                                    <?php if (isset($_POST['CRUD']) == false){echo('placeholder=""');} else {echo('value= "' . $usuario->usua_contrasena . '"');} ?>>
                                                                  <div style="text-align: center; margin-top:5px">
                                                                    <input type="checkbox" id="ver1" class="ver"
                                                                      onChange="hideOrShowPassword1()" />
                                                                    <label class="text" style="color:#0C4590"><i
                                                                        class="fas fa-eye"></i>&nbsp; Mostrar
                                                                      contraseña</label>
                                                                  </div>
                                                                </div>
                                                              </div>

                                                              <?php if (isset($_POST['CRUD']) == false) { ?>
                                                              <div class="col-lg-6 form-group">
                                                                <label for="strContrasenia02"><b>Confirme la
                                                                    contraseña: *</b></label>
                                                                <input type="password" class="form-control"
                                                                  id="strContrasenia02" name="strContrasenia02"
                                                                  placeholder="Contraseña">
                                                                <div style="text-align: center; margin-top:5px">
                                                                  <input type="checkbox" id="ver2" class="ver"
                                                                    onChange="hideOrShowPassword2()" />
                                                                  <label class="text" style="color:#0C4590"><i
                                                                      class="fas fa-eye"></i>&nbsp; Mostrar
                                                                    contraseña</label>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <?php } ?>
                                                          </div>
                                                        </div>

                                                        <!-- ID e Instrucciones -->
                                                        <?php if (isset($_POST['CRUD'])) { ?>
                                                        <?php if ($_POST['CRUD'] == 1) { ?>
                                                        <input type="hidden" name="dml" value="update" />
                                                        <input type="hidden" id="idUsuario" name="idUsuario"
                                                          value="<?php echo $_POST['id']; ?>">
                                                        <input type="hidden" id="idPersona" name="idPersona"
                                                          value="<?php echo $persona->pers_id_pers; ?>">
                                                        <?php } elseif ($_POST['CRUD'] == 0) { ?>
                                                        <input type="hidden" name="dml" value="select" />
                                                        <?php } ?>
                                                        <?php } else { ?>
                                                        <input type="hidden" name="dml" value="insert" />
                                                        <?php } ?>

                                                        <!-- Desactivar formulario FIN -->
                                                        <?php if (isset($_POST['CRUD'])) { ?>
                                                        <?php if ($_POST['CRUD'] == 0) { ?>
        </fieldset>
        <?php } ?>
        <?php } ?>

      </form>

      <!-- Botones -->
      <div class="col-lg-12" style="text-align: center;">
        <button id="btn-regresar-usuario" type="button" class="btn btn-success btn-footer">Regresar</button>
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 1) { ?>
        <button id="btn-actualizar-usuario" type="button" class="btn btn-success btn-footer">Actualizar</button>
        <?php } ?>
        <?php } else { ?>
        <button id="btn-registrar-usuario" type="button" class="btn btn-success btn-footer">Guardar</button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<script src="../sistema/usuarios/control_usuario.js"></script>