<?php

    include('../clases/BD.php');
    include('../clases/PreguntaSeguridad.php');

    $obj_PreguntaSeguridad = new PreguntaSeguridad();

    if($_POST['dml'] == 'insert')
    {
        $Pregunta = $_POST['NombrePreguntaSeguridad'];

        $existe = $obj_PreguntaSeguridad->buscarPreguntaSeguridadNombre($Pregunta);

        if($existe->numero == 0){
            $obj_PreguntaSeguridad->agregarPreguntaSeguridad($Pregunta);
            exit("1");
        } else {
            exit("2");
        }
    } 
    elseif ($_POST['dml'] == 'update')
    {
        $Pregunta = $_POST['NombrePreguntaSeguridad'];
        $id = $_POST['id_PreguntaSeguridad'];

        $existe = $obj_PreguntaSeguridad->buscarPreguntaSeguridadNombre($Pregunta);

        if($existe->numero == 0){
            $obj_PreguntaSeguridad->actulizarPreguntaSeguridad($Pregunta, $id);
            exit("1");
        } else {
            exit("2");
        }
    } 
    else
    {
        exit("0");
    }
  
?>