<?php
  include('../../clases/BD.php');
  include('../../clases/Calendario.php');

  $obj_Calendario = new Calendario();

  
  $arr_calendarios = $obj_Calendario->buscarCalendarios();
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <!-- Indicador -->
      <div class="form-inline">
        <div class="col-sm-10" style="padding:0px">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="far fa-calendar-times"></i>&nbsp; Calendarios
            </li>
          </ol>
        </div>
        <div class="col-sm-2" align="center">
          <a href="#">
            <button id="btn-registro-calendarios" type="button" class="btn btn-success">
              <i class="fas fa-plus-circle"></i>&nbsp;&nbsp; Agregar calendario
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
            <table class="table table-condensed table-hover" id="tabla_calendarios" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>Semestre</th>
                  <th>Inicio ciclo</th>
                  <th>Fin ciclo</th>
                  <th>Estado</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
               
                  <?php foreach ($arr_calendarios as $iCont => $calendario) { ?>
                  <tr>
                    <td><?php echo $calendario['cale_id_calendario'];?></td>
                    <td><?php echo $calendario['cale_semestre'];?></td>
                    <td><?php echo $calendario['cale_inicio_ciclo'];?></td>
                    <td><?php echo $calendario['cale_fin_ciclo'];?></td>
                    <td>
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input"
                            id="estatusCalendario<?php echo $calendario['cale_id_calendario']; ?>"
                            <?php if ($calendario['cale_activo'] == 't') { ?>  checked <?php } ?>
                            onclick="cambioEstatus(<?php echo $calendario['cale_id_calendario']; ?> , '<?php echo $calendario['cale_activo']; ?>', '<?php echo $calendario['cale_semestre']; ?>')">
                        <label class="custom-control-label"
                            for="estatusCalendario<?php echo $calendario['cale_id_calendario']; ?>"></label>
                      </div>
                    </td>

                    <td>
                      <button type="button" class="btn btn-info btn-table" title="Detalles" onclick="consultarCalendario(<?php echo $calendario['cale_id_calendario'] ?>)">
                        <i class="fas fa-search-plus"></i>
                      </button>
                      
                      <button type="button" class="btn btn-primary btn-table" title="Actualizares" onclick="actualizarCalendario(<?php echo $calendario['cale_id_calendario'] ?>)">
                        <i class="fas fa-edit"></i>
                      </button>
                      
                      <button type="button" class="btn btn-danger btn-table" title="Eliminar">
                        <i class="fas fa-trash-alt"></i>
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

<script src="../sistema/calendarios/calendarios.js"></script>