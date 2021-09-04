<?php
  include("../../clases/BD.php");
  include("../../clases/Busqueda.php");
  include("../../clases/Grupo.php");
  include("../../clases/Sesion.php");
  include("../../clases/Asistencia.php");

  include("../../clases/Curso.php");
  include("../../clases/Instructor.php");
  include("../../clases/Moderador.php");

  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Asistencia = new Asistencia();
  $obj_Busqueda = new Busqueda();

  $grupo = $obj_Grupo->buscarGrupoCompleto($_POST["grupo"]);
  $sesiones = $obj_Sesion->buscarSesionesIDGrupo($_POST["grupo"]);
  $inscritos = $obj_Grupo->buscarCorreosDeParticipantes($_POST["grupo"]);
  $datosInstructor = $obj_Grupo->buscarDatosInstructorGrupo(($_POST["grupo"]));

?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-cursos" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Lista/ Constancias Descargadas</a>
        </li>
      </ol>
      <p>
        <hr>
      </p>

      
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
                <p><b>ID del grupo: </b> <?php echo($grupo->grup_id_grupo); ?></p>
              </div>

              <div class="col-lg-4 form-group">
                <p><b>Nombre del curso: </b> <?php echo($grupo->curs_nombre); ?></p>
              </div>
              
              <div class="col-lg-4 form-group">
                <p><b>Nombre del Instructor: </b>
                  <?php echo($grupo->pers_nombre . " " . $grupo->pers_apellido_paterno . " " . $grupo-> pers_apellido_materno); ?>
                </p>
              </div>
            </div>

          <div class="col-lg-12 form-row">
            <div class="col-lg-4 form-group">
                <p><b>Moderador: </b> <?php
                if ($grupo->moderador != "") {
                    echo($grupo->moderador);
                } else {
                    echo("No asignado.");
                }?></p>
            </div>

            <div class="col-lg-8 form-group">
                <p><b>Semblanza del instructor: </b><br><?php if(isset($datosInstructor->prof_semblanza)) { echo($datosInstructor->prof_semblanza); } else {echo("Sin semblanza registrada por el instructor.");}?></p>
            </div>
          </div><hr><br>

            <div class="col-lg-12 form-row">
              <div class="col-lg-4 form-group">
                <p><b><?php
                if ($grupo->moap_id_modalidad == 1) {
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
                                   echo("No registrado");
                               } ?></p>
                </p>
              </div>
              <?php }?>

              <?php if ($grupo->moap_id_modalidad == 2) {?>
              <div class="col-lg-4 form-group">
                <p><b>Código: </b><?php if ($grupo->grup_clave_acceso != "") {
                                    echo($grupo->grup_clave_acceso);
                                  } else {
                                      echo("No registrado");
                                  } ?></p>
              </div>
              <?php }?>
            </div>

            <div class="col-lg-12 form-row">
              <div class="col-lg-4 form-group">
                <p><b>Número de inscritos: </b><?php echo($grupo->grup_num_inscritos); ?></p>

              </div>

              <div class="col-lg-4 form-group">
                <p><b>Número de sesiones: </b><?php echo($grupo->num_sesiones); ?></p>
              </div>

              <div class="col-lg-4 form-group">
                <p><b>Modalidad: </b><?php echo($grupo->moap_nombre); ?></p>
              </div>
            </div>
      
              
              <!-- Aqui estaba la tabla -->
          </div>
        </div>
        
        
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-condensed table-hover" id="tabla_asistencia" width="100%" cellspacing="0">
              <thead class="thead-dark"> 
                <tr>
                  <th>ID</th>
                  <th>Nombre del alumno</th>
                  <th>Estado Constancia</th>
                  <th>Descargada</th>
                  <th>Observaciones</th>
                  <th>Asignar Constancia</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($inscritos)) { $contador = 1;
                    foreach ($inscritos as $inscrito) { ?>
                    <tr>
                      <td><?php echo($inscrito["prof_id_profesor"]); ?></td>
                      <td><?php echo($inscrito["nombre"]); ?></td>
                      <td>
                        <?php 
                        $merece_Constancia = "t";
                        foreach($sesiones as $iCont => $sesion) { 
                          $asistencia = $obj_Asistencia->buscarAsistenciaSesion($sesion["sesi_id_sesiones"], $inscrito["insc_id_inscripcion"]);
                          if(isset($asistencia)){
                            if($asistencia->asis_presente == "f"){
                              $merece_Constancia = "f";
                            }
                          }
                        }
                        $constancia_Descargada = $obj_Busqueda->selectConstanciaID($inscrito["cons_id_constancias"]);
                        if(isset($constancia_Descargada)){
                          if ($merece_Constancia == "f"){
                            echo ("<p class = aviso-rojo>No Aplica, no acreedor</p>");
                          } else {
                            if($constancia_Descargada->cons_estado == "Disponible"){
                              echo ("<p class = aviso-azul>Disponible para descarga</p>");
                            } else {
                            echo $constancia_Descargada->cons_estado;
                            }
                          }
                        }
                        ?>
                      </td>
                      <td>
                        <input type="checkbox" class="form-check-input"
                          id="consDescargada" name="consDescargada" value="TRUE" 
                            <?php if ($merece_Constancia == "f") { echo (" unchecked disabled"); } else {
                            if(isset($constancia_Descargada) && $constancia_Descargada->cons_descargada == "t") { 
                              echo (" checked"); 
                            } else { 
                              echo (" unchecked disabled"); 
                            } }?> readonly="readonly" onclick="javascript: return false;">
                      </td>
                      <td><textarea disabled class="observaciones" id="observacion_<?php echo($inscrito["insc_id_inscripcion"]); ?>" name="observacion_<?php echo($inscrito["insc_id_inscripcion"]); ?>" rows="2"><?php echo($inscrito["insc_observacion"]); ?></textarea></td>
                      <td>
                        <div class="custom-file">
                          <input type="file" id="asignarConstancia<?php echo($contador) ?>" name="asignarConstancia<?php echo($contador) ?>" class="custom-file-input" accept="application/pdf"
                            <?php echo !isset($curso) ? "require": ""; ?> required>
                          <label class="custom-file-label"
                            for="asignarConstancia<?php echo($contador) ?>"><?php echo isset($curso) ? $curso -> curs_temario: ""; ?></label>
                        </div>
                      </td>
                    </tr>
                    <?php $contador += 1;} ?>
                <?php } ?>
              </tbody>
            </table
          </div>
        </div>
      </div>
      </form>

        <!-- Botones -->
        <div class="col-lg-12" style="text-align: center;">
          <button id = "btn-regresar-constancia" type="button" class="btn btn-success btn-footer">Aceptar</button>
        </div>
    </div>
  </div>
</div>

<script src="../sistema/asistencia/control_asistencias.js"></script>
