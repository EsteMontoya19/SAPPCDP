<?php

    include('../clases/BD.php');
    include('../clases/Calendario.php');

    $obj_Calendario = new Calendario();

    if (isset($_POST['dml'])){

        if($_POST['dml'] == 'insert')
        {
            $semestre = $_POST['NombreSem'];
            $inicioCiclo = $_POST['inicioCiclo'];
            $finCiclo = $_POST['finCiclo'];
            $inicioExamenes = $_POST['inicioExamenes'];
            $finExamenes = $_POST['finExamenes'];
            $inicioInter = $_POST['inicioInter'];
            $finInter = $_POST['finInter'];
            $inicioAsueto = $_POST['inicioAsueto'];
            $finAsueto = $_POST['finAsueto'];
            $inicioAdmin = $_POST['inicioAdmin'];
            $finAdmin = $_POST['finAdmin'];

            $diasInhabiles = array();

            $bandera = true;
            for ($iCont = 0 ; $bandera ; $iCont ++) {
                if(isset ($_POST['diaFestivo'.$iCont]) && $_POST['diaFestivo'.$iCont] != '') {
                    $diasInhabiles[$iCont] = $_POST['diaFestivo'.$iCont];
                } else {
                    $bandera = false;
                }
            }

            $obj_Calendario->agregarCalendario($semestre,$inicioCiclo, $finCiclo, $inicioExamenes, $finExamenes,
                                                $inicioInter, $finInter, $inicioAsueto, $finAsueto, $inicioAdmin, $finAdmin);
            
            $ultimoCalendario = $obj_Calendario->buscarUltimo();

            foreach ($diasInhabiles as $iCont => $dia) {
                $obj_Calendario->agregarInhabiles($ultimoCalendario, $dia);
            }
            exit("1");
            
            

        } 
        elseif ($_POST['dml'] == 'update')
        {
            $id = $_POST['id'];
            $semestre = $_POST['NombreSem'];
            $inicioCiclo = $_POST['inicioCiclo'];
            $finCiclo = $_POST['finCiclo'];
            $inicioExamenes = $_POST['inicioExamenes'];
            $finExamenes = $_POST['finExamenes'];
            $inicioInter = $_POST['inicioInter'];
            $finInter = $_POST['finInter'];
            $inicioAsueto = $_POST['inicioAsueto'];
            $finAsueto = $_POST['finAsueto'];
            $inicioAdmin = $_POST['inicioAdmin'];
            $finAdmin = $_POST['finAdmin'];

            $diasInhabiles = array();

            $bandera = true;
            for ($iCont = 0 ; $bandera ; $iCont ++) {
                if(isset ($_POST['diaFestivo'.($iCont + 1)]) && $_POST['diaFestivo'.($iCont + 1)] != '') {
                    $diasInhabiles[$iCont] = $_POST['diaFestivo'.($iCont + 1)];

                } else {
                    $bandera = false;
                }
            }
            

            $obj_Calendario->actualizarCalendario($id, $semestre,$inicioCiclo, $finCiclo, $inicioExamenes, $finExamenes,
            $inicioInter, $finInter, $inicioAsueto, $finAsueto, $inicioAdmin, $finAdmin);
            
            $obj_Calendario->eliminarInhabiles($id);

            foreach ($diasInhabiles as $iCont => $dia) {
                $obj_Calendario->agregarInhabiles($id, $dia);
            }

            exit('1');
        } 
        elseif ($_POST['dml'] == 'cambio')
        {
            //Se incializan las variables con los datos enviados por POST
            $id = $_POST['id'];
            $Activo = $_POST['estatus'];
            $calendarioActivo = $obj_Calendario->buscarCalendarioActivo();
            
            if(isset($calendarioActivo)) {
                if($calendarioActivo->cale_id_calendario == $id) {
                    
                    exit("2");
                } else {
                    //Si el estado es f
                    if($Activo == 'f')
                    {
                        $Activo = 'TRUE';
                        $obj_Calendario->cambiarEstatusCalendario($Activo, $id, $calendarioActivo->cale_id_calendario);
                    }
                    exit("1");
                }
            } else {
                exit("4");
            }

        }
        else
        {
            exit("0");
        }
    } else {
        exit("404");
    }
  
?>