<?php

    include('../clases/BD.php');
    include('../clases/Plataforma.php');

    $obj_Plataforma = new Plataforma();

    if($_POST['dml'] == 'insert')
    {
        $Nombre = $_POST['NombrePlataforma'];
        $Activo = $_POST['EstatusPlataforma'];

        $existe = $obj_Plataforma->buscarPlataformaNombre($Nombre);

        if($existe->numero == 0){
            $obj_Plataforma->agregarPlataforma($Nombre, $Activo);
            exit("1");
        } else {
            exit("2");
        }
    } 
    elseif ($_POST['dml'] == 'update')
    {
        $Nombre = $_POST['NombrePlataforma'];
        $id = $_POST['id_Plataforma'];

        $existe = $obj_Plataforma->buscarPlataformaNombre($Nombre);

        if($existe->numero == 0){
            $obj_Plataforma->actulizarPlataforma($Nombre, $id);
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
            $obj_Plataforma->cambiarEstatusPlataforma($Activo, $id);
        }
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