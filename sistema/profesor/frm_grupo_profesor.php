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
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');
  include('../../clases/Moderador.php');
  include('../../clases/Curso.php');
  include('../../clases/Persona.php');
  include('../../clases/Profesor.php');
  include('../../clases/Inscripcion.php');
  
  // Objetos
  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Moderador = new Moderador();
  $obj_Curso = new Curso();
  $obj_Persona = new Persona();
  $obj_Profesor = new Profesor();
  $obj_Inscripcion = new Inscripcion();
  $Grupo = $obj_Grupo->grup_id_grupo = null;
  $Grupo = $obj_Grupo->grup_num_inscritos = null;
  // Validar entidad
if (isset($_POST['id'])) {
    // Recuperar información de consulta
    $idGrupo = $_POST['id'];
    $Grupo = $obj_Grupo->buscarGrupoCompleto($idGrupo);
    $arr_Sesiones = $obj_Sesion->buscarSesionesIDGrupo($idGrupo);
    $personal = $obj_Grupo->idUsuarioModeradorGrupo($idGrupo);
    $Curso1=$obj_Curso->buscarCurso($Grupo->grup_id_curso);
    if (isset($personal)) {
        $moderador = $obj_Moderador->buscarModeradorIDUsuario($personal->pegr_id_usuario);
    } else {
        $moderador = null;
    }
}

if (isset($_POST['modalidad'])) {
    $idmodalidad = $_POST['modalidad'];
    if ($idmodalidad == 1) {
        $modalidad=$obj_Grupo->buscarDatosPresencial($idGrupo);
    } elseif ($idmodalidad == 2) {
        $modalidad=$obj_Grupo->buscarDatosEnLinea($idGrupo);
    } elseif ($idmodalidad == 3) {
        $modalidad=$obj_Grupo->buscarDatosAutogestivo($idGrupo);
    }
} else {
    $idmodalidad = null;
    $modalidad = null;
}

if (isset($_POST['persona'])) {
    // Recuperar información la persona que consulta
    $persona = $obj_Persona->buscarPersona($_POST['persona']);
    if (isset($_POST['CRUD'])) {
      $profesor = $obj_Profesor->buscarProfesor($persona->pers_id_persona);
      $inscrito =  $obj_Inscripcion->buscarInscripcion($Grupo->grup_id_grupo, $profesor->prof_id_profesor);
    }
}

  
?>
<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-grupo" class="breadcrumb-item">
        <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 0) { ?>
            <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Grupos disponibles</a>
            <?php } elseif ($_POST['CRUD'] == 1) { ?>
            <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Grupos inscritos</a>
            <?php }
        } ?>
        </li>
        <!-- Validación de la ruta -->
        <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 0 || $_POST['CRUD'] == 1) { ?>
            <li class="breadcrumb-item active"><i class="fas fa-search-plus"></i>&nbsp; Detalles del curso</li>
            <?php }
        } ?>
      </ol>
      <p>
        <hr>
      </p>
      <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 0) { ?>
          <p class = "aviso-amarillo">
            Para completar su inscripción es necesario revisar la información del grupo 
            y dar click en el botón "Inscribirse" ubicado al final de la página.
          </p>
            <?php }
      } ?>
      
      <!-- Formulario -->
      <form name="form_grupo" id="form_grupo" method="POST">

        <!-- Desactivar formulario INICIO en caso de no ser un registro-->
        <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 0 || $_POST['CRUD'] == 1) { ?>
            <fieldset disabled>
            <?php } ?>
        <?php } ?>

        <!-- Inicio de Sección: Curso -->
        <div class="form-group">
          <div class="card lg-12">
            <div class="card-header">
              <i class="fas fa-id-card fa-lg"></i>
              <b>&nbsp;&nbsp;Datos del Curso </b>
            </div>

            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <div class="col-lg-4 form-group">
                <label for="ID_Curso"><b>Curso:</b></label>
                <select required='required' class="custom-select" id="ID_Curso" name="ID_Curso" disabled>
                  <option value="0" selected> <?php echo ($Grupo->curs_nombre)?></option>
                </select>
              </div>
              
              <div class="col-lg-4 form-group">
                <label for="intTipoCurso"><b>Tipo de curso:</b></label>
                <select class="custom-select" id="intTipoCurso" name="intTipoCurso" disabled>
                  <option value='0' selected ><?php echo $Grupo->curs_tipo ?></option>
                </select>
              </div>

              <div class="col-lg-4 form-group">
                <label for="intNivel"><b>Nivel:</b></label>
                <select class="custom-select" id="intNivel" name="intNivel" disabled>
                  <option value='0' selected ><?php echo $Grupo->curs_nivel ?></option>
                </select>
              </div>
            </div>

            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <div class="col-lg-12 form-group">
                <label for="strObjCurso"><b>Objetivos:</b></label>
                <textarea type="text" class="form-control" id="strObjCurso" name="strObjCurso" disabled><?php echo isset($Grupo->curs_objetivos) ? $Grupo->curs_objetivos : ""; ?></textarea>
              </div>
            </div>

            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <div class="col-lg-12 form-group">
                <label for="strReqTec"><b>Requisitos Técnicos:</b></label>
                <textarea type="text" class="form-control" id="strReqTec" name="strReqTec" disabled><?php echo isset($Grupo->curs_req_tecnicos) ? $Grupo->curs_req_tecnicos : ""; ?></textarea>
              </div>
            </div>

            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <div class="col-lg-12 form-group">
                <label for="strConNeces"><b>Conocimientos Necesarios:</b></label>
                <textarea type="text" class="form-control" id="strConNeces" name="strConNeces" disabled><?php echo isset($Grupo->curs_conocimientos) ? $Grupo->curs_conocimientos : "";?></textarea>
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
                  for="GrupoTipo"><b>Tipo:</b></label>
                <select class="custom-select" id="GrupoTipo" name="GrupoTipo" disabled>
                <option value='0' selected><?php echo $Grupo->grup_tipo ?></option>
                </select>
              </div>
              <div class="col-lg-4 form-group">
                <label for="GrupoModalidad"><b>Modalidad:</b></label>
                <select required='required' class="custom-select" id="GrupoModalidad" name="GrupoModalidad" disabled>
                <option value='0' selected><?php echo $Grupo->moap_nombre ?></option>
                </select>
              </div>
              <div class="col-lg-4 form-group">
                <label for="Estado"><b>Estado:</b></label>
                <select class="custom-select" id="Estado" name="Estado" disabled>
                  <option value='0' selected ><?php echo $Grupo->esta_nombre ?></option>
                </select>
              </div>           
            </div>
            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <div class="col-lg-6 form-group">
                <label for="ID_Profesor"><b>Profesor:</b></label>
                <select class="custom-select" id="ID_Profesor" name="ID_Profesor" disabled>
                  <option value='0' selected ><?php echo $Grupo->pers_nombre." ".$Grupo->pers_apellido_paterno." ".$Grupo->pers_apellido_materno; ?></option>
                </select>
              </div>
              <div class="col-lg-6 form-group">
                <label for="ID_Moderador"><b>Moderador:</b></label>
                <select class="custom-select" id="ID_Moderador" name="ID_Moderador" disabled>
                  <option value='0' selected ><?php if (isset($moderador)) {
                        echo $moderador->pers_nombre." ".$moderador->pers_apellido_paterno." ".$moderador->pers_apellido_materno;
                                              } else {
                                                  echo 'Sin moderador';
                                              } ?></option>
                </select>
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
                  for="GrupoCupo"><b>Lugares disponibles:</b></label>
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
              <b>&nbsp;&nbsp; <?php echo "Datos de la Modalidad: ".$Grupo->moap_nombre;?></b>
            </div>
            <!-- div de la modalidad Presencial -->
            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <?php if (isset($idmodalidad) && $Grupo->grup_id_modalidad == 1) { ?>
              <div id="Edificio" class="col-lg-6 form-group">
              <?php } else {?>
              <div id="Edificio" class="col-lg-6 form-group" style="display: none;">
              <?php }?>
                <label for="lbID_Edificio"><b>Edificio:</b></label>
                <select class="custom-select" id="ID_Salon" name="ID_Edificio">
                  <option value="0" selected> <?php echo $modalidad->edif_nombre; ?></option>
                </select>
              </div>
              <?php if (isset($idmodalidad) && $Grupo->grup_id_modalidad == 1) { ?>
              <div id="Salon" class="col-lg-6 form-group">
              <?php } else {?>
              <div id="Salon" class="col-lg-6 form-group" style="display: none;">
              <?php }?>
                <label for="lbID_Salon"><b>Salon:</b></label>
                <select class="custom-select" id="ID_Salon" name="ID_Salon">
                  <option value="0" selected> <?php echo $modalidad->salo_nombre; ?></option>
                </select>
              </div>
            </div>
            <!-- div de la modalidad En línea -->
            <?php if (isset($idmodalidad) && $Grupo->grup_id_modalidad == 2) { ?>
            <div id="Plataforma" class="col-lg-12 form-group">
            <?php } else {?>
            <div id="Plataforma" class="col-lg-12 form-group" style="display: none;">
            <?php }?>
                <label for="lbID_Plataforma"><b>Plataforma:</b></label>
                <select class="custom-select" id="ID_Plataforma" name="ID_Plataforma">
                  <option value="0" selected> <?php echo isset($modalidad) ? $modalidad->plat_nombre : ""; ?></option>
                </select>
            </div>
            
            <?php if (isset($idmodalidad) && $Grupo->grup_id_modalidad == 2 && $_POST['CRUD'] == 1 && $Grupo->esta_nombre == 'En curso' && (isset($inscrito) && $inscrito->insc_activo == 't')) { ?>
            <div id="URL" class="col-lg-12 form-group">
            <?php } else {?>
            <div id="URL" class="col-lg-12 form-group" style="display: none;">
            <?php }?>
                <label for="lbURL_Acceso"><b>URL de acceso:</b></label>
                <input type="text" class="form-control" id="URL" name="URL"
                        value="<?php echo isset($modalidad) ? $modalidad->grup_url : ""; ?>">
            </div>
            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <?php if (isset($idmodalidad) && $Grupo->grup_id_modalidad == 2 && $_POST['CRUD'] == 1 && $Grupo->esta_nombre == 'En curso' && (isset($inscrito) && $inscrito->insc_activo == 't')) { ?>
              <div id="ID_Acceso" class="col-lg-6 form-group">
              <?php } else {?>
              <div id="Reunion" class="col-lg-6 form-group" style="display: none;">
              <?php }?>
                <label for="lbID_Acceso"><b>ID de la Reunión:</b></label>
                <input type="text" class="form-control" id="ID_Acceso" name="ID_Acceso" 
                  value="<?php echo isset($modalidad) ? $modalidad->grup_id_acceso: ""; ?>">
              </div>
              <?php if (isset($idmodalidad) && $Grupo->grup_id_modalidad == 2 && $_POST['CRUD'] == 1 && $Grupo->esta_nombre == 'En curso' && (isset($inscrito) && $inscrito->insc_activo == 't')) { ?>
              <div id="Clave" class="col-lg-6 form-group">
              <?php } else {?>
              <div id="Clave" class="col-lg-6 form-group" style="display: none;">
              <?php }?>
                <label for="lbClave_Acceso"><b>Clave de Acceso:</b></label>
                <input type="text" class="form-control" id="Clave_Acceso" name="Clave_Acceso"
                  value="<?php echo isset($modalidad) ? $modalidad->grup_clave_acceso : ""; ?>">
              </div>
            </div>
            
            <!-- div de la modalidad Autogestionable -->
            <?php if (isset($idmodalidad) && $Grupo->grup_id_modalidad == 3) { ?>
            <div id="URL" class="col-lg-12 form-group">
            <?php } else {?>
            <div id="URL" class="col-lg-12 form-group" style="display: none;">
            <?php }?>
                <label for="lbURL_Acceso"><b>URL de acceso:</b></label>
                <input type="text" class="form-control" id="URL" name="URL"
                        value="<?php echo isset($modalidad) ? $modalidad->grup_url : ""; ?>">
            </div>

          </div>
        </div>
        <!-- Fin de Sección: Modalidad -->

        <!-- Inicio de Sección: Sesiones -->
        <div id="Sesiones" class="form-group">
        <?php
        $i = 1;
        foreach ($arr_Sesiones as $Sesion) {
            $idSesion = "idSesion".$i;
            $SesionFecha = "SesionFecha".$i;
            $SesionHoraInicio = "SesionHoraInicio".$i;
            $SesionHoraFin = "SesionHoraFin".$i; ?>
          
          <div class="card lg-12">
            <div class="card-header">
              <i class="fas fa-id-card fa-lg"></i>
              <b>&nbsp;&nbsp; <?php echo "Sesión #".$i; ?></b>
              <input type="hidden" id="<?php echo $idSesion;?>" name="idSesion[]" value="<?php echo $Sesion['sesi_id_sesion'];?>">
            </div>
            <div class="col-lg-12 form-row" style="margin-top: 15px;">
              <div id="<?php echo $SesionFecha;?>" class="col-lg-6 form-group">
                <label for="<?php echo $SesionFecha;?>"><b>Fecha:</b></label>
                <input type="date" class="form-control" id="<?php echo $SesionFecha;?>"
                  name="SesionFecha[]" placeholder="0" min="0"
                  value="<?php echo isset($Sesion)?$Sesion['sesi_fecha']:""; ?>">
              </div>
              <div id="<?php echo $SesionHoraInicio;?>" class="col-lg-3 form-group">
                <label for="<?php echo $SesionHoraInicio;?>"><b>Hora de inicio:</b></label>
                <input type="time" class="form-control" id="<?php echo $SesionHoraInicio;?>"
                  name="SesionHoraInicio[]>" placeholder="0" min="0"
                  value="<?php echo isset($Sesion)?$Sesion['sesi_hora_inicio']:"";?>">
              </div>
              <div id="<?php echo $SesionHoraFin;?>" class="col-lg-3 form-group">
                <label for="<?php echo $SesionHoraFin;?>"><b>Hora de fin:</b></label>
                <input type="time" class="form-control" id="<?php echo $SesionHoraFin;?>"
                  name="SesionHoraFin[]>" placeholder="0" min="0"
                  value="<?php echo isset($Sesion)?$Sesion['sesi_hora_fin']:"";?>">
              </div>
            </div>
          </div>
            <?php $i++;
        } ?>
        </div>
        <!-- Fin de Sección: Sesiones -->

        <!-- Desactivar formulario FIN -->
        <?php if (isset($_POST['CRUD']) && $_POST['CRUD'] == 0 || $_POST['CRUD'] == 1) { ?>
            </fieldset>
        <?php } ?>
      </form>
    </div>
    <!-- Botones -->
    <div class="col-lg-12" style="text-align: center;">
      <button id="btn-regresar-grupo" type="button" class="btn btn-primary btn-footer btn-regresar">Regresar</button>
      <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 0 || $_POST['CRUD'] == 1) { ?>
          <a id="temarioDW" href="<?php echo isset($Curso1) ? $Curso1 -> curs_temario : "No subido"; ?>" download
              class="btn btn-descarga" role="button"><i class="fas fa-file-download"
                style="padding-right: 10px;"></i>Descargar temario</a>

                <?php
                if (isset($persona)  && isset($Grupo)) {

                    $periodoInscripcion = $obj_Inscripcion->buscarVigenciaInscripcion($Grupo->grup_id_grupo);

                  //? Se verifica que el periodo de inscripción del grupo se vigente, si no no aparece nada
                    if (isset($periodoInscripcion)) {
                  //? Si el profesor ya esta inscrito el botón no aparece
                        if (!isset($inscrito)) {
                              //? Si se ha agotado el cupo del grupo
                            if ($Grupo->grup_num_inscritos == $Grupo->grup_cupo) {
                                echo ("<p class = 'aviso-rojo'>Ya no hay cupo para inscribirse a este grupo.</p>");
                            } else { ?>
                <button id="btn-inscripcion-grupo" type="button" class="btn btn-success btn-footer btn-aceptar" 
                  onclick="inscribirGrupo(<?php echo $Grupo->grup_id_grupo?>, <?php echo $Grupo->grup_num_inscritos?>, <?php echo $Grupo->grup_cupo?>, <?php echo $persona->pers_id_persona?>, '<?php echo $Curso1->curs_nombre?>', '<?php echo $Curso1->curs_tipo?>', '<?php echo $Curso1->curs_nivel?>')">Inscribirse</button>
                            <?php } ?>
                        <?php } else {
                          if ($inscrito->insc_activo == 't'){
                            echo ("<p class = 'aviso-rojo'>Ya se encuentra inscrito a este grupo</p>");
                          } else {
                            echo ("<p class = 'aviso-rojo'>Estaba inscrito a este grupo, pero cancelo su inscripción</p>");
                          }
                        }
                    } else {
                      if ($_POST['CRUD'] == 0) {
                        echo ("<p class = 'aviso-rojo'>El periodo de inscripción  a este grupo finalizo</p>"); 
                      }
                    }?>
                <?php } ?>
            <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>



<script src="../sistema/profesor/control_profesores.js"></script>
