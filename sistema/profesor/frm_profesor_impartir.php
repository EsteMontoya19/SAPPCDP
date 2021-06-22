<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');
  include('../../clases/Profesor.php');
  
  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Profesor = new Profesor();

  $arr_grupos = null;
  
  if (isset($_POST['persona'])){
    $idPersona = $_POST['persona'];
    $profesor = $obj_Profesor->buscarProfesor($idPersona);
    $arr_grupos = $obj_Grupo->buscarGruposImpartidosxProfesor($profesor->prof_id_profesor);
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
              <i class="fas fa-users"></i>&nbsp; Grupos a Impartir
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
                    <th>Semestre</th>
                    <th>Nombre</th>
                    <th>Modalidad</th>
                    <th>Número de sesiones</th>
                    <th>Fecha y Hora Sesión 1</th>
                    <th>Datos de acceso</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                if (isset($arr_grupos)) {
                  foreach ($arr_grupos as $grupo) { 
                  $idGrupo = $grupo['grup_id_grupo'];
                  $sesion = $obj_Sesion->buscarMinSesion($idGrupo);
                  if($grupo['grup_modalidad'] == 'En línea'){
                    $modalidad=$obj_Grupo->buscarDatosEnLinea($idGrupo);
                  } else {
                    $modalidad=$obj_Grupo->buscarDatosPresencial($idGrupo);
                  }
                
                ?>

                      <tr>
                        <td><?php echo $grupo['grup_id_grupo'];?></td>
                        <td><?php echo $grupo['cale_semestre'];?></td>
                        <td><?php echo $grupo['curs_nombre'];?></td>
                        <td><?php echo $grupo['grup_modalidad'];?></td>
                        <td><?php echo $grupo['curs_num_sesiones'];?></td>
                        <td><?php echo $sesion->sesi_fecha."      ".$sesion->sesi_hora_inicio;?></td>
                        <td><?php if($grupo['grup_modalidad'] == 'En línea'){?>
                          <a href="<?php echo $modalidad->grup_acceso;?>" target="_blank"><?php echo $modalidad->plat_nombre;?></a>
                        <?php
                        } else {
                          echo "Edificio: ".$modalidad->edif_nombre." Salón: ".$modalidad->salo_nombre;
                        }?>
                        <td>
                          <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;" 
                            onclick="consultarGrupoImpartir(<?php echo $grupo['grup_id_grupo']?>,'<?php echo $idPersona?>')">
                            <i class="fas fa-search-plus"></i>
                          </button>
                          //TODO : Hacer que genere un Excel de la lista. 
                          <button type="button" class="btn btn-primary btn-table" title="Lista" style="margin-top: 5px;">
                            <i class="fas fa-list-alt"></i>
                          </button>
                          <?php if($grupo['grup_num_inscritos'] != 0){ ?>
                            <a href="../modulos/Control_PDF_Inscritos.php?idGrupo=<?php echo $grupo['grup_id_grupo'];?>" target="_blank" type="button" class="btn btn-primary btn-table" title="Lista" style="margin-top: 5px;">
                              <i class="fas fa-list-alt"></i>
                            </a>
                          <?php } ?>
                        </td>
                      </tr>
                  <?php } } ?>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../sistema/profesor/control_profesores.js"></script>