<?php
  include('../../clases/BD.php');
  include('../../clases/Usuario.php');

  $obj_usuario = new Usuario();
  $arr_usuarios = $obj_usuario->buscarTodosUsuarios();

  $x = 0;
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <!-- Indicador -->
      <div class="form-inline">
        <div class="col-sm-10" style="padding:0px">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-user-shield"></i>&nbsp; Usuarios
            </li>
          </ol>
        </div>
        <div class="col-sm-2" align="center">
          <a href="#">
            <button id="btn-registro-usuario" type="button" class="btn btn-success">
              <i class="fas fa-plus-circle"></i>&nbsp;&nbsp; Agregar usuario
            </button>
          </a>
        </div>
      </div>

      <p>
        <hr>
      </p>
    
      <!-- Tabla -->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-folder"></i>&nbsp; &nbsp;Resultados
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-condensed table-hover" id="tabla_usuarios" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>Nombre(s)</th>
                  <th>Primer apellido</th>
                  <th>Segundo apellido</th>
                  <th>Rol</th>
                  <th>Estatus</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($arr_usuarios as $usuario) { ?>
                  <tr>
                    <?php $x++; ?>
                    <td><?php echo $usuario['usua_id_usuario']; ?></td>
                    <td><?php echo $usuario['pers_nombre']; ?></td>
                    <td><?php echo $usuario['pers_apellido_paterno']; ?></td>
                    <td><?php echo $usuario['pers_apellido_materno']; ?></td>
                    <td><?php echo $usuario['rol_nombre']; ?></td>
                    <td>
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="estatusUsuario<?php echo $x ?>" <?php if ($usuario['usua_activo'] == 't') { ?> checked <?php } ?> onclick="cambioEstatus(<?php echo $usuario['usua_id_usuario'] ?> , '<?php echo $usuario['usua_activo']; ?>', '<?php echo $usuario['pers_nombre']; ?>', '<?php echo $usuario['pers_apellido_paterno']; ?>')">
                        <label class="custom-control-label" for="estatusUsuario<?php echo $x ?>"></label>
                      </div>
                    </td>
                    <td>
                      <button type="button" class="btn btn-primary btn-table" title="Actualizar" onclick="actualizarUsuario(<?php echo $usuario['rol_id_rol'] ?>, <?php echo $usuario['usua_id_usuario'] ?>, <?php echo $usuario['usua_num_usuario'] ?>)">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button type="button" class="btn btn-info btn-table" title="Detalles" onclick="buscarUsuario(<?php echo $usuario['usua_id_usuario'] ?>">
                        <i class="fas fa-search-plus"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-table" title="Eliminar" onclick="eliminarUsuario(<?php echo $usuario['usua_id_usuario'] ?>,  <?php echo $usuario['pers_id_persona'] ?>, '<?php echo $usuario['pers_nombre']; ?>', '<?php echo $usuario['pers_primer_ape']; ?>')">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>  
    </div>
  </div>
</div>

<script src="../sistema/usuarios/usuarios.js"></script>