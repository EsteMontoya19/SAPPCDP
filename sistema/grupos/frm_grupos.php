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
  include('../../clases/Instructor.php');
  include('../../clases/Moderador.php');

  // Objetos
  $obj_Busqueda = new Busqueda();
  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Curso = new Curso();
  $obj_instructor = new Instructor();
  $obj_Moderador = new Moderador();

  //Catálogos
  $arr_Cursos = $obj_Busqueda->selectCursosActivos();
  $arr_Instructores = $obj_instructor->buscarInstructoresActivos();
  $arr_Moderadores = $obj_Moderador->buscarModeradoresActivos();
  $arr_Plataformas = $obj_Busqueda->selectPlataformas();
  $arr_Salones = $obj_Busqueda->selectSalones();
  $arr_Modalidades = $obj_Busqueda->selectModalidadesAprendizaje();
  $arr_Estados = $obj_Busqueda->selectEstadosGrupo();

  $Grupo = new Grupo();
  $Grupo = $obj_Grupo->grup_id_grupo = null;
  
  //$obj_Calendario = $obj_Busqueda->selectCalendario();
  
  
    // Validar entidad
if (isset($_POST['id'])) {
  // Recuperar información de consulta

    $Grupo = $obj_Grupo->buscarSoloGrupo($_POST['id']);
    $arr_Sesiones = $obj_Sesion->buscarSesionesIDGrupo($_POST['id']);
  //$Curso=$obj_Curso->buscarCurso($Grupo->curs_id_curso);
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
                <b>&nbsp;&nbsp;<?php if (isset($_POST['CRUD']) == false) {
                    echo "Selecciona un ";
                               } ?>Curso </b>
              </div>
              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <div class="col-lg-6 form-group">
                  <label for="ID_Curso"><b>Curso:<?php if (isset($_POST['CRUD']) == false) {
                        echo "*";
                                                 } ?></b></label>
                  <select required='required' class="custom-select" id="ID_Curso" name="ID_Curso"
                    <?php if (isset($_POST['CRUD']) == 1) {
                        echo "disabled";
                    } ?>>
                    <option value="0">Seleccionar una opción</option>
                    <?php foreach ($arr_Cursos as $Curso) { ?>
                    <option value="<?php echo $Curso['curs_id_curso']; ?>" <?php if (isset($Grupo)) {
                        if ($Grupo->curs_id_curso == $Curso['curs_id_curso']) {
                            ?> selected <?php
                        }
                                   }?>> <?php echo ($Curso['curs_nombre']." (".$Curso['curs_tipo'].") ".$Curso['curs_nivel']); ?>
                    </option>
                    <?php } ?>
                  </select>
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
                <div class="col-lg-4 form-group">
                  <label
                    for="GrupoTipo"><b>Tipo:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                        echo "*";
                                            }?></b></label>
                  <select class="custom-select" id="GrupoTipo" name="GrupoTipo">
                    <option value="0">Seleccione una opción</option>
                    <option value="Público"
                      <?php if (isset($Grupo) && $Grupo->grup_tipo == "Público") {
                            echo "selected";
                      }?>> Público</option>
                    <option value="Privado"
                      <?php if (isset($Grupo) && $Grupo->grup_tipo == "Privado") {
                            echo "selected";
                      }?>> Privado</option>
                  </select>
                </div>
                <div class="col-lg-4 form-group">
                  <label
                    for="GrupoModalidad"><b>Modalidad:<?php if (isset($_POST['CRUD']) == false) {
                        echo "*";
                                                      } ?></b></label>
                  <select required='required' class="custom-select" id="GrupoModalidad" name="GrupoModalidad"
                    <?php if (isset($_POST['CRUD']) == 1) {
                        echo "disabled";
                    } ?>>
                    <option value="0">Seleccione una opción</option>
                    <?php foreach ($arr_Modalidades as $Modalidad) {?>
                      <option value="<?php echo $Modalidad['moap_id_modalidad'];?>" 
                        <?php if (isset($Grupo)) {
                            if ($Grupo->moap_id_modalidad == $Modalidad['moap_id_modalidad']) {
                                ?> selected <?php
                            }
                        }?>>
                        <?php echo $Modalidad['moap_nombre'];?>
                      </option>
                    <?php }?>
                  </select>
                </div>
                <div class="col-lg-4 form-group">
                  <label
                    for="GrupoEstatus"><b>Estado:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                        echo "*";
                                                 } ?></b></label>
                  <select class="custom-select" id="GrupoEstatus" name="GrupoEstatus">
                    <option value="0"> Seleccione una opción </option>
                    <?php foreach ($arr_Estados as $Estado) {?>
                      <option value="<?php echo $Estado['esta_id_estado']; ?>"
                        <?php if (isset($Grupo)) {
                            if ($Grupo->esta_id_estado == $Estado['esta_id_estado']) {
                                ?> selected <?php
                            }
                        }?>>
                        <?php echo $Estado['esta_nombre']; ?>
                      </option>
                    <?php }?>
                  </select>
                </div>
              </div>

              <div class="col-lg-12 form-row" style="margin-top: 15px;">
                <?php if (isset($_POST['CRUD'])) {?>
                <div class="col-lg-4 form-group">
                <?php } else {?>
                  <div class="col-lg-4 form-group">
                <?php } ?>
                    <label for="ID_Profesor"><b>Profesor:
                        <?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                            echo "*";
                        } ?></b></label>
                    <select class="custom-select" id="ID_Profesor" name="ID_Profesor">
                      <option value="0">Seleccione una opción</option>
                      <?php foreach ($arr_Instructores as $Instructor) { ?>
                      <option value="<?php echo $Instructor['usr_instructor']; ?>" <?php if (isset($Grupo)) {
                            if ($Grupo->usr_instructor == $Instructor['usr_instructor']) {
                                ?> selected <?php
                            }
                                     }?>>
                            <?php echo $Instructor['pers_nombre']." ".$Instructor['pers_apellido_paterno']." ".$Instructor['pers_apellido_materno']; ?>
                      <?php } ?>
                    </select>
                  </div>
                <?php if (isset($_POST['CRUD'])) {?>
                  <div class="col-lg-4 form-group">
                <?php } else {?>
                  <div class="col-lg-4 form-group">
                <?php } ?>
                <label for="ID_Moderador"><b>Moderador:
                    <?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                        echo "*";
                    }?></b></label>
                <select class="custom-select" id="ID_Moderador" name="ID_Moderador">
                  <option value="0"><?php if (isset($_POST['CRUD']) && ($_POST['CRUD']) == 0) {
                        echo "Sin Moderador";
                                    } elseif (!isset($_POST['CRUD']) || ($_POST['CRUD']) != 0) {
                                        echo "Seleccione una opción";
                                    }?> </option>
                  <?php foreach ($arr_Moderadores as $Moderador) { ?>
                  <option value="<?php echo $Moderador['usr_moderador']; ?>" <?php if (isset($Grupo)) {
                        if ($Grupo->usr_moderador == $Moderador['usr_moderador']) {
                            ?> selected <?php
                        }
                                 }?>>
                        <?php echo $Moderador['pers_nombre']." ".$Moderador['pers_apellido_paterno']." ".$Moderador['pers_apellido_materno']; ?>
                  <?php } ?>
                </select>
              </div>
              <?php if (isset($_POST['CRUD'])) {?>
              <div class="col-lg-4 form-group">
              <?php } else {?>
                <div class="col-lg-4 form-group">
              <?php } ?>
                  <label for="ID_Status"><b>Publicado:
                      <?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                            echo "*";
                      }?></b></label>
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="ID_Status" name="ID_Status"
                      <?php if (isset($Grupo) && $Grupo->grup_publicado == 'f') { ?>
                      <?php } else {
                          echo "checked";
                      } ?> <?php if (isset($Grupo)) { ?>
                      onclick="Publicar(<?php echo $Grupo->grup_id_grupo ?> , '<?php echo $Grupo->grup_publicado; ?>')"
                      <?php } else {
                            ?> value="true" <?php
                      } ?>>
                    <label class="custom-control-label" for="ID_Status"></label>
                  </div>
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
                      for="GrupoCupo"><b>Cupo:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                            echo "*";
                                              }?></b></label>
                    <input type="number" class="form-control grupo-cupo" id="GrupoCupo" name="GrupoCupo" placeholder="0"
                      min="0" value="<?php echo isset($Grupo)?$Grupo->grup_cupo : ""; ?>">
                  </div>
                  <div class="col-lg-5 form-group">
                    <label for="GrupoInicioInscripcion"><b>Iniciar Inscripciones en la Fecha:</b></label>
                    <input type="date" class="form-control" id="GrupoInicioInscripcion"
                      name="GrupoInicioInscripcion" placeholder="0" min="0"
                      value="<?php echo isset($Grupo)?$Grupo->grup_inicio_insc : ""; ?>">
                  </div>
                  <div class="col-lg-5 form-group">
                    <label for="GrupoFinInscripcion"><b>Finalizar Inscripciones en la Fecha:</b></label>
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
                    if (isset($Grupo->moap_id_modalidad)) {
                        foreach ($arr_Modalidades as $Modalidad) {
                            if ($Grupo->moap_id_modalidad == $Modalidad['moap_id_modalidad']) {
                                echo ": ".$Modalidad['moap_nombre'];
                            }
                        }
                    } ?></b>
                </div>
                <div class="col-lg-12 form-row" style="margin-top: 15px;">
                  <!-- div de la modalidad presencial -->
                  <?php if (isset($Grupo) && $Grupo->moap_id_modalidad == 1) { ?>
                    <div id="Salon" class="col-lg-6 form-group">
                  <?php } else {?>
                    <div id="Salon" class="col-lg-6 form-group" style="display: none;">
                  <?php }?>
                    <label for="lbID_Salon"><b>Salon:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                          echo "*";
                                                     } ?></b></label>
                    <select class="custom-select" id="ID_Salon" name="ID_Salon">
                      <option value="0">Seleccione una opción</option>
                      <?php if (isset($arr_Salones)) {
                            foreach ($arr_Salones as $Salon) { ?>
                        <option value="<?php echo $Salon['salo_id_salon'];?>"
                                  <?php if (isset($Grupo)) {
                                        if ($Grupo->salo_id_salon == $Salon['salo_id_salon']) {
                                            ?> selected
                                        <?php }
                                  }?>>
                                  <?php echo "Edificio: ".$Salon['edif_nombre']." Salon: ".$Salon['salo_nombre']; ?>
                        </option>
                            <?php }
                      }?>
                    </select>
                  </div>
                    <!-- div de la modalidad en línea -->
                    <?php if (isset($Grupo) && $Grupo->moap_id_modalidad == 2) { ?>
                    <div id="Plataforma" class="col-lg-6 form-group">
                    <?php } else {?>
                      <div id="Plataforma" class="col-lg-6 form-group" style="display: none;">
                    <?php }?>
                        <label
                          for="lbID_Plataforma"><b>Plataforma:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                                echo "*";
                                                              }?></b></label>
                        <select class="custom-select" id="ID_Plataforma" name="ID_Plataforma">
                          <option value="0">Seleccione una opción</option>
                          <?php foreach ($arr_Plataformas as $Plataforma) {
                                if ($Plataforma['plat_activo'] == 't') {?>
                            <option value="<?php echo $Plataforma['plat_id_plataforma'];?>"
                                                                    <?php if (isset($Grupo)) {
                                                                        if ($Grupo->plat_id_plataforma == $Plataforma['plat_id_plataforma']) {
                                                                            ?>selected <?php
                                                                        }
                                                                    }?>>
                                    <?php echo $Plataforma['plat_nombre']; ?>
                            </option>
                                <?php } else {
                                    if (isset($Grupo)) {
                                        if ($Grupo->plat_id_plataforma == $Plataforma['plat_id_plataforma']) { ?>
                            <option value="<?php echo $Plataforma['plat_id_plataforma'] ?>" selected>
                                              <?php echo $Plataforma['plat_nombre']; ?>
                            </option>
                                        <?php }
                                    }
                                }
                          } ?>
                        </select>
                      </div>
                      <?php if (isset($Grupo) && $Grupo->moap_id_modalidad == 2) { ?>
                      <div id="Acceso" class="col-lg-6 form-group">
                      <?php } else {?>
                        <div id="Acceso" class="col-lg-6 form-group" style="display: none;">
                      <?php }?>
                          <label for="lbURL_Acceso"><b>Link de
                              acceso:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                                    echo "*";
                                     }?></b></label>
                          <input type="text" class="form-control" id="URL_Acceso" name="URL_Acceso"
                            value="<?php echo isset($Grupo) ? $Grupo->grup_url : ""; ?>">
                        </div>
                      </div>
                      <div class="col-lg-12 form-row" style="margin-top: 15px;">
                        <?php if (isset($Grupo) && $Grupo->moap_id_modalidad == 2) { ?>
                        <div id="Reunion" class="col-lg-6 form-group">
                        <?php } else {?>
                          <div id="Reunion" class="col-lg-6 form-group" style="display: none;">
                        <?php }?>
                            <label for="lbID_Reunion"><b>ID de la
                                Reunión:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
/*echo "*";*/
                                        } ?></b></label>
                            <input type="text" class="form-control" id="ID_Reunion" name="ID_Reunion"
                              value="<?php echo isset($Grupo) ? $Grupo->grup_id_acceso : ""; ?>">
                          </div>
                          <?php if (isset($Grupo) && $Grupo->moap_id_modalidad == 2) { ?>
                          <div id="Clave" class="col-lg-6 form-group">
                          <?php } else {?>
                            <div id="Clave" class="col-lg-6 form-group" style="display: none;">
                          <?php }?>
                              <label for="lbClave_Acceso"><b>Clave de
                                  Acceso:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
/*echo "*";*/
                                         } ?></b></label>
                              <input type="text" class="form-control" id="Clave_Acceso" name="Clave_Acceso"
                                value="<?php echo isset($Grupo) ? $Grupo->grup_clave_acceso : ""; ?>">
                            </div>
                          </div>
                        
                      <!-- Div de la modalidad: AutoGestiva-->
                      <?php if (isset($Grupo) && $Grupo->moap_id_modalidad == 3) { ?>
                        <div id="PlataformaAG" class="col-lg-6 form-group">
                      <?php } else {?>
                        <div id="PlataformaAG" class="col-lg-6 form-group" style="display: none;">
                      <?php }?>
                          <label for="lbURL_Plataforma"><b>Link de la plataforma donde se toma
                            el curso:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                                echo "*";
                                     }?></b></label>
                              <input type="text" class="form-control" id="URL_Plataforma" name="URL_Plataforma"
                                value="<?php echo isset($Grupo) ? $Grupo->grup_url : ""; ?>">
                        </div>

                  </div>
                </div>
            <!-- Fin de Sección: Modalidad -->

          <?php if (isset($Grupo)) {?>
          <!-- Inicio de Sección: Sesiones -->
                <?php if (isset($Grupo)) { ?>
              <div id="Sesiones" class="form-group">
                <?php } else {?>
              <div id="Sesiones" class="form-group" style="display: none;">
                <?php }
                $i = 1;
                foreach ($arr_Sesiones as $Sesion) {
                    $idSesion = "idSesion".$i;
                    $SesionFecha = "SesionFecha".$i;
                    $SesionHoraInicio = "SesionHoraInicio".$i;
                    $SesionHoraFin = "SesionHoraFin".$i;
                    $SesionNombre = "Sesion".$i;
                    $Hora = "Hora".$i;
                    ?>
                <div class="card lg-12">
                  <div class="card-header">
                    <i class="fas fa-id-card fa-lg"></i>
                    <b>&nbsp;&nbsp; <?php echo "Sesión #".$i; ?></b>
                    <input type="hidden" id="<?php echo $idSesion;?>" name="idSesion[]" value="<?php echo $Sesion['sesi_id_sesiones'];?>">
                  </div>
                  <div class="col-lg-12 form-row" style="margin-top: 15px;">
                    <div id="<?php echo $SesionNombre;?>" class="col-lg-6 form-group">
                      <label
                        for="<?php echo $SesionFecha;?>"><b>Fecha:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                            echo "*";
                             }?></b></label>
                      <input type="date" class="form-control" id="<?php echo $SesionFecha;?>"
                        name="SesionFecha[]>" placeholder="0" min="0"
                        value="<?php echo isset($Sesion)?$Sesion['sesi_fecha']:""; ?>">
                    </div>
                    <div id="<?php echo $Hora;?>" class="col-lg-3 form-group">
                      <label
                        for="<?php echo $SesionHoraInicio;?>"><b>Hora de inicio:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                            echo "*";
                             }; ?></b></label>
                      <input type="time" class="form-control" id="<?php echo $SesionHoraInicio;?>"
                        name="SesionHoraInicio[]>" placeholder="0" min="0"
                        value="<?php echo isset($Sesion)?$Sesion['sesi_hora_inicio']:"";?>">
                    </div>
                    <div id="<?php echo $Hora;?>" class="col-lg-3 form-group">
                      <label
                        for="<?php echo $SesionHoraFin;?>"><b>Hora de fin:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1) {
                            echo "*";
                             }; ?></b></label>
                      <input type="time" class="form-control" id="<?php echo $SesionHoraFin;?>"
                        name="SesionHoraFin[]>" placeholder="0" min="0"
                        value="<?php echo isset($Sesion)?$Sesion['sesi_hora_fin']:"";?>">
                    </div>
                  </div>
                </div>
                    <?php $i++;
                } ?>
                <input type="hidden" name="numSesiones" id="numSesiones" value= <?php echo ($i - 1) ?>>
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
            <input type="hidden" id="ifModalidad" name="ifModalidad" value="<?php echo $Grupo->moap_id_modalidad;?>">

            <?php if($Grupo->usr_moderador != '') { 
              $moderador = $obj_Busqueda->buscarHorarioModerador($Grupo->usr_moderador);
              if(isset($moderador)){
            
                $dias = $obj_Busqueda->buscarDiasModerador($moderador->mode_id_moderador);
            
                $cadenaDias = '';
                foreach($dias as $dia){
                  $cadenaDias .= $dia['dia_id_dia'];
                  $cadenaDias .= '-';
                }
              ?>

            <input type="hidden" id="modeFechaInicio" name="modeFechaInicio" value="<?php echo $moderador->mode_fecha_inicio;?>">
            <input type="hidden" id="modeFechaFin" name="modeFechaFin" value="<?php echo $moderador->mode_fecha_fin;?>">
            <input type="hidden" id="modeHoraInicio" name="modeHoraInicio" value="<?php echo $moderador->mode_hora_inicio;?>">
            <input type="hidden" id="modeHoraFin" name="modeHoraFin" value="<?php echo $moderador->mode_hora_fin;?>">
            <input type="hidden" id="modeDias" name="modeDias" value="<?php echo $cadenaDias;?>">

            <?php } } else { ?>

            <input type="hidden" id="modeFechaInicio" name="modeFechaInicio" value="">
            <input type="hidden" id="modeFechaFin" name="modeFechaFin" value="">
            <input type="hidden" id="modeHoraInicio" name="modeHoraInicio" value="">
            <input type="hidden" id="modeHoraFin" name="modeHoraFin" value="">
            <input type="hidden" id="modeDias" name="modeDias" value="">

            <?php } ?>
            <?php } elseif ($_POST['CRUD'] == 0) { ?>
            <input type="hidden" name="dml" value="select" />
            <?php } ?>
        <?php } else { ?>
          <input type="hidden" name="dml" value="insert" />
          <input type="hidden" id="modeFechaInicio" name="modeFechaInicio" value="">
          <input type="hidden" id="modeFechaFin" name="modeFechaFin" value="">
          <input type="hidden" id="modeHoraInicio" name="modeHoraInicio" value="">
          <input type="hidden" id="modeHoraFin" name="modeHoraFin" value="">
          <input type="hidden" id="modeDias" name="modeDias" value="">
        <?php } ?>

      </form>
    </div>
    <!-- Botones -->
    <div class="col-lg-12" style="text-align: center;">
      <button id="btn-regresar-grupo" type="button" class="btn btn-primary btn-footer btn-regresar">Regresar</button>
      <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 1) { ?>
      <button id="btn-actualizar-grupo" type="button" class="btn btn-success btn-footer btn-aceptar">Actualizar</button>
            <?php } ?>
      <?php } else { ?>
      <button id="btn-registrar-grupo" type="button" class="btn btn-success btn-footer btn-aceptar">Guardar</button>
      <?php } ?>
    </div>
  </div>
</div>
</div>



<script src="../sistema/grupos/control_grupos.js"></script>
