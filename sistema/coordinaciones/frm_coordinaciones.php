<?php
include('../../clases/BD.php');
include('../../clases/Coordinacion.php');

$obj_coordinacion = new Coordinacion();

if (isset($_POST['id'])) {
    // Recuperar información de consulta
    $coordinacion = $obj_coordinacion->buscarCoordinacion($_POST['id']);
}
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-coordinacion" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Coordinacion </a>
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





      <form name="form_coordinaciones" id="form_coordinaciones" method="POST" enctype="multipart/form-data"
        action="../modulos/Control_coordinacion.php">

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
              <b>&nbsp;&nbsp;Coordinacion</b>
            </div>
          </div>  
          <div class="card lg-12" style="padding: 15px;">
            <div class="col-lg-12 form-row">
               <div class="col-lg-6 form-group">
                <label for="coordinacion"><b>Coordinacion: *</b></label>
                <input type="text" class="form-control" id="NombreCoordinacion" name="NombreCoordinacion"
                value="<?php echo isset($coordinacion) ? $coordinacion->coor_nombre : ""; ?>">
              </div>
            </div>
          </div>
          


          <!-- ID e Instrucciones -->
          <?php if (isset($_POST['CRUD'])) { ?>
                <?php if ($_POST['CRUD'] == 1) { ?>
            <input type="hidden" name="dml" value="update"/>
            <input type="hidden" id="id_coordinacion" name="id_coordinacion" value="<?php echo $_POST['id'];?>">
                <?php }
          } else { ?>
            <input type="hidden" name="dml" value="insert" />
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
        <button id="btn-regresar-coordinacion" type="button" class="btn btn-success btn-footer btn-regresar">Regresar</button>
        <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 1) { ?>
        <button id="btn-actualizar-coordinacion" type="button"
          class="btn btn-success btn-footer btn-aceptar">Actualizar</button>
            <?php } ?>
        <?php } else { ?>
        <button id="btn-registrar-coordinacion" type="button" form="form_preguntasseguridad"
          class="btn btn-success btn-footer btn-aceptar">Guardar</button>
        <?php } ?>
      </div>
    </div>
  </div>

  <script src="../sistema/coordinaciones/control_coordinaciones.js"></script>
