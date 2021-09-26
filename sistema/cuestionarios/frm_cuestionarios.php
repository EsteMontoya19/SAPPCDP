<?php
include('../../clases/BD.php');
include('../../clases/Plataforma.php');

// TODO: Adaptar a Clase Cuestionario.
$obj_plataforma = new Plataforma();

// Variables
$tipos_de_preguntas = array('Abierta', 'Opción múltiple', 'Si y no', 'Si y no, con justificación');
$tipo_pregunta_seleccionada = null;
?>

<div id="wrapper">
    <div id="content-wrapper">
        <div class="container-fluid">

            <ol class="breadcrumb">
                <li id="btn-inicio-cuestionario" class="breadcrumb-item">
                    <a href="#"><i class="fas fa-user-shield"></i>&nbsp; Cuestionarios</a>
                </li>
                <!-- Validación de la ruta -->
                <?php if (isset($_POST['CRUD'])) { ?>
                    <?php if ($_POST['CRUD'] == 1) { ?>
                        <li class="breadcrumb-item active"><i class="fas fa-edit"></i>&nbsp; Actualizar registro</li>
                    <?php }
                } else { ?>
                    <li class="breadcrumb-item active"><i class="fas fa-folder-plus"></i>&nbsp; Nuevo registro</li>
                <?php } ?>
            </ol>

            <p>
                <hr>
            </p>

            <!-- Inicio de Sección: Nueva pregunta -->
            <div class="form-group">
                <div class="card lg-3">

                    <!-- Header Nueva pregunta -->
                    <div class="card-header">
                        <i class="fas fa-id-card fa-lg"></i>
                        <b>&nbsp;&nbsp;Nueva pregunta</b>
                    </div>


                    <div class="col-lg-12 form-row" style="margin-top: 15px;">

                        <div class="col-lg-4 form-group">
                            <label for="TipoPregunta"><b>Tipo de pregunta: *</b></label>
                            <select required='required' class="custom-select" id="TipoPregunta" name="TipoPregunta">
                                <option value="0">Seleccione una opción</option>
                                <?php foreach ($tipos_de_preguntas as $tipo_pregunta) {
                                ?> <option value="<?php echo $tipo_pregunta?>" <?php if (isset($Cuestionario)) {
                                        if ($tipo_pregunta_seleccionada == $tipo_pregunta) {
                                            ?> selected <?php
                                        } ?>
                                    } ?>></option>
                                <?php
                                } ?>
                            </select>
                        </div>

                        <!-- Sección: Pregunta -> Tipo -> Abierta-->
                        <div class="col-lg-4 form-group">
                            <label><b>Pregunta: *</b></label>
                            <input required='required' class="form-control" id="pregunta_abierta" name="pregunta_abierta">
                            </input>
                        </div>

                        <!-- Section: Respuesta -> Tipo -> Abierta-->
                        <?php if (strcmp($tipo_pregunta_seleccionada, 'Abierta') == 0) { ?>
                            <div id="PlataformaAG" class="col-lg-6 form-group">
                        <?php } else { ?>
                                <div id="PlataformaAG" class="col-lg-6 form-group" style="display: none;">
                                <?php
                        }
                        ?>
                                <label for="lbURL_Plataforma"><b>Respuesta *<?php echo $tipo_pregunta_seleccionada ?> </b></label>
                                <input type="text" class="form-control" id="URL_Plataforma" name="URL_Plataforma">
                                </div>
                                <!-- Fin de Sección: Nueva pregunta -->

                                <!-- Botones -->
                                <div class="col-lg-12" style="text-align: center;">
                                    <button id="btn-regresar-cuestionario" type="button" class="btn btn-success btn-footer btn-regresar">Regresar</button>
                                    <?php if (isset($_POST['CRUD'])) { ?>
                                        <?php if ($_POST['CRUD'] == 1) { ?>
                                            <button id="btn-actualizar-cuestionario" type="button" class="btn btn-success btn-footer btn-aceptar">Actualizar</button>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <button id="btn-registrar-cuestionario" type="button" form="form_cuestionarios" class="btn btn-success btn-footer btn-aceptar">Guardar</button>
                                    <?php } ?>
                                </div>
                            </div>
                    </div>

                    <script src="../sistema/cuestionarios/control_cuestionarios.js"></script>
