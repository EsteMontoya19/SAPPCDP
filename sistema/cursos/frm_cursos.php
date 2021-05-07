<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-cursos" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Cursos/ Registro de propuesta</a>
        </li>
      </ol>

      <p>
        <hr>
      </p>

      <!-- Formulario -->
      <form name="form_cursos" id="form_cursos" method="POST">
        <div class="form-group">
          <!-- Datos generales -->
          <div class="card lg-12" style="padding: 15px;">
            <div class="col-lg-12 form-row">

              <div class="col-lg-3 form-group">
                <label for="intTipoCurso"><b>Tipo de curso: *</b></label>
                <select class="custom-select" id="intTipoCurso" name="intTipoCurso" onchange="ocultar(this.value)">
                  <option value='0'>Seleccione una opción</option>
                  <option value='1'>Curso</option>
                  <option value='2'>Taller</option>
                </select>
              </div>

              <div id="nivel" class="col-lg-3 form-group">
                <label for="intTipoCurso"><b>Nivel: *</b></label>
                <select class="custom-select" id="intTipoCurso" name="intTipoCurso">
                  <option value="0">Seleccione una opción</option>
                  <option></option>
                </select>
              </div>

              <div id="nombre" class="col-lg-6 form-group">
                <label for="strNombreCurso"><b>Nombre: *</b></label>
                <input type="text" class="form-control" id="strNombreCurso" name="strNombreCurso">
              </div>

              <div class="col-lg-6 form-group">
                <label for="strReqTec"><b>Requisitos Técnicos: *</b></label>
                <textarea type="text" class="form-control" id="strReqTec" name="strReqTec"></textarea>
              </div>

              <div class="col-lg-6 form-group">
                <label for="strObjCurso"><b>Objetivos del curso: *</b></label>
                <textarea type="text" class="form-control" id="strObjCurso" name="strObjCurso"></textarea>
              </div>

              <div class="col-lg-6 form-group">
                <label for="strConNeces"><b>Conocimientos necesarios: *</b></label>
                <textarea type="text" class="form-control" id="strConNeces" name="strConNeces"></textarea>
              </div>

              
              <div id="numeroSesiones" class="col-lg-6 form-group" style="display:show;">
                <label for="strNumeroSesiones"><b>Número de sesiones: *</b></label>
                <input class="form-control numeros_permitidos" type="number" min="0" max="20" class="form-control" id="strNumeroSesiones" name="strNumeroSesiones">
              </div>

              <div class="col-lg-6 form-group">
                <label for="temario"><b>Temario:</b></label>
                <div class="custom-file">
                  <input type="file" accept="application/pdf" id="temario" name="temario" class="custom-file-input" />
                  <label class="custom-file-label" for="temario">Selecciona un archivo</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>

      <!-- Botones -->
      <div class="col-lg-12" style="text-align: center;">
        <button type="button" class="btn btn-success btn-footer">Regresar</button>
        <button type="button" class="btn btn-success btn-footer">Guardar</button>
      </div>

    </div>
  </div>
</div>

<script src="../sistema/cursos/control_cursos.js"></script>