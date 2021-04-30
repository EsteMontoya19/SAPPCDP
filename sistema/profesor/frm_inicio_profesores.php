<?php
  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  include('../../clases/Inscripcion.php');
  
  $obj_Grupo = new Grupo();
  $arr_grupos = $obj_Grupo ->buscarTodosGrupos();
  $arr_webs = $obj_Grupo->buscarTodosWebinar();

  $obj_Inscripcion = new Inscripcion();
?>

  <div id="wrapper">
    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Indicador -->
        <div class="form-inline">
          <div class="col-sm-12">
            <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-users"></i>&nbsp; Grupos
            </li>
            </ol>
          </div>
        </div>

        <p>
          <hr>
        </p>

        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-folder"></i> Resultados
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-condensed table-hover" id="tabla_grupos" width="100%" cellspacing="0">
                <thead class="thead-dark">
                  <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Modalidad</th>
                    <th>Estatus</th>
                    <th>Lugares Disp</th>
                    <th>Profesor</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Horario</th>
                    <th>Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>

                        <button type="button" class="btn btn-primary btn-table" title="Registrar" style="margin-top: 5px;">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-info btn-table" title="Detalles" style="margin-top: 5px;">
                          <i class="fas fa-search-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-table" title="Eliminar" style="margin-top: 5px;">
                          <i class="fas fa-trash-alt"></i>
                        </button>


                        <button type="button" class="btn btn-primary btn-table" title="Comporbante" style="margin-top: 5px;">
                          <i class="fas fa-list-alt"></i>
                        </button>


                        <button type="button" class="btn btn-danger btn-table" title="Constancia" style="margin-top: 5px;background: #20560a">
                          <i class="fas fa-file"></i>
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

  <script src="../sistema/profesor/profesores.js"></script>

