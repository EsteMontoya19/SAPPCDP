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

                //? Validación solicitada por la Coordinadora del programa en la reunión del 17/08/2021
                if (count($arr_Acreedores) != count($files) - 2) {
                    exit("5");
                }
                
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

    // Inputs
    $fechaInicio =  $_POST["ConstanciasMes"];

    //? Se le da el formato a la fecha para restringir los periodos a un mes
    $fechaFin = substr($fechaInicio,-2);

    if($fechaFin == 12) {
        $fechaFin = substr($fechaInicio, 0, 4);
        $fechaFin += 1;
        $fechaFin = $fechaFin . "-01-01";
    } else {
        $fechaFin += 1;
        if ($fechaFin < 10) {
            $fechaFin = "0" . $fechaFin;
        }
        $fechaFin = substr($fechaInicio, 0 , 4) . "-" . $fechaFin;
        $fechaFin = $fechaFin . "-01";
    }
    $fechaInicio = $fechaInicio . "-01";


    $arr_Instructores = $obj_Constancia->consultarConstanciaInstructores($fechaInicio, $fechaFin);
    $arr_Moderadores = $obj_Constancia->consultarConstanciaModeradores($fechaInicio, $fechaFin);

    //? Validamos que si hayan subido algo y no este todo en blanco.
    if (isset($_FILES['constanciasInstructor']['name']) && $_FILES['constanciasInstructor']['name'] != '') {
        $nombreArchivo = $_FILES['constanciasInstructor']['name'];

        //? Comprobamos que la extensión sea .zip
        if(substr($nombreArchivo, -4) == ".zip") {
            
            $zip=new ZipArchive();
            //? Guardamos la direccion de la carpeta donde se descomprimira todo
            $direccion = "../recursos/PDF/Constancias/Instructores/".$fechaInicio."/"; 

            //? Existe la dirección temporal?
            if($zip->open($_FILES['constanciasInstructor']['tmp_name'])===TRUE) { 
                $direccionTemporal = "../recursos/PDF/Constancias/Instructores/".substr($nombreArchivo, 0 , -4)."/";
                
                $direccionTemporal = "../recursos/PDF/Constancias/Instructores/".substr($nombreArchivo, 0 , -4)."/";

                //? Si ya existe una carpeta con el id del grupo elimina para sobrescribir
                if(file_exists("../recursos/PDF/Constancias/Instructores/".$fechaInicio."/")) {
                
                    $obj_Constancia->eliminarDirectorio("../recursos/PDF/Constancias/Instructores/".$fechaInicio."/");
                }

                //? Extrae los archivos pero nombra la carpeta como el .zip
                $zip->extractTo("../recursos/PDF/Constancias/Instructores/");

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

                //? Validación solicitada por la Coordinadora del programa en la reunión del 17/08/2021
                if (count($arr_Instructores) != count($files) - 2) {
                    $obj_Constancia->eliminarDirectorio("../recursos/PDF/Constancias/Instructores/".$fechaInicio."/");
                    exit("5");
                }
                
                //? Asignamos las constancias a los instructores
                foreach ($arr_Instructores as $iCont => $acreedor) {
                    $obj_Constancia->cargarConstancia($acreedor['cons_id_constancias'], $direccion.$files[$iCont + 2]);
                    
                }

                //? Asignamos el No aplica constancia a los no acreedores
                /*foreach ($arr_NoAcreedores as $iCont => $noAcreedor) {
                    $obj_Constancia->negarConstancia($noAcreedor['cons_id_constancias']);
                    
                }*/
                
                
                
                
                /*

                    Asignación para Instructores
                
                
                */
                
                
                
                
                
                
                
                //? Validamos que si hayan subido algo y no este todo en blanco.
                if (isset($_FILES['constanciasModerador']['name']) && $_FILES['constanciasModerador']['name'] != '') {
                    $nombreArchivo = $_FILES['constanciasModerador']['name'];

                    //? Comprobamos que la extensión sea .zip
                    if(substr($nombreArchivo, -4) == ".zip") {
                        
                        $zip=new ZipArchive();
                        //? Guardamos la direccion de la carpeta donde se descomprimira todo
                        $direccion = "../recursos/PDF/Constancias/Moderadores/".$fechaInicio."/"; // Falta asignar un serial a la carpeta

                        //? Existe la dirección temporal?
                        if($zip->open($_FILES['constanciasModerador']['tmp_name'])===TRUE) {
                            
                            $direccionTemporal = "../recursos/PDF/Constancias/Moderadores/".substr($nombreArchivo, 0 , -4)."/";

                            //? Si ya existe una carpeta con el id del grupo elimina para sobrescribir
                            if(file_exists("../recursos/PDF/Constancias/Moderadores/".$fechaInicio."/")) {
                            
                                $obj_Constancia->eliminarDirectorio("../recursos/PDF/Constancias/Moderadores/".$fechaInicio."/");
                            }

                            //? Extrae los archivos pero nombra la carpeta como el .zip
                            $zip->extractTo("../recursos/PDF/Constancias/Moderadores/");

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

                            //? Validación solicitada por la Coordinadora del programa en la reunión del 17/08/2021
                            if (count($arr_Moderadores) != count($files) - 2) {
                                $obj_Constancia->eliminarDirectorio("../recursos/PDF/Constancias/Moderadores/".$fechaInicio."/");
                                exit("5");
                            }
                            
                            //? Asignamos las constancias a los Moderadores
                            foreach ($arr_Moderadores as $iCont => $acreedor) {
                                $obj_Constancia->cargarConstancia($acreedor['cons_id_constancias'], $direccion.$files[$iCont + 2]);
                                
                            }

                            //? Asignamos el No aplica constancia a los no acreedores
                            /*foreach ($arr_NoAcreedores as $iCont => $noAcreedor) {
                                $obj_Constancia->negarConstancia($noAcreedor['cons_id_constancias']);
                                
                            }*/


                            
                            exit("1");
                        }

                    } else {
                        exit("3");
                    }
                } else {
                    exit("1");
                }
            }

        } else {
            exit("3");
        }
    } else {
        exit("2");
    }

    exit("4");

} elseif ($_POST['dml'] == 'insertConstanciaManual'){
    
    $idGrupo = $_POST['idGrupo'];
    $idConstanciaProfesor = $_POST['ID_profesor_constancia'];

    //Esta parte es para la verificación de que se ha subido un archivo de constancia al profesor seleccionado
    if($idConstanciaProfesor != 0){
        if (isset($_FILES['constanciaProfesor']['name']) && $_FILES['constanciaProfesor']['name'] != '') {
            //TODO hay que verificar si ya tiene asignada una constancia el profesor para en dado caso eliminarla 
            //TODO y posteriormente guardar el nuevo archivo en la misma url, de lo contrario se tiene que guardar
            //TODO el archivo nuevo con un nombre nuevo (agregar al final al formato de los archivos de constancia 
            //TODO el nombre del profesor y id constancia) Si no merece constancia no se debe permitir asignar.
        }
    }

    //Aqui comienza la verificación de si se ha subido un archivo de constancia al instructor
    if(isset($_FILES['constanciaInstructor']['name']) && $_FILES['constanciaInstructor']['name'] != ''){
        //TODO verificar si el instructor ya tiene asignada una constancia para en su caso eliminarla y guardar
        //TODO el archivo de la nueva con la misma ruta, de lo contrario guardar el archivo con nombre nuevo.
    }

    //TODO Aqui primero hay que buscar al moderador del grupo y verificar que sea profesor para asignar la constancia 
    //TODO si no lo es debe de mostrar el error directamente desde el js
    //Aqui comienza la verificación de si se ha subido un archivo de constancia al moderador
    if(isset($_FILES['constanciaModerador']['name']) && $_FILES['constanciaModerador']['name'] != ''){
        //TODO verificar si el moderador ya tiene asignada una constancia para en su caso eliminarla y guardar
        //TODO el archivo de la nueva con la misma ruta, de lo contrario guardar el archivo con nombre nuevo.
    }
}  
?>