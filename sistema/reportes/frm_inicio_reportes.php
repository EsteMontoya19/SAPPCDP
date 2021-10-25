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
                        <a href="#"><i class="fa fa-file-alt"></i>&nbsp; Reportes</a>
                    </li>
                </ol>
                <p>
                    <hr>
                </p>

                <!-- Formulario -->
                <form name="form_grupo" action='../sistema/reportes/generar_reportes.php' id="form_grupo" method="POST">
                    <!-- Section: Datos de constancia -->
                    <div class="form-group">
                        <div class="card lg-12">
                            <div class="card-header">
                                    <i class="fas fa-id-card fa-lg"></i>
                                    <b>&nbsp; Periodo de las constancias</b>
                            </div>
                            <div class="col-lg-12 form-row" style="margin-top: 15px;">
                                <div class="col-lg-6 form-group">
                                    <label for ="fechaInicio"><b>Fecha de inicio:</b></label>
                                    <input type="date" class="form-control" id="mesConstancia" name="fechaDeInicio" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label for ="fechaFin"><b>Fecha de término:</b></label>
                                    <input type="date" class="form-control" id="mesConstancia" name="fechaDeFin">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="text-align: center;">
                            <button id="btn-regresar-reporte" type="button" class="btn btn-secondary btn-footer btn-regresar">Regresar</button>
                            <input id="btn-consultar-reporte" type="submit" class="btn btn-primary" value='Generar'></input>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Botones -->

    <script src="../reportes/control_reportes.js"></script>
