<?php

  // Clases
  include('../../clases/BD.php');
  include('../../clases/Busqueda.php');
  include('../../clases/Correo.php');
  include('../../clases/Persona.php');
  include('../../clases/Telefono.php');
  include('../../clases/Usuario.php');
  
  // Catálogo
  $obj_Busqueda = new Busqueda();
  $arr_roles = $obj_Busqueda->selectRoles();
  $arr_preguntas = $obj_Busqueda->selectPregunta();

  // Validar entidad
  if (isset($_POST['persona']) && isset($_POST['id'])) {

    // Recuperar información
    $obj_Correo = new Correo();
    $correo = $obj_Correo->buscarCorreo($_POST['persona'], 1);

    $obj_Persona = new Persona();
    $persona = $obj_Persona->buscarPersona($_POST['persona']);

    $obj_Telefono = new Telefono();
    $telefono = $obj_Telefono->buscarTelefono($_POST['persona'], 1);

    $objUsuario = new Usuario();
    $usuario = $objUsuario->buscarUsuario($_POST['id']);

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

      <!-- Desactivar formulario INICIO -->
      <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 0) { ?>
          <fieldset disabled>
        <?php } ?>
      <?php } ?>

        <div class="form-group">

          <!-- Datos generales -->
          <div class="card lg-12">
            <div class="card-header">
              <i class="fas fa-id-card fa-lg"></i>
              <b>&nbsp;&nbsp;Datos generales</b>
            </div>
            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <div class="col-lg-4 form-group">
                <label for="strUsuarioNombre"><b>Nombre(s): *</b></label>
                <input type="text" class="form-control" id="strUsuarioNombre" name="strUsuarioNombre" value="<?php echo isset($persona) ? $persona->pers_nombre : ""; ?>">
              </div>
              <div class="col-lg-4 form-group">
                <label for="strUsuarioPrimerApe"><b>Primer apellido: *</b></label>
                <input type="text" class="form-control" id="strUsuarioPrimerApe" name="strUsuarioPrimerApe" value="<?php echo isset($persona) ? $persona->pers_primer_ape : ""; ?>">
              </div>
              <div class="col-lg-4 form-group">
                <label for="strUsuarioSegundoApe"><b>Segundo apellido:</b></label>
                <input type="text" class="form-control" id="strUsuarioSegundoApe" name="strUsuarioSegundoApe" value="<?php echo isset($persona) ? $persona->pers_segundo_ape : ""; ?>">
              </div>
            </div>
            <div class="col-lg-12 form-row">
              <div class="col-lg-6 form-group">
                <label for="strUsuarioCorreo"><b>Correo electrónico: *</b></label>
                <input type="text" class="form-control" id="strUsuarioCorreo" name="strUsuarioCorreo" placeholder="ej. ejemplo@dominio.com" value="<?php echo isset($correo) ? $correo->corr_direccion : ""; ?>">
              </div>
              <div class="col-lg-6 form-group">
                <label for="strUsuarioTelefono"><b>Teléfono: *</b></label>
                <input type="text" class="form-control" id="strUsuarioTelefono" name="strUsuarioTelefono" placeholder="ej. 5511223344" value="<?php echo isset($telefono) ? $telefono->tele_numero : ""; ?>">
              </div>
            </div>
          </div>
        </div>

        <!-- Datos de la cuenta -->
        <div class="form-group">
          <div class="card lg-12">
            <div class="card-header">
              <i class="fas fa-id-badge fa-lg"></i>
              <b>&nbsp;Datos de la cuenta</b>
            </div>
            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <div class="col-lg-6 form-group">
                <label for="strNombreUsuario"><b>Nombre de usuario: *</b></label>
                <input type="text" class="form-control" id="strNombreUsuario" name="strNombreUsuario" value="<?php echo isset($usuario) ? $usuario->usua_nombre : ""; ?>">
              </div>
              <div class="col-lg-6 form-group">
                <label for="intUsuarioRol"><b>Rol: *</b></label>
                <select class="custom-select" id="intUsuarioRol" name="intUsuarioRol">
                  <option value="0">Seleccione una opción</option>
                  <?php foreach ($arr_roles as $rol) { ?>
                    <option value="<?php echo $rol['rol_id_rol']; ?>" <?php if(isset($usuario)) { if ($usuario->usua_id_rol == $rol['rol_id_rol']) { ?> selected <?php } }?>>
                      <?php echo $rol['rol_nombre']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <?php if (isset($_POST['CRUD']) == false) { ?>
              <div class="col-lg-12 form-row">
                <div class="col-lg-6 form-group">
                  <label for="UsuarioPregunta"><b>Pregunta de seguridad: *</b></label>
                  <select class="custom-select" id="UsuarioPregunta" name="UsuarioPregunta">
                    <option value="0">Seleccione una pregunta</option>
                    <?php foreach ($arr_preguntas as $pregunta) { ?>
                      <option value="<?php echo $pregunta['preg_id_preg']; ?>"><?php echo $pregunta['preg_nombre']; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-lg-6 form-group">
                  <label for="UsuarioRespuesta"><b>Proporcione la respuesta: *</b></label>
                  <input type="text" class="form-control" id="UsuarioRespuesta" name="UsuarioRespuesta" placeholder="">
                </div>
              </div>
              <div class="col-lg-12 form-row">
                <div class="col-lg-6 form-group">
                  <label for="strContrasenia01"><b>Ingrese la contraseña: *</b></label>
                  <input type="password" class="form-control" id="strContrasenia01" name="strContrasenia01" placeholder="Contraseña">
                  <div style="text-align: center; margin-top:5px">
                    <input type="checkbox" id="ver1" class="ver" onChange="hideOrShowPassword1()" />
                    <label class="text" style="color:#0C4590"><i class="fas fa-eye"></i>&nbsp; Mostrar contraseña</label>
                  </div>
                </div>
                <div class="col-lg-6 form-group">
                  <label for="strContrasenia02"><b>Confirme la contraseña: *</b></label>
                  <input type="password" class="form-control" id="strContrasenia02" name="strContrasenia02" placeholder="Contraseña">
                  <div style="text-align: center; margin-top:5px">
                    <input type="checkbox" id="ver2" class="ver" onChange="hideOrShowPassword2()" />
                    <label class="text" style="color:#0C4590"><i class="fas fa-eye"></i>&nbsp; Mostrar contraseña</label>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        
        <!-- ID e Instrucciones -->
        <?php if (isset($_POST['CRUD'])) { ?>
          <?php if ($_POST['CRUD'] == 1) { ?>
            <input type="hidden" name="dml" value="update"/>
            <input type="hidden" id="idUsuario" name="idUsuario" value="<?php echo $_POST['id']; ?>">
            <input type="hidden" id="idPersona" name="idPersona" value="<?php echo $persona->pers_id_pers; ?>">
          <?php } elseif ($_POST['CRUD'] == 0) { ?>
            <input type="hidden" name="dml" value="select"/>
          <?php } ?>
        <?php } else { ?>
          <input type="hidden" name="dml" value="insert"/>
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

<script src="../sistema/usuarios/usuarios.js"></script>