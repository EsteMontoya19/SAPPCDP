<?php
include('../../clases/BD.php');
include('../../clases/PreguntaSeguridad.php');

$obj_PreguntaSeguridad = new PreguntaSeguridad();

  if (isset($_POST['id'])) {
    // Recuperar información de consulta
    $preguntaseguridad = $obj_PreguntaSeguridad->buscarPreguntaSeguridad($_POST['id']);
  }
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-preguntaseguridad" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Pregunta de Seguridad</a>
        </li>
        <!-- Validación de la ruta -->
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 1) { ?>
        <li class="breadcrumb-item active"><i class="fas fa-edit"></i>&nbsp; Actualizar registro</li>
        <?php }
        } else { ?>
        <li class="breadcrumb-item active"><i class="fas fa-folder-plus"></i>&nbsp; Nuevo registro</li>
        <?php } ?>
      </ol>

      <p>
        <hr>
      </p>

      <!-- Formulario -->





      <form name="form_preguntasseguridad" id="form_preguntasseguridad" method="POST" enctype="multipart/form-data"
        action="../modulos/Control_PreguntaSeguridad.php">

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
              <b>&nbsp;&nbsp;Pregunta de Seguridad</b>
            </div>
          </div>  
          <div class="card lg-12" style="padding: 15px;">
            <div class="col-lg-12 form-row">
               <div class="col-lg-6 form-group">
                <label for="PreguntaSeguridad"><b>Pregunta de Seguridad: *</b></label>
                <input type="text" class="form-control" id="NombrePreguntaSeguridad" name="NombrePreguntaSeguridad"
                value="<?php echo isset($preguntaseguridad) ? $preguntaseguridad->prse_pregunta : ""; ?>">
              </div>
            </div>
          </div>
          


          <!-- ID e Instrucciones -->
          <?php if (isset($_POST['CRUD'])) { ?>
          <?php if ($_POST['CRUD'] == 1) { ?>
            <input type="hidden" name="dml" value="update"/>
            <input type="hidden" id="id_PreguntaSeguridad" name="id_PreguntaSeguridad" value="<?php echo $_POST['id'];?>">
          <?php }} else { ?>
            <input type="hidden" name="dml" value="insert" />
            <input type="hidden" id="EstatusPreguntaSeguridad" name="EstatusPreguntaSeguridad" value="true">
          <?php } ?>



          <!-- Desactivar formulario FIN -->
          <?php if (isset($_POST['CRUD'])) { ?>
          <?php if ($_POST['CRUD'] == 0) { ?>
        </fieldset>
        <?php } ?>
        <?php } ?>

      </form>
      
      <!-- Botones -->
      <div class="col-lg-12" style="text-align: center;">
        <button id="btn-regresar-preguntaseguridad" type="button" class="btn btn-success btn-footer btn-regresar">Regresar</button>
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 1) { ?>
        <button id="btn-actualizar-preguntaseguridad" type="button"
          class="btn btn-success btn-footer btn-aceptar">Actualizar</button>
        <?php } ?>
        <?php } else { ?>
        <button id="btn-registrar-preguntaseguridad" type="button" form="form_preguntasseguridad"
          class="btn btn-success btn-footer btn-aceptar">Guardar</button>
        <?php } ?>
      </div>
    </div>
  </div>

  <script src="../sistema/preguntasseguridad/control_preguntasseguridad.js"></script>