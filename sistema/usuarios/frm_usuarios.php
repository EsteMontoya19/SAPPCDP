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

  $usuario = null;
  
  $persona = new Persona();
  $persona->pers_id_persona = null;
  $persona->pers_nombre = null;
  $persona->pers_apellido_materno = null;
  $persona->pers_apellido_paterno = null;
  $persona->pers_correo = null;
  $persona->pers_telefono = null;
  $persona = null;

  $profesor = null;
  $profesor_coordinacion = null;

  $moderador_dia = null;

  
  
  // Catálogos
  $obj_Busqueda = new Busqueda();
  $arr_roles = $obj_Busqueda->selectRoles();
  $arr_preguntas = $obj_Busqueda->selectPregunta();
  $arr_dias = $obj_Busqueda->selectDias();
  $arr_niveles = $obj_Busqueda->selectNiveles();
  $arr_modalidades = $obj_Busqueda->selectModalidades();
  $arr_coordinaciones = $obj_Busqueda->selectCoordinaciones();
  $arr_nombramientos = $obj_Busqueda->selectNombramientos();

  // Constantes de roles
  define("ADMINISTRADOR", 1);
  define("INSTRUCTOR", 2);
  define("MODERADOR", 3);
  define("PROFESOR", 4);
  
  // Validar entidad  //*? Se crean las variables para consultar en caso de no ser un nuevo registro.
if (isset($_POST['persona']) && isset($_POST['id'])) {
    // Recuperar información de consulta
    $obj_Persona = new Persona();
    $persona = $obj_Persona->buscarPersona($_POST['persona']);

    $obj_Usuario = new Usuario();
    $usuario = $obj_Usuario->buscarUsuario($_POST['id']);
    $obj_Profesor = new Profesor();
    $obj_Moderador = new Moderador();

    switch ($usuario->rol_id_rol) {
        case ADMINISTRADOR: //Administrador
        case INSTRUCTOR: //Instructor
        case PROFESOR: //Profesor
            $profesor = $obj_Profesor->buscarProfesor($_POST['persona']);
            $profesor_nivel = $obj_Profesor->buscarProfesorNiveles($profesor->prof_id_profesor);
            $profesor_modalidad = $obj_Profesor->buscarProfesorModalidades($profesor->prof_id_profesor);
            $profesor_coordinacion = $obj_Profesor->buscarProfesorCoordinaciones($profesor->prof_id_profesor);
            ?>
            <?php
            break;
      
        case MODERADOR: //Moderador
          //? Si tienen más de un rol no tienen datos de Servidor_Social, sino de profesor
          //? Este If valida eso y asigna las variables correspondientes
            if ($obj_Moderador->buscarServidorSocial($_POST['persona'])) {
                $servidorSocial = $obj_Moderador->buscarServidorSocial($_POST['persona']);
            } else {
                $profesor = $profesor = $obj_Profesor->buscarProfesor($_POST['persona']);
            }
            $moderador = $obj_Moderador->buscarModerador($_POST['persona']);
            $moderador_dia = $obj_Moderador->buscarModeradorDias($_POST['persona']);
            break;

      //? Por los cambios del usuario ahora el Administrador tiene los mismos datos que un profesor
      // case 1: //Administrador
      //   $obj_Administrador = new Administrador();
      //   $administrador = $obj_Administrador->buscarAdministrador($_POST['persona']);
      // break;
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
        <!-- Validación de la ruta (cinta de la pantalla) -->
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
      <input type="hidden" name="numCoordinaciones" id="numCoordinaciones" value=<?php echo(sizeof($arr_coordinaciones)); ?>>
        <!-- Desactivar formulario INICIO en caso de no ser un registro-->
        <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 0) { ?>
            <fieldset disabled>
            <?php } ?>
        <?php } ?>


          <!-- Datos generales -->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header negritas">
                <i class="fas fa-id-card fa-lg"></i>
                &nbsp;&nbsp;Datos generales
              </div>

              <div class="col-lg-12 form-row">
                <div id="numCuenta" class="col-lg-6 form-group">
                <?php
                 //? Si es un servidor socila debe aparecer número de cuenta, sino es el de trabajador
                if (isset($usuario) && $usuario->rol_id_rol == MODERADOR) {
                    if (isset($servidorSocial)) { ?>
                        <label for="numCuenta" class = "negritas">Número de cuenta:*</label>
                        <input value="<?php echo isset($servidorSocial) ? $servidorSocial-> seso_num_cuenta : ""; ?>" type="text" 
                          class="form-control" name="intNumCuenta"  id="intNumCuenta">
                    <?php } else { ?>
                        <label for="intNum_Trabajador" class = "negritas">Número de trabajador:*</label>
                        <input value="<?php echo isset($profesor) ? $profesor-> prof_num_trabajador : ""; ?>" type="text" 
                        class="form-control" name="intNum_Trabajador"  id="intNum_Trabajador">
                    <?php }
                } else {?>
                      <label for="intNum_Trabajador" class = "negritas">Número de trabajador:*</label>
                      <input value="<?php echo isset($profesor) ? $profesor-> prof_num_trabajador : "" ; ?>" type="text" 
                        class="form-control" name="intNum_Trabajador"  id="intNum_Trabajador" 
                        <?php //? Evita al Coordinador escribir el Numero de trabajador cuando se crea un Profesor
                        if (!isset($_POST['CRUD'])) {
                            echo (' onblur="buscarProfesor()" ');
                        }
                        ?> >
                <?php } ?>
                  </div> 

                <?php //? Si es Administrador, Profesor o Instructor?>
                  <div id="rfc" class="col-lg-6 form-group">
                  <label for="rfc" class = "negritas">RFC: *</label>
                  <input value="<?php   if (isset($persona)) {
                                          echo($persona-> pers_rfc);
                                        } else {
                                          echo("");
                                        }?>"  type="text" class="form-control" name="strRFC" id="strRFC"
                      <?php //? Evita al Coordinador escribir el Numero de trabajador cuando se crea un Profesor
                        if (!isset($_POST['CRUD'])) {
                            echo (' onkeyup = "AsignarContrasena();" ');
                        }
                        ?> >
                  </div>
              </div>

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <!-- Define los campos que estarán en una fila -->
                <div class="col-lg-4 form-group">
                  <label for="strUsuarioNombre" class = "negritas">Nombre(s):<?php if (isset($_POST['CRUD']) == false) {
                        echo "*";
                                                                             } ?></label>
                  <input type="text" class="form-control" id="strUsuarioNombre" name="strUsuarioNombre"
                    value="<?php echo isset($persona) ? $persona->pers_nombre : ""; ?>">
                </div>
                <div class="col-lg-4 form-group">
                  <label for="strUsuarioPrimerApe" class = "negritas">Apellido
                      Paterno:<?php if (isset($_POST['CRUD']) == false) {
                            echo "*";
                              } ?></label>
                  <input type="text" class="form-control" id="strUsuarioPrimerApe" name="strUsuarioPrimerApe"
                    value="<?php echo isset($persona) ? $persona->pers_apellido_paterno : ""; ?>">
                </div>
                <div class="col-lg-4 form-group">
                  <label for="strUsuarioSegundoApe" class = "negritas">Apellido Materno:</label>
                  <input type="text" class="form-control" id="strUsuarioSegundoApe" name="strUsuarioSegundoApe"
                    value="<?php echo isset($persona) ? $persona->pers_apellido_materno : ""; ?>">
                </div>
              </div>

              <div class="col-lg-12 form-row">
                <div class="col-lg-4 form-group">
                  <label for="strUsuarioCorreo" class = "negritas">Correo
                      electrónico:<?php if (isset($_POST['CRUD']) == false) {
                            echo "*";
                                  } ?></label>
                  <input type="text" class="form-control" id="strUsuarioCorreo" name="strUsuarioCorreo"
                    placeholder="ej. ejemplo@dominio.com"
                    value="<?php echo isset($persona) ? $persona->pers_correo : ""; ?>">
                </div>
                <div class="col-lg-4 form-group">
                  <label
                    for="strUsuarioTelefono" class = "negritas">Teléfono:<?php if (isset($_POST['CRUD']) == false) {
                        echo "*";} ?></label>
                  <input type="text" class="form-control" id="strUsuarioTelefono" name="strUsuarioTelefono"
                    placeholder="ej. 5511223344" value="<?php echo isset($persona) ? $persona->pers_telefono : ""; ?>">
                </div>
                <div class="col-lg-4 form-group">
                  <label
                    for="strSexo" class = "negritas">Sexo:<?php if (isset($_POST['CRUD']) == false) {
                        echo "*";} ?></label><br>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="Sexo">
                      <input type="radio" class="form-check-input" id="strSexoH" name="strSexo" value="Hombre" <?php echo (isset($persona) && $persona->pers_sexo == "Hombre") ? "checked" : ""; ?>>Hombre
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="strSexoM">
                      <input type="radio" class="form-check-input" id="strSexoM" name="strSexo" value="Mujer" <?php echo (isset($persona) && $persona->pers_sexo == "Mujer") ? "checked" : ""; ?>>Mujer
                    </label>
                  </div>

                </div>
              </div>

              
            </div>
          </div>

          <!-- Datos de la usuario -->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header negritas">
                <i class="fas fa-id-badge fa-lg"></i>
                &nbsp;Datos de usuario
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-12 form-group">
                  <label for="lbintUsuarioRol" class = "negritas">Rol:<?php if (isset($_POST['CRUD']) == false) {
                        echo "*";
                                                                      } ?></label>
                  <select required='required' class="custom-select" id="intUsuarioRol" name="intUsuarioRol" <?php if (isset($_POST['CRUD']) == 1) {
                        echo "disabled";
                                                                                                            } ?>>
                    <option value="0">Seleccionar rol</option>
                    <?php foreach ($arr_roles as $rol) { ?>
                    <option value="<?php echo $rol['rol_id_rol']; ?>"
                        <?php if (isset($usuario)) {
                            if ($usuario->rol_id_rol == $rol['rol_id_rol']) {
                                ?> selected
                            <?php }
                        }?>>
                        <?php echo $rol['rol_nombre']; ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-6 form-group">
                  <label for="strNombreUsuario" class = "negritas">Nombre de usuario:<?php if (isset($_POST['CRUD']) == false) {
                        echo "*";
                                                                                     } ?></label>
                  <input type="text" class="form-control" id="strNombreUsuario" name="strNombreUsuario"
                    value="<?php echo isset($usuario) ? $usuario->usua_num_usuario : ""; ?>">
                </div>
                <div class="col-lg-6 form-group">
                  <label for="strContrasenia01" class = "negritas"><?php if (isset($_POST['CRUD']) == false) {
                        echo "Ingrese contraseña:*";
                                                                   } else {
                                                                       echo "Contraseña: ";
                                                                   } ?></label>
                  <input type="password" class="form-control" id="strContrasenia01" name="strContrasenia01"
                    <?php if (isset($_POST['CRUD']) == false) {
                        echo('placeholder=""');
                    } else {
                        echo('value= "' . $usuario->usua_contrasena . '"');
                    } ?>>
                  <?php //? Aqui desbloqueamos consultas ?>
                  <div style="text-align: center; margin-top:5px">
                    <input type="checkbox" id="ver1" class="ver" onChange="hideOrShowPassword1()"/>
                    <label class="text" style="color:#0C4590"><i
                        class="fas fa-eye"></i>&nbsp; Mostrar contraseña</label>
                  </div>
                </div>
                <?php if (isset($_POST['CRUD']) == false || $_POST['CRUD'] == 1) { ?>
                  <div class="col-lg-6 form-group">
                    <label for="strContrasenia02" class = "negritas">Confirme la contraseña: *</label>
                    <input type="password" class="form-control" id="strContrasenia02" name="strContrasenia02" placeholder="Contraseña">
                    <div style="text-align: center; margin-top:5px">
                      <input type="checkbox" id="ver2" class="ver" onChange="hideOrShowPassword2()" />
                      <label class="text" style="color:#0C4590"><i class="fas fa-eye"></i>&nbsp; Mostrar contraseña</label>
                    </div>
                  </div>
                <?php } ?>
              </div>

              <?php //! Apartado eliminado por solicitud del usuario ?>
              <!-- <div class="col-lg-12 form-row">
                <div class="col-lg-6 form-group">
                  <label for="UsuarioPregunta" class = "negritas">Pregunta de seguridad:<?php if (isset($_POST['CRUD']) == false) {
                        echo "*";
                                                                                        } ?></label>
                  <select class="custom-select" id="UsuarioPregunta"name="UsuarioPregunta">
                    <option value="0">Seleccione una pregunta</option>
                    <?php foreach ($arr_preguntas as $pregunta) {
                        if ($pregunta['prse_activo'] == 't') { ?>
                      <option value="<?php echo $pregunta['prse_id_pregunta']; ?>"
                                                    <?php if (isset($usuario)) {
                                                        if ($usuario->prse_id_pregunta == $pregunta['prse_id_pregunta']) { ?>
                                                        <?php }
                                                    }?>>
                            <?php echo $pregunta['prse_pregunta']; ?>
                      </option>
                        <?php } else {
                            if (isset($usuario)) {
                                if ($usuario->prse_id_pregunta == $pregunta['prse_id_pregunta']) {?>
                          <option value="<?php echo $pregunta['prse_id_pregunta'];?>" selected>
                                        <?php echo $pregunta['prse_pregunta']; ?>
                          </option>
                                <?php }
                            }
                        }
                    }?>
                  </select>
                </div>
                <div class="col-lg-6 form-group">
                  <label for="UsuarioRespuesta" class = "negritas"><?php if (isset($_POST['CRUD']) == false) {
                        echo "Proporcione la respuesta: *";
                                                                   } else {
                                                                       echo "Respuesta";
                                                                   }?></label>
                  <input type="text" class="form-control" id="UsuarioRespuesta" name="UsuarioRespuesta"
                    <?php if (isset($_POST['CRUD']) == false) {
                        echo('placeholder=""');
                    } else {
                        echo('value= "' . $usuario->usua_respuesta . '"');
                    } ?>>
                </div>
              </div> -->
            </div>
          </div>

          <!-- Datos de cuenta según rol -->
          <div id = "datosCuenta" class="form-group"                    
           <?php if (isset($usuario) && $usuario->rol_id_rol == ADMINISTRADOR) {
                      echo ('style="display: none;"');
           }
            ?> >
            <div class="card lg-12">
              <div class="card-header negritas">
                <i class="fas fa-id-badge fa-lg"></i>
                &nbsp;Datos de la cuenta
              </div>
              
              <!-- Datos del Moderador -->
              <div class="col-lg-12 form-row" style="margin-top: 15px;"> 
                <?php if (isset($usuario) && $usuario->rol_id_rol == MODERADOR) { ?>
                  <div id="diasServicio" class="col-lg-12 form-group">
                <?php } else { ?>
                  <div id="diasServicio" class="col-lg-12 form-group" style="display: none;">
                <?php } ?>
                    <label for="diasServicio" class = "negritas">Dias del servicio:*</label><br>
                    <?php foreach ($arr_dias as $dia) { ?>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="strDiaServicio<?php echo ($dia['dia_id_dia']);?>" value="<?php echo ($dia['dia_id_dia']);?>" name="strDiaServicio<?php echo ($dia['dia_id_dia']);?>" 
                          <?php if (isset($moderador_dia) && is_array($moderador_dia) || is_object($moderador_dia)) {
                                foreach ($moderador_dia as $diaModerador) {
                                    if ($diaModerador['dia_id_dia'] == $dia['dia_id_dia']) {
                                        ?> checked <?php
                                    }
                                }
                          }?>>
                        <label class="form-check-label" for="inlineCheckbox1"><?php echo ($dia['dia_nombre']);?></label>
                      </div>
                    <?php } ?>
              </div>  <!-- Cierre div de datos row -->

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if (isset($usuario) && $usuario->rol_id_rol == MODERADOR) { ?>
                  <div id="fechaInicio" class="col-lg-3 form-group">
                <?php } else { ?>
                  <div id="fechaInicio" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="fechaInicio" class = "negritas">Fecha de inicio del servicio: *</label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_fecha_inicio: ""; ?>" type="date" class="form-control" name="strFechaInicio" id="strFechaInicio">
                  </div>
                <?php if (isset($usuario) && $usuario->rol_id_rol == MODERADOR) { ?>
                  <div id="fechaFin" class="col-lg-3 form-group">
                <?php } else { ?>
                  <div id="fechaFin" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="fechaFin" class = "negritas">Fecha de fin del servicio:*</label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_fecha_fin: ""; ?>" type="date" class="form-control" name="strFechaFin" id="strFechaFin">
                  </div>
                <?php if (isset($usuario) && $usuario->rol_id_rol == MODERADOR) { ?>
                  <div id="horaInicio" class="col-lg-3 form-group">
                <?php } else { ?>
                  <div id="horaInicio" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="horaInicio" class = "negritas">Hora de inicio del servicio: *</label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_hora_inicio: ""; ?>" type="time" class="form-control" name="strHoraInicio" id="strHoraInicio">
                  </div>
                <?php if (isset($usuario) && $usuario->rol_id_rol == MODERADOR) { ?>
                  <div id="horaFin" class="col-lg-3 form-group">
                <?php } else { ?>
                  <div id="horaFin" class="col-lg-3 form-group" style="display: none;">
                <?php } ?>
                    <label for="horaFin" class = "negritas">Hora de fin del servicio: *</label>
                    <input value="<?php echo isset($moderador) ? $moderador-> mode_hora_fin: ""; ?>" type="time" class="form-control" name="strHoraFin" id="strHoraFin"> 
              </div>  <!-- Cierre div de datos row -->
              

              <!-- Datos del Profesor -->
              <div class="col-lg-12 form-row" style="margin-top: 15px;">  
                <?php if (isset($usuario) && $usuario->rol_id_rol == INSTRUCTOR) { ?>
                  <div id="semblanza" class="col-lg-12 form-group">
                <?php } else { ?>
                  <div id="semblanza" class="col-lg-12 form-group" style="display: none;">
                <?php } ?>
                  <label for="strSemblanza" class = "negritas">Semblanza:*</label>
                  <textarea type="text" class="form-control" id="strSemblanza" name="strSemblanza"><?php echo isset($profesor) ? $profesor-> prof_semblanza: ""; ?></textarea>           
                  </div>
              </div> <!-- Cierre div de datos row -->
    
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php //? Si es Profesor  o Instructor ?>
                <?php if (isset($usuario) && ($usuario->rol_id_rol == PROFESOR )) { ?>
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
                <?php //? Si es Profesor  o Instructor ?>
                <?php if (isset($usuario) && ($usuario->rol_id_rol == PROFESOR)) { ?>
                  <div id="modalidadImparticion" class="col-lg-6 form-group">
                <?php } else { ?>
                  <div id="modalidadImparticion" class="col-lg-6 form-group" style="display: none;">
                <?php } ?>
                  <label for="modalidadImparticion" class = "negritas">Modalidad en la que imparte clases : * </label><br>
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
                <?php //? Si es Profesor o Instructor ?>
                <?php if (isset($usuario) && ($usuario->rol_id_rol == PROFESOR)) { ?>
                  <div id="coordinaciones" class="col-lg-12 form-group">
                <?php } else { ?>
                  <div id="coordinaciones" class="col-lg-12 form-group" style="display: none;">
                <?php } ?>    
                <label for="strCoordinacion" class = "negritas">Coordinaciones a las que pertenece: *</label><br>
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
                                }
                                ?>
                            </div>
                      <?php } ?>
                    </td>
                  </tr>
                </table>
              </div>  <!-- Fin del campo-->
            </div>  <!-- Fin del card-->

            <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php //? Si es Profesor o Instructor ?>
                <?php if (isset($usuario) && ($usuario->rol_id_rol == PROFESOR)) { ?>
                  <div id="nombramientos" class="col-lg-12 form-group">
                <?php } else { ?>
                  <div id="nombramientos" class="col-lg-12 form-group" style="display: none;">
                <?php } ?>    
                <label for="strNombramiento" class = "negritas">Nombramiento principal: *</label><br>
                <table> <?php //*? Esto lo creo para hacer columnas con los checkbox?>
                  <tr>
                    <td>
                      <?php foreach ($arr_nombramientos as $nombramiento) { ?> 
                        <div class="form-check form-check-inline">
                          <label class="form-check-label" for="nombramiento">
                            <input type="radio" class="form-check-input" id= <?php echo("nombramiento".$nombramiento['nomb_id_nombramiento']); ?>
                              name="nombramiento" value="<?php echo isset($profesor) ? $nombramiento['nomb_id_nombramiento'] : ""; ?>" <?php echo (isset($profesor) && $profesor->nomb_id_nombramiento == $nombramiento['nomb_id_nombramiento']) ? "checked" : ""; ?>><?php echo($nombramiento['nomb_descripcion']); ?>
                          </label>
                        </div> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                      <?php } ?>
                    </td>
                  </tr>
                </table>
              </div>  <!-- Fin del campo-->
            </div>  <!-- Fin del card-->
          </div> <!-- Este es cierra todo el grupo de Datos de cuenta -->

        <!-- ID e Instrucciones -->
        <?php //? Al haber algo en el CRUD es que es una consulta ?>
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php  //? Si es 1 significa una actualización ?>
            <?php if ($_POST['CRUD'] == 1) { ?>
            <input type="hidden" name="dml" value="update">
            <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $_POST['id']; ?>">
            <input type="hidden" id="idPersona" name="idPersona" value="<?php echo $persona->pers_id_persona; ?>">
            <input type="hidden" name="hideRol" id="hideRol" value="<?php echo $usuario->rol_id_rol; ?>">
            <?php } elseif ($_POST['CRUD'] == 0) { ?>
            <input type="hidden" name="dml" value="select">
            <?php } ?>
        <?php } else { ?>
          <input type="hidden" name="dml" value="insert">
        <?php } ?>

        <!-- Desactivar formulario FIN -->
        <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 0) { ?>
            </fieldset>
            <?php } ?>
        <?php } ?>

      </form>
    </div>
  </div>
</div>
<!-- Botones -->
<div class="col-lg-12" style="text-align: center;">
  <button id="btn-regresar-usuario" type="button" class="btn btn-success btn-footer btn-regresar">Regresar</button>
  <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 1) { ?>
      <button id="btn-actualizar-usuario" type="button" class="btn btn-success btn-footer btn-aceptar">Actualizar</button>
        <?php } ?>
  <?php } else { ?>
    <button id="btn-registrar-usuario" type="button" class="btn btn-success btn-footer btn-aceptar">Guardar</button>
  <?php } ?>
</div>

<script src="../sistema/usuarios/control_usuario.js"></script>
