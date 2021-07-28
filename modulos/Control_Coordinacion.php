<?php

include('../clases/BD.php');
include('../clases/Coordinacion.php');

$obj_Coordinacion = new Coordinacion();

if($_POST['dml'] == 'insert'){

    //inicialización de la variable con los datos enviados por POST
    $nombre = $_POST['NombreCoordinacion'];

    //Se busca si existe alguna coordinacion con ese nombre
    $encontrado = $obj_Coordinacion->buscarCoordinacionNombre($nombre);

    //En caso de encontrarlo no lo registra, de lo contrario hace el registro
    if(isset($encontrado->coor_id_coordinacion)){
        exit('2');//algo fue encontrado por ello no se registra
    } 

    $obj_Coordinacion->agregarCoordinacion($nombre);
    exit('1');//Como no se encontró una coincidencia, lo registra

}

elseif($_POST['dml'] == 'update'){

    //Se inicializan las variables con los datos enviados por POST
    $nombre = $_POST['NombreCoordinacion'];
    $id = $_POST['id_coordinacion'];

    //Se busca si existe alguna coordinacion con ese nombre que se quiere actualizar
    $encontrado = $obj_Coordinacion->buscarCoordinacionNombre($nombre);

    //En caso de encontrarlo no lo registra, de lo contrario hace el registro
    if(isset($encontrado->coor_id_coordinacion)){
        exit('2');//algo fue encontrado por ello no se registra
    } 

    $obj_Coordinacion->actualizarCoordinacion($id, $nombre);
    exit('1');//Como no se encontró una coincidencia, lo registra

}

else{
    exit('0');
}
?>