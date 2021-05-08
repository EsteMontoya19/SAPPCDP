<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <!-- Indicador -->
      <div class="form-inline">
        <div class="col-sm-12" style="padding:0px">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active">
              <i class="fas fa-user-shield"></i>&nbsp; Cursos históricos
            </li>
          </ol>
        </div>
        <!-- <div class="col-sm-2" align="center">
          <a href="#">
            <button id="btn-registrar-curso" type="button" class="btn btn-success">
              <i class="fas fa-plus-circle"></i>&nbsp;&nbsp; Agregar Curso
            </button>
          </a>
        </div> -->
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
                <th></th>
                <th>Nombre del curso</th>
                <th>Fecha de propuesta</th>
                <th>Horario</th>
                <th>Duración</th>
                <th>Nombre del instructor</th>
                <th>Tipo</th>
                <th>Estado</th>
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
                <td>
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="estatusUsuario1" checked=""
                      onclick="cambioEstatus(2 , 't', 'Luis Eduardo', 'Magos')">
                    <label class="custom-control-label" for="estatusUsuario1"></label>
                  </div>
                </td>
                <td>
                  <button type="button" class="btn btn-info btn-table" title="Detalles">
                    <i class="fas fa-search-plus"></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-table" title="Editar">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button type="button" class="btn btn-danger btn-table" title="Cancelar">
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

<script src="../sistema/cursos/cursos.js"></script>