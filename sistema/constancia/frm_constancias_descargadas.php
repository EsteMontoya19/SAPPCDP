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
      <form name="form_constancias_ds" id="form_constancias_ds" method="POST" enctype="multipart/form-data" action 
        action="../modulos/Control_Constancia.php">
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

            </div><hr><br>

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
                </tr>
              </thead>
              <tbody>
                <?php
                if (isset($inscritos)) { 
                    foreach ($inscritos as $inscrito) { ?>
                    <tr>
                      <td><?php echo($inscrito["prof_id_profesor"]); ?></td>
                      <td><?php echo($inscrito["nombre"]); ?></td>
                      <td>
                        <?php 
                        $merece_Constancia = "t";
                        foreach($sesiones as $iCont => $sesion) { 
                          $asistencia = $obj_Asistencia->buscarAsistenciaSesion($sesion["sesi_id_sesion"], $inscrito["insc_id_inscripcion"]);
                          if(isset($asistencia)){
                            if($asistencia->asis_presente == "f"){
                              $merece_Constancia = "f";
                            }
                          }
                        }
                        $constancia_Descargada = $obj_Busqueda->selectConstanciaID($inscrito["insc_id_constancia"]);
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
                    </tr>
                    <?php } ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card lg-12">
        <div class="card-header">
          <i class="fas fa-id-card fa-lg"></i>
          <b>&nbsp; Cargar constancia del Alumno: </b>
        </div>
        <div class="col-lg-12 form-row">
          <div class="col-lg-6 form-group">
            <label><b>Seleccione el profesor al que le desea asignar la constancia: *</b></label>
            <select required='required' class="custom-select" id="ID_profesor_constancia" name="ID_profesor_constancia">
              <option value="0">Seleccionar una opción</option>
              <?php foreach ($inscritos as $inscrito) { ?>
              <option value="<?php echo $inscrito['insc_id_constancia']; ?>"> 
                <?php echo ($inscrito['prof_id_profesor'].".- ".$inscrito['nombre']); ?>
              </option>
              <?php } ?>
            </select>
          </div>
          <div class="col-lg-6 form-group">
            <label for="constanciaProfesor"><b>Seleccione el archivo pdf de la constancia del profesor: *</b></label>
            <div class="custom-file">
                <input type="file" id="constanciaProfesor" name="constanciaProfesor"  class="custom-file-input" accept="application/pdf" required>
                <label class="custom-file-label" for="constanciaProfesor"></label>
            </div>
          </div>
        </div>
      </div>

      <div class="card lg-12">
        <div class="card-header">
          <i class="fas fa-id-card fa-lg"></i>
          <b>&nbsp; Cargar constancia del Instructor: <?php echo($grupo->pers_nombre . " " . $grupo->pers_apellido_paterno . " " . $grupo-> pers_apellido_materno); ?></b>
        </div>

        <div class="col-lg-6 form-group">
          <label for="constanciaInstructor"><b>Seleccione el archivo pdf de la constancia del instructor: *</b></label>
          <div class="custom-file">
              <input type="file" id="constanciaInstructor" name="constanciaInstructor"  class="custom-file-input" accept="application/pdf" required>
              <label class="custom-file-label" for="constanciaInstructor"></label>
          </div>
        </div>
      </div>  

      <?php if($grupo->moderador != '') { ?>
      <div class="card lg-12">
        <div class="card-header">
          <i class="fas fa-id-card fa-lg"></i>
          <b>&nbsp; Cargar constancia de Moderador: <?php
                  if ($grupo->moderador != "") {
                      echo($grupo->moderador);
                  } else {
                      echo("No asignado.");
                  }?></b>
        </div>
        
        <div class="col-lg-6 form-group">
          <label for="constanciaModerador"><b>Seleccione el archivo pdf de la constancia de la constancia del moderador: *</b></label>
          <div class="custom-file">
              <input type="file" id="constanciaModerador" name="constanciaModerador"  class="custom-file-input" accept="application/pdf" required>
              <label class="custom-file-label" for="constanciaModerador"></label>
          </div>
        </div>
      </div>
      <?php } ?>
      

        <!-- Botones -->
        <input type="hidden" name="dml" value="insertConstanciaManual" />
        <input type="hidden" name="idGrupo" value="<?php echo $grupo->grup_id_grupo; ?>"/>

        <div class="col-lg-12" style="text-align: center;">
          <button id="btn-regresar-constancia" type="button" class="btn btn-secondary btn-footer btn-regresar">Regresar</button>
          <button id="btn-registrar-constancia-manual" type="button" form="form_constancias_ds"
            class="btn btn-success btn-footer btn-aceptar">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="../sistema/constancia/control_constancias.js"></script>
