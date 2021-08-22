<?php

// Clases
include('../../clases/BD.php');
include('../../clases/Busqueda.php');
include('../../clases/Grupo.php');
include('../../clases/Sesion.php');
include('../../clases/Curso.php');
include('../../clases/Instructor.php');
include('../../clases/Moderador.php');

// Objetos
$obj_Busqueda = new Busqueda();
$obj_Grupo = new Grupo();
$obj_Sesion = new Sesion();
$obj_Curso = new Curso();
$obj_instructor = new Instructor();
$obj_Moderador = new Moderador();

//Catálogos
$arr_Cursos = $obj_Busqueda->selectCursosActivos();
$arr_Instructores = $obj_instructor->buscarInstructoresActivos();
$arr_Moderadores = $obj_Moderador->buscarModeradoresActivos();
$arr_Plataformas = $obj_Busqueda->selectPlataformas();
$arr_Salones = $obj_Busqueda->selectSalones();
$arr_Modalidades = $obj_Busqueda->selectModalidadesAprendizaje();
$arr_Estados = $obj_Busqueda->selectEstadosGrupo();

$Grupo = new Grupo();
$Grupo = $obj_Grupo->grup_id_grupo = null;

?>

<div id="wrapper">
        <div id="content-wrapper">
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li id="btn-inicio-grupo" class="breadcrumb-item">
                        <a href="#"><i class="fa fa-file-alt"></i>&nbsp; Constancias</a>
                    </li>
                </ol>
                <p>
                    <hr>
                </p>

                <!-- Formulario -->
                <form name="form_grupo" action='../sistema/constancia/sheets.php' id="form_grupo" method="POST">
                    <!-- Section: Datos de constancia -->
                    <div class="form-group">
                        <div class="card lg-12">
                            <div class="card-header">
                                    <i class="fas fa-id-card fa-lg"></i>
                                    <b>&nbsp; Constancias por periodo</b>
                            </div>
                            <div class="col-lg-12 form-row" style="margin-top: 15px;">
                                <div class="col-lg-6 form-group">
                                    <label for ="mesConstancia"><b>Mes de las constancias:</b></label>
                                    <input type="month" class="form-control" id="mesConstancia" name="mesConstancia" placeholder="0" min="0" value="<?php echo isset($Grupo) ? $Grupo->grup_inicio_insc : ""; ?>"
                                        max = "<?php 
                                                $fecha =  date('m');
                                                $fecha -= 1;
                                                if ($fecha < 10) {
                                                    $fecha = '0' . $fecha;
                                                }
                                                $fecha = date('Y') . "-" . $fecha;
                                                echo($fecha); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="text-align: center;">
                            <button id="btn-regresar-constancia" type="button" class="btn btn-secondary btn-footer btn-regresar">Regresar</button>
                            <input id="btn-consultar-constancias" type="submit" class="btn btn-primary" value='Generar'></input>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Botones -->


    <script src="../sistema/constancia/control_constancias.js"></script>
