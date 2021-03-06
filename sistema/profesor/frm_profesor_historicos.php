<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');
  include('../../clases/Profesor.php');
  include('../../clases/Busqueda.php');
  include('../../clases/Constancias.php');

  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Profesor = new Profesor();
  $obj_Busqueda = new Busqueda();
  $obj_Constancia = new Constancias();

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
                    
                    if($grupo['grup_id_modalidad'] == 1){
                      $modalidad=$obj_Grupo->buscarDatosPresencial($idGrupo);
                    } elseif ($grupo['grup_id_modalidad'] == 2) {
                      $modalidad=$obj_Grupo->buscarDatosEnLinea($idGrupo);
                    } elseif ($grupo['grup_id_modalidad'] == 3) {
                      $modalidad=$obj_Grupo->buscarDatosAutogestivo($idGrupo);
                    }
                    ?>
                      <tr>
                        <td><?php echo $grupo['insc_id_inscripcion'];?></td>
                        <td><?php echo $grupo['cale_semestre'];?></td>
                        <td><?php echo $grupo['curs_nombre'];?></td>
                        <td><?php echo $grupo['moap_nombre'];?></td>
                        <td><?php echo $sesion->numero;?></td>
                        <td><?php echo $grupo['esta_nombre'];?>
                        <td>
                          <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;" onclick="consultarGrupoInscrito(<?php echo $grupo['grup_id_grupo']?>,<?php echo $idPersona?>, <?php echo $grupo['grup_id_modalidad']?>)">
                            <i class="fas fa-search-plus"></i>
                          </button>
                          <!-- <button type="button" class="btn btn-primary btn-table" title="Comprobante" style="margin-top: 5px;">
                            <i class="fas fa-list-alt"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-table" title="Constancia" <?php if ($grupo['insc_id_constancia'] == Null) {?> style="display: none;" <?php } ?> style="margin-top: 5px;background: #20560a">
                            <i class="fas fa-file"></i>
                          </button> -->
                        </td>
                        <td>

                          <?php if($grupo['insc_activo'] == 't'){ ?>
                            <?php if ($grupo['esta_nombre'] == 'Finalizado') {
                              $resultadoInscripcion = $obj_Constancia->buscarRespuestasInscripcion($grupo['insc_id_inscripcion']);
                              //? Primero se solicita resolver la evaluación del curso, este o no este aún disponible la constancia.
                              if(isset($resultadoInscripcion)) {
                                //? Si la constancia aún no se ha cargado.
                                if($grupo['insc_id_constancia'] == '') { 
                                  echo "Pendiente carga de constancia";
                                } else {
                                  //? Se busca el ID de la constancia asociada a la inscripción.
                                  $constancia = $obj_Busqueda->selectConstanciaID($grupo['insc_id_constancia']); 
                                  if (isset($constancia)) {
                                    //? Si la constancia ya esta cargada 
                                    if ($constancia->cons_estado == 'Disponible') { ?>
                                      <a id="btn-constancia" href="<?php echo isset($constancia->cons_url) ? $constancia->cons_url : "Error al descargar la constancia." ?>" download
                                        class="btn btn-descarga" onclick="descargaConstancia(<?php echo $constancia->cons_id_constancia ?>)" role="button"><i class="fas fa-file-download"
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
                              } else { ?>
                                <a id="Solicitud_Evaluacion"  onClick='formularioEvaluacion(<?php echo ($grupo['insc_id_inscripcion']) ?>)' class="d-block small btn btn-evaluacion" href="#" data-toggle="modal" data-target="#exampleModal" role="button">
                                  <i class="fas fa-chart-bar" style="padding-right: 10px;"></i>Responder evaluación</a>
                                </div> <?php 
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

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title col-lg-12" id="exampleModalLabel"
            style="background: #132c33;color: #fff;padding: 10px">Evaluación de curso</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                  <p class = "aviso-verde">Para poder descargar su constancia es necesario realizar la evaluación del curso que se tomó.</p>
                  <section id = "EvaluacionCurso">
                  </section>
              </div>
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-regresar" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary btn-aceptar" id = "btn-registrar-evaluacion">Registrar respuesta</button>
        </div>
      </div>
    </div>
  </div>

  <script src="../sistema/profesor/control_profesores.js"></script>