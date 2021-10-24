<?php

// Clases
include('../../clases/BD.php');
include('../../clases/Busqueda.php');
include('../../clases/Grupo.php');


// Objetos
$obj_Busqueda = new Busqueda();
$obj_Grupo = new Grupo();


//Catálogos


$Grupo = new Grupo();
$Grupo = $obj_Grupo->grup_id_grupo = null;

?>

<div id="wrapper">
        <div id="content-wrapper">
            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li id="btn-inicio-grupo" class="breadcrumb-item">
                        <a href="#"><i class="fas fa-envelope"></i></i>&nbsp; Correo</a>
                    </li>
                </ol>
                <p>
                    <hr>
                </p>

                <!-- Formulario -->
                <form name="form_correo" id="form_correo"  autocomplete="on" method="POST">
                    <!-- Section: Datos de constancia -->
                    <div class="form-group">
                        <div class="card lg-12">
                            <div class="card-header">
                                    <i class="fas fa-id-card fa-lg"></i>
                                    <b>&nbsp; Envió de correos a inscritos a grupos</b>
                            </div>

                            <div class="col-lg-12 form-row" style="margin-top: 15px;">
                                <div class="col-lg-1 form-group">
                                    <label for ="destinatario"><b> Para:</b></label>
                                </div>
                                <div class="col-lg-11 form-group">
                                    <input type="text" class="form-control" id="destinatario" name="destinatario" placeholder="Ingrese el ID o nombre del grupo al cual desea mandar correo."
                                     autocomplete="off" >
                                </div>
                            </div>

                            <div class="col-lg-12 form-row" style="margin-top: 15px;">
                                <div class="col-lg-1 form-group">
                                    <label for ="asunto"><b> Asunto:</b></label>
                                </div>
                                <div class="col-lg-11 form-group">
                                <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Ingrese el asunto que llevara el correo">
                                </div>
                            </div>

                            <br>
                            <br>
                            <div class="col-lg-12 form-row" style="margin-top: 15px;">
                                <div class="col-lg-1 form-group">
                                    <label for ="mensaje"><b> Mensaje:</b></label>
                                </div>
                                <div class="col-lg-11 form-group">
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="8" placeholder="Contenido del correo..."></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12" style="text-align: center;">
                            <button id="btn-limpiar" type="button" class="btn btn-secondary btn-footer btn-regresar">Limpiar</button>
                            <button id="btn-enviar" type="button" class="btn-footer btn btn-primary" value='Enviar'>Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Botones -->


    <script src="../sistema/correo/control_correo.js"></script> 

