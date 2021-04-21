

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <!-- Indicador -->
      <div class="form-inline">
        <div class="col-lg-12" style="padding:0px">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-user-shield"></i>&nbsp; Propuestas
            </li>
          </ol>
        </div>
        
      </div>

      <p>
        <hr>
      </p>
    
      <!-- Tabla -->
      <div class="card mb-3">
        
      
          <div class="table-responsive">
            <table class="table table-condensed table-hover" id="tabla_usuarios" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>ID</th>
                  <th>Nombre del curso</th>
                  <th>Fecha Inicio - Fecha Termino</th>
                  <th>Profesor</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                
                  <tr>
               
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="estatusUsuario1" checked="" onclick="cambioEstatus(2 , 't', 'Luis Eduardo', 'Magos')">
                        <label class="custom-control-label" for="estatusUsuario1"></label>
                      </div>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>

      </div>  
    </div>
  </div>
</div>

<script src="../sistema/cursos/cursos.js"></script>