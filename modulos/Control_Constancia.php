<?php

include('../clases/BD.php');
include('../clases/Constancias.php');
include('../clases/Grupo.php');

$obj_Constancia = new Constancias();
$obj_Grupo = new Grupo();

if($_POST['dml'] == 'insert'){

    $idGrupo = $_POST['id'];

    //Existe la ruta? si no, la crea
    if(file_exists("../recursos/PDF/Constancias/".$idGrupo."/") == false){
        mkdir($rutaNueva, 0755); //0755 (Rwxr-xr-x) 
    }

    //Hay un archivo? Lo carga al sistema
    if (isset($_FILES['constancia']['name']) && $_FILES['constancia']['name'] != '') { //? Si lleno el constancia
        
        $file = is_uploaded_file($_FILES['constancia']['tmp_name']);
        $rutaTemporal = $_FILES['constancia']['tmp_name'];
        $rutaNueva = "../recursos/PDF/Constancias/".$idGrupo."/";
        $nuevoNombre = "constancia_".$idGrupo.".zip";
        move_uploaded_file($_FILES['constancia']['tmp_name'], $rutaNueva.$nuevoNombre);
        $constancia = $rutaNueva.$nuevoNombre;

        $file = fopen ("Mensajes.txt", "a");
        fwrite($file, $rutaTemporal.PHP_EOL);
        fwrite($file, $constancia.PHP_EOL);
        fclose($file);
    }

    /*

    // Descomprimir el archivo y eliminar el zip
    
    if (extractTo($rutaNueva, $constancia) == false){
        exit("2");
    } else {
        if (unlink($constancia)) {
            // file was successfully deleted
        } else {
            // there was a problem deleting the file
            exit("3");
        }
    }

    // Realizar la consulta que generó el archivo de constancias 

    $arr_Inscritos = $obj_Grupo->buscarCorreosDeParticipantes($idGrupo); // Revisar

    

    // Enlazar la dirección del archivo con su inscripción

    */

    exit("1");
}
?>