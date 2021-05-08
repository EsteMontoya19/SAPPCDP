<?php

  // Clases BD, Grupo, Sesiones, Curso, Profesor, Moderador, Busqueda(Plataforma, Salón*, Calendario)
  include('../../clases/BD.php');
  include('../../clases/Busqueda.php');
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');
  include('../../clases/Curso.php');
  include('../../clases/Profesor.php');
  include('../../clases/Moderador.php');
   
  // Catálogos
  $obj_Busqueda = new Busqueda();
  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Curso = new Curso();
  $arr_Cursos = $obj_Busqueda->selectCursos();
  $obj_Profesor = new Profesor();
  $arr_Profesores = $obj_Profesor->buscarProfesoresActivos();
  $obj_Moderador = new Moderador();
  $arr_Moderadores = $obj_Moderador->buscarModeradoresActivos();
  $arr_Plataformas = $obj_Busqueda->selectPlataformas();
  $arr_Salones = $obj_Busqueda->selectSalones();

  $Grupo = new Grupo();
  $Grupo = $obj_Grupo->grup_id_grupo = Null;
  
  //$obj_Calendario = $obj_Busqueda->selectCalendario();
  
  
    // Validar entidad  
    if (isset($_POST['id'])) { 

      // Recuperar información de consulta

      $Grupo = $obj_Grupo->buscarGrupo($_POST['id']);
      //$Curso=$obj_Curso->buscarCurso($Grupo->curs_id_cursos);
  }
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-curso" class="breadcrumb-item">
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
      <form name="form_usuario" id="form_usuario" method="POST">

        <!-- Desactivar formulario INICIO en caso de no ser un registro-->
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 0) { ?>
        <fieldset disabled>
          <?php } ?>
          <?php } ?>

          <!-- Datos generales -->
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-card fa-lg"></i>
                <b>&nbsp;&nbsp;<?php if (isset($_POST['CRUD']) == false)  echo "Selecciona un "; ?>Curso</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-6 form-group">
                  <label for="ID_Curso"><b>Curso:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <select class="custom-select" id="ID_Curso" name="ID_Curso">
                    <option value="0">Seleccionar una opción</option>
                    <?php foreach ($arr_Cursos as $Curso) { ?>
                    <option value="<?php echo $Curso['curs_id_cursos']; ?>"
                      <?php if(isset($Grupo)) { if ($Grupo->curs_id_cursos == $Curso['curs_id_cursos']) { ?> selected
                      <?php } }?>>
                      <?php echo $Curso['curs_nombre']; ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-card fa-lg"></i>
                <b>&nbsp;&nbsp;Datos del Grupo</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-4 form-group">
                  <label for="lbGrupoTipo"><b>Tipo:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                    <select class="custom-select" id="GrupoTipo" name="GrupoTipo">
                      <option value="0">Seleccione una opción</option>
                      <option value="Público" <?php if(isset($Grupo)) {
                        if($Grupo['grup_tipo'] == 'Público') {
                          //? Puede ser el string o el value
                          echo (selected); 
                        }
                      } ?>>Público</option>
                      <option value="Privado" <?php if(isset($Grupo)) {
                        if($Grupo['grup_tipo'] == 'Privado') {
                          //? Puede ser el string o el value
                          echo (selected); 
                        }
                      } ?>>Privado</option>
                  </select>
                </div>
                <div class="col-lg-4 form-group">
                  <label for="lbGrupoModalidad"><b>Modalidad:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                    <select required='required' class="custom-select" id="GrupoModalidad" name="GrupoModalidad">
                      <option value="0">Seleccione una opción</option>
                      <option value="En línea" <?php if(isset($Grupo)) {
                        if($Grupo['grup_modalidad'] == 'En línea') {
                          //? Puede ser el string o el value
                          echo (selected); 
                        }
                      } ?>> En línea </option>
                      <option value="Presencial" <?php if(isset($Grupo)) {
                        if($Grupo['grup_modalidad'] == 'Presencial') {
                          //? Puede ser el string o el value
                          echo (selected); 
                        }
                      } ?>>Presencial</option>  
                    </select>
                </div>
                <div class="col-lg-4 form-group">
                  <label for="GrupoEstatus"><b>Estatus:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                    <select class="custom-select" id="GrupoEstatus" name="GrupoEstatus">
                      <option value="0">Seleccione una opción</option>
                      <option value="Aprobado" <?php if(isset($Grupo)) {
                        if($Grupo['grup_estado'] == 'Aprobado') {
                          //? Puede ser el string o el value
                          echo (selected); 
                        }
                      } ?>>Aprobado</option>
                      <option value="Pendiente" <?php if(isset($Grupo)) {
                        if($Grupo['grup_estado'] == 'Pendiente') {
                          //? Puede ser el string o el value
                          echo (selected); 
                        }
                      } ?>>Pendiente</option>
                      <option value="Rechazado" <?php if(isset($Grupo)) {
                        if($Grupo['grup_estado'] == 'Rechazado') {
                          //? Puede ser el string o el value
                          echo (selected); 
                        }
                      } ?>>Rechazado</option>
                  </select>
                </div>
            </div>
            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <div class="col-lg-6 form-group">
                <label for="ID_Moderador"><b>Moderador: <?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                <select class="custom-select" id="ID_Moderador" name="ID_Moderador">
                <option value="0">Seleccionar una opción</option>
                    <?php foreach ($arr_Moderadores as $Moderador) { ?>
                <option value="<?php echo $Moderador['mode_id_moderador']; ?>"
                    <?php if(isset($Grupo)) { if ($Grupo->mode_id_moderador == $Moderador['mode_id_moderador']) 
                            { ?> selected <?php }}?>
                        ><?php echo $Moderador['pers_nombre'].$Moderador['pers_apellido_paterno'].$Moderador['pers_apellido_materno']; ?> 
                </option> <?php } ?>
                  </select>
                </div>
                <div class="col-lg-6 form-group">
                  <label for="ID_Profesor"><b>Profesor: <?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                    <select class="custom-select" id="ID_Profesor" name="ID_Profesor">
                      <option value="0">Seleccione una opción</option>  
                        <?php foreach ($arr_Profesores as $Profesor) { ?>
                      <option value="<?php echo $Profesor['prof_id_profesor']; ?>"
                        <?php if(isset($Grupo)) { if ($Grupo->prof_id_profesor == $Profesor['prof_id_profesor']) 
                            { ?> selected <?php }}?>
                        ><?php echo $Profesor['pers_nombre'].$Profesor['pers_apellido_paterno'].$Profesor['pers_apellido_materno']; ?> 
                        </option> <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-card fa-lg"></i>
                <b>&nbsp;&nbsp;Datos sobre las Inscripciones</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-2 form-group">
                  <label for="GrupoCupo"><b>Cupo:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                    <input type="number" class="form-control" id="GrupoCupo" name="GrupoCupo"
                    placeholder="0" min="0" value="<?php echo isset($Grupo)?$Grupo->grup_cupo : ""; ?>">
                </div>
                <div class="col-lg-5 form-group">
                  <label for="GrupoInicioInscripcion"><b>Iniciar Inscripciones en la Fecha:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                    <input type="date" class="form-control" id="GrupoInicioInscripcion" name="GrupoInicioInscripcion"
                    placeholder="0" min="0" value="<?php echo isset($Grupo)?$Grupo->grup_inicio_insc : ""; ?>">
                </div>
                <div class="col-lg-5 form-group">
                  <label for="GrupoFinInscripcion"><b>Finalizar Inscripciones en la Fecha:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                    <input type="date" class="form-control" id="GrupoFinInscripcion" name="GrupoFinInscripcion"
                    placeholder="0" min="0" value="<?php isset($Grupo)?$Grupo->grup_fin_insc : ""; ?>">
                </div>
              </div>
            </div>
          </div>
          <!-- Formulario Modalidad-->
          
          
          
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-card fa-lg"></i>
                  <b>&nbsp;&nbsp; Modalidad <?php if (isset($Grupo) && $Grupo->grup_id_grupo == 'En línea')  { echo "en línea";} 
                  elseif (isset($Grupo) && $Grupo->grup_id_grupo == 'En línea')  {echo "presencial";} else { echo "";} ?></b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <?php if (isset($Grupo) && $Grupo->grup_modalidad == 'En línea') { ?>
                <div id="ID_Plataforma" class="col-lg-6 form-group"> 
                <?php } else {?> 
                  <div id="ID_Plataforma" class="col-lg-6 form-group" style="display: none;">
                <?php }?>
                  <label for="lbID_Plataforma"><b>Plataforma:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <select class="custom-select" id="ID_Plataforma" name="ID_Plataforma">
                    <option value="0">Seleccione una opción</option>  
                    <?php foreach ($arr_Plataformas as $Plataforma) { ?>
                    <option value="<?php echo $Plataforma['plat_id_plataforma'];?>"
                      <?php if(isset($Grupo)) { if ($Grupo->plat_id_plataforma == $Plataforma['plat_id_plataforma']) { ?> 
                      selected
                      <?php } }?>>
                      <?php echo $Plataforma['plat_nombre']; ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-lg-5 form-group">
                <label for="lbURL_Acceso"><b>Link de acceso:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <input type="text" class="form-control" id="URL_Acceso" name="URL_Acceso"
                    value="<?php echo isset($Grupo) ? $Grupo->grup_acceso : ""; ?>">
                </div>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-6 form-group">
                  <label for="lbID_Reunion"><b>ID de la Renunón:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <input type="text" class="form-control" id="ID_Reunion" name="ID_Reunion"
                    value="<?php echo isset($Grupo) ? $Grupo->grup_reunion : ""; ?>">
                </div>
                <div class="col-lg-5 form-group">
                  <label for="lbClave_Acceso"><b>Clave de Acceso:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                  <input type="text" class="form-control" id="Clave_Acceso" name="Clave_Acceso"
                    value="<?php echo isset($Grupo) ? $Grupo->grup_clave_acceso : ""; ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-id-card fa-lg"></i>
                <b>&nbsp;&nbsp; Sesión #</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-6 form-group">
                  <label for="SesionFecha"><b>Fecha:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                    <input type="date" class="form-control" id="SesionFecha" name="SesionFecha"
                    placeholder="0" min="0" value="<?php echo isset($sesion)?$sesion->sesi_fecha:""; ?>">
                </div>
                <div class="col-lg-5 form-group">
                  <label for="SesionHora"><b>Iniciar Inscripciones en la Fecha:<?php if (isset($_POST['CRUD']) == false)  echo "*"; ?></b></label>
                    <input type="time" class="form-control" id="SesionHora" name="SesionHora"
                    placeholder="0" min="0" value="<?php echo isset($sesion)?$sesion->sesi_hora:""; ?>">
              </div>
            </div>
          </div>


        <!-- Desactivar formulario FIN -->
        <?php if (isset($_POST['CRUD']) && $_POST['CRUD'] == 0) { ?>
          </fieldset>
        <?php } ?>

      </form>
    </div>  
        <!-- Botones -->
        <div class="col-lg-12" style="text-align: center;">
          <button id="btn-regresar-grupo" type="button" class="btn btn-primary btn-footer">Regresar</button>
          <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 1) { ?>
              <button id="btn-actualizar-grupo" type="button" class="btn btn-success btn-footer">Actualizar</button>            
            <?php } ?>
          <?php } else { ?>
            <button id="btn-registar-grupo" type="button" class="btn btn-success btn-footer">Guardar</button>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>



<script src="../sistema/grupos/control_grupos.js"></script>