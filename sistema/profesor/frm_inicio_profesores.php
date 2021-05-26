<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  
  $obj_Grupo = new Grupo();
  $arr_grupos = $obj_Grupo ->buscarGruposProfesores();
  
  if (isset($_POST['persona'])){
    $idPersona = $_POST['persona'];
  } else {
    $idPersona = 0;
  }

?>

  <div id="wrapper">
    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Indicador -->
        <div class="form-inline">
          <div class="col-sm-12">
            <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-users"></i>&nbsp; Grupos publicados
            </li>
            </ol>
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
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Modalidad</th>
                    <th>Lugares Disp</th>
                    <th>Profesor</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Número de sesiones</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <?php foreach ($arr_grupos as $grupo) { ?>
                      <tr>
                        <td><?php echo $grupo['grup_id_grupo'];?></td>
                        <td><?php echo $grupo['curs_nombre'];?></td>
                        <td><?php echo $grupo['curs_tipo'];?></td>
                        <td><?php echo $grupo['grup_modalidad'];?></td>
                        <td><?php echo ($grupo['grup_cupo'] - $grupo['grup_num_inscritos']);?></td>
                        <td><?php echo $grupo['pers_nombre'];?> <?php echo $grupo['pers_apellido_paterno'];?> <?php echo $grupo['pers_apellido_materno'];?></td>
                        <td><?php echo $grupo['grup_inicio_insc'];?></td>
                        <td><?php echo $grupo['grup_fin_insc'];?></td>
                        <td><?php echo $grupo['curs_num_sesiones'];?></td>
                        <td>

                          <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;" onclick="consultarGrupo(<?php echo $grupo['grup_id_grupo']?>,'<?php echo $idPersona?>')">
                            <i class="fas fa-search-plus"></i>
                          </button>
                         <!-- <button type="button" class="btn btn-primary btn-table" title="Inscribir" style="margin-top: 5px;">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button type="button" class="btn btn-primary btn-table" title="Comprobante" style="margin-top: 5px;">
                            <i class="fas fa-list-alt"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-table" title="Constancia" style="margin-top: 5px;background: #20560a">
                            <i class="fas fa-file"></i>
                          </button> -->
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

  <script src="../sistema/profesor/control_profesores.js"></script>

