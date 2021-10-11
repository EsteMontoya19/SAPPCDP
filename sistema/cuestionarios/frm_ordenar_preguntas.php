<?php
include('../../clases/BD.php');
include('../../clases/Pregunta.php');
include('../../clases/Cuestionario.php');

$obj_Pregunta = new Pregunta();
$arr_Preguntas = $obj_Pregunta->buscarPreguntasActivas(); 

$x = 0;
?>

<div id="wrapper">
    <div id="content-wrapper">
        <div class="container-fluid">

            <!-- Indicador -->
            <div class="form-inline">
                <div class="col-sm-12" style="padding:0px">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <i class="fas fa-user-shield"></i>&nbsp; Cuestionario Actual
                        </li>
                    </ol>
                </div>
            </div>

            <p>
                <hr>
            </p>

            <div class="row sortable"  id="drop-items">
                <?php
                if(isset($arr_Preguntas)){
                    foreach ($arr_Preguntas as $pregunta) { 
                ?>
                    <div class="col-md-6 col-lg-12" data-index="<?php echo $pregunta['preg_id_pregunta']; ?>" data-position="<?php echo $pregunta['preg_orden']; ?>">
                        <div class="drop__card">
                            <div class="drop__data">
                                <div class="circulo">
                                    <h2><?php echo $pregunta['preg_orden']; ?> </h2>
                                </div> 
                                <div>
                                    <h1 class="drop__name">Pregunta: <?php echo $pregunta['preg_descripcion']; ?></h1>
                                    <h1 class="drop__profession">Tipo: <?php echo $pregunta['preg_tipo']; ?></h1>
                                </div>
                            </div>     
                        </div>
                    </div>
                <?php
                    }
                }
                ?>

            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8" src="C:/wamp64/www/SAPPCDP/recursos/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" charset="utf-8" src="C:/wamp64/www/SAPPCDP/recursos/js/jquery-ui.min.js"></script>
<script src="../sistema/cuestionarios/control_cuestionarios.js"></script>

