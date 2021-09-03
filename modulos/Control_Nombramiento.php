<?php

include('../clases/BD.php');
include('../clases/Nombramiento.php');

$obj_Nombramiento = new Nombramiento();

if($_POST['dml'] == 'insert'){

    //inicialización de la variable con los datos enviados por POST
    $nombre = $_POST['NombreNombramiento'];

    //Se busca si existe alguna Nombramiento con ese nombre
    $encontrado = $obj_Nombramiento->buscarNombramientoNombre($nombre);

    //En caso de encontrarlo no lo registra, de lo contrario hace el registro
    if(isset($encontrado->coor_id_nombramiento)){
        exit('2');//algo fue encontrado por ello no se registra
    } 

    $obj_Nombramiento->agregarNombramiento($nombre);
    exit('1');//Como no se encontró una coincidencia, lo registra

}

elseif($_POST['dml'] == 'update'){

    //Se inicializan las variables con los datos enviados por POST
    $nombre = $_POST['NombreNombramiento'];
    $id = $_POST['id_nombramiento'];

    //Se busca si existe alguna nombramiento con ese nombre que se quiere actualizar
    $encontrado = $obj_Nombramiento->buscarNombramientoNombre($nombre);

    //En caso de encontrarlo no lo registra, de lo contrario hace el registro
    if(isset($encontrado->coor_id_Nombramiento)){
        exit('2');//algo fue encontrado por ello no se registra
    } 

    $obj_Nombramiento->actualizarNombramiento($id, $nombre);
    exit('1');//Como no se encontró una coincidencia, lo registra

}

else{
    exit('0');
}
?>