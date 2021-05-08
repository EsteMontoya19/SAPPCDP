<?php
include('../../clases/BD.php');
include('../../clases/Curso.php');

// TODO: Confirmar datos
$curso = new Curso();
$curso -> curs_id_curso=null;
$curso -> curs_tipo=null;
$curso -> curs_nombre=null;
$curso -> curs_num_sesiones=null;
$curso -> curs_req_tecnicos=null;
$curso -> curs_conocimientos=null;
$curso -> curs_nivel=null;
$curso -> curs_objetivos=null;
$curso -> curs_temario=null;

  if (isset($_POST['curso']) && isset($_POST['id'])) { 
  // TODO: Modificar de acuerdo a Cursos
    // Recuperar información de consulta
    $obj_Curso = new Curso();
    $curso = $obj_Curso->buscarCurso($_POST['curso']);

    switch ($curso->rol_id_rol) {
      case 1: //Administrador
        $obj_Administrador = new Administrador();
        $administrador = $obj_Administrador->buscarAdministrador($_POST['persona']);
      break;

      case 2: //Moderador
        $obj_Moderador = new Moderador();
        $moderador = $obj_Moderador->buscarModerador($_POST['persona']);
        $moderador_dia = $obj_Moderador->buscarModeradorDias($moderador->mode_id_moderador);
      break;

      case 3: //Profesor
        $obj_Profesor = new Profesor();
        $profesor = $obj_Profesor->buscarProfesor($_POST['persona']);
        $profesor_nivel = $obj_Profesor->buscarProfesorNiveles($profesor->prof_id_profesor);
        $profesor_modalidad = $obj_Profesor->buscarProfesorModalidades($profesor->prof_id_profesor);
        $profesor_coordinacion = $obj_Profesor->buscarProfesorCoordinaciones($profesor->prof_id_profesor);
      break;
      
    }
  }
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-cursos" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Cursos</a>
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
      <form name="form_cursos" id="form_cursos" method="POST">

        <!-- Desactivar formulario INICIO en caso de no ser un registro-->
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 0) { ?>
        <fieldset disabled>
          <?php } ?>
          <?php } ?>

          <div class="form-group">
            <!-- Datos generales -->
            <div class="card lg-12" style="padding: 15px;">
              <div class="col-lg-12 form-row">

                <div id="nombre" class="col-lg-6 form-group">
                  <label for="strNombreCurso"><b>Nombre: *</b></label>
                  <input type="text" class="form-control" id="strNombreCurso" name="strNombreCurso"
                    value="<?php echo isset($curso) ? $curso->curs_nombre : ""; ?>">
                </div>

                <div class="col-lg-3 form-group">
                  <label for="intTipoCurso"><b>Tipo de curso: *</b></label>
                  <select class="custom-select" id="intTipoCurso" name="intTipoCurso" onchange="ocultar(this.value)">
                    <option value='0'>Seleccione una opción</option>
                    <option value='1'>Curso</option>
                    <option value='2'>Taller</option>
                  </select>
                </div>

                <div id="nivel" class="col-lg-3 form-group">
                  <label for="intTipoCurso"><b>Nivel: *</b></label>
                  <select class="custom-select" id="intTipoCurso" name="intTipoCurso">
                    <option value="0">Seleccione una opción</option>
                    <option value="Basico">Básico</option>
                    <option value="Intermedio">Intermedio</option>
                    <option value="Avanzado">Avanzado</option>
                  </select>
                </div>



                <div class="col-lg-6 form-group">
                  <label for="strReqTec"><b>Requisitos Técnicos: *</b></label>
                  <textarea type="text" class="form-control" id="strReqTec" name="strReqTec"></textarea>
                </div>

                <div class="col-lg-6 form-group">
                  <label for="strObjCurso"><b>Objetivos del curso: *</b></label>
                  <textarea type="text" class="form-control" id="strObjCurso" name="strObjCurso"></textarea>
                </div>

                <div class="col-lg-6 form-group">
                  <label for="strConNeces"><b>Conocimientos necesarios: *</b></label>
                  <textarea type="text" class="form-control" id="strConNeces" name="strConNeces"></textarea>
                </div>


                <div id="numeroSesiones" class="col-lg-6 form-group" style="display:show;">
                  <label for="strNumeroSesiones"><b>Número de sesiones: *</b></label>
                  <input class="form-control numeros_permitidos" type="number" min="0" max="20" class="form-control"
                    id="strNumeroSesiones" name="strNumeroSesiones">
                </div>

                <div class="col-lg-6 form-group">
                  <label for="temario"><b>Temario:</b></label>
                  <div class="custom-file">
                    <input type="file" accept="application/pdf" id="temario" name="temario" class="custom-file-input" />
                    <label class="custom-file-label" for="temario">Selecciona un archivo</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </form>

      <!-- Botones -->
      <div class="col-lg-12" style="text-align: center;">
        <button id="btn-regresar-curso" type="button" class="btn btn-success btn-footer">Regresar</button>
        <button type="button" class="btn btn-success btn-footer">Guardar</button>
      </div>

    </div>
  </div>
</div>

<script src="../sistema/cursos/control_cursos.js"></script>