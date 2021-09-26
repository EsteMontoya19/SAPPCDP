<?php

    include('../clases/BD.php');
    include('../clases/Pregunta.php');
    include('../clases/Opcion.php');
    include('../clases/Cuestionario.php');

    $obj_Pregunta = new Pregunta();
    $obj_Opcion = new Opcion();
    $obj_Cuestionario = new Cuestionario();

    if($_POST['dml'] == 'insert')
    {
        
    } 
    elseif ($_POST['dml'] == 'update')
    {
        
    } 
    elseif ($_POST['dml'] == 'cambio')
    {
        //Se incializan las variables con los datos enviados por POST
        $id = $_POST['id'];
        $Activo = $_POST['estatus'];

        //Si el estado es t
        if ($Activo == 't')
        {
            $Activo = 'FALSE';
            $obj_Pregunta->actualizarActivoPregunta($id, $Activo);
        }
        //Si el estado es f
        elseif($Activo == 'f')
        {
            $Activo = 'TRUE';
            $obj_Pregunta->actualizarActivoPregunta($id, $Activo);
        }

        

        
        exit("1");
    }
    else
    {
        exit("0");
    }
  
?>