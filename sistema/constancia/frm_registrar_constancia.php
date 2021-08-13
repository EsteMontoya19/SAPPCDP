<?php
  // Validar entidad
    if (isset($_POST['grupo'])) {
        // Recuperar información de consulta
        $idGrupo = $_POST['grupo'];
    }
?>

<div id="wrapper">
    <div id="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li id="btn-inicio-constancia" class="breadcrumb-item">
                    <a href="#"><i class="fa fa-file-alt"></i>&nbsp; Subir Constancias</a>
                </li>
            </ol>
            <p>
                <hr>
            </p>
            <!-- Formulario -->
            <form name = "form_constancias" id="form_constancias" method="POST" enctype="multipart/form-data"
                action="../modulos/Control_Constancia.php">
                
                <!-- Section: Datos de constancia -->
                <div class="form-group">
                    <div class="card lg-12">
                        <div class="card-header">
                                <i class="fas fa-id-card fa-lg"></i>
                                <b>&nbsp; Constancias del Grupo: </b>
                        </div>
                    </div>


                    <div class="col-lg-6 form-group">
                        <label for="constancias"><b>Seleccione el archivo zip de las constancias del grupo <?php echo ($idGrupo); ?>: *</b></label>
                        <div class="custom-file">
                            <input type="file" id="constancias" name="constancias"  class="custom-file-input" accept="application/zip" required>
                            <label class="custom-file-label" for="constancias"></label>
                        </div>
                    </div>    
  

                    <!-- Botones -->
                    <input type="hidden" name="dml" value="insert" />
                    <input type="hidden" name="id" value="<?php echo $idGrupo; ?>"/>

                    <div class="col-lg-12" style="text-align: center;">
                        <button id="btn-regresar-constancia" type="button" class="btn btn-secondary btn-footer btn-regresar">Regresar</button>
                        <button id="btn-registrar-constancia" type="button" form="form_constancias"
                            class="btn btn-success btn-footer btn-aceptar">Guardar</button>
                    </div>
                </div>
            </form> 

        </div>
    </div>
</div>

<script src="../sistema/constancia/control_constancias.js"></script>