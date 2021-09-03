<?php

// Clases
include('../../clases/BD.php');
include('../../clases/Grupo.php');

// Objetos
$obj_Grupo = new Grupo();

//Catálogos
$arr_GruposPrivados = $obj_Grupo->buscarGruposPrivados();
?>

<div id="wrapper">
    <div id="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li id="btn-inicio-grupo" class="breadcrumb-item">
                    <a href="#"><i class="fas fa-key"></i>&nbsp; Inscripcion a grupos privados</a>
                </li>
            </ol>
            <p>
                <hr>
            </p>

            <!-- Formulario -->
            <form name="form_privados" action='../sistema/constancia/sheets.php' id="form_grupo" method="POST">
                <!-- Section: Datos de constancia -->
                <div class="form-group">
                    <div class="card-header">
                        <i class="fas fa-id-card fa-lg"></i>
                        <b>&nbsp;&nbsp;Inscripcion a grupos privados </b>
                    </div>

                    <div class="col-lg-12 form-row" style="margin-top: 15px;">
                        <div class="col-lg-12 form-group">
                            <label for="idGrupo"><b>Gupos privados en periodo de inscripcion:</b></label>
                            <select required='required' class="custom-select" id="idGrupo" name="idGrupo" <?php echo(isset($arr_GruposPrivados) ? "" : "disabled" );?>>
                                <option value="0"><?php echo(isset($arr_GruposPrivados) ? "Seleccione un grupo" : "Sin grupos privados disponibles" );?></option>
                                <?php foreach ($arr_GruposPrivados as $grupo) { ?>
                                    <option value="<?php echo $grupo['grup_id_grupo']; ?>"> 
                                        <?php echo ($grupo['curs_nombre']." | (".$grupo['curs_tipo'].") ".$grupo['curs_nivel']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                    <?php //? Este contenedor se llena con los profesores activos disponibles eliminando al instructor del grupo seleccionado y a los ya inscritos ?>
                    <section id="contenedorProfesores">


                    </section>
                    
                
                    <div class="col-lg-12" style="text-align: center;">
                        <button id="btn-regresar-privados" type="button" class="btn btn-secondary btn-footer btn-regresar">Regresar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../sistema/inscripciones/control_inscripciones.js"></script>
