<?php
// Clases
include('../../clases/BD.php');
include('../../clases/Busqueda.php');
include('../../clases/Cuestionario.php');

// Catálogos
$obj_Busqueda = new Busqueda();
$obj_Cuestionario = new Cuestionario();
$arr_cuestionario = $obj_Cuestionario->buscarPreguntasCuestionario();
?>


<form name="form_cuestionario" id="form_cuestionario" method="POST">

    <?php foreach ($arr_cuestionario as $iCont => $pregunta) {?>
        <div class="form-group row">

            <div class="col-lg-12 form-group">
                <label for="<?php echo($pregunta['preg_id_pregunta']); ?>" class="col-lg-12 col-form-label"><?php echo($pregunta['preg_orden'].".- ".$pregunta['preg_descripcion']); ?></label>

                <?php switch ($pregunta['prop_tipo']) { 
                    case "Si y no": ?>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="SiNo">
                                <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']); ?>_Si" name="SiNo" value="Si">Sí
                            </label>
                        </div>
                        <br>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="SiNo">
                                <input type="radio" class="form-check-input" id="<?php echo($pregunta['preg_id_pregunta']); ?>_No" name="SiNo" value="No" >No
                            </label>
                        </div>
                    <?php break; 
                    
                    case "Abierta": ?>
                        <textarea class="form-control" id="<?php echo($pregunta['preg_id_pregunta']); ?>" rows="3"></textarea>
                    <?php break; ?>
                <?php } ?>
                    
            </div>
        </div>
    <?php } ?>
</form>

<script src="sistema/usuarios/control_usuario.js"></script>