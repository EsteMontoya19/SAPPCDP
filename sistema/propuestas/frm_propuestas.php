

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-cursos" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Propuestas/ Registro de propuestas</a>
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
          
             <div class="col-lg-6 form-group">
                <label for="intTipoCurso"><b>Tipo de Curso: *</b></label>
                <select class="custom-select" id="intTipoPlata" name="intTipoCurso">
                  <option value="0">Seleccione una opción</option>
                  
                    <option>
                    </option>
                  
                </select>
              </div>

              <div class="col-lg-6 form-group">
                <label for="strNombreCurso"><b>Nombre: *</b></label>
                <input type="text" class="form-control" id="strNombrePlata" name="strNombreCurso">
              </div>


              <div class="col-lg-6 form-group">
                <label for="strNombreCurso"><b>Numéro de sesiones: *</b></label>
                <input type="text" class="form-control" id="strNombrePlata" name="strNombreCurso">
              </div>


               <div class="col-lg-6 form-group">
                <label for="intTipoCurso"><b>Plataforma: *</b></label>
                <select class="custom-select" id="intTipoPlata" name="intTipoCurso">
                  <option value="0">Seleccione una opción</option>
                  
                    <option>
                    </option>
                  
                </select>
              </div>

               <div class="col-lg-6 form-group">
                <label for="strNombreCurso"><b>Datos de acceso a la reunión: *</b></label>
                <input type="text" class="form-control" id="strNombrePlata" name="strNombreCurso">
              </div>


              <div class="col-lg-6 form-group">
                <label for="strNombreCurso"><b>ID de reunión: *</b></label>
                <input type="text" class="form-control" id="strNombrePlata" name="strNombreCurso">
              </div>

               <div class="col-lg-6 form-group">
                <label for="strNombreCurso"><b>Código de la reunión: *</b></label>
                <input type="text" class="form-control" id="strNombrePlata" name="strNombreCurso">
              </div>

               <div class="col-lg-6 form-group">
                <label for="strNombreCurso"><b>Tiempo de duración (hrs): *</b></label>
                <input type="text" class="form-control" id="strNombrePlata" name="strNombreCurso">
              </div>

            

              <div class="col-lg-6 form-group">
                <label for="strNombreCurso"><b>Requisitos Técnicos: *</b></label>
               <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>


             


              <div class="col-lg-6 form-group">
                <label for="strNombreCurso"><b>Conocimientos necesarios: *</b></label>
               <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>


                <div class="col-lg-6 form-group">
                <label for="strNombreCurso"><b>Objetivo del curso: *</b></label>
               <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>


              


                <div class="col-lg-6 form-group">
                    <label for="exampleFormControlFile1"><b>Temario</b></label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1">
              </div>

               <div class="col-lg-6 form-group">
              
              </div>


              <div class="card-header col-lg-12" style="margin-bottom: 10px">
              <i class="fas fa-id-card fa-lg"></i>
              <b>Sesión 1</b>
            </div>


              <div class="col-lg-6 form-group">
                <label for="strFecInicio"><b>Fecha inicio: *</b></label>
                <input type="date" class="form-control" id="strFecInicio" name="strFecInicio">
              </div>

                <div class="col-lg-3 form-group">
                  <label><b>Hora inicio:</b></label>
                  <div class="input-group">
                    <input type="number" class="form-control"  placeholder="0">
                    <div class="input-group-append">
                      <span class="input-group-text">horas</span>
                    </div>
                  </div>
                </div>


                <div class="col-lg-3 form-group">
                  <label><b>Hora Fin:</b></label>
                  <div class="input-group">
                    <input type="number" class="form-control"  placeholder="0">
                    <div class="input-group-append">
                      <span class="input-group-text">horas</span>
                    </div>
                  </div>
                </div>




            <div class="card-header col-lg-12" style="margin-bottom: 10px">
              <i class="fas fa-id-card fa-lg"></i>
              <b>Sesión 2</b>
            </div>


              <div class="col-lg-6 form-group">
                <label for="strFecInicio2"><b>Fecha inicio: *</b></label>
                <input type="date" class="form-control" id="strFecInicio2" name="strFecInicio2">
              </div>

                <div class="col-lg-3 form-group">
                  <label><b>Hora inicio:</b></label>
                  <div class="input-group">
                    <input type="number" class="form-control" placeholder="0">
                    <div class="input-group-append">
                      <span class="input-group-text">horas</span>
                    </div>
                  </div>
                </div>


                <div class="col-lg-3 form-group">
                  <label><b>Hora Fin:</b></label>
                  <div class="input-group">
                    <input type="number" class="form-control" placeholder="0">
                    <div class="input-group-append">
                      <span class="input-group-text">horas</span>
                    </div>
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

<script src="../sistema/cursos/cursos.js"></script>