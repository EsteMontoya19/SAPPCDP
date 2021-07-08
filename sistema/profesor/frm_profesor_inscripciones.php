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
    $profesor = $obj_Profesor->buscarProfesorxPersona($idPersona);
    if(isset($profesor)){
      $arr_grupos = $obj_Grupo->gruposInscritosxProfesor($profesor->prof_id_profesor);
    }
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
                    $sesion = $obj_Sesion->numSesionesGrupo($idGrupo);
                    $sesionUno = $obj_Sesion->buscarMinSesion($idGrupo);
                    if($grupo['moap_id_modalidad'] == 1){
                      $modalidad=$obj_Grupo->buscarDatosPresencial($idGrupo);
                    } elseif ($grupo['moap_id_modalidad'] == 2) {
                      $modalidad=$obj_Grupo->buscarDatosEnLinea($idGrupo);
                    } elseif ($grupo['moap_id_modalidad'] == 3) {
                      $modalidad=$obj_Grupo->buscarDatosAutogestivo($idGrupo);
                    }
                    ?>
                      <tr>
                        <td><?php echo $grupo['grup_id_grupo'];?></td>
                        <td><?php echo $grupo['cale_semestre'];?></td>
                        <td><?php echo $grupo['curs_nombre'];?></td>
                        <td><?php echo $grupo['moap_nombre'];?></td>
                        <td><?php echo $sesion->numero;?></td>
                        <td><?php echo $sesionUno->fecha.'  '.$sesionUno->hora_ini.'-'.$sesionUno->hora_fin;?></td>
                        <td><?php 
                        if ($grupo['esta_nombre'] == 'En curso'){
                          if($grupo['moap_id_modalidad'] == 2){?>
                            <a href="<?php echo $modalidad->grup_url;?>" target="_blank"><?php echo $modalidad->plat_nombre;?></a>
                          <?php
                          } elseif($grupo['moap_id_modalidad'] == 1) { 
                            echo "Edificio: ".$modalidad->edif_nombre." Salón: ".$modalidad->salo_nombre;
                          } elseif($grupo['moap_id_modalidad'] == 3) { ?>
                            <a href="<?php echo $modalidad->grup_url;?>" target="_blank">Plataforma externa</a>
                          <?php
                          }
                        } else {
                          echo $grupo['esta_nombre'];
                        }?>
                        <td>
                          <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;" onclick="consultarGrupoInscrito(<?php echo $grupo['grup_id_grupo']?>,<?php echo $idPersona?>, <?php echo $grupo['moap_id_modalidad']?>)">
                            <i class="fas fa-search-plus"></i>
                          </button>
                          <a class = "btn btn-pdf" target="_blank" title="Comprobante inscripción" href="../modulos/Control_PDF.php?tipo=comprobante&idP=<?php echo($idPersona); ?>&idG=<?php echo($grupo['grup_id_grupo']); ?>" role="button"><i class="far fa-file-pdf"></i></i></a>
                          <!-- <button type="button" class="btn btn-primary btn-table" title="Comprobante" style="margin-top: 5px;">
                            <i class="fas fa-list-alt"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-table" title="Constancia" <?php if ($grupo['cons_id_constancias'] == Null) {?> style="display: none;" <?php } ?> style="margin-top: 5px;background: #20560a">
                            <i class="fas fa-file"></i>
                          </button> -->
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