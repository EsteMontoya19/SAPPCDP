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
            <form name = "form_constancias_personal" id="form_constancias_personal" method="POST" enctype="multipart/form-data"
                action="../modulos/Control_Constancia.php">
                
                <!-- Section: Datos de constancia -->
                <div class="form-group">
                    <div class="card lg-12">
                        <div class="card-header">
                                <i class="fas fa-id-card fa-lg"></i>
                                <b>&nbsp; Periodo de las constancias: </b>
                        </div>

                        <div class="col-lg-12 form-row" style="margin-top: 15px;">
                            <div class="col-lg-6 form-group">
                                <label for ="PeriodoInicio"><b>Inicio del periodo: *</b></label>
                                <input type="date" class="form-control" id="PeriodoInicio" name="PeriodoInicio" placeholder="0" min="0" value="<?php echo isset($Grupo) ? $Grupo->grup_inicio_insc : ""; ?>">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for ="PeriodoFinal"><b>Fin del periodo: *</b></label>
                                <input type="date" class="form-control" id="PeriodoFinal" name="PeriodoFinal" placeholder="0" min="0" value="<?php echo isset($Grupo) ? $Grupo->grup_fin_insc : ""; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="card lg-12">
                        <div class="card-header">
                                <i class="fas fa-id-card fa-lg"></i>
                                <b>&nbsp; Cargar constancias de Instructores: </b>
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="constanciasInstructor"><b>Seleccione el archivo zip de las constancias del periodo seleccionado anteriormente: *</b></label>
                            <div class="custom-file">
                                <input type="file" id="constanciasInstructor" name="constanciasInstructor"  class="custom-file-input" accept="application/zip" required>
                                <label class="custom-file-label" for="constanciasInstructor"></label>
                            </div>
                        </div>
                    </div>  

                    <div class="card lg-12">
                        <div class="card-header">
                                <i class="fas fa-id-card fa-lg"></i>
                                <b>&nbsp; Cargar constancias de Moderadores: </b>
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="constanciasModerador"><b>Seleccione el archivo zip de las constancias del periodo seleccionado anteriormente: *</b></label>
                            <div class="custom-file">
                                <input type="file" id="constanciasModerador" name="constanciasModerador"  class="custom-file-input" accept="application/zip" required>
                                <label class="custom-file-label" for="constanciasModerador"></label>
                            </div>
                        </div>
                    </div>       
  

                    <!-- Botones -->
                    <input type="hidden" name="dml" value="insertPersonal" />

                    <div class="col-lg-12" style="text-align: center;">
                        <button id="btn-regresar-constancia" type="button" class="btn btn-secondary btn-footer btn-regresar">Regresar</button>
                        <button id="btn-registrar-constancia_personal" type="button" form="form_constancias_personal"
                            class="btn btn-success btn-footer btn-aceptar">Guardar</button>
                    </div>
                </div>
            </form> 

        </div>
    </div>
</div>

<script src="../sistema/constancia/control_constancias.js"></script>