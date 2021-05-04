<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
 
  
  $obj_Grupo = new Grupo();
  $arr_grupos = $obj_Grupo ->buscarTodosGruposPresencial();
  $arr_webs = $obj_Grupo->buscarTodosWebinar();

?>

  <div id="wrapper">
    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Indicador -->
        <div class="form-inline">
          <div class="col-sm-10">
            <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-users"></i>&nbsp; Grupos
            </li>
            </ol>
          </div>
          <div class="col-sm-2" align="center">
            <a href="#">
              <button id="btn-registro-grupo" type="button" class="btn btn-success">
                <i class="fas fa-plus-circle"></i>&nbsp;&nbsp; Agregar grupo
              </button>
            </a>
          </div>
        </div>

        <p>
          <hr>
        </p>

        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-folder"></i> Resultados
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-condensed table-hover" id="tabla_grupos" width="100%" cellspacing="0">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Curso</th>
                    <th>Modalidad</th>
                    <th>Estatus</th>
                    <th>Lugares disponibles</th>
                    <th>Profesor</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($arr_webs as $grupo) { ?>
                    <tr>
                      <td><?php echo $grupo['grup_id_grupo'];?></td>
                      <td><?php echo $grupo['grup_tipo'];?></td>
                      <td><?php echo $grupo['curs_nombre'];?></td>
                      <td><?php echo $grupo['grup_modalidad'];?></td>
                      <td>
                      <?php echo $grupo['grup_estado'];?>
                      <!-- Comenta este código 
                        <//?php if($grupo['esgr_nombre'] == 'Abierto'){ ?>
                          <div class="alert alert-success" role="alert">
                            <//?php echo $grupo['esgr_nombre'];?>
                          </div>
                        <//?php } else {?>
                          <div class="alert alert-danger" role="alert">
                            <//?php echo $grupo['esgr_nombre'];?>
                          </div>
                        <//?php } ?>
                        -->
                      
                      </td>
                      <td><?php echo $grupo['grup_cupo'];?></td>
                      <td><small><?php echo $grupo['pers_nombre'];?> <?php echo $grupo['pers_apellido_paterno'];?> <?php echo $grupo['pers_apellido_materno'];?></small></td>
                      <td>
                        <button type="button" class="btn btn-primary btn-table" title="Actualizar" style="margin-top: 5px;" onclick="actualizarGrupo(<?php echo $grupo['grup_id_grupo']?>)">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;" onclick="consultarGrupo(<?php echo $grupo['grup_id_grupo']?>, '<?php echo $grupo['grup_modalidad']?>')">
                          <i class="fas fa-search-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-table" title="Eliminar" style="margin-top: 5px;" onclick="eliminarGrupo(<?php echo $grupo['grup_id_grupo']?>)">
                          <i class="fas fa-trash-alt"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-table" title="Listas" style="margin-top: 5px;background: #20560a">
                          <i class="fas fa-list-alt"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-table" title="Constancias" style="margin-top: 5px">
                          <i class="fas fa-list-alt"></i>
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

  <script src="../sistema/grupos/control_grupos.js"></script>

