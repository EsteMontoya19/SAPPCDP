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
                        <!-- Section: Tipo de pregunta -->
                        <div class="col-lg-4 form-group">
                            <label><b>Tipo de pregunta: *</b></label>
                            <select onChange="myFunction(this.options[this.selectedIndex].value)"  required='required' class="custom-select" id="tipo_pregunta" name="tipo_pregunta1">
                                <option>Seleccionar una opción</option>
                                <option>Abierta</option>
                                <option>Opción múltiple</option>
                                <option>Si y no</option>
                                <option>Si y no, con justificación</option>
                            </select>
                        </div>

                        <!-- Section: Pregunta  -->
                        <div class="col-lg-4 form-group" id='preguntaGeneral'>
                            <label><b>Pregunta: *</b></label>
                            <input required='required' class="form-control" id="pregunta" name="pregunta"></input>
                        </div>

                        <!-- Section: Respuesta -> Tipo -> Opción Múltiple-->
                        <div class="col-lg-4 form-group" id='respTipMultiple'>
                            <label><b>Insiso : *</b></label>
                            <input required='required' class="form-control" id="respuesta_abierta" name="respuesta_abierta"></input>
                        </div>


                    </div>


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

                <script src="../sistema/cuestionarios/control_cuestionarios.js"></script>