<?php
include('../../clases/BD.php');
include('../../clases/Plataforma.php');

$obj_plataforma = new Plataforma();

if (isset($_POST['id'])) {
    // Recuperar información de consulta
    $platarforma = $obj_plataforma->buscarPlataforma($_POST['id']);
}
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-plataforma" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Plataformas</a>
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





      <form name="form_plataformas" id="form_plataformas" method="POST" enctype="multipart/form-data"
        action="../modulos/Control_Plataforma.php">

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
              <b>&nbsp;&nbsp;Plataforma</b>
            </div>
          </div>  
          <div class="card lg-12" style="padding: 15px;">
            <div class="col-lg-12 form-row">
               <div class="col-lg-6 form-group">
                <label for="NombrePlataforma"><b>Nombre Plataforma: *</b></label>
                <input type="text" class="form-control" id="NombrePlataforma" name="NombrePlataforma"
                value="<?php echo isset($platarforma) ? $platarforma->plat_nombre : ""; ?>">
              </div>
            </div>
          </div>
          


          <!-- ID e Instrucciones -->
          <?php if (isset($_POST['CRUD'])) { ?>
                <?php if ($_POST['CRUD'] == 1) { ?>
            <input type="hidden" name="dml" value="update"/>
            <input type="hidden" id="id_Plataforma" name="id_Plataforma" value="<?php echo $_POST['id'];?>">
                <?php }
          } else { ?>
            <input type="hidden" name="dml" value="insert" />
            <input type="hidden" id="EstatusPlataforma" name="EstatusPlataforma" value="true">
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
        <button id="btn-regresar-plataforma" type="button" class="btn btn-success btn-footer btn-regresar">Regresar</button>
        <?php if (isset($_POST['CRUD'])) { ?>
            <?php if ($_POST['CRUD'] == 1) { ?>
        <button id="btn-actualizar-plataforma" type="button"
          class="btn btn-success btn-footer btn-aceptar">Actualizar</button>
            <?php } ?>
        <?php } else { ?>
        <button id="btn-registrar-plataforma" type="button" form="form_plataformas"
          class="btn btn-success btn-footer btn-aceptar">Guardar</button>
        <?php } ?>
      </div>
    </div>
  </div>

  <script src="../sistema/plataformas/control_plataformas.js"></script>
