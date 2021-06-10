<?php
  include('../../clases/BD.php');
  include('../../clases/PreguntaSeguridad.php');

  $obj_PreguntaSeguridad = new PreguntaSeguridad();
  $arr_preguntasseguridad = $obj_PreguntaSeguridad->buscarTodasPreguntaSeguridad();
?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <!-- Indicador -->
      <div class="form-inline">
        <div class="col-sm-10" style="padding:0px">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-user-shield"></i>&nbsp; Preguntas de Seguridad
            </li>
          </ol>
        </div>
        <div class="col-sm-2" aligne="center">
          <a href="#">
            <button id="btn-registro-preguntaseguridad" type="button" class="btn btn-success">
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
            <table class="table table-condensed table-hover" id="tabla_preguntasseguridad" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>Pregunta de Seguridad</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($arr_preguntasseguridad as $preguntasseguridad) { ?>
                  <tr>
                    <td><?php echo $preguntasseguridad['prse_id_pregunta']; ?></td>
                    <td><?php echo $preguntasseguridad['prse_pregunta']; ?></td>
                    <td>
                      <button type="button" class="btn btn-primary btn-table" title="Actualizar"
                        onclick="actualizarPreguntaSeguridad(<?php echo $preguntasseguridad['prse_id_pregunta']?>)">
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

<script src="../sistema/preguntasseguridad/control_preguntasseguridad.js"></script>