<?php
// Clases
include('../../clases/BD.php');
include('../../clases/Busqueda.php');
include('../../clases/Inscripcion.php');
include('../../clases/Constancias.php');
include('../../clases/Cuestionario.php');

// Catálogos
$obj_Busqueda = new Busqueda();
$obj_Inscripcion = new Inscripcion();
$obj_Cuestionario = new Cuestionario();
$obj_Constancia = new Constancias();

$arr_cuestionario = $obj_Cuestionario->buscarPreguntasCuestionario();

$inscripcion = $obj_Inscripcion->buscarInscripcionId($_POST['inscripcion']);
$constancia = $inscripcion->insc_id_constancia;
$url = $obj_Constancia->buscarConstanciaId($constancia)->cons_url;
?>


<form name="form_cuestionario" id="form_cuestionario" method="POST">

    <?php if(isset($arr_cuestionario)) {
        foreach ($arr_cuestionario as $iCont => $pregunta) {?>
            <div class="form-group row">

                <div class="col-lg-12 form-group">
                    <label for="<?php echo($pregunta['preg_id_pregunta']); ?>" class="col-lg-12 col-form-label"><?php echo($pregunta['preg_orden'].".- ".$pregunta['preg_descripcion']); ?></label>

                    <?php switch ($pregunta['preg_tipo']) { 
                        case "Si/No": ?>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="<?php echo($pregunta['preg_id_pregunta']); ?>_SiNo">
                                    <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']); ?>_Si" name="<?php echo($pregunta['preg_id_pregunta']); ?>_SiNo" value=1 required>Sí
                                </label>
                            </div>
                            <br>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="<?php echo($pregunta['preg_id_pregunta']); ?>_SiNo">
                                    <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']); ?>_No" name="<?php echo($pregunta['preg_id_pregunta']); ?>_SiNo" value=2 required>No
                                </label>
                            </div>
                        <?php break; 
                        
                        case "Abierta": ?>
                            <textarea class="form-control" id="<?php echo($pregunta['preg_id_pregunta']); ?>" name = "<?php echo($pregunta['preg_id_pregunta']); ?>"rows="3"></textarea>
                        <?php break; 
                        
                        case "Si/No, con justificación": ?> 
                            <div class="col-lg-12 form-row" style="margin-top: 15px;">
                                <div class="col-lg-2 col-md-12 form-group">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="<?php echo($pregunta['preg_id_pregunta']); ?>_SiNoJ">
                                            <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']); ?>_SiJ" name="<?php echo($pregunta['preg_id_pregunta']); ?>_SiNoJ" value=1>Sí
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="<?php echo($pregunta['preg_id_pregunta']); ?>_SiNoJ">
                                            <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']); ?>_NoJ" name="<?php echo($pregunta['preg_id_pregunta']); ?>_SiNoJ" value=2 >No
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-12 form-group">
                                <p for="id=<?php echo($pregunta['preg_id_pregunta'].'Justificacion'); ?>">Justifique su respuesta:</p>
                                    <textarea class="form-control" id="<?php echo($pregunta['preg_id_pregunta'].'Justificacion'); ?>" name ="<?php echo($pregunta['preg_id_pregunta'].'Justificacion'); ?>" required></textarea>
                                </div>
                            </div>

                       <?php break; 
                       
                       case "Acuerdo/Desacuerdo": ?>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa">
                                    <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa3" name="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa" value=3 >Totalmente de acuerdo
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa">
                                    <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa4" name="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa" value=4 >De acuerdo
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa">
                                    <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa5" name="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa" value=5 >En desacuerdo
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa">
                                    <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa6" name="<?php echo($pregunta['preg_id_pregunta']); ?>_AcueDesa" value=6 >Totalmente en desacuerdo
                                </label>
                            </div>



                        <?php break; 

                        case "Opción Múltiple": 
                            $arr_opciones = $obj_Cuestionario->buscarOpcionesPregunta($pregunta['preg_id_pregunta']);
                            foreach ($arr_opciones as $iCont => $opcion) { ?>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="<?php $pregunta['preg_id_pregunta']."_ multiple" ?>">
                                        <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']."_".$opcion['prop_id_opcion']); ?>" name="<?php echo($pregunta['preg_id_pregunta']."_multiple"); ?>" value=<?php echo($opcion['prop_id_opcion']) ?> ><?php echo($opcion['opci_descripcion']) ?>
                                    </label>
                                </div>
                           <?php } ?>
                        <?php break; ?>
                    <?php } ?>
                        
                </div>
            </div>
        <?php } ?>
        <input id ="dml" name="dml" type="hidden" value="respuestas">
        <input id ="constancia" name="constancia" type="hidden" value="<?php  echo($constancia); ?>">
        <input id ="url" name="url" type="hidden" value="<?php  echo($url) ?>">
    <?php } else {
        echo("No hay cuestionario de evaluación de grupos registrado")   ;
    }?>
</form>