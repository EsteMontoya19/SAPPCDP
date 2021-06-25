<?php

    include('../clases/BD.php');
    include('../clases/PreguntaSeguridad.php');

    $obj_PreguntaSeguridad = new PreguntaSeguridad();

    if($_POST['dml'] == 'insert')
    {
        //Se incializan las variables con los datos enviados por POST
        $Pregunta = $_POST['NombrePreguntaSeguridad'];
        $Activo = $_POST['EstatusPreguntaSeguridad'];

        //Se busca un registro dada la pregunta
        $existe = $obj_PreguntaSeguridad->buscarPreguntaSeguridadNombre($Pregunta);

        //Si no existe una registr con el mismo nombre se agrega
        if($existe->numero == 0){
            $obj_PreguntaSeguridad->agregarPreguntaSeguridad($Pregunta, $Activo);
            exit("1");
        //Si existe
        } else {
            exit("2");
        }
    } 
    elseif ($_POST['dml'] == 'update')
    {
        //Se incializan las variables con los datos enviados por POST
        $Pregunta = $_POST['NombrePreguntaSeguridad'];
        $id = $_POST['id_PreguntaSeguridad'];

        //Se busca un registro dada la pregunta
        $existe = $obj_PreguntaSeguridad->buscarPreguntaSeguridadNombre($Pregunta);

        //Si no existe una registr con el mismo nombre se agrega
        if($existe->numero == 0){
            $obj_PreguntaSeguridad->actulizarPreguntaSeguridad($Pregunta, $id);
            exit("1");
        //Si existe
        } else {
            exit("2");
        }
    } 
    elseif ($_POST['dml'] == 'cambio')
    {
        //Se incializan las variables con los datos enviados por POST
        $id = $_POST['id'];
        $Activo = $_POST['estatus'];
        //Si el activo es t
        if ($Activo == 't')
        {
            $Activo = 'FALSE';
            $obj_PreguntaSeguridad->cambiarEstatusPreguntaSeguridad($Activo, $id);
        }
        //Si el activo es f
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