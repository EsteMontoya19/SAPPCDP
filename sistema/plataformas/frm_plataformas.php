

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-cursos" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Pñataformas/ Registro de plataformas</a>
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
                <label for="strNombreCurso"><b>Nombre Plataforma: *</b></label>
                <input type="text" class="form-control" id="strNombrePlata" name="strNombreCurso">
              </div>


             <div class="col-lg-6 form-group">
                <label for="intTipoCurso"><b>Tipo de plataforma: *</b></label>
                <select class="custom-select" id="intTipoPlata" name="intTipoCurso">
                  <option value="0">Seleccione una opción</option>
                  
                    <option>
                    </option>
                  
                </select>
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