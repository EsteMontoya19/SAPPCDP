<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');
  include('../../clases/Profesor.php');
  
  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Profesor = new Profesor();
  
  if (isset($_POST['persona'])){
    $persona = $_POST['persona'];
    $profesor = $obj_Profesor->buscarProfesor($persona);
    $arr_grupos = $obj_Grupo->gruposInscritosxProfesor($profesor->prof_id_profesor);
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
              <i class="fas fa-users"></i>&nbsp; Grupos inscritos
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
                    <th>Nivel</th>
                    <th>Modalidad</th>
                    <th>Número de sesiones</th>
                    <th>Fecha Sesión 1</th>
                    <th>Hora Sesión 1</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($arr_grupos as $grupo) { 
                  $idGrupo = $grupo['grup_id_grupo'];
                  $sesion = $obj_Sesion->buscarMinSesion($idGrupo);?>
                      <tr>
                        <td><?php echo $grupo['grup_id_grupo'];?></td>
                        <td><?php echo $grupo['curs_nombre'];?></td>
                        <td><?php echo $grupo['curs_tipo'];?></td>
                        <td><?php echo $grupo['curs_nivel'];?></td>
                        <td><?php echo $grupo['grup_modalidad'];?></td>
                        <td><?php echo $grupo['curs_num_sesiones'];?></td>
                        <td><?php echo $sesion->sesi_fecha;?></td>
                        <td><?php echo $sesion->sesi_hora_inicio;?></td>
                        <td>

                          <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;" >
                            <i class="fas fa-search-plus"></i>
                          </button>
                          <button type="button" class="btn btn-primary btn-table" title="Comprobante" style="margin-top: 5px;">
                            <i class="fas fa-list-alt"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-table" title="Constancia" <?php if ($grupo['cons_id_constancias'] == Null) {?> style="display: none;" <?php } ?> style="margin-top: 5px;background: #20560a">
                            <i class="fas fa-file"></i>
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

  <script src="../sistema/profesor/control_profesores.js"></script>