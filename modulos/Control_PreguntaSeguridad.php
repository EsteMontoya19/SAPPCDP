<?php

    include('../clases/BD.php');
    include('../clases/PreguntaSeguridad.php');

    $obj_PreguntaSeguridad = new PreguntaSeguridad();

    if($_POST['dml'] == 'insert')
    {
        $Pregunta = $_POST['NombrePreguntaSeguridad'];
        $Activo = $_POST['EstatusPreguntaSeguridad'];

        $existe = $obj_PreguntaSeguridad->buscarPreguntaSeguridadNombre($Pregunta);

        if($existe->numero == 0){
            $obj_PreguntaSeguridad->agregarPreguntaSeguridad($Pregunta, $Activo);
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
    elseif ($_POST['dml'] == 'cambio')
    {
        $id = $_POST['id'];
        $Activo = $_POST['estatus'];

        if ($Activo == 't')
        {
            $Activo = 'FALSE';
            $obj_PreguntaSeguridad->cambiarEstatusPreguntaSeguridad($Activo, $id);
        }
        elseif($Activo == 'f')
        {
            $Activo = 'TRUE';
            $obj_PreguntaSeguridad->cambiarEstatusPreguntaSeguridad($Activo, $id);
        }
        
        exit("1");
    }
    else
    {
        exit("0");
    }
  
?>