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
            $orden = 'null';
            $obj_Pregunta->actualizarActivoPregunta($id, $Activo, $orden);
        }
        //Si el estado es f
        elseif($Activo == 'f')
        {
            $Activo = 'TRUE';
            $obj_Pregunta->actualizarActivoPregunta($id, $Activo, $orden);
        }

        exit("1");
    }
    elseif ($_POST['dml'] == 'orden')
    {
        
    } elseif (isset($_POST['update'])) {

        foreach($_POST['positions'] as $position) {
            $index = $position[0];
            $newPosition = $position[1];
            
            $result = $obj_Pregunta->actualizarOrdenPregunta($index, $newPosition);
            
            

            //$UpdatePosition = ("UPDATE drag_drop SET posicion = '$newPosition' WHERE id='$index' ");
            //$result = mysqli_query($con, $UpdatePosition);
            //print_r($UpdatePosition);
        }
        
        exit('1');
    }
    else
    {
        exit("0");
    }
  
?>