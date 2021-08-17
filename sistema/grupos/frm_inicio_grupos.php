<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  
  $obj_Grupo = new Grupo();
  $arr_grupos = $obj_Grupo ->buscarTodosGrupos();
  $activo = 0;

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
          <div class="col-sm-2" aligne="center">
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
                    <th>Estado</th>
                    <th>Lugares disponibles</th>
                    <th>Profesor</th>
                    <th>Publicado</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                if (isset($arr_grupos)) {
                    foreach ($arr_grupos as $grupo) { ?>
                    <tr>
                      <?php $activo++; ?>
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
                      <td><?php echo ($grupo['grup_cupo'] - $grupo['grup_num_inscritos']);?></td>
                      <td><small><?php echo $grupo['pers_nombre'];?> <?php echo $grupo['pers_apellido_paterno'];?> <?php echo $grupo['pers_apellido_materno'];?></small></td>
                      <td>
                        <div class="custom-control custom-switch">
                          <input type="checkbox" class="custom-control-input" id="estatusGrupo<?php echo $activo ?>" <?php if ($grupo['grup_publicado'] == 't') {?> checked 
                             <?php } ?> onclick="cambioPublicacion(<?php echo $grupo['grup_id_grupo'] ?> , '<?php echo $grupo['grup_publicado']; ?>', '<?php echo $grupo['curs_nombre']; ?>', '<?php echo $grupo['grup_modalidad']; ?>')">
                          <label class="custom-control-label" for="estatusGrupo<?php echo $activo ?>"></label>
                        </div>
                      </td>

                      <!-- //Section: Columna de opciones. -->
                      <td >

                        <div align="right" >
                          <div align='left' style="width: 80%;">
                            <button type="button" class="btn btn-primary btn-table" title="Actualizar" <?php if ($grupo['grup_publicado'] == 't' || $grupo['grup_estado'] == 'Finalizado'  || $grupo['grup_estado'] == 'Cancelado') {?> style="display: none;" 
                              <?php } ?>style="margin-top: 5px;" onclick="actualizarGrupo(<?php echo $grupo['grup_id_grupo']?>)">
                            <i class="fas fa-edit"></i>
                          </button>

                          <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;" onclick="consultarGrupo(<?php echo $grupo['grup_id_grupo']?>, '<?php echo $grupo['grup_modalidad']?>')">
                            <i class="fas fa-search-plus"></i>
                          </button>



                              <!-- <?php if ($grupo['grup_num_inscritos'] != 0) { ?>
                            <a href="../modulos/Control_PDF_Inscritos.php?idGrupo=<?php echo $grupo['grup_id_grupo'];?>" target="_blank" type="button" class="btn btn-primary btn-table" title="Lista" style="margin-top: 5px;background: #20560a">
                            <i class="fas fa-list-alt"></i>
                          </a>
                                   <?php } ?> -->

                              <?php if ($grupo['grup_num_inscritos'] != 0) { ?>
                            <a href="../modulos/Control_PDF_Inscritos.php?idGrupo=<?php echo $grupo['grup_id_grupo'];?>" target="_blank" type="button" class="btn btn-table btn-pdf" title="PDF Inscritos" style="margin-top: 5px;">
                              <i class="fa fa-file-pdf"></i>
                            </a>
                              <?php } ?>

                          <?php if ($grupo['grup_num_inscritos'] != 0) { ?>
                            <a href="../modulos/Control_Generar_Excel.php?idGrupo=<?php echo $grupo['grup_id_grupo'];?>" target="_blank" type="button" class="btn btn-table btn-excel" title="Excel Asistencia" <?php if ($grupo['grup_estado'] == 'Pendiente') {?> style="display: none;" <?php } ?> 
                              style="margin-top: 5px;">
                              <i class="fas fa-clipboard-list"></i>
                            </a>
                          <?php } ?>


                          <?php if ($grupo['grup_num_inscritos'] != 0) { ?>
                            <a href="../modulos/Control_Generar_Constancia.php?idGrupo=<?php echo $grupo['grup_id_grupo'];?>" target="_blank" type="button" class="btn btn-info btn-table" title="Excel Constancias" <?php if ($grupo['grup_estado'] != 'Finalizado') {?> style="display: none;" <?php } ?>
                              style="margin-top: 5px;">
                              <i class="fa fa-table"></i>
                            </a>
                          <?php } ?>


                          <button type="button" class="btn btn-info btn-table" title="Asistencias" <?php if ($grupo['grup_estado'] == 'Pendiente' || $grupo['grup_estado'] == 'Cancelado' ||  $grupo['grup_publicado'] != "t") {?> style="display: none;" <?php } ?> 
                            style="margin-top: 5px;" onclick="asistenciaGrupo(<?php echo $grupo['grup_id_grupo']?>)">
                            <i class="fas fa-tasks"></i>
                          </button>

                          <button type="button" class="btn btn-info btn-table" title="Subir Constancias" <?php if ($grupo['grup_estado'] != 'Finalizado') {
                                ?> style="display: none;" <?php } ?> style="margin-top: 5px;" onclick="registrarConstancias(<?php echo $grupo['grup_id_grupo']?>)">
                            <i class="fas fa-file-upload"></i>
                          </button>

                          <button type="button" class="btn btn-info btn-table" title="Constancias Descargadas" <?php if ($grupo['grup_estado'] != 'Finalizado') {
                                ?> style="display: none;" <?php } ?> style="margin-top: 5px;" onclick="verificarDescargasConstancias(<?php echo $grupo['grup_id_grupo']?>)">
                            <i class="fas fa-clipboard-check"></i>
                          </button>

                        </div>
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

  <script src="../sistema/grupos/control_grupos.js"></script>
