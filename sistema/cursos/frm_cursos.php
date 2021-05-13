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

  if (isset($_POST['id'])) {
    // Recuperar información de consulta
    $obj_Curso = new Curso();
    $curso = $obj_Curso->buscarCurso($_POST['id']);
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





      <form name="form_cursos" id="form_cursos" method="POST" enctype="multipart/form-data"
        action="../modulos/Control_Curso.php">

        <!-- Desactivar formulario INICIO en caso de no ser un registro-->
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 0) { ?>
        <fieldset disabled>
          <?php } ?>
          <?php } ?>

          <!-- Datos generales -->
          <div class="form-group">
            <div class="card-header">
              <i class="fas fa-id-card fa-lg"></i>
              <b>&nbsp;&nbsp;Datos del curso</b>
            </div>
            <div class="card lg-12" style="padding: 15px;">

              <div class="col-lg-12 form-row" style="margin-top: 15px;">

                <div id="nombre" class="col-lg-6 form-group">
                  <label for="strNombreCurso"><b>Nombre:
                      <?php if (isset($_POST['CRUD']) == false || $_POST['CRUD'] == 1)  echo "*"; ?></b></label>
                  <input type="text" class="form-control" id="strNombreCurso" name="strNombreCurso"
                    value="<?php echo isset($curso) ? $curso->curs_nombre : ""; ?>">
                </div>

                <div class="col-lg-3 form-group">
                  <label for="intTipoCurso"><b>Tipo de curso:
                      <?php if (isset($_POST['CRUD']) == false || $_POST['CRUD'] == 1)  echo "*"; ?></b></label>
                  <select class="custom-select" id="intTipoCurso" name="intTipoCurso">
                    <option value='0'>Seleccione una opción</option>
                    <option value='Curso'
                      <?php if (isset($curso) && $curso->curs_tipo == "Curso") { echo "selected"; }?>>Curso</option>
                    <option value='Taller'
                      <?php if (isset($curso) && $curso->curs_tipo == "Taller") { echo "selected"; }?>>Taller</option>
                    <!-- TODO: Ingresar php para selected option value-->
                  </select>
                </div>

                <div class="col-lg-3 form-group">
                  <label for="intNivel"><b>Nivel:
                      <?php if (isset($_POST['CRUD']) == false || $_POST['CRUD'] == 1)  echo "*"; ?></b></label>
                  <select class="custom-select" id="intNivel" name="intNivel">
                    <option value="0">Seleccione una opción</option>
                    <option value='Básico'
                      <?php if (isset($curso) && $curso->curs_nivel == "Básico") { echo "selected"; }?>>Básico</option>
                    <option value='Intermedio'
                      <?php if (isset($curso) && $curso->curs_nivel == "Intermedio") { echo "selected"; }?>>Intermedio
                    </option>
                    <option value='Avanzado'
                      <?php if (isset($curso) && $curso->curs_nivel == "Avanzado") { echo "selected"; }?>>Avanzado
                    </option>
                  </select>
                </div>



                <div class="col-lg-6 form-group">
                  <label for="strReqTec"><b>Requisitos Técnicos:
                    </b></label>
                  <textarea type="text" class="form-control" id="strReqTec"
                    name="strReqTec"><?php echo isset($curso) ? $curso-> curs_req_tecnicos: ""; ?></textarea>
                </div>

                <div class="col-lg-6 form-group">
                  <label for="strObjCurso"><b>Objetivos del curso:
                      <?php if (isset($_POST['CRUD']) == false || $_POST['CRUD'] == 1)  echo "*"; ?></b></label>
                  <textarea type="text" class="form-control" id="strObjCurso"
                    name="strObjCurso"><?php echo isset($curso) ? $curso -> curs_objetivos: ""; ?></textarea>
                </div>

                <div class="col-lg-6 form-group">
                  <label for="strConNeces"><b>Conocimientos necesarios:
                    </b></label>
                  <textarea type="text" class="form-control" id="strConNeces"
                    name="strConNeces"><?php echo isset($curso) ? $curso -> curs_conocimientos: ""; ?></textarea>
                </div>


                <div id="numeroSesiones" class="col-lg-6 form-group" style="display:show;">
                  <label for="strNumeroSesiones"><b>Número de sesiones:
                      <?php if (isset($_POST['CRUD']) == false || $_POST['CRUD'] == 1)  echo "*"; ?></b></label>
                  <input class="form-control numeros_permitidos" type="number" min="1" max="20" class="form-control"
                    id="strNumeroSesiones" name="strNumeroSesiones"
                    value="<?php echo isset($curso) ? $curso->curs_num_sesiones : ""; ?>">
                </div>

                <div class="col-lg-6 form-group">
                  <label for="temario"><b>Temario:</b></label>
                  <div class="custom-file">
                    <input type="file" id="temario" name="temario" class="custom-file-input" accept="application/pdf"
                      <?php echo !isset($curso) ? "require": ""; ?> required>
                    <label class="custom-file-label"
                      for="temario"><?php echo isset($curso) ? $curso -> curs_temario: ""; ?></label>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <!-- ID e Instrucciones -->
          <?php if (isset($_POST['CRUD'])) { ?>
          <?php if ($_POST['CRUD'] == 1) { ?>
          <input type="hidden" name="dml" value="update" />
          <input type="hidden" id="idCurso" name="idCurso" value="<?php echo $_POST['id'];?>">
          <input type="hidden" id="bEstado" name="bEstado" value="true">
          <?php } elseif ($_POST['CRUD'] == 0) { ?>
          <input type="hidden" name="dml" value="select" />
          <?php } ?>
          <?php } else { ?>
          <input type="hidden" name="dml" value="insert" />
          <?php } ?>



          <!-- Desactivar formulario FIN -->
          <?php if (isset($_POST['CRUD'])) { ?>
          <?php if ($_POST['CRUD'] == 0) { ?>
        </fieldset>
        <?php } ?>
        <?php } ?>

      </form>
      <!--! Este código lo descarga con el nombre del archivo original según el href que debes modificar con php -->

      <!-- Botones -->
      <div class="col-lg-12" style="text-align: center;">
        <button id="btn-regresar-curso" type="button" class="btn btn-success btn-footer btn-regresar">Regresar</button>
        <a id="temarioDW" href="<?php echo isset($curso) ? $curso -> curs_temario : "No subido"; ?>" download
          class="btn btn-descarga" role="button"><i class="fas fa-file-download"
            style="padding-right: 10px;"></i>Descargar temario</a>
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 1) { ?>
        <button id="btn-actualizar-curso" type="button"
          class="btn btn-success btn-footer btn-aceptar">Actualizar</button>
        <?php } ?>
        <?php } else { ?>
        <button id="btn-registrar-curso" type="button" form="form_cursos"
          class="btn btn-success btn-footer btn-aceptar">Guardar</button>
        <?php } ?>
      </div>
    </div>
  </div>

  <script src="../sistema/cursos/control_cursos.js"></script>