<?php
  include('../../clases/BD.php');
  include('../../clases/Coordinacion.php');

  $obj_Coordinacion = new Coordinacion();
  $arr_coordinaciones = $obj_Coordinacion->buscarTodasCoordinaciones();
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <!-- Indicador -->
      <div class="form-inline">
        <div class="col-sm-10" style="padding:0px">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-user-shield"></i>&nbsp; Coordinaciones
            </li>
          </ol>
        </div>
        <div class="col-sm-2" aligne="center">
          <a href="#">
            <button id="btn-registro-coordinacion" type="button" class="btn btn-success">
              <i class="fas fa-plus-circle"></i>&nbsp;&nbsp; Agregar
            </button>
          </a>
        </div>
      </div> 

      <p>
        <hr>
      </p>
    
      <!-- Tabla -->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-folder"></i>&nbsp; &nbsp;Resultados
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-condensed table-hover" id="tabla_coordinaciones" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>Coordinacion</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if (isset($arr_coordinaciones)){
                foreach ($arr_coordinaciones as $coordinacion) { ?>
                  <tr>
                    <td><?php echo $coordinacion['coor_id_coordinacion']; ?></td>
                    <td><?php echo $coordinacion['coor_nombre']; ?></td>
                    <td>
                      <button type="button" class="btn btn-primary btn-table" title="Actualizar"
                        onclick="actualizarCoordinacion(<?php echo $coordinacion['coor_id_coordinacion']?>)">
                        <i class="fas fa-edit"></i>
                      </button> 
                    </td>
                  </tr>
                <?php }} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>  
    </div>
  </div>
</div>

<script src="../sistema/coordinaciones/control_coordinaciones.js"></script>