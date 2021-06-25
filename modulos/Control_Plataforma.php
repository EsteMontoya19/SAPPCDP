<?php

    include('../clases/BD.php');
    include('../clases/Plataforma.php');

    $obj_Plataforma = new Plataforma();

    if($_POST['dml'] == 'insert')
    {
        //Se incializan las variables con los datos enviados por POST
        $Nombre = $_POST['NombrePlataforma'];
        $Activo = $_POST['EstatusPlataforma'];

        //Se busca un registro dado el nombre
        $existe = $obj_Plataforma->buscarPlataformaNombre($Nombre);

        //Si no existe una plataforma con el mismo nombre se agrega
        if($existe->numero == 0){
            $obj_Plataforma->agregarPlataforma($Nombre, $Activo);
            exit("1");
        //Si existe
        } else {
            exit("2");
        }
    } 
    elseif ($_POST['dml'] == 'update')
    {
        //Se incializan las variables con los datos enviados por POST
        $Nombre = $_POST['NombrePlataforma'];
        $id = $_POST['id_Plataforma'];

        //Se busca un registro dado el nombre
        $existe = $obj_Plataforma->buscarPlataformaNombre($Nombre);

        //Si no existe una plataforma con el mismo nombre se agrega
        if($existe->numero == 0){
            $obj_Plataforma->actulizarPlataforma($Nombre, $id);
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

        //Si el estado es t
        if ($Activo == 't')
        {
            $Activo = 'FALSE';
            $obj_Plataforma->cambiarEstatusPlataforma($Activo, $id);
        }
        //Si el estado es f
        elseif($Activo == 'f')
        {
            $Activo = 'TRUE';
            $obj_Plataforma->cambiarEstatusPlataforma($Activo, $id);
        }
        
        exit("1");
    }
    else
    {
        exit("0");
    }
  
?>