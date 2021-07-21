<?php
  include('../../clases/BD.php');
  include('../../clases/Busqueda.php');
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');
  include('../../clases/Asistencia.php');

  include('../../clases/Curso.php');
  include('../../clases/Instructor.php');
  include('../../clases/Moderador.php');

  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Asistencia = new Asistencia();


  $grupo = $obj_Grupo->buscarGrupoCompleto($_POST['grupo']);
  $sesiones = $obj_Sesion->buscarSesionesIDGrupo($_POST['grupo']); 
  $inscritos = $obj_Grupo->buscarCorreosDeParticipantes($_POST['grupo']); 

?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-cursos" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Lista/ Asitencia</a>
        </li>
      </ol>
      <p>
        <hr>
      </p>

      <?php 
        if (isset($_POST['moderador'])) {
          echo ('<p class = "aviso-amarillo">Recuerde que unicamente el Coordinador y el Instructor del curso pueden modificar asistencias de sesiones pasadas.</p>');
        }
      ?>
      <!-- Formulario -->
      <form name="form_asistencia" id="form_asistencia" method="POST">
        <?php //? Se necesita saber estos datos para registrar las asistencias ?>
        <input type="hidden" id = "idGrupo" name = "idGrupo" value = "<?php echo($grupo->grup_id_grupo); ?>">
      <div class="card mb-3">
        <div class="form-group">
          <!-- Datos generales -->
          <div class="card lg-12" style="padding: 15px;">
            <div class="col-lg-12 form-row">

              <div class="col-lg-4 form-group">
                <p><b>Nombre del curso: </b> <?php echo($grupo->curs_nombre); ?></p>
              </div>
              
              <div class="col-lg-4 form-group">
                <p><b>Nombre del Instructor: </b>
                  <?php echo($grupo->pers_nombre . " " . $grupo->pers_apellido_paterno . " " . $grupo-> pers_apellido_materno); ?>
                </p>
              </div>

              <div class="col-lg-4 form-group">
                <p><b>Moderador: </b> <?php 
                                        if ($grupo->moderador != "") {
                                          echo($grupo->moderador); 
                                        } else { 
                                          echo("No asignado."); 
                                        }?></p>
              </div>

              <div class="col-lg-4 form-group">
                <p><b><?php 
                    if($grupo->moap_id_modalidad == 1 ) {
                      echo("Salón: </b>".$grupo->salo_nombre);
                    } elseif ($grupo->moap_id_modalidad == 2 || $grupo->moap_id_modalidad == 3) {
                      echo("Enlace: </b><a href target = '_blank'>".$grupo->grup_url."</a>"); 

                    }?></p>
              </div>

              <?php if ($grupo->moap_id_modalidad == 2) {?>
              <div class="col-lg-4 form-group">
                <p><b>ID: </b> <?php if ($grupo->grup_id_acceso != "") { 
                                    echo($grupo->grup_id_acceso); 
                                  } else {
                                    echo("No registrado");} ?></p>
                </p>
              </div>
              <?php }?>

              <?php if ($grupo->moap_id_modalidad == 2) {?>
              <div class="col-lg-4 form-group">
                <p><b>Código: </b><?php if ($grupo->grup_clave_acceso != "") { 
                                    echo($grupo->grup_clave_acceso); 
                                  } else {
                                    echo("No registrado");} ?></p>
              </div>
              <?php }?>

              <div class="col-lg-4 form-group">
                <p><b>Número de inscritos: </b><?php echo($grupo->grup_num_inscritos); ?></p>

              </div>

              <div class="col-lg-4 form-group">
                <p><b>Número de sesiones: </b><?php echo($grupo->num_sesiones); ?></p>
              </div>

              <div class="col-lg-4 form-group">
                <p><b>Modalidad: </b><?php echo($grupo->moap_nombre); ?></p>
              </div>
      
              
              <!-- Aqui estaba la tabla -->
            </div>
          </div>
        </div>
        
        
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-condensed table-hover" id="tabla_asistencia" width="100%" cellspacing="0">
              <thead class="thead-dark"> 
                <tr>
                  <th>ID</th>
                  <th>Nombre del alumno</th>
                  <?php
                    foreach ($sesiones as $key => $valor) { 
                      $key = $key + 1;
                      echo ("<th> Sesión ".$key.":<br>".$valor['sesi_fecha']."</th>");   
                    }
                  ?>
                </tr>
              </thead>
              <tbody>
                <?php 
                if (isset($inscritos)) {
                  foreach ($inscritos as $inscrito) { ?>
                    <tr>
                      <td><?php echo($inscrito['prof_id_profesor']); ?></td>
                      <td><?php echo($inscrito['nombre']); ?></td>
                      <?php
                        foreach ($sesiones as $iCont => $sesion) {  ?>
                        <td>
                          <input type="checkbox" class="form-check-input" 
                            id= "<?php echo($inscrito['insc_id_inscripcion']); ?>_asistencia_<?php echo($iCont + 1);?>" 
                            name= "<?php echo($inscrito['insc_id_inscripcion']); ?>_asistencia_<?php echo($iCont + 1);?>"
                            value="TRUE" 
                            <?php 
                              $asistencia = $obj_Asistencia->buscarAsistenciaSesion($sesion['sesi_id_sesiones'],$inscrito['insc_id_inscripcion']);
                              if (isset ($asistencia) ) {
                                //? Si estuvo presente marcamos la casilla sino, se queda desactivada
                                if ($asistencia->asis_presente == "t") {
                                  echo (" checked");
                                }
                              
                                //? Si es en un futuro
                                if ($sesion['sesi_fecha'] >  date("Y")."-".date("m")."-".date("d") ) {
                                  echo (' disabled');
                                }
                                
                                //? Si viene de moderador no puede cambiar registros historicos
                                if (isset($_POST['moderador'])) {
                                  //? Si ya paso el dia de la asistencia
                                  if ($sesion['sesi_fecha'] <  date("Y")."-".date("m")."-".date("d") ) {
                                    echo (' class = "disabled" readonly="readonly" onclick="javascript: return false;"');
                                  }
                                }
                              }
                              //TODO: Aqui se pueden validar que las asistencias no se tomen en un futuro
                              
                            ?> >
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?>

                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </form>

        <!-- Botones -->
        <div class="col-lg-12" style="text-align: center;">
          <button id = "btn-regresar" type="button" class="btn btn-success btn-footer">Regresar</button>
          <button id = "btn-registrar-asistencia" type="button" class="btn btn-success btn-footer">Guardar</button>
        </div>
    </div>
  </div>
</div>

<script src="../sistema/asistencia/control_asistencias.js"></script>