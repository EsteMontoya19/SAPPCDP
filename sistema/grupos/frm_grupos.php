<?php
  include('../../clases/BD.php');
  include('../../clases/Busqueda.php');
  include('../../clases/Grupo.php');
  include('../../clases/Horario.php');
  include('../../clases/Periodo.php');
  include('../../clases/Profesor.php');


  $obj_Busqueda = new Busqueda();
  $arr_eventos = $obj_Busqueda->selectEventos();
  $arr_modalidades = $obj_Busqueda->selectModalidadGrupo();
  $arr_estatus = $obj_Busqueda->selectEstatusGrupo();
  $arr_dias = $obj_Busqueda->selectDias();
  $arr_salones = $obj_Busqueda->selectSalones();

  $obj_Profesor = new Profesor();
  $arr_profesores = $obj_Profesor->buscarTodosProfesores();

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
                <b style="color:orange">&nbsp;Datos generales</b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 20px;">
               
                <div class="col-lg-4 form-group">
                  <label for="GrupoModalidad" style="color:#0C4590"><b>Modalidad: *</b></label>
                  <select class="custom-select" id="GrupoModalidad" name="GrupoModalidad">
                    <option>Seleccione una opción</option>
                    <?php foreach ($arr_modalidades as $modalidad) { ?>
                      <option value="<?php echo $modalidad['mogr_id_mogr']; ?>" <?php if(isset($grupo)) { if ($grupo->grup_id_mogr == $modalidad['mogr_id_mogr']) { ?> selected <?php } }?>>
                        <?php echo $modalidad['mogr_nombre']; ?>
                      </option>
                    <?php } ?>
                    <option value="">En línea</option>
                    <option value="">Presencial</option>
                  </select>
                </div>
                <div class="col-lg-4 form-group">
                  <label for="GrupoEstatus" style="color:#0C4590"><b>Estatus del grupo: *</b></label>
                  <select class="custom-select" id="GrupoEstatus" name="GrupoEstatus">
                    <option>Seleccione una opción</option>
                    <?php foreach ($arr_estatus as $estatu) { ?>
                      <option value="<?php echo $estatu['esgr_id_esgr']; ?>" <?php if(isset($grupo)) { if ($grupo->grup_id_esgr == $estatu['esgr_id_esgr']) { ?> selected <?php } }?>>
                        <?php echo $estatu['esgr_nombre']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-lg-2 form-group">
                  <label for="GrupoCupo" style="color:#0C4590"><b>Cupo: *</b></label>
                  <input type="number" class="form-control" id="GrupoCupo" name="GrupoCupo" placeholder="0" min="0" value="<?php echo isset($grupo)?$grupo->grup_cupo:"";?>">
                </div>
              </div>

              
              <div class="col-lg-12 form-row">
                <div class="col-lg-4 form-group">
                  <?php if (isset($_POST['CRUD'])) { ?>
                    <fieldset disabled>
                  <?php } ?>
                  <label for="GrupoCurso" style="color:#0C4590"><b>Evento: *</b></label>
                  <select class="custom-select" id="GrupoCurso" name="GrupoCurso" onchange="mostrarFormulario()">
                    <option value="0">Seleccione una opción</option>
                    <option value="1">En línea</option>
                    <option value="2">Presencial</option>
                  </select>
                  <?php if (isset($_POST['CRUD'])) { ?>
                    </fieldset>
                  <?php } ?>
                </div>
                <input type="hidden" name="id_evento" value="<?php echo isset($grupo)?$grupo->grup_id_even:"";?>"/>
               
               
                <div class="col-lg-4 form-group" id="div_profesor" style="display: none;">
                  <label for="GrupoProfesores" style="color:#0C4590"><b>Profesor: *</b></label>
                  <select class="custom-select" id="GrupoProfesores" name="GrupoProfesores">
                    <option value="0">Seleccione una opción</option>
                    <?php foreach ($arr_profesores as $profesor) { ?>
                      <option value="<?php echo $profesor['prof_id_prof']; ?>" <?php if(isset($grupo)) { if ($grupo->grup_id_prof == $profesor['prof_id_prof']) { ?> selected <?php } }?>>
                        <?php echo $profesor['pers_nombre'] . ' ' . $profesor['pers_primer_ape'] . ' ' . $profesor['pers_segundo_ape']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Formulario para la mayoria de los eventos -->
          <div class="form-group" id="eventos" style="display: none;">
            <div class="card-deck">
              <div class="card lg-6">
                <div class="card-header">
                  <i class="fas fa-calendar-alt fa-lg" style="color:orange"></i>
                  <b style="color:orange">&nbsp;Periodo de inscripción</b>
                </div>
                <div class="col-lg-12 form-row" style="margin-top: 20px;">
                  <div class="col-lg-6 form-group">
                    <label for="GrupoInsInicio" style="color:#0C4590"><b>Fecha de inicio: *</b></label>
                    <input type="date" class="form-control" id="GrupoInsInicio" name="GrupoInsInicio" value="<?php echo isset($periodoIns)?$periodoIns->peri_inicio:"";?>">
                  </div>
                  <div class="col-lg-6 form-group">
                    <label for="GrupoInsFin" style="color:#0C4590"><b>Fecha de termino: *</b></label>
                    <input type="date" class="form-control" id="GrupoInsFin" name="GrupoInsFin" value="<?php echo isset($periodoIns)?$periodoIns->peri_fin:"";?>">
                  </div>
                </div>
                <?php if(isset($_POST['id'])) { ?>
                  <input type="hidden" name="idPeriodo1" value="<?php echo isset($periodoIns)?$periodoIns->peri_id_peri:"";?>"/>
                <?php } ?>
              </div>
              <div class="card lg-6">
                <div class="card-header">
                  <i class="fas fa-calendar-alt fa-lg" style="color:orange"></i>
                  <b style="color:orange">&nbsp;Periodo del curso</b>
                </div>
                <div class="col-lg-12 form-row" style="margin-top: 20px;">
                  <div class="col-lg-6 form-group">
                    <label for="GrupoCurInicio" style="color:#0C4590"><b>Inicio del curso: *</b></label>
                    <input type="date" class="form-control" id="GrupoCurInicio" name="GrupoCurInicio" value="<?php echo isset($periodoCur)?$periodoCur->peri_inicio:"";?>">
                  </div>
                  <div class="col-lg-6 form-group">
                    <label for="GrupoCurFin" style="color:#0C4590"><b>Fin del curso: *</b></label>
                    <input type="date" class="form-control" id="GrupoCurFin" name="GrupoCurFin" value="<?php echo isset($periodoCur)?$periodoCur->peri_fin:"";?>">
                  </div>
                </div>
                <?php if(isset($_POST['id'])) { ?>
                  <input type="hidden" name="idPeriodo2" value="<?php echo isset($periodoCur)?$periodoCur->peri_id_peri:"";?>"/>
                <?php } ?>
              </div>
            </div>
          </div>
          
          <!-- Días y horarios del evento -->
          <!-- Actualización y consulta -->
          <?php if(isset($_POST['CRUD']) && $tipo_evento->even_id_tiev != 4) { ?>
            <?php foreach ($arr_horarios as $horario) { ?>
            <?php $i++; ?>
              <div id="UDTDia<?php echo $i ?>" style="margin-bottom: 30px;" class="form-group">
                <input type="hidden" name="idHorario<?php echo $i ?>" value="<?php echo $horario['hogr_id_hogr'];?>"/>
                <div class="card lg-12">
                  <div class="card-header">
                    <i class="fas fa-clock fa-lg" style="color:orange"></i>
                    <b style="color:orange">&nbsp;Horario <?php echo $i ?></b>
                    <a href="#" style="margin: 5px">
                      <button style="float: right;" id="btn-eliminar-dia" type="button" class="btn btn-danger" title="Quitar" onclick="eliminarHorario(<?php echo $horario['hogr_id_hogr'];?>, <?php echo isset($grupo)?$grupo->grup_id_grup:"";?>)">
                        <i class="fas fa-minus"></i>  
                      </button>
                    </a>
                  </div>
                  <div class="col-lg-12 form-row" style="margin-bottom: 20px;">
                    <div class="col-lg-3 form-group">
                      <label for="UDTGrupoDia<?php echo $i ?>" style="color:#0C4590"><b>Día:</b></label>
                      <select class="custom-select my-1 mr-sm-2" id="UDTGrupoDia<?php echo $i ?>" name="UDTGrupoDia<?php echo $i ?>">
                        <option>Seleccione una opción</option>
                        <?php foreach ($arr_dias as $dia) { ?>
                          <option value="<?php echo $dia['dia_id_dia']; ?>" <?php if($horario['hogr_id_dia'] == $dia['dia_id_dia']) {?>selected<?php } ?> ><?php echo $dia['dia_nombre']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-lg-3 form-group">
                      <label for="UDTGrupoSalon<?php echo $i ?>" style="color:#0C4590"><b>Salón:</b></label>
                      <select class="custom-select my-1 mr-sm-2" id="UDTGrupoSalon<?php echo $i ?>" name="UDTGrupoSalon<?php echo $i ?>" >
                        <option>Seleccione una opción</option>
                        <?php foreach ($arr_salones as $salon) { ?>
                          <option value="<?php echo $salon['salo_id_salo']; ?>" <?php if($horario['hogr_id_salo'] == $salon['salo_id_salo']) {?>selected<?php } ?> ><?php echo $salon['salo_nombre']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-lg-2 form-group">
                      <label for="UDTGrupoHoraInicio<?php echo $i ?>" style="color:#0C4590"><b>Hora de inicio:</b></label>
                      <input type="time" class="form-control" id="UDTGrupoHoraInicio<?php echo $i ?>" name="UDTGrupoHoraInicio<?php echo $i ?>" style="margin-top: 5px;" value="<?php echo $horario['hogr_hora_inicio'];?>">
                    </div>
                    <div class="col-lg-2 form-group">
                      <label for="UDTGrupoHoraFin<?php echo $i ?>" style="color:#0C4590"><b>Hora final:</b></label>
                      <input type="time" class="form-control" id="UDTGrupoHoraFin<?php echo $i ?>" name="UDTGrupoHoraFin<?php echo $i ?>" style="margin-top: 5px;" value="<?php echo $horario['hogr_hora_fin'];?>">
                    </div>
                  </div>
                </div>
              </div>
            <?php } $n = $i + 1;?>
            <?php for ($i = 1; $i <= 7; $i++) { ?>
              <div id="Dia<?php echo $i ?>" style="display: none; margin-bottom: 30px;" class="form-group">
                <div class="card lg-12">
                  <div class="card-header">
                    <i class="fas fa-clock fa-lg" style="color:orange"></i>
                    <b style="color:orange">&nbsp;Horario <?php echo $i ?></b>
                  </div>
                  <div class="col-lg-12 form-row" style="margin-bottom: 20px;">
                    <div class="col-lg-3 form-group">
                      <label for="GrupoDia<?php echo $i ?>" style="color:#0C4590"><b>Día:</b></label>
                      <select class="custom-select my-1 mr-sm-2" id="GrupoDia<?php echo $i ?>" name="GrupoDia<?php echo $i ?>">
                        <option value="0">Seleccione una opción</option>
                        <?php foreach ($arr_dias as $dia) { ?>
                          <option value="<?php echo $dia['dia_id_dia']; ?>"><?php echo $dia['dia_nombre']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-lg-3 form-group">
                      <label for="GrupoSalon<?php echo $i ?>" style="color:#0C4590"><b>Salón:</b></label>
                      <select class="custom-select my-1 mr-sm-2" id="GrupoSalon<?php echo $i ?>" name="GrupoSalon<?php echo $i ?>" >
                        <option value="0">Seleccione una opción</option>
                        <?php foreach ($arr_salones as $salon) { ?>
                          <option value="<?php echo $salon['salo_id_salo']; ?>"><?php echo $salon['salo_nombre']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-lg-2 form-group">
                      <label for="GrupoHoraInicio<?php echo $i ?>" style="color:#0C4590"><b>Hora de inicio:</b></label>
                      <input type="time" class="form-control" id="GrupoHoraInicio<?php echo $i ?>" name="GrupoHoraInicio<?php echo $i ?>" style="margin-top: 5px;">
                    </div>
                    <div class="col-lg-2 form-group">
                      <label for="GrupoHoraFin<?php echo $i ?>" style="color:#0C4590"><b>Hora final:</b></label>
                      <input type="time" class="form-control" id="GrupoHoraFin<?php echo $i ?>" name="GrupoHoraFin<?php echo $i ?>" style="margin-top: 5px;">
                    </div>
                  </div>
                </div>
              </div>
            <?php }?>
            <!-- Botones de los eventos -->
            <?php if($_POST['CRUD'] == 1) { ?> 
              <div class="col-lg-12" id="botones_eventos" style="text-align: center; display: none;">
                <button id="btn-borrar-horario" type="button" class="btn btn-danger btn-footer" title="Quitar" onclick="ocultarDiaUPD(<?php echo $n?>)">Borrar nuevo día</i></i></button>
                <button id="btn-agregar-horario"  style="display: none;"  type="button" class="btn btn-info btn-footer" onclick="mostrarDia()">Agregar nuevo día</button>
                <button id="btn-agregar-horarioAct" type="button" class="btn btn-info btn-footer" onclick="mostrarDiaUPD(<?php echo $n?>)">Agregar nuevo día</button>
              </div>
              <hr>
            <?php } ?>
          <!-- Registro -->
          <?php } else { ?>
            <?php for ($i = 1; $i <= 7; $i++) { ?>
              <div id="Dia<?php echo $i ?>" style="display: none; margin-top: 20px;" class="form-group">
                <div class="card lg-12">
                  <div class="card-header">
                    <i class="fas fa-clock fa-lg" style="color:orange"></i>
                    <b style="color:orange">&nbsp;Horario <?php echo $i ?></b>
                  </div>
                  <div class="col-lg-12 form-row" style="margin-top: 15px;">
                    <div class="col-lg-4 form-group">
                      <label for="GrupoDia<?php echo $i ?>" style="color:#0C4590"><b>Día:</b></label>
                      <select class="custom-select my-1 mr-sm-2" id="GrupoDia<?php echo $i ?>" name="GrupoDia<?php echo $i ?>">
                        <option value="0">Seleccione una opción</option>
                        <?php foreach ($arr_dias as $dia) { ?>
                          <option value="<?php echo $dia['dia_id_dia']; ?>"><?php echo $dia['dia_nombre']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-lg-4 form-group">
                      <label for="GrupoSalon<?php echo $i ?>" style="color:#0C4590"><b>Salón:</b></label>
                      <select class="custom-select my-1 mr-sm-2" id="GrupoSalon<?php echo $i ?>" name="GrupoSalon<?php echo $i ?>">
                        <option value="0">Seleccione una opción</option>
                        <?php foreach ($arr_salones as $salon) { ?>
                          <option value="<?php echo $salon['salo_id_salo']; ?>"><?php echo $salon['salo_nombre']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-lg-2 form-group">
                      <label for="GrupoHoraInicio<?php echo $i ?>" style="color:#0C4590"><b>Hora de inicio:</b></label>
                      <input type="time" class="form-control" id="GrupoHoraInicio<?php echo $i ?>" name="GrupoHoraInicio<?php echo $i ?>" style="margin-top: 5px;">
                    </div>
                    <div class="col-lg-2 form-group">
                      <label for="GrupoHoraFin<?php echo $i ?>" style="color:#0C4590"><b>Hora final:</b></label>
                      <input type="time" class="form-control" id="GrupoHoraFin<?php echo $i ?>" name="GrupoHoraFin<?php echo $i ?>" style="margin-top: 5px;">
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
            <?php if(!isset($_POST['CRUD']) || $_POST['CRUD'] == 1) { ?> 
              <!-- Botones de los eventos -->
              <div class="col-lg-12" id="botones_eventos" style="text-align: center; margin-bottom: 20px; display: none;">
                <button id="btn-borrar-horario"  type="button" class="btn btn-danger btn-footer" title="Quitar" onclick="ocultarDia()">Borrar día</i></i></button>
                <button id="btn-agregar-horario" type="button" class="btn btn-info btn-footer" onclick="mostrarDia()">Agregar día</button>
              </div>
              <hr>
            <?php } ?>
          <?php } ?>

          <!-- Formulario webinar -->
          <!-- SOLO Registro -->
          <div class="form-group" id="webinar" style="display: none;">
            <div class="card-deck">
              <div class="card lg-6">
                <div class="card-header">
                  <i class="fas fa-calendar-alt fa-lg" style="color:orange"></i>
                  <b style="color:orange">&nbsp;Datos del webinar</b>
                </div>
                <div class="col-lg-12 form-row" style="margin-top: 20px;">
                  <div class="col-lg-6 form-group">
                    <label for="GrupoInsInicioWeb" style="color:#0C4590"><b>Inicio de la inscripción: *</b></label>
                    <input type="date" class="form-control" id="GrupoInsInicioWeb" style="margin-top: 5px;" name="GrupoInsInicioWeb" value="<?php echo isset($periodoIns)?$periodoIns->peri_inicio:"";?>">
                  </div>
                  <div class="col-lg-6 form-group">
                    <label for="GrupoInsFinWeb" style="color:#0C4590"><b>Fin de la inscripción: *</b></label>
                    <input type="date" class="form-control" id="GrupoInsFinWeb" style="margin-top: 5px;" name="GrupoInsFinWeb" value="<?php echo isset($periodoIns)?$periodoIns->peri_fin:"";?>">
                  </div>
                </div>
                <div class="col-lg-12 form-row">
                  <div class="col-lg-4 form-group">
                    <label for="GrupoCurInicioWeb" style="color:#0C4590"><b>Día del evento: *</b></label>
                    <input type="date" class="form-control" id="GrupoCurInicioWeb" name="GrupoCurInicioWeb" value="<?php echo isset($periodoWeb)?$periodoWeb->peri_inicio:"";?>">
                    </div>
                  <div class="col-lg-4 form-group">
                    <label for="UDTGrupoSalonWeb" style="color:#0C4590"><b>Salón:</b></label>
                    <select class="custom-select" id="UDTGrupoSalonWeb" name="UDTGrupoSalonWeb" >
                      <option>Seleccione una opción</option>
                      <?php foreach ($arr_salones as $salon) { ?>
                        <option value="<?php echo $salon['salo_id_salo']; ?>" <?php if(isset($horario_web)) { if($horario_web->hogr_id_salo == $salon['salo_id_salo']) {?>selected<?php } } ?> >
                          <?php echo $salon['salo_nombre']; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-lg-2 form-group">
                    <label for="UDTGrupoHoraInicioWeb" style="color:#0C4590"><b>Hora de inicio: *</b></label>
                    <input type="time" class="form-control" id="UDTGrupoHoraInicioWeb" name="UDTGrupoHoraInicioWeb" value="<?php if(isset($horario_web)) { echo $horario_web->hogr_hora_inicio; } ?>">
                  </div>
                  <div class="col-lg-2 form-group">
                    <label for="UDTGrupoHoraFinWeb" style="color:#0C4590"><b>Hora final: *</b></label>
                    <input type="time" class="form-control" id="UDTGrupoHoraFinWeb" name="UDTGrupoHoraFinWeb" value="<?php if(isset($horario_web)) { echo $horario_web->hogr_hora_fin; } ?>">
                  </div>
                  <?php if(isset($_POST['id'])) { ?>
                    <input type="hidden" name="ID_HorarioWeb" value="<?php echo isset($horario_web)?$horario_web->hogr_id_hogr:"";?>"/>
                    <input type="hidden" name="idPeriodo1" value="<?php echo isset($periodoIns)?$periodoIns->peri_id_peri:"";?>"/>
                    <input type="hidden" name="idPeriodo2" value="<?php echo isset($periodoWeb)?$periodoWeb->peri_id_peri:"";?>"/>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <?php if (!isset($_POST['id'])) {?>
            <div class="form-group" id="ponente1" style="display: none;">
              <div class="card lg-12">
                <div class="card-header">
                  <i class="fas fa-id-card fa-lg" style="color:orange"></i>
                  <b style="color:orange">&nbsp;Ponente 1</b>
                </div>
                <div class="col-lg-12 form-row" style="margin-top: 10px;">
                  <div class="col-lg-6 form-group">
                    <label for="PonenteNombre1" style="color:#0C4590"><b>Nombre completo: *</b></label>
                    <input type="text" class="form-control" id="PonenteNombre1" name="PonenteNombre1" value="<?php echo isset($grupo) ? $persona->pers_nombre : ""; ?>">
                  </div>
                  <div class="col-lg-6 form-group">
                    <label for="PonenteCargo1" style="color:#0C4590"><b>Cargo: *</b></label>
                    <input type="text" class="form-control" id="PonenteCargo1" name="PonenteCargo1" value="<?php echo isset($grupo) ? $persona->pers_primer_ape : ""; ?>">
                  </div>
                </div>
                <div class="col-lg-12 form-row">
                  <div class="form-group col-lg-12">
                    <label for="PonenteSemblanza1" style="color:#0C4590"><b>Semblanza: *</b></label>
                    <textarea class="form-control formulario" rows="3" style="width: 100%" id="PonenteSemblanza1" name="PonenteSemblanza1"><?php echo isset($grupo) ? $profesor->prof_semblanza : ""; ?></textarea>
                  </div>
                </div>
              </div>
            </div>
            <!-- Resto de los ponente -->
            <?php for ($p = 2; $p <= 3; $p++) { ?>
              <div class="form-group" id="ponente<?php echo $p ?>" style="display: none;">
                <div class="card lg-12">
                  <div class="card-header">
                    <i class="fas fa-id-card fa-lg" style="color:orange"></i>
                    <b style="color:orange">&nbsp;Ponente <?php echo $p ?></b>
                  </div>
                  <div class="col-lg-12 form-row" style="margin-top: 10px;">
                    <div class="col-lg-6 form-group">
                      <label for="PonenteNombre<?php echo $p ?>" style="color:#0C4590"><b>Nombre completo: *</b></label>
                      <input type="text" class="form-control" id="PonenteNombre<?php echo $p ?>" name="PonenteNombre<?php echo $p ?>" value="<?php echo isset($grupo) ? $persona->pers_nombre : ""; ?>">
                    </div>
                    <div class="col-lg-6 form-group">
                      <label for="PonenteCargo<?php echo $p ?>" style="color:#0C4590"><b>Cargo: *</b></label>
                      <input type="text" class="form-control" id="PonenteCargo<?php echo $p ?>" name="PonenteCargo<?php echo $p ?>" value="<?php echo isset($grupo) ? $persona->pers_primer_ape : ""; ?>">
                    </div>
                  </div>
                  <div class="col-lg-12 form-row">
                    <div class="form-group col-lg-12">
                      <label for="PonenteSemblanza<?php echo $p ?>" style="color:#0C4590"><b>Semblanza: *</b></label>
                      <textarea class="form-control formulario" rows="3" style="width: 100%" id="PonenteSemblanza<?php echo $p ?>" name="PonenteSemblanza<?php echo $p ?>"><?php echo isset($grupo) ? $profesor->prof_semblanza : ""; ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>

            <?php if(!isset($_POST['CRUD']) || $_POST['CRUD'] == 1) { ?> 
              <!-- Botones de los eventos -->
              <div class="col-lg-12" id="botones_ponentes" style="text-align: center; margin-bottom: 20px; display: none;">
                <button id="btn-borrar-horario"  type="button" class="btn btn-danger btn-footer" title="Quitar" onclick="ocultarPonente()">Borrar ponente</i></i></button>
                <button id="btn-agregar-horario" type="button" class="btn btn-info btn-footer" onclick="mostrarPonente()">Agregar ponente</button>
              </div>
              <hr>
            <?php } ?>
          <?php } else { ?>
            <?php if(isset($_POST['CRUD']) && $tipo_evento->even_id_tiev == 4) { ?>
              <?php foreach ($arr_ponentes as $ponente) { ?>
                <?php $i_pon++; ?>
                <div class="form-group" id="ponente<?php echo $i_pon ?>" >
                  <div class="card lg-12">
                    <div class="card-header">
                      <i class="fas fa-id-card fa-lg" style="color:orange"></i>
                      <b style="color:orange">&nbsp;Ponente <?php echo $i_pon ?></b>
                      <a href="#" style="margin: 5px">
                        <button style="float: right;" id="btn-eliminar-dia" type="button" class="btn btn-danger" title="Quitar" onclick="eliminarPonente(<?php echo $ponente['pone_id_pone'];?>, <?php echo isset($grupo)?$grupo->grup_id_grup:"";?>)">
                          <i class="fas fa-minus"></i>  
                        </button>
                      </a>
                    </div>
                    <div class="col-lg-12 form-row" style="margin-top: 10px;">
                      <div class="col-lg-6 form-group">
                        <label for="PonenteNombreCRUD<?php echo $i_pon ?>" style="color:#0C4590"><b>Nombre completo: *</b></label>
                        <input type="text" class="form-control" id="PonenteNombreCRUD<?php echo $i_pon ?>" name="PonenteNombreCRUD<?php echo $i_pon ?>" value="<?php echo isset($ponente) ? $ponente['pone_nombre'] : ""; ?>">
                      </div>
                      <div class="col-lg-6 form-group">
                        <label for="PonenteCargoCRUD<?php echo $i_pon ?>" style="color:#0C4590"><b>Cargo: *</b></label>
                        <input type="text" class="form-control" id="PonenteCargoCRUD<?php echo $i_pon ?>" name="PonenteCargoCRUD<?php echo $i_pon ?>" value="<?php echo isset($ponente) ?  $ponente['pone_cargo'] : ""; ?>">
                      </div>
                    </div>
                    <div class="col-lg-12 form-row">
                      <div class="form-group col-lg-12">
                        <label for="PonenteSemblanzaCRUD<?php echo $i_pon ?>" style="color:#0C4590"><b>Semblanza: *</b></label>
                        <textarea class="form-control formulario" rows="3" style="width: 100%" id="PonenteSemblanzaCRUD<?php echo $i_pon ?>" name="PonenteSemblanzaCRUD<?php echo $i_pon ?>"><?php echo isset($ponente) ? $ponente['pone_descripcion'] : ""; ?></textarea>
                      </div>
                    </div>
                    <input type="hidden" name="id_Ponente<?php echo $i_pon ?>" value="<?php echo isset($ponente)?$ponente['pone_id_pone']:"";?>"/>
                  </div>
                </div>
              <?php } $n = $i_pon + 1; ?>
              <?php for ($i = 2; $i <= 3; $i++) { ?>
                <div class="form-group" id="ponente<?php echo $i ?>" style="display: none;">
                  <div class="card lg-12">
                    <div class="card-header">
                      <i class="fas fa-id-card fa-lg" style="color:orange"></i>
                      <b style="color:orange">&nbsp;Ponente <?php echo $i ?></b>
                    </div>
                    <div class="col-lg-12 form-row" style="margin-top: 10px;">
                      <div class="col-lg-6 form-group">
                        <label for="PonenteNombre<?php echo $i ?>" style="color:#0C4590"><b>Nombre completo: *</b></label>
                        <input type="text" class="form-control" id="PonenteNombre<?php echo $i ?>" name="PonenteNombre<?php echo $i ?>" value="">
                      </div>
                      <div class="col-lg-6 form-group">
                        <label for="PonenteCargo<?php echo $i ?>" style="color:#0C4590"><b>Cargo: *</b></label>
                        <input type="text" class="form-control" id="PonenteCargo<?php echo $i ?>" name="PonenteCargo<?php echo $i ?>" value="">
                      </div>
                    </div>
                    <div class="col-lg-12 form-row">
                      <div class="form-group col-lg-12">
                        <label for="PonenteSemblanza<?php echo $i ?>" style="color:#0C4590"><b>Semblanza: *</b></label>
                        <textarea class="form-control formulario" rows="3" style="width: 100%" id="PonenteSemblanza<?php echo $i ?>" name="PonenteSemblanza<?php echo $i ?>"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
              <?php }?>
            <?php } ?>
            <?php if($_POST['CRUD'] == 1) { ?> 
              <div class="col-lg-12" id="botones_ponentes" style="text-align: center; ">
                <button id="btn-borrar-ponente" type="button" class="btn btn-danger btn-footer" title="Quitar" onclick="ocultarPonenteUPD(<?php echo $n?>)">Borrar nuevo ponente</i></i></button>
                <button id="btn-agregar-ponente"  style="display: none;"  type="button" class="btn btn-info btn-footer" onclick="mostrarPonente()">Agregar nuevo ponente</button>
                <button id="btn-agregar-ponenteAct" type="button" class="btn btn-info btn-footer" onclick="mostrarPonenteUPD(<?php echo $n?>)">Agregar nuevo ponente</button>
              </div>
              <hr>
            <?php } ?>
          <?php } ?>

          <!-- ID e Instrucciones -->
          <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 1) { ?>
              <input type="hidden" name="dml" value="update"/>
              <input type="hidden" name="idGrupo" value="<?php echo isset($grupo)?$grupo->grup_id_grup:"";?>"/>
            <?php } elseif ($_POST['CRUD'] == 0) { ?>
              <input type="hidden" name="dml" value="select"/>
            <?php } ?>
          <?php } else { ?>
            <input type="hidden" name="dml" value="insert"/>
          <?php } ?>

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

<script src="../sistema/grupos/control_grupos.js"></script>
<script src="../sistema/grupos/ponentes.js"></script>
