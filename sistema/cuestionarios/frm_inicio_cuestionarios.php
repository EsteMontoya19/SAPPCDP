<?php
include('../../clases/BD.php');
include('../../clases/Pregunta.php');

$obj_Pregunta = new Pregunta();
$arr_Preguntas = $obj_Pregunta->buscarPreguntas(); 

$x = 0;

?>

<div id="wrapper">
    <div id="content-wrapper">
        <div class="container-fluid">

            <!-- Indicador -->
            <div class="form-inline">
                <div class="col-sm-10" style="padding:0px">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <i class="fas fa-user-shield"></i>&nbsp; Cuestionarios
                        </li>
                    </ol>
                </div>
                <div class="col-sm-2" alignment="center">
                    <a href="#">
                        <button id="btn-registro-cuestionario" type="button" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i>&nbsp;&nbsp; Agregar
                        </button>
                    </a>
                </div>
            </div>

            <p>
                <hr>
            </p>

            <!-- Tabla -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-folder"></i>&nbsp; &nbsp;Resultados
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- TODO: Considerar valores de una tabla -->
                        <table class="table table-condensed table-hover" id="tabla_cuestionarios" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Lugar en la encuesta</th>
                                    <th>Estatus</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($arr_Preguntas)) {
                                    foreach ($arr_Preguntas as $pregunta) { 
                                        ?>
                                        <tr>
                                            <?php $x++; ?>
                                            <td><?php echo $pregunta['preg_id_pregunta']; ?></td>
                                            <td><?php echo $pregunta['preg_descripcion']; ?></td>
                                            <td><?php echo $pregunta['preg_tipo']; ?></td>
                                            <td><?php if ($pregunta['preg_orden'] == NULL || $pregunta['preg_activo'] != 't') {echo "-";} else {echo $pregunta['preg_orden'];} ?></td>
                                            <td>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="estatusCuestionario<?php echo $x ?>" <?php if ($pregunta['preg_activo'] == 't') {
                                                        ?> checked <?php
                                                                                                                             } ?> onclick="cambioEstatus(<?php echo $pregunta['preg_id_pregunta']; ?> , '<?php echo $pregunta['preg_activo']; ?>', '<?php echo $pregunta['preg_descripcion']; ?>')">
                                                    <label class="custom-control-label" for="estatusCuestionario<?php echo $x ?>"></label>
                                                </div>
                                            </td>
                                            <td>
                                            <button id="button_detalles" type="button" class="btn btn-info btn-table" title="Detalles" onclick="consultarPreguntaDirecto(<?php echo $pregunta['preg_id_pregunta'] ?>)">
                                                <i class="fas fa-search-plus"></i>
                                            </button>
                                            <button id="button_editar" type="button" class="btn btn-primary btn-table" title="Editar"
                                                onclick="actualizarPreguntaDirecto(<?php echo $pregunta['preg_id_pregunta'] ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../sistema/cuestionarios/control_cuestionarios.js"></script>
