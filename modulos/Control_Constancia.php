<?php

include('../clases/BD.php');
include('../clases/Constancias.php');
include('../clases/Grupo.php');

$obj_Constancia = new Constancias();
$obj_Grupo = new Grupo();

if($_POST['dml'] == 'insert'){

    $idGrupo = $_POST['id'];

    //? Busca acredores del grupo solicitado, es el mismo que se utiliza para las listas de constancias.
	$arr_Acreedores = $obj_Grupo->buscarAcreedorConstancia($idGrupo);
    $arr_NoAcreedores = $obj_Grupo->buscarNoAcreedoresConstancia($idGrupo); 

    //? Validamos que si hayan subido algo y no este todo en blanco.
    if (isset($_FILES['constancias']['name']) && $_FILES['constancias']['name'] != '') {
        $nombreArchivo = $_FILES['constancias']['name'];

        //? Comprobamos que la extensión sea .zip
        if(substr($nombreArchivo, -4) == ".zip") {
            
            $zip=new ZipArchive();
            //? Guardamos la direccion de la carpeta donde se descomprimira todo
            $direccion = "../recursos/PDF/Constancias/Profesores/$idGrupo/";

            //? Existe la dirección temporal?
            if($zip->open($_FILES['constancias']['tmp_name'])===TRUE) {
                $direccionTemporal = "../recursos/PDF/Constancias/Profesores/".substr($nombreArchivo, 0 , -4)."/";
                
                //? Si ya existe una carpeta con el id del grupo elimina para sobrescribir
                if(file_exists("../recursos/PDF/Constancias/Profesores/".$idGrupo."/")) {
                
                    $archivosDirectorio = scandir("../recursos/PDF/Constancias/Profesores/".$idGrupo."/");
                    
                    foreach ($archivosDirectorio as $iCont => $archivo) {
                        if ($iCont >= 2) {
                            unlink("../recursos/PDF/Constancias/Profesores/".$idGrupo."/".$archivo);
                        }
                    }
                    rmdir("../recursos/PDF/Constancias/Profesores/".$idGrupo."/");
                }

                //? Extrae los archivos pero nombra la carpeta como el .zip
                $zip->extractTo("../recursos/PDF/Constancias/Profesores/");

                //? Se renombra la carpeta con el id del grupo
                rename($direccionTemporal, $direccion);
                $zip->close();

                //? Se crea un arreglo con los archivos de la carpeta
                $files = scandir($direccion); //Por default se ordena asc y empieza apartir del [2] las direcciones de archivos
                
                //? Se renombran los archivo con el formato de dos digitos 00
                foreach($files as $nombre){
                    $obj_Constancia->renombrarConstancia($nombre, $direccion);
                }
                //? Se guardan los nuevos nombres de archivos en un arreglo 
                $files= scandir($direccion);
                
                //? Asignamos las constancias a los acreedores
                foreach ($arr_Acreedores as $iCont => $acreedor) {
                    $obj_Constancia->cargarConstancia($acreedor['cons_id_constancias'], $direccion.$files[$iCont + 2]);
                    
                }

                //? Asignamos el No aplica constancia a los no acreedores
                foreach ($arr_NoAcreedores as $iCont => $noAcreedor) {
                    $obj_Constancia->negarConstancia($noAcreedor['cons_id_constancias']);
                    
                }
                
                exit("1");
            }

        } else {
            exit("2");
        }
    } else {
        exit("2");
    }

    exit("2");

        
} elseif ($_POST['dml'] == 'cambioEstadoDescargada') {
    $id = $_POST['consID'];

    $obj_Constancia->actualizarEstadoConstanciaDescargada($id);

    exit('1');
} elseif($_POST['dml'] == 'insertPersonal'){

    $periodoInicio = $_POST['PeriodoInicio'];
    $periodoFinal = $_POST['PeriodoFinal'];

    //? Busca acredores (Inductores y Moderadores) del periodo solicitado, es el mismo que se utiliza para las listas de constancias.
	

    //? Validamos que si hayan subido algo y no este todo en blanco.
    if (isset($_FILES['constanciasInstructor']['name']) && $_FILES['constanciasInstructor']['name'] != '') {
        $nombreArchivo = $_FILES['constanciasInstructor']['name'];

        //? Comprobamos que la extensión sea .zip
        if(substr($nombreArchivo, -4) == ".zip") {
            
            $zip=new ZipArchive();
            //? Guardamos la direccion de la carpeta donde se descomprimira todo
            $direccion = "../recursos/PDF/Constancias/Instructores/"; // Falta asignar un serial a la carpeta

            //? Existe la dirección temporal?
            if($zip->open($_FILES['constanciasInstructor']['tmp_name'])===TRUE) {
                
                
                
                exit("1");
            }

        } else {
            exit("2");
        }
    } else {
        exit("2");
    }

    exit("2");

}   
?>