<?php
  include('../../clases/BD.php');
  include('../../clases/Plataforma.php');

  $obj_plataforma = new Plataforma();
  $arr_plataformas = $obj_plataforma->buscarTodasPlataformas();

  $x = 0;
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <!-- Indicador -->
      <div class="form-inline">
        <div class="col-sm-10" style="padding:0px">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-user-shield"></i>&nbsp; Plataformas
            </li>
          </ol>
        </div>
        <div class="col-sm-2" aligne="center">
          <a href="#">
            <button id="btn-registro-plataforma" type="button" class="btn btn-success">
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
            <table class="table table-condensed table-hover" id="tabla_plataformas" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>Plataforma</th>
                  <th>Estatus</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if (isset($arr_plataformas)){
                foreach ($arr_plataformas as $plataformas) { ?>
                  <tr>
                  <?php $x++; ?>
                    <td><?php echo $plataformas['plat_id_plataforma']; ?></td>
                    <td><?php echo $plataformas['plat_nombre']; ?></td>
                    <td>
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input"
                            id="estatusPlataforma<?php echo $x ?>"
                            <?php if ($plataformas['plat_activo'] == 't') { ?> checked <?php } ?>
                            onclick="cambioEstatus(<?php echo $plataformas['plat_id_plataforma']; ?> , '<?php echo $plataformas['plat_activo']; ?>', '<?php echo $plataformas['plat_nombre']; ?>')">
                        <label class="custom-control-label"
                            for="estatusPlataforma<?php echo $x ?>"></label>
                      </div>
                    <td>
                      <button type="button" class="btn btn-primary btn-table" title="Actualizar"
                        onclick="actualizarPlataforma(<?php echo $plataformas['plat_id_plataforma']?>)">
                        <i class="fas fa-edit"></i>
                      </button> 
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>  
    </div>
  </div>
</div>

<script src="../sistema/plataformas/control_plataformas.js"></script>