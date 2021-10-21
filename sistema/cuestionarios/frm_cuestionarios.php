<?php
include('../../clases/BD.php');
include('../../clases/Pregunta.php');
include('../../clases/Opcion.php');
include('../../clases/Cuestionario.php');

// TODO: Adaptar a Clase Cuestionario.
$obj_Pregunta = new Pregunta();
$obj_Opcion = new Opcion();
$obj_Cuestionario = new Cuestionario();

// Variables
$tipos_de_preguntas = array('Abierta', 'Si/No', 'Si/No, con justificación', 'Opción múltiple');
$tipo_pregunta_seleccionada = null;

if (isset($_POST['id'])) {
    // Recuperar información de consulta
    $pregunta = $obj_Pregunta->buscarPreguntaID($_POST['id']);
    $tipo = $pregunta->preg_tipo;
    $arr_Opciones = $obj_Cuestionario->buscarPROPIDPregunta($_POST['id']);
}
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
                    <?php } else { ?>
                <li class="breadcrumb-item active"><i class="fas fa-search-plus"></i>&nbsp; Consultar registro</li>
                    <?php }
                } else { ?>
                <li class="breadcrumb-item active"><i class="fas fa-folder-plus"></i>&nbsp; Nuevo registro</li>
                <?php } ?>
            </ol>

            <p>
                <hr>
            </p>

            <!-- Formulario -->
            <form name="form_preguntas" id="form_preguntas" method="POST">

                <!-- Desactivar formulario INICIO en caso de no ser un registro-->
                <?php if (isset($_POST['CRUD'])) { ?>
                    <?php if ($_POST['CRUD'] == 0) { ?>
                <fieldset disabled>
                    <?php } ?>
                <?php } ?>

                    <!-- Inicio de Sección: Nueva pregunta -->
                    <div class="form-group">
                        <div class="card lg-12">

                            <!-- Header Nueva pregunta -->
                            <div class="card-header">
                                <i class="fas fa-id-card fa-lg"></i>
                                <b>&nbsp;&nbsp;Nueva pregunta</b>
                            </div>

                            <div class="col-lg-12 form-row" style="margin-top: 15px;">
                                <!-- Section: Tipo de pregunta -->
                                <div class="col-lg-4 form-group">

                                    <label><b>Tipo de pregunta: *</b></label>
                                    <select onChange="myFunction(this.options[this.selectedIndex].value)"
                                        required='required' class="custom-select" id="tipo_pregunta"
                                        name="tipo_pregunta" <?php if (isset($_POST['CRUD'])) {
                                            echo "disabled" ;
                                                             }?>
                                        >Abierta</option> >
                                        <option value=0>Seleccionar una opción</option>
                                        <option value="Abierta" <?php if (isset($pregunta) && $tipo=="Abierta") {
                                            echo "selected" ;
                                                                }?> >Abierta</option>
                                        <option value="Si/No" <?php if (isset($pregunta) && $tipo=="Si/No") {
                                            echo "selected" ;
                                                              }?> >Si/No</option>
                                        <option value="Si/No, con justificación" <?php if (isset($pregunta) &&
                                            $tipo=="Si/No, con justificación") {
                                                                  echo "selected" ;
                                                                                 }?> >Si/No, con
                                            justificación</option>
                                        <option value="Opción múltiple" <?php
                                        if (isset($pregunta) && $tipo=="Opción múltiple") {
                                            echo "selected" ;
                                        }?> >Opción múltiple</option>
                                    </select>
                                </div>

                                <!-- Section: Pregunta  -->
                                <div class="col-lg-8 form-group" id='preguntaGeneral'>
                                    <label><b>Pregunta: *</b></label>
                                    <input required='required' class="form-control" id="pregunta"
                                        name="pregunta"></input>
                                </div>

                                <?php if (isset($_POST['CRUD'])) { ?>
                                <div class="form-group col-md-12 " id="divPregunta">
                                <?php } else { ?>
                                    <div class="form-group col-md-12 " id="divPregunta" style="display: none;">
                                <?php } ?>
                                        <label><b>Pregunta: *</b></label>
                                        <input required='required' class="form-control" id="PreguntaConsulta"
                                            name="PreguntaConsulta"
                                            value="<?php echo isset($pregunta) ? $pregunta->preg_descripcion : ""; ?>"></input>
                                    </div>


















                                    <!-- Section: Respuesta -> Tipo -> Opción Múltiple-->
                                    <div class="container" id="respuestaMultiple" style=" display: <?php if ($tipo=="Opción múltiple") {
                                        echo 'block;';
                                                                                                   } else {
                                                                                                       echo 'none';
                                                                                                   }?>" >
                                        <?php

                                        if (!isset($_POST['CRUD'])) { ?>
                                        <div class="col-lg-12 form-row" >

                                            <table class="table table-bordered" id="dynamic_field">
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" id="opcion0"
                                                            name="opcion0" value="" placeholder="Opcion 1">
                                                    </td>
                                                    <td>
                                                        <button type="button" name="add" id="add"
                                                            class="btn btn-success">Agregar Inciso</button>
                                                        <button type="button" name="remove" id="remove"
                                                            class="btn btn-danger btn_remove">Eliminar Inciso</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" id="opcion1"
                                                            name="opcion1" value="" placeholder="Opcion 2">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <?php } elseif ($_POST['CRUD'] == 0) {
                                            if (isset($arr_Opciones)) {
                                                ?>
                                        <div class="col-lg-12 form-row">
                                            <table class="table table-bordered" id="dynamic_field">

                                                <div class="col-lg-8 form-group">
                                                </div>

                                                <?php foreach ($arr_Opciones as $iCont => $opcion) { ?>
                                                <tr id="row<?php echo ($iCont); ?>">
                                                    <td><input type="text" class="form-control" placeholder="0"
                                                            id="opcion<?php echo ($iCont ); ?>"
                                                            name="opcion<?php echo ($iCont ); ?>"
                                                            value="<?php echo ($opcion['opci_descripcion']); ?>"> </td>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                            <?php }
                                        } elseif ($_POST['CRUD'] == 1) {
                                            foreach ($arr_Opciones as $iCont => $opcion) {
                                                ?>
                                        <tr id="row<?php echo ($iCont); ?>">
                                            <br>
                                            <td>
                                                <input type="text" class="form-control" placeholder="Opcion <?php echo ($iCont); ?>"
                                                    id="opcion<?php echo ($iCont); ?>"
                                                    name="opcion<?php echo ($iCont); ?>"
                                                    value="<?php echo ($opcion['opci_descripcion']); ?>">
                                            </td>
                                        </tr>
                                        <div class="col-lg-8 form-group">
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
          //? Creación y envio del dml
                                if (!isset($_POST['CRUD'])) { ?>
                                <input type="hidden" id="dml" name="dml" value="insert">
                                                    <?php
                                } elseif (isset($_POST['CRUD']) && $_POST['CRUD'] == 1) { ?>
                                <input type="hidden" id="dml" name="dml" value="update">
                                <input type="hidden" id="id" name="id"
                                    value="<?php echo ($pregunta->preg_id_pregunta); ?>">
                                <?php }?>
                            </div>
                        </div>



































                    </div>

                    <!-- ID e Instrucciones -->
                    <?php if (isset($_POST['CRUD'])) { ?>
                        <?php if ($_POST['CRUD'] == 1) { ?>
                    <input type="hidden" name="dml" value="update" />
                    <input type="hidden" id="idPregunta" name="idPregunta" value="<?php echo $_POST['id'];?>">
                        <?php }
                    } else { ?>
                    <input type="hidden" name="dml" value="insert" />
                    <?php } ?>

                    <!-- Desactivar formulario FIN -->
                    <?php if (isset($_POST['CRUD'])) { ?>
                        <?php if ($_POST['CRUD'] == 0) { ?>
                </fieldset>
                        <?php } ?>
                    <?php } ?>

            </form>
            <?php if (isset($_POST['CRUD'])) { ?>
                <?php if ($_POST['CRUD'] == 1) { ?>
            <p class="aviso-rojo">* Sólo se puede actualizar una pregunta, si no ha sido respondida por un profesor.</p>
            <p class="aviso-rojo">** No se puede cambiar el tipo de pregunta. Puede eliminar la pregunta y luego crear
                un nuevo registro.</p>
                <?php } ?>
            <?php } ?>
            <!-- Botones -->
            <div class="col-lg-12" style="text-align: center;">
                <button id="btn-regresar-cuestionario" type="button"
                    class="btn btn-success btn-footer btn-regresar">Regresar</button>
                <?php if (isset($_POST['CRUD'])) { ?>
                    <?php if ($_POST['CRUD'] == 1) { ?>
                <button id="btn-actualizar-cuestionario" type="button"
                    class="btn btn-success btn-footer btn-aceptar">Actualizar</button>
                    <?php } ?>
                <?php } else { ?>
                <button id="btn-registrar-cuestionario" type="button" form="form_cuestionarios"
                    class="btn btn-success btn-footer btn-aceptar">Guardar</button>
                <?php } ?>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
        <script>
            // Variables
            let agregar = document.getElementById('agregar');
            let contenido = document.getElementById('contenedor');
            agregar.addEventListener('click', (e) => {
                e.preventDefault();
                let clonado = document.querySelector('.clonar');
                let clon = clonado.cloneNode(true);

                contenido.appendChild(clon).classList.remove('clonar');

                let remover_ocultar = contenido.lastChild.childNodes[1].querySelectorAll('button');
                remover_ocultar[0].classList.remove('ocultar');
            });

            contenido.addEventListener('click', (e) => {
                e.preventDefault();
                if (e.target.classList.contains('puntero')) {
                    let contenedor = e.target.parentNode.parentNode;

                    contenedor.parentNode.removeChild(contenedor);
                }
            });
        </script>
        <script src="../sistema/cuestionarios/control_cuestionarios.js"></script>
