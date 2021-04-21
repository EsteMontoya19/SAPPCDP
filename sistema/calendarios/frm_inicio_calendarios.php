<?php
  include('../../clases/BD.php');
  include('../../clases/Usuario.php');

  $obj_usuario = new Usuario();
  $arr_usuarios = $obj_usuario->buscarTodosUsuarios();

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
              <i class="fas fa-user-shield"></i>&nbsp; Calendarios
            </li>
          </ol>
        </div>
        <div class="col-sm-2" align="center">
          <a href="#">
            <button id="btn-registro-calendarios" type="button" class="btn btn-success">
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
            <table class="table table-condensed table-hover" id="tabla_usuarios" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>Calendario</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
               
                  <tr>
                    
                    <td></td>
                    <td></td>
                    
                    <td>
                      <button type="button" class="btn btn-primary btn-table" title="Actualizar">
                        <i class="fas fa-edit"></i>
                      </button>
                      
                      <button type="button" class="btn btn-danger btn-table" title="Eliminar">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </td>
                  </tr>
         
              </tbody>
            </table>
          </div>
        </div>
      </div>  
    </div>
  </div>
</div>

<script src="../sistema/calendarios/calendarios.js"></script>