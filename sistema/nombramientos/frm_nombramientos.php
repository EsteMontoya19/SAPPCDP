<?php
include('../../clases/BD.php');
include('../../clases/Nombramiento.php');

$obj_nombramiento = new Nombramiento();

  if (isset($_POST['id'])) {
    // Recuperar información de consulta
    $nombramiento = $obj_nombramiento->buscarNombramiento($_POST['id']);
  }
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-nombramiento" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Nombramiento </a>
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
      <form name="form_nombramientos" id="form_nombramientos" method="POST" enctype="multipart/form-data"
        action="../modulos/Control_nombramiento.php">

        <!-- Desactivar formulario INICIO en caso de no ser un registro-->
        <?php if (isset($_POST['CRUD'])) { ?>
          <?php if ($_POST['CRUD'] == 0) { ?>
            <fieldset fieldset disabled>
          <?php } ?>
        <?php } ?>

          <!-- Datos generales -->
          <div class="form-group">
            <div class="card-header">
              <i class="fas fa-id-card fa-lg"></i>
              <b>&nbsp;&nbsp;Nombramiento</b>
            </div>
          </div>  
          <div class="card lg-12" style="padding: 15px;">
            <div class="col-lg-12 form-row">
               <div class="col-lg-6 form-group">
                <label for="nombramiento"><b>Nombramiento: *</b></label>
                <input type="text" class="form-control" id="NombreNombramiento" name="NombreNombramiento"
                value="<?php echo isset($nombramiento) ? $nombramiento->nomb_descripcion : ""; ?>">
              </div>
            </div>
          </div>
          


          <!-- ID e Instrucciones -->
          <?php if (isset($_POST['CRUD'])) { ?>
          <?php if ($_POST['CRUD'] == 1) { ?>
            <input type="hidden" name="dml" value="update"/>
            <input type="hidden" id="id_nombramiento" name="id_nombramiento" value="<?php echo $_POST['id'];?>">
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
        <button id="btn-regresar-nombramiento" type="button" class="btn btn-success btn-footer btn-regresar">Regresar</button>
        <?php if (isset($_POST['CRUD'])) { ?>
        <?php if ($_POST['CRUD'] == 1) { ?>
        <button id="btn-actualizar-nombramiento" type="button"
          class="btn btn-success btn-footer btn-aceptar">Actualizar</button>
        <?php } ?>
        <?php } else { ?>
        <button id="btn-registrar-nombramiento" type="button" form="form_preguntasseguridad"
          class="btn btn-success btn-footer btn-aceptar">Guardar</button>
        <?php } ?>
      </div>
    </div>
  </div>

  <script src="../sistema/nombramientos/control_nombramientos.js"></script>