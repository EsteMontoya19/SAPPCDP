<?php
  include('../../clases/BD.php');
  include('../../clases/Nombramiento.php');

  $obj_Nombramiento = new Nombramiento();
  $arr_nombramientos = $obj_Nombramiento->buscarTodosNombramientos();
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <!-- Indicador -->
      <div class="form-inline">
        <div class="col-sm-10" style="padding:0px">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-user-shield"></i>&nbsp; Nombramientos
            </li>
          </ol>
        </div>
        <div class="col-sm-2" aligne="center">
          <a href="#">
            <button id="btn-registro-nombramiento" type="button" class="btn btn-success">
              <i class="fas fa-plus-circle"></i>&nbsp;&nbsp; Agregar nuevo
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
            <table class="table table-condensed table-hover" id="tabla_nombramientos" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>Nombramiento</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if (isset($arr_nombramientos)){
                foreach ($arr_nombramientos as $nombramiento) { ?>
                  <tr>
                    <td><?php echo $nombramiento['nomb_id_nombramiento']; ?></td>
                    <td><?php echo $nombramiento['nomb_descripcion']; ?></td>
                    <td>
                      <button type="button" class="btn btn-primary btn-table" title="Actualizar"
                        onclick="actualizarNombramiento(<?php echo $nombramiento['nomb_id_nombramiento']?>)">
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

<script src="../sistema/nombramientos/control_nombramientos.js"></script>