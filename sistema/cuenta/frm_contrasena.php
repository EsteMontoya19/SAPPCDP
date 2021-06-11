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



// Catálogos
$obj_Busqueda = new Busqueda();
$arr_roles = $obj_Busqueda->selectRoles();
$arr_preguntas = $obj_Busqueda->selectPregunta();

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

        case 2: //Moderador
        $obj_Moderador = new Moderador();
        $moderador = $obj_Moderador->buscarModerador($_POST['persona']);
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
        <li id="btn-validacion-contrasena" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Validación usuario</a>
        </li>
        <li id="btn-cambiar-contrasena" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Cambiar contraseña</a>
        </li>
      </ol>
      <p>
        <hr>
      </p>

      <!-- Formulario -->
      <form name="form_contrasena" id="form_contrasena" method="POST">
          <!-- Datos de la usuario -->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-badge fa-lg"></i>
                <b>&nbsp;Datos de usuario</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-6 form-group">
                  <label for="strNombreUsuario" class = "negritas">Nombre de usuario: *</label>
                  <input type="text" class="form-control" id="strNombreUsuario" name="strNombreUsuario"
                    value="<?php  echo isset($usuario) ? $usuario->usua_num_usuario : ""; ?>">
                </div>
                <div class="col-lg-6 form-group">
                  <label
                    for="lbintUsuarioRol" class = "negritas">Rol: *</label>
                  <select required='required' class="custom-select" id="intUsuarioRol" name="intUsuarioRol" disabled>
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
              <div class="col-lg-12 form-row">
                <div class="col-lg-6 form-group">
                  <label for="UsuarioPregunta">Pregunta de seguridad: *</label>
                  <select class="custom-select" id="UsuarioPregunta"name="UsuarioPregunta">
                    <option value="0">Seleccione una pregunta</option>
                    <?php foreach ($arr_preguntas as $pregunta) { ?>
                      <option value="<?php echo $pregunta['prse_id_pregunta']; ?>"
                        <?php if(isset($usuario)) { if ($usuario->prse_id_pregunta == $pregunta['prse_id_pregunta']) { ?>
                        selected <?php } }?>>
                        <?php echo $pregunta['prse_pregunta']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-lg-6 form-group">
                  <label for="UsuarioRespuesta" class = "negritas">Respuesta: *</label>
                  <input type="text" class="form-control" id="UsuarioRespuesta" name="UsuarioRespuesta" <?php echo('value= "' . $usuario->usua_respuesta . '"');?>>
                </div>
              </div>

              <div class="col-lg-12 form-row">
                <div class="col-lg-6 form-group">
                  <label for="strContrasenia01" class = "negritas">Contraseña: *</label>
                  <input type="password" class="form-control" id="strContrasenia01" name="strContrasenia01" <?php echo('value= "' . $usuario->usua_contrasena . '"');?>>
                  <div style="text-align: center; margin-top:5px">
                    <input type="checkbox" id="ver1" class="ver" onChange="hideOrShowPassword1()" />
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
            </div>
          </div>                                           
        <!-- Necesarios para actualizar -->
        <input type="hidden" name="dml" value="update">
        <input type="hidden" name="procedencia" value="mi_cuenta">
        <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $_POST['persona']; ?>">
        <input type="hidden" id="idPersona" name="idPersona" value="<?php echo $persona->pers_id_persona; ?>">
        <input type="hidden" name="hideRol" id="hideRol" value="<?php echo $usuario->rol_id_rol; ?>">
      </form>
      <!-- Botones -->
      <div class="col-lg-12" style="text-align: center;">
        <button id="btn-regresar-cambio-contrasena" type="button" class="btn btn-success btn-footer btn-regresar">Regresar</button>
        <button id="btn-actualizar-usuario-contrasena" type="button" class="btn btn-success btn-footer btn-aceptar">Guardar</button>
      </div>
    </div>
  </div>
</div>

<script src="../sistema/cuenta/control_cuenta.js"></script>