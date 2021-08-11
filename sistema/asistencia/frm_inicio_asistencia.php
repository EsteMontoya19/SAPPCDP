<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  
  $obj_Grupo = new Grupo();
  $arr_grupos = $obj_Grupo ->buscarTodosGruposAsignados($_POST['idUsuario']);
  $activo = 0;

?>

  <div id="wrapper">
    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Indicador -->
        <div class="form-inline">
          <div class="col-sm-12">
            <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-user-graduate"></i>&nbsp; Asistencias
            </li>
            </ol>
          </div>
          <div class="col-sm-2" aligne="center">

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
              <table class="table table-condensed table-hover" id="tabla_asistencia" width="100%" cellspacing="0">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>Curso</th>
                    <th>Modalidad</th>
                    <th>Estado</th>
                    <th>Profesor</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                if (isset($arr_grupos)) {
                    foreach ($arr_grupos as $grupo) { ?>
                    <tr>
                      <td><?php echo $grupo['grup_id_grupo'];?></td>
                      <td><?php echo $grupo['curs_nombre'];?></td>
                      <td><?php echo $grupo['grup_modalidad'];?></td>
                      <td> <?php echo $grupo['grup_estado'];?> </td>
                      <td><small><?php echo $grupo['pers_nombre'];?> <?php echo $grupo['pers_apellido_paterno'];?> <?php echo $grupo['pers_apellido_materno'];?></small></td>
                      <td>
                        <div align="left">
                        <button type="button" class="btn btn-info btn-table" title="Asistencias" <?php if ($grupo['grup_estado'] != 'En curso') {
                            ?> style="display: none;" <?php
                                                                                                 } ?> style="margin-top: 5px;" onclick="asistenciaGrupo(<?php echo $grupo['grup_id_grupo']?> , true )">
                          <i class="fas fa-tasks"></i>
                        </button>
                        </div>
                      </td>
                    </tr>
                    <?php }
                }?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../sistema/asistencia/control_asistencias.js"></script>
