<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');
  include('../../clases/Profesor.php');
  include('../../clases/Busqueda.php');

  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Profesor = new Profesor();
  $obj_Busqueda = new Busqueda();

  $arr_grupos = null;

  if (isset($_POST['persona'])){
    $idPersona = $_POST['persona'];
    $profesor = $obj_Profesor->buscarProfesorxPersona($idPersona);
    if(isset($profesor)){
      $arr_grupos = $obj_Grupo->gruposInscritosxProfesorHistoricos($profesor->prof_id_profesor);
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
              <i class="fas fa-users"></i>&nbsp; Grupos Históricos
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
                    <th>Estado</th>
                    <th>Información</th>
                    <th>Constancia</th>
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
                        <td><?php echo $grupo['esta_nombre'];?>
                        <td>
                          <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;" onclick="consultarGrupoInscrito(<?php echo $grupo['grup_id_grupo']?>,<?php echo $idPersona?>, <?php echo $grupo['moap_id_modalidad']?>)">
                            <i class="fas fa-search-plus"></i>
                          </button>
                          <!-- <button type="button" class="btn btn-primary btn-table" title="Comprobante" style="margin-top: 5px;">
                            <i class="fas fa-list-alt"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-table" title="Constancia" <?php if ($grupo['cons_id_constancias'] == Null) {?> style="display: none;" <?php } ?> style="margin-top: 5px;background: #20560a">
                            <i class="fas fa-file"></i>
                          </button> -->
                        </td>
                        <td>
                          <?php if($grupo['insc_activo'] == 't'){ ?>
                            <?php if ($grupo['esta_nombre'] == 'Finalizado') {
                              if($grupo['cons_id_constancias'] == '') { 
                                echo "Pendiente carga de constancia";
                              } else {
                                $constancia = $obj_Busqueda->selectConstanciaID($grupo['cons_id_constancias']); 
                                if (isset($constancia)) { 
                                  if ($constancia->cons_estado == 'Disponible') {?>
                            <a id="btn-constancia" href="<?php echo $constancia->cons_url ?>" download
                            class="btn btn-descarga" onclick="descargaConstancia(<?php echo $constancia->cons_id_constancias ?>)" role="button"><i class="fas fa-file-download"
                            style="padding-right: 10px;"></i>Descargar Constancia</a>
                            <?php } elseif ($constancia->cons_estado == 'No aplica') { 
                                    echo ('<p class = aviso-azul>No Aplica</p>');
                                  }elseif ($constancia->cons_estado == 'No disponible') { 
                                    echo ('<p class = aviso-azul>Constancia no disponible</p>');
                                  } else {
                                    echo ($constancia->cons_estado);
                                  }
                                } 
                              } 
                            } else {
                              echo ('<p class = aviso-rojo>No aplica a grupos cancelados</p>');
                            }?>
                          <?php } else {
                              echo ('<p class = aviso-azul>Inscripción Cancelada</p>');
                           } ?>
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