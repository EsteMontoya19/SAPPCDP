<?php 
include('../../clases/BD.php');
include('../../clases/Calendario.php');


$obj_Calendario = new Calendario();

if (isset($_POST['CRUD'])) {
  // Recuperar información de consulta
  $calendario = $obj_Calendario->buscarCalendario($_POST['id']);
    $arr_Inhabiles = $obj_Calendario->buscarDiasFestivos($_POST['id']);
  }

  $asterisco = "*";
  $habilitado = "disabled";



?>

<div id="wrapper">
  <div id="content-wrapper">
    <div class="container-fluid">

      <ol class="breadcrumb">
        <li id="btn-inicio-cursos" class="breadcrumb-item">
          <a href="#"><i class="fas fa-user-shield"></i>&nbsp; 
          <?php 
         

          if(isset($_POST['CRUD'])) {
            if($_POST['CRUD'] == 1)  {
              echo ('Calendarios/ Consultar calendarios</a>');
              $asterisco = " ";
            } elseif ($_POST['CRUD'] == 2) {
              echo ('Calendarios/ Actualizar calendario</a>');
              $habilitado = " ";
            } 
          }else{
            echo ('Calendarios/ Registrar calendario</a>');
            $habilitado = " ";
          } ?>
        </li>
        
      </ol> 

      <p>
        <hr>
      </p>

      <!-- Formulario -->
      <form name="form_calendario" id="form_calendario" method="POST">
        <div class="form-group">
          <div class="card lg-12" style="padding: 15px;">
            
            <div class="card-header negritas">
              <i class="fas fa-id-card fa-lg"></i>
                &nbsp;&nbsp;Calendario
            </div>
            <div class="col-lg-12 form-row">

            <div class="col-lg-4 form-group">
            </div>
              <div class="col-lg-4 form-group">
                <label for="strNombreSem"><b>Semestre: <?php echo ($asterisco); ?> </b></label>
                <input type="text" class="form-control" id="NombreSem" name="NombreSem"
                  value="<?php if (isset($calendario)) { echo ($calendario->cale_semestre);} ?>" <?php echo($habilitado); ?> >
              </div>

             
            </div>


            <div class="card-header negritas">
              <i class="fas fa-id-card fa-lg"></i>
                &nbsp;&nbsp;Ciclo escolar
            </div>
            <div class="col-lg-12 form-row">
               <div class="col-lg-6 form-group">
                  <label><b>Inicia:</b></label>
                  <div class="input-group">
                    <input type="date" class="form-control" placeholder="0" id="inicioCiclo" name="inicioCiclo"
                    value="<?php if (isset($calendario)) { echo ($calendario->cale_inicio_ciclo);} ?>" <?php echo($habilitado); ?> >
                  </div>
                </div>
               <div class="col-lg-6 form-group">
                  <label><b>Finaliza:</b></label>
                  <div class="input-group">
                    <input type="date" class="form-control" placeholder="0" id="finCiclo" name="finCiclo"
                    value="<?php if (isset($calendario)) { echo ($calendario->cale_fin_ciclo);} ?>" <?php echo($habilitado); ?> >
                    
                  </div>
                </div>
            </div>

            <div class="card-header negritas">
              <i class="fas fa-id-card fa-lg"></i>
                &nbsp;&nbsp;Periodo de examenes
            </div>
            <div class="col-lg-12 form-row">
              <div class="col-lg-6 form-group">
                <label><b>Inicia:</b></label>
                <div class="input-group">
                  <input type="date" class="form-control" placeholder="0" id="inicioExamenes" name="inicioExamenes"
                  value="<?php if (isset($calendario)) { echo ($calendario->cale_inicio_examenes);} ?>" <?php echo($habilitado); ?> >
                </div>
              </div>
              <div class="col-lg-6 form-group">
                <label><b>Finaliza:</b></label>
                <div class="input-group">
                  <input type="date" class="form-control" placeholder="0" id="finExamenes" name="finExamenes"
                  value="<?php if (isset($calendario)) { echo ($calendario->cale_fin_examenes);} ?>" <?php echo($habilitado); ?> >
                  
                </div>
              </div>
            </div>

            <div class="card-header negritas">
              <i class="fas fa-id-card fa-lg"></i>
                &nbsp;&nbsp;Periodo intersemestral
            </div>
              <div class="col-lg-12 form-row">
               <div class="col-lg-6 form-group">
                  <label><b>Inicia:</b></label>
                  <div class="input-group">
                    <input type="date" class="form-control" placeholder="0" id="inicioInter" name="inicioInter"
                    value="<?php if (isset($calendario)) { echo ($calendario->cale_inicio_intersemestral);} ?>" <?php echo($habilitado); ?> > 
                  </div>
                </div>
               <div class="col-lg-6 form-group">
                  <label><b>Finaliza:</b></label>
                  <div class="input-group">
                    <input type="date" class="form-control" placeholder="0" id="finInter" name="finInter"
                    value="<?php if (isset($calendario)) { echo ($calendario->cale_fin_intersemestral);} ?>" <?php echo($habilitado); ?> >  
                  </div>
                </div>
              </div>

            <div class="card-header negritas">
              <i class="fas fa-id-card fa-lg"></i>
                &nbsp;&nbsp;Asueto Académico
            </div>
            <div class="col-lg-12 form-row">
              <div class="col-lg-6 form-group">
                <label><b>Inicia:</b></label>
                <div class="input-group">
                  <input type="date" class="form-control" placeholder="0" id="inicioAsueto" name="inicioAsueto"
                  value="<?php if (isset($calendario)) { echo ($calendario->cale_inicio_asueto);} ?>" <?php echo($habilitado); ?> > 
                </div>
              </div>
              <div class="col-lg-6 form-group">
                <label><b>Finaliza:</b></label>
                <div class="input-group">
                  <input type="date" class="form-control" placeholder="0" id="finAsueto" name="finAsueto"
                  value="<?php if (isset($calendario)) { echo ($calendario->cale_fin_asueto);} ?>" <?php echo($habilitado); ?> > 
                </div>
              </div>
            </div>

            <div class="card-header negritas">
              <i class="fas fa-id-card fa-lg"></i>
                &nbsp;&nbsp;Vacaciones administrativas
            </div>
            <div class="col-lg-12 form-row">
              <div class="col-lg-6 form-group">
                <label><b>Inicia:</b></label>
                <div class="input-group">
                  <input type="date" class="form-control" placeholder="0" id="inicioAdmin" name="inicioAdmin"
                  value="<?php if (isset($calendario)) { echo ($calendario->cale_inicio_admin);} ?>" <?php echo($habilitado); ?> >        
                </div>
              </div>
              <div class="col-lg-6 form-group">
                <label><b>Finaliza:</b></label>
                <div class="input-group">
                  <input type="date" class="form-control" placeholder="0" id="finAdmin" name="finAdmin"
                  value="<?php if (isset($calendario)) { echo ($calendario->cale_fin_admin);} ?>" <?php echo($habilitado); ?> >      
                </div>
              </div>
            </div>

            <div class="card-header negritas">
              <i class="fas fa-id-card fa-lg"></i>
                &nbsp;&nbsp;Dias festivos
            </div>

            <?php 

            if(!isset($_POST['CRUD'])) { ?>
              <div class="col-lg-12 form-row">
                
                <table class="table table-bordered" id="dynamic_field">
                  <tr>
                  <td><input type="date" class="form-control" placeholder="0" id="diaFestivo0" name="diaFestivo0"
                          value=""></td>
                  <td>
                    <button type="button" name="add" id="add" class="btn btn-success" >Agregar día</button>
                    <button type="button" name="remove"  class="btn btn-danger btn_remove">Eliminar día</button>
                  </td>
                  </tr>
                </table>
                </div>
            <?php } elseif ($_POST['CRUD'] == 2) {
              if(isset($arr_Inhabiles)) { ?>
                <div class="col-lg-12 form-row">
                  <table class="table table-bordered" id="dynamic_field"> 

                  <div class="col-lg-8 form-group">
                  </div>

                  <div class="col-lg-4 form-group">
                    <tr>
                      <td>
                        <button type="button" name="add" id="add" class="btn btn-success">Agregar día</button>
                        <button type="button" name="remove"  class="btn btn-danger btn_remove">Eliminar día</button>
                      </td>
                    </tr>
                  </div>
                  <input type="hidden" id="diasActualizacion" value="<?php echo(count($arr_Inhabiles)); ?>">
                <?php foreach ($arr_Inhabiles as $iCont => $diaInhabil) { ?>

                    <tr id = "row<?php echo ($iCont + 1); ?>">
                    <td><input type="date" class="form-control" placeholder="0" id="diaFestivo<?php echo (($iCont + 1)); ?>" name="diaFestivo<?php echo (($iCont + 1)); ?>"
                          value="<?php echo ($diaInhabil['dife_fecha']); ?>" <?php echo($habilitado); ?>> </td>
                    </tr>
                <?php } ?>
                </table>
                </div>
             <?php }

            } elseif ($_POST['CRUD'] == 1) {
                 
                 foreach ($arr_Inhabiles as $iCont => $diaInhabil) { ?>

                  <tr id = "row<?php echo ($iCont + 1); ?>">
                  <br>
                  <td><input type="date" class="form-control" placeholder="0" id="diaFestivo<?php echo (($iCont + 1)); ?>" name="diaFestivo<?php echo (($iCont + 1)); ?>"
                        value="<?php echo ($diaInhabil['dife_fecha']); ?>" <?php echo($habilitado); ?>> </td>
                  </tr>
                <?php } ?>
              
            <?php } ?>
            </div>
          </div>
          <?php 
          //? Creación y envio del dml
          if (!isset($_POST['CRUD'])) { ?>
            <input type="hidden" id="dml" name="dml" value="insert">
            
          <?php 
          } elseif (isset($_POST['CRUD']) && $_POST['CRUD'] == 2) { ?>
            <input type="hidden" id="dml" name="dml" value="update">
            <input type="hidden" id="id" name="id" value="<?php echo ($calendario->cale_id_calendario); ?>">
          <?php }?>
        </div>


      

      </form>

      <!-- Botones -->
      <div class="col-lg-12" style="text-align: center;">
        <button id = "boton-regresar" name = "boton-regresar" type="button" class="btn btn-success btn-footer btn-regresar">Regresar</button>
        <?php 
         if (!isset($_POST['CRUD'])) { ?>
           <button id = "boton-registrar" type="button" class="btn btn-success btn-footer btn-aceptar">Guardar</button>
        <?php 
        } elseif (isset($_POST['CRUD']) && $_POST['CRUD'] == 2) { ?>
          <button id = "boton-actualizar" type="button" class="btn btn-success btn-footer btn-aceptar">Actualizar</button>
        <?php }?>
      
      </div>
    </div>
  </div>
</div>

<script src="../sistema/calendarios/calendarios.js"></script>