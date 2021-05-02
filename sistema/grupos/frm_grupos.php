<?php
  include('../../clases/BD.php');
  include('../../clases/Busqueda.php');
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');
  include('../../clases/Periodo.php');
  include('../../clases/Moderador.php');
  include('../../clases/Profesor.php');


  $obj_Busqueda = new Busqueda();
  $arr_Cursos = $obj_Busqueda->selectCursos();
  $arr_Plataformas = $obj_Busqueda->selectPlataformas();
  $obj_Moderador = new Moderador();
  $arr_Moderadores = $obj_Moderador->buscarModeradoresActivos();
  $obj_Profesor = new Profesor();
  $arr_Profesores = $obj_Profesor->buscarProfesoresActivos();
  $objeto_Sesion= new Sesion();
  
  if (isset($_POST['id'])) {

    $obj_Grupo = new Grupo();
    $tipo_evento = $obj_Grupo->buscarTipoEvento($_POST['id']);
    
    if ($tipo_evento->even_id_tiev == 4) {

      $grupo = $obj_Grupo->buscarGrupoWeb($_POST['id']);

    

      $obj_Horario = new Horario();
      $horario_web = $obj_Horario->buscarHorarioWeb($_POST['id']);

      $obj_Periodo = new Periodo();
      $periodoIns = $obj_Periodo->buscarPeriodoIns($_POST['id']);
      $periodoWeb = $obj_Periodo->buscarPeriodoWeb($_POST['id']);

    } else {
      $grupo = $obj_Grupo->buscarGrupo($_POST['id']);

      $obj_Horario = new Horario();
      $arr_horarios = $obj_Horario->buscarTodosHorarios($_POST['id']);

      $obj_Periodo = new Periodo();
      $periodoIns = $obj_Periodo->buscarPeriodoIns($_POST['id']);
      $periodoCur = $obj_Periodo->buscarPeriodoCur($_POST['id']);
    }
  }

  $i = 0;
  $i_pon = 0;

?>

  <div id="wrapper">
    <div id="content-wrapper">
      <div class="container-fluid">
        <ol class="breadcrumb">
          <li id="btn-inicio-grupo" class="breadcrumb-item">
            <a href="#"><i class="fas fa-users"></i>&nbsp; Grupos</a>
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

        <form name="frm_registro_grupo" id="formAjaxGrupo" method="POST">

        <!-- Desactivar formulario INICIO -->
        <?php if (isset($_POST['CRUD']) && $_POST['CRUD'] == 0) { ?>
          <fieldset disabled>
        <?php } ?>

          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-chalkboard fa-lg" style="color:orange"></i>
                <b style="color:orange">&nbsp;Selecciona un Curso</b>
              </div>
            <div class="col-lg-12 form-row" style="margin-top: 20px;">    
            <div class="col-lg-4 form-group">
              <label for="ID_Curso" style="color:#0C4590"><b>Cursos: *</b></label>
              <select class="custom-select" id="ID_Curso" name="ID_Curso">
                <option value="0">Seleccione una opción</option>
                <?php foreach ($arr_Cursos as $Cursos) { ?>
                <option value="<?php echo $Cursos['curs_id_cursos'];?>"><?php echo $Cursos['curs_nombre'];?>
                </option><?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-chalkboard fa-lg" style="color:orange"></i>
                <b style="color:orange">&nbsp;Datos generales</b>
              </div>
            </div>
            <div class="col-lg-12 form-row" style="margin-top: 20px;">
              <div class="col-lg-4 form-group">
                  <label for="GrupoTipo" style="color:#0C4590"><b>Tipo: *</b></label>
                  <select class="custom-select" id="GrupoTipo" name="GrupoTipo">
                      <option value="0">Seleccione una opción</option>
                      <option value="Público">Público</option>
                      <option value="Privado">Privado</option>
                  </select>
              </div>
              <div class="col-lg-4 form-group">
                <label for="GrupoModalidad" style="color:#0C4590"><b>Modalidad: *</b></label>
                <select class="custom-select" id="GrupoModalidad" name="GrupoModalidad">
                    <option value="0">Seleccione una opción</option>
                    <option value="En línea">En línea</option>
                    <option value="Presencial">Presencial</option>
                </select>
              </div>
              <div class="col-lg-4 form-group">
                <label for="GrupoEstatus" style="color:#0C4590"><b>Estatus del grupo: *</b></label>
                <select class="custom-select" id="GrupoEstatus" name="GrupoEstatus">
                    <option value="0">Seleccione una opción</option>
                    <option value="1">Aprobado</option>
                    <option value="2">Pendiente</option>
                    <option value="3">Rechazado</option>
                </select>
              </div>
            </div>
            <div class="col-lg-12 form-row" style="margin-top: 20px;">
              <div class="col-lg-6 form-group">
                <label for="ID_Moderador" style="color:#0C4590"><b>Moderador: *</b></label>
                <select class="custom-select" id="ID_Moderador" name="ID_Moderador">
                  <option value="0">Seleccione una opción</option>
                  <?php foreach ($arr_Moderadores as $Moderadores) { ?>
                  <option value="<?php echo $Moderadores['mode_id_moderador'];?>"><?php echo $Moderadores['pers_nombre'].$Moderadores['pers_apellido_paterno'].$Moderadores['pers_apellido_materno'];?>
                  </option><?php } ?>
                </select>
              </div>
              <div class="col-lg-6 form-group">
                <label for="ID_Profesor" style="color:#0C4590"><b>Profesor: *</b></label>
                <select class="custom-select" id="ID_Profesor" name="ID_Profesor">
                  <option value="0">Seleccione una opción</option>
                  <?php foreach ($arr_Profesores as $Profesores) { ?>
                  <option value="<?php echo $Profesores['prof_id_profesor'];?>"><?php echo $Profesores['pers_nombre'].$Profesores['pers_apellido_paterno'].$Profesores['pers_apellido_materno'];?>
                  </option><?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="card lg-12">
            <div class="card-header">
              <i class="fas fa-chalkboard fa-lg" style="color:orange"></i>
              <b style="color:orange">&nbsp;Inscripciones</b>
            </div>
          </div>     
          <div class="col-lg-12 form-row" style="margin-top: 20px;">
            <div class="col-lg-2 form-group">
              <label for="GrupoCupo" style="color:#0C4590"><b>Cupo: *</b></label>
              <input type="number" class="form-control" id="GrupoCupo" name="GrupoCupo" placeholder="0" min="0" value="<?php echo isset($grupo)?$grupo->grup_cupo:"";?>">
            </div>
            <div class="col-lg-5 form-group">
              <label for="GrupoInicioInscripcion" style="color:#0C4590"><b>Iniciar Inscripciones en la Fecha:</b></label>
              <input type="date" class="form-control" id="GrupoInicioInscripcion" name="GrupoInicioInscripcion" placeholder="0" min="0" value="<?php echo isset($grupo)?$grupo->grup_inicio_insc:"";?>">
            </div>
            <div class="col-lg-5 form-group">
              <label for="GrupoFinInscripcion" style="color:#0C4590"><b>Finalizar Inscripciones en la Fecha:</b></label>
              <input type="date" class="form-control" id="GrupoFinInscripcion" name="GrupoFinInscripcion" placeholder="0" min="0" value="<?php echo isset($grupo)?$grupo->grup_fin_insc:"";?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="card lg-12">
            <div class="card-header">
              <i class="fas fa-chalkboard fa-lg" style="color:orange"></i>
              <b style="color:orange">&nbsp;En línea</b>
            </div>
          <div class="col-lg-12 form-row" style="margin-top: 20px;">    
          <div class="col-lg-6 form-group">
            <label for="ID_Curso" style="color:#0C4590"><b>Plataforma: *</b></label>
            <select class="custom-select" id="ID_Curso" name="ID_Curso">
              <option value="0">Seleccione una opción</option>
              <?php foreach ($arr_Plataformas as $Plataformas) { ?>
              <option value="<?php echo $Plataformas['plat_id_plataforma'];?>"><?php echo $Plataformas['plat_nombre'];?>
              </option><?php } ?>
            </select>
          </div>
          <div class="col-lg-6 form-group">
            <label for="URL_Acceso"><b>Link de acceso: *</b></label>
              <input type="text" class="form-control" id="URL_Acceso" name="URL_Acceso" value="">
          </div>
          <div class="col-lg-12 form-row" style="margin-top: 20px;">    
            <div class="col-lg-6 form-group">
              <label for="ID_Reunion"><b>ID de la Renunón: *</b></label>
                <input type="text" class="form-control" id="ID_Reunion" name="ID_Reunion" value="">
            </div>
            <div class="col-lg-6 form-group">
              <label for="Clave_Acceso"><b>Clave de Acceso: *</b></label>
                <input type="text" class="form-control" id="Clave_Acceso" name="Clave_Acceso" value="">
            </div>
          </div>
        </div>
        <div class="form-group">
            <div class="card lg-12">
              <div class="card-header">
                <i class="fas fa-chalkboard fa-lg" style="color:orange"></i>
                <b style="color:orange">&nbsp;Sesión #</b>
              </div>
            <div class="col-lg-12 form-row" style="margin-top: 20px;">    
            <div class="col-lg-6 form-group">
              <label for="SesionFecha" style="color:#0C4590"><b>Fecha</b></label>
              <input type="date" class="form-control" id="SesionFecha" name="SesionFecha" placeholder="0" min="0" value="<?php echo isset($sesion)?$sesion->sesi_fecha:"";?>">
            </div>
            <div class="col-lg-6 form-group">
              <label for="SesionHora" style="color:#0C4590"><b>Fecha</b></label>
              <input type="time" class="form-control" id="SesionHora" name="SesionHora" placeholder="0" min="0" value="<?php echo isset($sesion)?$sesion->sesi_hora:"";?>">
            </div>
          </div>
        </div>
      </div>

        <!-- Desactivar formulario FIN -->
        <?php if (isset($_POST['CRUD']) && $_POST['CRUD'] == 0) { ?>
          </fieldset>
        <?php } ?>
        </form>

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

  <script>
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();
    if(dd<10){
      dd='0'+dd
    } 
    if(mm<10){
      mm='0'+mm
    } 
    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("GrupoInsInicio").setAttribute("min", today);
    document.getElementById("GrupoInsFin").setAttribute("min", today);
    document.getElementById("GrupoCurInicio").setAttribute("min", today);
    document.getElementById("GrupoCurFin").setAttribute("min", today);
    document.getElementById("GrupoInsInicioWeb").setAttribute("min", today);
    document.getElementById("GrupoInsFinWeb").setAttribute("min", today);
    document.getElementById("GrupoCurInicioWeb").setAttribute("min", today);

    var tipo_evento;

  tipo_evento = $("#GrupoCurso").val();

  if (tipo_evento.startsWith('4')) {
    // Si la checkbox de mostrar contraseña está activada
    $("#webinar").show();
    $("#ponente1").show();
    $("#botones_ponentes").show();
    $("#eventos").hide();
    $("#botones_eventos").hide();
    $("#div_profesor").hide();
  } // Si no está activada
  else if (tipo_evento.startsWith('0')) {
    $("#webinar").hide();
    $("#ponente1").hide();
    $("#botones_ponentes").hide();
    $("#eventos").hide();
    $("#botones_eventos").hide();
    $("#div_profesor").hide();
  } else {
    $("#webinar").hide();
    $("#ponente1").hide();
    $("#botones_ponentes").hide();
    $("#eventos").show();
    $("#botones_eventos").show();
    $("#div_profesor").show();
  }
  </script>

<script src="../sistema/grupos/grupos.js"></script>
<script src="../sistema/grupos/ponentes.js"></script>
