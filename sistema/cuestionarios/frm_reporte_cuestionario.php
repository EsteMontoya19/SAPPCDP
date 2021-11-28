<?php
  include('../../clases/BD.php');
  include('../../clases/Cuestionario.php');
  include('../../clases/Pregunta.php');
  include('../../clases/Opcion.php');
  
  $obj_Cuestionario = new Cuestionario();
  $obj_Opcion = new Opcion();
  
if (isset($_POST['grupo'])) {
    $id = $_POST['grupo'];
    $arr_Cuestionario = $obj_Cuestionario->buscarCuestionarioGrupo($id);
}
?>

<div id="wrapper">
    <div id="content-wrapper">
        <div class="container-fluid">

            <ol class="breadcrumb">
                <li id="btn-inicio-grupo" class="breadcrumb-item">
                    <a href="#"><i class="fas fas fa-user-shield"></i>&nbsp; Grupo</a>
                </li>
                <li class="breadcrumb-item active">
                    <i class="fas fa-chart-bar"></i>&nbsp; Resultados de cuestionario
                </li>
            </ol>
            <p>
                <hr>
            </p>
            
        <?php if (isset($arr_Cuestionario) == false) { ?>
            <b>&nbsp;&nbsp;Los profesores aun no han contestado el cuestionario.</b>
        <?php } else {
            foreach ($arr_Cuestionario as $pregunta) {?>
            <div class="form-group">
                <div class="card lg-12">
                    <div class="card-header">
                        <i class="fas fa-question fa-lg"></i> 
                        <b>&nbsp;&nbsp;Pregunta: 
                            <?php echo $pregunta['preg_descripcion'];?>
                        </b>
                    </div>
                    <table class="table table-condensed table-hover" id="tabla_cuestionarios" width="80%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Opcion</th>
                                <th>Cantidad</th>
                                <th>Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php $arr_Opciones = $obj_Cuestionario->buscarRespuestasPregunta($id, $pregunta['preg_id_pregunta']);
                    if (isset($arr_Opciones)) {
                        foreach ($arr_Opciones as $opcion) {
                            if ($pregunta['preg_tipo'] != 'Abierta') {
                                $opcionDescripcion = $obj_Opcion->buscarOpcionID($opcion['prop_id_opcion']);
                                $porcentaje = ($opcion['cantidad']*100) / $pregunta['cantidad']; ?>
                            <tr>
                                <td><?php echo isset($opcionDescripcion) ? $opcionDescripcion->opci_descripcion : ''; ?></td>
                                <td><?php echo $opcion['cantidad']; ?></td>
                                <td><?php echo $porcentaje.' %'; ?></td>
                            </tr>
                            <?php }
                        }
                    } ?>
                            <tr>
                                <td><?php echo $pregunta['preg_tipo']; ?></td>
                                <td><?php echo $pregunta['cantidad']; ?></td>
                                <td><?php echo '100 %' ?></td>
                            </tr>
                        <tbody>
                    </table>
                <?php if ($pregunta['preg_tipo'] != 'Si/No, con justificación' && $pregunta['preg_tipo'] != 'Abierta') {?>
                    <div class="col-lg-12 form-row" style="margin-top: 15px;" style="display: none;">
                <?php } else { ?> 
                    <div class="col-lg-12 form-row" style="margin-top: 15px;">
                    <?php if ($pregunta['preg_tipo'] == 'Abierta') {
                        $arr_RespuestasTexto = $obj_Cuestionario->buscarRespuestaTexto($id, $pregunta['preg_id_pregunta']);
                        if (isset($arr_RespuestasTexto)) { ?>
                            <label><b>Respuesta(s): </b></label>
                            <?php foreach ($arr_RespuestasTexto as $texto) {?>
                        <div class="col-lg-12 form-group">
                            <textarea type="text" class="form-control" readonly>
                                <?php echo $texto['resp_texto']; ?>
                            </textarea>
                        </div>
                            <?php }
                        }?>
                    <?php } elseif ($pregunta['preg_tipo'] == 'Si/No, con justificación') {
                        $arr_RespuestasTextoSi = $obj_Cuestionario->buscarRespuestaTextoSi($id, $pregunta['preg_id_pregunta']);
                        $arr_RespuestasTextoNo = $obj_Cuestionario->buscarRespuestaTextoNo($id, $pregunta['preg_id_pregunta']);
                        if (isset($arr_RespuestasTextoSi)) { ?>
                        <label><b>Justificación, Respuesta Si: </b></label>
                            <?php foreach ($arr_RespuestasTextoSi as $texto) {?>
                            <div class="col-lg-12 form-group">
                                <textarea type="text" class="form-control" readonly>
                                    <?php echo $texto['resp_texto']; ?>
                                </textarea>
                            </div>
                            <?php }
                        } ?>
                            
                        <?php if (isset($arr_RespuestasTextoNo)) {?>
                        <label><b>Justificación, Respuesta No: </b></label>
                            <?php foreach ($arr_RespuestasTextoNo as $texto) {?>
                            <div class="col-lg-12 form-group">
                                <textarea type="text" class="form-control" readonly>
                                    <?php echo $texto['resp_texto']; ?>
                                </textarea>
                            </div>
                            <?php }
                        }?>
                    <?php }?>
                    </div>
                <?php }?>
                </div>
            </div>
            <p>
                <hr>
            </p>
            <?php }
        } ?>
        </div>
    </div>
</div>
<div class="col-lg-12" style="text-align: center;">
  <button id = "btn-regresar-grupos" type="button" class="btn btn-success btn-footer">Regresar</button>
</div>

<script src="../sistema/cuestionarios/control_cuestionarios.js"></script>
