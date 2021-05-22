<!-- Inicio de Sección: Sesiones -->
<?php
if (isset($_POST['curs_num_sesiones'])) { 
    $numSesiones = $_POST['curs_num_sesiones'];
} else {
    $numSesiones = 0;
}?>


<?php

    for ($i = 1; $i <= $numSesiones; $i++){ 
        $SesionFecha = "SesionFecha".$i;
        $SesionHoraInicio = "SesionHoraInicio".$i;
        $SesionHoraFin = "SesionHoraFin".$i; 
        $Sesion = "Sesion".$i;
        $Hora = "Hora".$i?>

        <div class="card lg-12">
        <div class="card-header"> 
            <i class="fas fa-id-card fa-lg"></i> <b>Sesion <?php echo ($i); ?></b>
        </div>
        <div class="col-lg-12 form-row" style="margin-top: 15px;">
            <div id="<?php echo $Sesion;?>" class="col-lg-6 form-group">
            <label for="<?php echo $SesionFecha;?>"><b>Fecha: *</b></label>
                <input type="date" class="form-control" id="<?php echo $SesionFecha;?>" name="<?php echo $SesionFecha;?>" 
                placeholder="0" min="0">
            </div>
            <div id="<?php echo $Hora;?>"class="col-lg-3 form-group">
            <label for="<?php echo $SesionHoraInicio;?>"><b>Hora inicio:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1)  echo "*"; ?></b></label>
                <input type="time" class="form-control" id="<?php echo $SesionHoraInicio;?>" name="<?php echo $SesionHoraInicio;?>"
                placeholder="0" min="0">
            </div>
            <div id="<?php echo $Hora;?>"class="col-lg-3 form-group">
            <label for="<?php echo $SesionHoraFin;?>"><b>Hora fin:<?php if (isset($_POST['CRUD']) == false || ($_POST['CRUD']) == 1)  echo "*"; ?></b></label>
                <input type="time" class="form-control" id="<?php echo $SesionHoraFin;?>" name="<?php echo $SesionHoraFin;?>"
                placeholder="0" min="0">
            </div>     
        </div>
    </div>
    <?php } ?> 
    <input type="hidden" name="numSesiones" id="numSesiones" value= <?php echo ($numSesiones) ?>>
    
<!-- Fin de Sección: Sesiones -->