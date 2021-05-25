<script>
jQuery(document).ready(function () {
    jQuery('.grupo-cupo').keypress(function (tecla) {
        if (tecla.charCode < 48 || tecla.charCode > 57) {
            return false;
        }
    });
});
</script>

<?php

  // Clases BD, Grupo, Sesiones, Curso, Profesor, Moderador, Busqueda(Plataforma, Salón*, Calendario)
  include('../../clases/BD.php');
  include('../../clases/Busqueda.php');
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');
  include('../../clases/Curso.php');
  include('../../clases/Profesor.php');
  include('../../clases/Moderador.php');

  // Objetos
  $obj_Busqueda = new Busqueda();
  $obj_Grupo = new Grupo();

  $obj_Sesion = new Sesion();
  $obj_Curso = new Curso();
  $obj_Profesor = new Profesor();
  $obj_Moderador = new Moderador();

  //Catálogos
  $arr_Cursos = $obj_Busqueda->selectCursosActivos();
  $arr_Profesores = $obj_Profesor->buscarProfesoresActivos();
  $arr_Moderadores = $obj_Moderador->buscarModeradoresActivos();
  $arr_Plataformas = $obj_Busqueda->selectPlataformas();
  $arr_Salones = $obj_Busqueda->selectSalones();

  $Grupo = new Grupo();
  $Grupo = $obj_Grupo->grup_id_grupo = Null;
  $Grupo = $obj_Grupo->grup_num_inscritos = Null;
  
  //$obj_Calendario = $obj_Busqueda->selectCalendario();
  
  
    // Validar entidad  
    if (isset($_POST['id'])) { 

      // Recuperar información de consulta

      $Grupo = $obj_Grupo->buscarSoloGrupo($_POST['id']);
      $arr_Sesiones = $obj_Sesion->buscarSesionesIDGrupo($_POST['id']);
      $Curso1=$obj_Curso->buscarCurso($Grupo->curs_id_cursos);
  }
?>
<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-grupo" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Grupos</a>
        </li>
        <!-- Validación de la ruta -->
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 1) { ?>
        <li class="breadcrumb-item active"><i class="fas fa-edit"></i>&nbsp; Actualizar registro</li>
        <?php } elseif ($_POST['CRUD'] == 0) { ?>
        <li class="breadcrumb-item active"><i class="fas fa-search-plus"></i>&nbsp; Consultar registro</li>
        <?php } ?>
        <?php } else { ?>
        <li class="breadcrumb-item active"><i class="fas fa-folder-plus"></i>&nbsp; Nuevo registro</li>
        <?php } ?>
      </ol>
      <p>
        <hr>
      </p>

      <!-- Formulario -->
      <form name="form_grupo" id="form_grupo" method="POST">

        <!-- Desactivar formulario INICIO en caso de no ser un registro-->
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 0) { ?>
        <fieldset disabled>
          <?php } ?>
          <?php } ?>

          <!-- Inicio de Sección: Curso -->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-card fa-lg"></i>
                <b>&nbsp;&nbsp;<?php if (isset($_POST['CRUD']) == false)  echo "Selecciona un "; ?>Curso </b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-6 form-group">
                  <label for="ID_Curso"><b>Curso:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <select required='required' class="custom-select" id="ID_Curso" name="ID_Curso"
                    <?php if (isset($_POST['CRUD']) == 1) { echo "disabled";} ?>>
                    <option value="0">Seleccionar una opción</option>
                    <?php foreach ($arr_Cursos as $Curso) { ?>
                    <option value="<?php echo $Curso['curs_id_cursos']; ?>" <?php if(isset($Grupo)) { 
                      if ($Grupo->curs_id_cursos == $Curso['curs_id_cursos']) { 
                      ?> selected <?php } }?>> <?php echo ($Curso['curs_nombre']." (".$Curso['curs_tipo'].") ".$Curso['curs_nivel']); ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-lg-6 form-group">
                  <label for="strObjCurso"><b>Objetivos:</b></label>
                  <textarea type="text" class="form-control" id="strObjCurso" name="strObjCurso">
                    <?php if (isset($Grupo)) { echo $Curso1->curs_objetivos; }?>
                  </textarea>
                </div>
                <div class="col-lg-6 form-group">
                  <label for="strReqTec"><b>Requisitos Técnicos:</b></label>
                  <textarea type="text" class="form-control" id="strReqTec" name="strReqTec">
                    <?php if (isset($Grupo)) { echo $Curso1->curs_req_tecnicos; }?>
                  </textarea>
                </div>
                <div class="col-lg-6 form-group">
                  <label for="strConNeces"><b>Conocimientos Necesarios:</b></label>
                  <textarea type="text" class="form-control" id="strConNeces" name="strConNeces">
                    <?php if (isset($Grupo)) { echo $Curso1->curs_conocimientos; }?>
                  </textarea>
                </div>
              </div>
            </div>
          </div>
          <!-- Fin de Sección: Curso -->


          <!-- Inicio de Sección:  Datos del Grupo-->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-card fa-lg"></i>
                <b>&nbsp;&nbsp;Datos del Grupo</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-4 form-group" style="display: none;">
                  <label
                    for="GrupoTipo"><b>Tipo:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) { echo "*"; }?></b></label>
                  <select class="custom-select" id="GrupoTipo" name="GrupoTipo">
                    <option value="Público">Seleccione una opción</option>
                    <option value="Público"
                      <?php if(isset($Grupo) && $Grupo->grup_tipo == "Público") { echo "selected"; }?>> Público</option>
                  </select>
                </div>
                <div class="col-lg-12 form-group">
                  <label
                    for="GrupoModalidad"><b>Modalidad:<?php if (isset($_POST['CRUD']) == false) { echo "*";} ?></b></label>
                  <select required='required' class="custom-select" id="GrupoModalidad" name="GrupoModalidad"
                    <?php if (isset($_POST['CRUD']) == 1) { echo "disabled";} ?>>
                    <option value="0">Seleccione una opción</option>
                    <option value="En línea"
                      <?php if(isset($Grupo) && $Grupo->grup_modalidad == "En línea") { echo "selected"; }?>> En línea
                    </option>
                    <option value="Presencial"
                      <?php if(isset($Grupo) && $Grupo->grup_modalidad == "Presencial") { echo "selected"; }?>>
                      Presencial</option>
                  </select>
                </div>                
              </div>

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if (isset($_POST['CRUD']) ){?>
                <div class="col-lg-6 form-group">
                  <?php } else {?>
                  <div class="col-lg-4 form-group">
                    <?php } ?>
                    <label for="ID_Profesor"><b>Profesor:
                        <?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1)  { echo "*";} ?></b></label>
                    <select class="custom-select" id="ID_Profesor" name="ID_Profesor">
                      <option value="0">Seleccione una opción</option>
                      <?php foreach ($arr_Profesores as $Profesor) { ?>
                      <option value="<?php echo $Profesor['prof_id_profesor']; ?>" <?php if(isset($Grupo)) { if ($Grupo->prof_id_profesor == $Profesor['prof_id_profesor']) 
                      { ?> selected <?php }}?>>
                        <?php echo $Profesor['pers_nombre']." ".$Profesor['pers_apellido_paterno']." ".$Profesor['pers_apellido_materno']; ?>
                      </option> <?php } ?>
                    </select>
                  </div>
                <?php if (isset($_POST['CRUD']) ){?>
                  <div class="col-lg-6 form-group">
                <?php } else {?>
                  <div class="col-lg-4 form-group">
                <?php } ?>
                <label for="ID_Moderador"><b>Moderador:
                    <?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) { echo "*";}?></b></label>
                <select class="custom-select" id="ID_Moderador" name="ID_Moderador">
                  <option value="0">Seleccione una opción</option>
                  <?php foreach ($arr_Moderadores as $Moderador) { ?>
                  <option value="<?php echo $Moderador['mode_id_moderador']; ?>" <?php if(isset($Grupo)) { if ($Grupo->mode_id_moderador == $Moderador['mode_id_moderador']) 
                { ?> selected <?php }}?>>
                    <?php echo $Moderador['pers_nombre']." ".$Moderador['pers_apellido_paterno']." ".$Moderador['pers_apellido_materno']; ?>
                  </option> <?php } ?>
                </select>
              </div>
              <?php if (isset($_POST['CRUD']) ){?>
              <div class="col-lg-4 form-group" style="display: none;">
                <?php } else {?>
                <div class="col-lg-4 form-group">
                  <?php } ?>
                  <label for="ID_Status"><b>Publicado:
                      <?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) { echo "*";}?></b></label>
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="ID_Status" name="ID_Status"
                      <?php if (isset($Grupo) && $Grupo->grup_activo == 'f') { ?>
                      <?php } else { echo "checked";} ?> <?php if (isset($Grupo)) { ?>
                      onclick="Publicar(<?php echo $Grupo->grup_id_grupo ?> , '<?php echo $Grupo->grup_activo; ?>')"
                      <?php } else {?> value="true" <?php } ?>>
                    <label class="custom-control-label" for="ID_Status"></label>
                  </div>
                </div>
              </div>
            </div>
            <!-- Fin de Sección: Datos del Grupo-->


            <!-- Inicio de Sección: Limites de Inscripción  -->
            <div class="form-group">
              <div class="card lg-12">
                <div class="card-header">
                  <i class="fas fa-id-card fa-lg"></i>
                  <b>&nbsp;&nbsp;Datos sobre las Inscripciones</b>
                </div>
                <div class="col-lg-12 form-row" style="margin-top: 15px;">
                  <div class="col-lg-2 form-group">
                    <label
                      for="GrupoCupo"><b>Lugares disponibles:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) { echo "*";}?></b></label>
                    <input type="number" class="form-control grupo-cupo" id="GrupoCupo" name="GrupoCupo" placeholder="0"
                      min="0" value="<?php echo isset($Grupo)?($Grupo->grup_cupo - $Grupo->grup_num_inscritos) : "";?>">
                  </div>
                  <div class="col-lg-5 form-group">
                    <label for="GrupoInicioInscripcion"><b>Fecha de inicio de inscripciones:</b></label>
                    <input type="date" class="form-control" id="GrupoInicioInscripcion"
                      name="GrupoInicioInscripcion" placeholder="0" min="0"
                      value="<?php echo isset($Grupo)?$Grupo->grup_inicio_insc : ""; ?>">
                  </div>
                  <div class="col-lg-5 form-group">
                    <label for="GrupoFinInscripcion"><b>Última fecha de inscripciones: </b></label>
                    <input type="date" class="form-control" id="GrupoFinInscripcion" name="GrupoFinInscripcion"
                      placeholder="0" min="0" value="<?php echo isset($Grupo)?$Grupo->grup_fin_insc : ""; ?>">
                  </div>
                </div>
              </div>
            </div>
            <!-- Fin de Sección: Limites de Inscripción -->


            <!-- Inicio de Sección: Modalidad -->
            <div class="form-group">
              <div class="card lg-12">
                <div class="card-header">
                  <i class="fas fa-id-card fa-lg"></i>
                  <b>&nbsp;&nbsp; <?php echo "Datos de la Modalidad"; 
                    if (isset($Grupo->grup_modalidad)) echo ": ".$Grupo->grup_modalidad;?></b>
                </div>
                <div class="col-lg-12 form-row" style="margin-top: 15px;">
                  <!-- div de la modalidad presencial -->
                  <?php if (isset($Grupo) && $Grupo->grup_modalidad == 'Presencial') { ?>
                    <div id="Salon" class="col-lg-6 form-group">
                  <?php } else {?>
                    <div id="Salon" class="col-lg-6 form-group" style="display: none;">
                  <?php }?>
                    <label for="lbID_Salon"><b>Salon:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1)  { 
                          echo "*";} ?></b></label>
                    <select class="custom-select" id="ID_Salon" name="ID_Salon">
                      <option value="0">Seleccione una opción</option>
                      <?php foreach ($arr_Salones as $Salon) { ?>
                        <option value="<?php echo $Salon['salo_id_salon'];?>"
                          <?php if(isset($Grupo)) { if ($Grupo->salo_id_salon == $Salon['salo_id_salon']) { ?>
                          selected <?php } }?>>
                          <?php echo "Edificio: ".$Salon['edif_nombre']." Salon: ".$Salon['salo_nombre']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                    <!-- div de la modalidad en línea -->
                    <?php if (isset($Grupo) && $Grupo->grup_modalidad == 'En línea') { ?>
                    <div id="Plataforma" class="col-lg-12 form-group">
                      <?php } else if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 0){?>
                        <div id="Plataforma" class="col-lg-6 form-group">
                      <?php } else {?>
                        <div id="Plataforma" class="col-lg-6 form-group" style="display: none;">
                        <?php }?>
                        <label 
                          for="lbID_Plataforma"><b>Plataforma:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) { echo "*";}?></b></label>
                        <select class="custom-select" id="ID_Plataforma" name="ID_Plataforma">
                          <option value="0">Seleccione una opción</option>
                          <?php foreach ($arr_Plataformas as $Plataforma) { ?>
                            <option value="<?php echo $Plataforma['plat_id_plataforma'];?>"
                              <?php if(isset($Grupo)) { if ($Grupo->plat_id_plataforma == $Plataforma['plat_id_plataforma']) { ?>selected <?php } }?>>
                              <?php echo $Plataforma['plat_nombre']; ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <?php if (isset($Grupo) && $Grupo->grup_modalidad == 'En línea' && $Grupo-> grup_tipo != 'Público') { ?>
                      <div id="Acceso" class="col-lg-6 form-group">
                        <?php } else {?>
                        <div id="Acceso" class="col-lg-6 form-group" style="display: none;">
                          <?php }?>
                          <label for="lbURL_Acceso"><b>Link de
                              acceso:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) { echo "*";}?></b></label>
                          <input type="text" class="form-control" id="URL_Acceso" name="URL_Acceso"
                            value="<?php echo isset($Grupo) ? $Grupo->grup_acceso : ""; ?>">
                        </div>
                      </div>
                      <div class="col-lg-12 form-row" style="margin-top: 15px;">
                        <?php if (isset($Grupo) && $Grupo->grup_modalidad == 'En línea' && $Grupo-> grup_tipo != 'Público') { ?>
                        <div id="Reunion" class="col-lg-6 form-group">
                          <?php } else {?>
                          <div id="Reunion" class="col-lg-6 form-group" style="display: none;">
                            <?php }?>
                            <label for="lbID_Reunion"><b>ID de la
                                Reunión:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1)  { echo "*";} ?></b></label>
                            <input type="text" class="form-control" id="ID_Reunion" name="ID_Reunion" 
                              value="<?php echo isset($Grupo) ? $Grupo->grup_reunion : ""; ?>">
                          </div>
                          <?php if (isset($Grupo) && $Grupo->grup_modalidad == 'En línea' && $Grupo-> grup_tipo != 'Público') { ?>
                          <div id="Clave" class="col-lg-6 form-group">
                            <?php } else {?>
                            <div id="Clave" class="col-lg-6 form-group" style="display: none;">
                              <?php }?>
                              <label for="lbClave_Acceso"><b>Clave de
                                  Acceso:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1)  { echo "*";} ?></b></label>
                              <input type="text" class="form-control" id="Clave_Acceso" name="Clave_Acceso"
                                value="<?php echo isset($Grupo) ? $Grupo->grup_clave_acceso : ""; ?>">
                            </div>
                          </div>
                        </div>
                      </div>
            <!-- Fin de Sección: Modalidad -->

          <?php if(isset($Grupo)) {?>
          <!-- Inicio de Sección: Sesiones -->
            <?php if (isset($Grupo)) { ?>
              <div id="Sesiones" class="form-group">
            <?php } else {?>
              <div id="Sesiones" class="form-group" style="display: none;">
            <?php } 
              $i = 1; 
              foreach($arr_Sesiones as $Sesion){ 
                $idSesion = "idSesion".$i;
                $SesionFecha = "SesionFecha".$i;
                $SesionHoraInicio = "SesionHoraInicio".$i;
                $SesionHoraFin = "SesionHoraFin".$i; ?>
                <div class="card lg-12">
                  <div class="card-header">
                    <i class="fas fa-id-card fa-lg"></i>
                    <b>&nbsp;&nbsp; <?php echo "Sesión #".$i; ?></b>
                    <input type="hidden" id="<?php echo $idSesion;?>" name="idSesion[]" value="<?php echo $Sesion['sesi_id_sesiones'];?>">
                  </div>
                  <div class="col-lg-12 form-row" style="margin-top: 15px;">
                    <div id="<?php echo $SesionFecha;?>" class="col-lg-6 form-group">
                      <label
                        for="<?php echo $SesionFecha;?>"><b>Fecha:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) { echo "*";}?></b></label>
                      <input type="date" class="form-control" id="<?php echo $SesionFecha;?>"
                        name="SesionFecha[]" placeholder="0" min="0"
                        value="<?php echo isset($Sesion)?$Sesion['sesi_fecha']:""; ?>">
                    </div>
                    <div id="<?php echo $SesionHoraInicio;?>" class="col-lg-3 form-group">
                      <label
                        for="<?php echo $SesionHoraInicio;?>"><b>Hora de inicio:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) { echo "*";}; ?></b></label>
                      <input type="time" class="form-control" id="<?php echo $SesionHoraInicio;?>"
                        name="SesionHoraInicio[]>" placeholder="0" min="0"
                        value="<?php echo isset($Sesion)?$Sesion['sesi_hora_inicio']:"";?>">
                    </div>
                    <div id="<?php echo $SesionHoraFin;?>" class="col-lg-3 form-group">
                      <label
                        for="<?php echo $SesionHoraFin;?>"><b>Hora de fin:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) { echo "*";}; ?></b></label>
                      <input type="time" class="form-control" id="<?php echo $SesionHoraFin;?>"
                        name="SesionHoraFin[]>" placeholder="0" min="0"
                        value="<?php echo isset($Sesion)?$Sesion['sesi_hora_fin']:"";?>">
                    </div>
                  </div>
                </div>
          <?php $i++; } ?>
        </div>
        <!-- Fin de Sección: Sesiones -->
        <?php } else { ?>
          <section id="contenedorSesiones">



          </section>
        <?php } ?>

        <!-- Desactivar formulario FIN -->
        <?php if (isset($_POST['CRUD']) && $_POST['CRUD'] == 0) { ?>
            </fieldset>
        <?php } ?>

        <!-- ID e Instrucciones -->
        <?php if (isset($_POST['CRUD'])) { ?>
          <?php if ($_POST['CRUD'] == 1) { ?>
            <input type="hidden" name="dml" value="update" />
            <input type="hidden" id="idGrupo" name="idGrupo" value="<?php echo $_POST['id'];?>">
            <input type="hidden" id="ifModalidad" name="ifModalidad" value="<?php echo $Grupo->grup_modalidad;?>">
          <?php } elseif ($_POST['CRUD'] == 0) { ?>
            <input type="hidden" name="dml" value="select" />
          <?php } ?>
        <?php } else { ?>
          <input type="hidden" name="dml" value="insert" />
        <?php } ?>

      </form>
    </div>
    <!-- Botones -->
    <div class="col-lg-12" style="text-align: center;">
      <button id="btn-regresar-grupo" type="button" class="btn btn-primary btn-footer btn-regresar">Regresar</button>
      <?php if (isset($_POST['CRUD'])) { ?>
      <?php if ($_POST['CRUD'] == 0) { ?>
      <!-- TODO: Revisar la ruta que tiene el Href -->
      <a id="temarioDW" href="<?php echo isset($curso) ? $curso -> curs_temario : "No subido"; ?>" download
          class="btn btn-descarga" role="button"><i class="fas fa-file-download"
            style="padding-right: 10px;"></i>Descargar temario</a>
      <button id="btn-inscripcion-grupo" type="button" class="btn btn-success btn-footer btn-aceptar">Inscribirse</button>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>
</div>



<script src="../sistema/profesor/control_profesores.js"></script>