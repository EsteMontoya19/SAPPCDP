<?php

    include('../clases/BD.php');
    include('../clases/Pregunta.php');
    include('../clases/Opcion.php');
    include('../clases/Cuestionario.php');

    $obj_Pregunta = new Pregunta();
    $obj_Opcion = new Opcion();
    $obj_Cuestionario = new Cuestionario();

    if($_POST['dml'] == 'respuestas') {
        $cuestionario = $obj_Cuestionario->buscarPreguntasCuestionario();

        foreach ($cuestionario as $iCont => $pregunta) {

            switch ($pregunta['preg_tipo']) {
                case 'Si/No':
                    if(isset($_POST[$pregunta['preg_id_pregunta']."_SiNo"])) {
                        $obj_Cuestionario->registrarRespuesta($_POST['inscripcion'], $pregunta['preg_id_pregunta'],$_POST[$pregunta['preg_id_pregunta']."_SiNo"], "null");
                    } else {
                        exit("3");
                    }
                break;

                case 'Acuerdo/Desacuerdo':
                    if(isset($_POST[$pregunta['preg_id_pregunta']."_AcueDesa"])) {
                        $obj_Cuestionario->registrarRespuesta($_POST['inscripcion'], $pregunta['preg_id_pregunta'],$_POST[$pregunta['preg_id_pregunta']."_AcueDesa"], "null");
                    } else {
                        exit("3");
                    }
                break;

                case 'Si/No, con justificación':
                    if(isset($_POST[$pregunta['preg_id_pregunta']."_SiNoJ"])) {
                        $obj_Cuestionario->registrarRespuesta($_POST['inscripcion'], $pregunta['preg_id_pregunta'],$_POST[$pregunta['preg_id_pregunta']."_SiNoJ"], $_POST[$pregunta['preg_id_pregunta']."Justificacion"]);
                    } else {
                        exit("3");
                    }
                break;

                case 'Opción Múltiple':
                    $arr_opciones = $obj_Cuestionario->buscarOpcionesPregunta($pregunta['preg_id_pregunta']);
                        if(isset($_POST[$pregunta['preg_id_pregunta']."_multiple"])) {
                            $obj_Cuestionario->registrarRespuesta($_POST['inscripcion'], $pregunta['preg_id_pregunta'],$_POST[$pregunta['preg_id_pregunta']."_multiple"], "null");
                        } else {
                            exit("3");
                    }

                break;

                case 'Abierta':                    
                    if(isset($_POST[$pregunta['preg_id_pregunta']])) {
                        $obj_Cuestionario->registrarRespuesta($_POST['inscripcion'], $pregunta['preg_id_pregunta'],"null", $_POST[$pregunta['preg_id_pregunta']]);
                    } else {
                        exit("3");
                    }

                break;
                
                default:
                    exit("2");
                break;
            }            
        }
        exit("1");
    } 
    else if($_POST['dml'] == 'insert') {
        $pregunta = $_POST['pregunta'];
        $activo = 'FALSE';
        $tipo = $_POST['tipo_pregunta1'];
        $orden = 'NULL';
        
        $obj_Pregunta->agregarPregunta($pregunta, $activo, $orden, $tipo);
        $id = $obj_Pregunta->buscarUltimo();

        if($tipo == 'Abierta'){
            $obj_Cuestionario->agregarPROP($id, 'NULL');
        } elseif ($tipo == 'Si/No'){
            $obj_Cuestionario->agregarPROP($id, 1);
            $obj_Cuestionario->agregarPROP($id, 2);
        } elseif ($tipo == 'Si/No, con justificación'){
            $obj_Cuestionario->agregarPROP($id, 1);
            $obj_Cuestionario->agregarPROP($id, 2);
        }elseif ($tipo == 'Acuerdo/Desacuerdo'){
            $obj_Cuestionario->agregarPROP($id, 3);
            $obj_Cuestionario->agregarPROP($id, 4);
            $obj_Cuestionario->agregarPROP($id, 5);
            $obj_Cuestionario->agregarPROP($id, 6);
        } elseif ($tipo == "Opción múltiple") {
            //Se registran las opciones
            $arr_Opciones = $_POST['opcion'];

            for ($i=0; $i<sizeof($arr_Opciones); $i++) {
                $obj_Opcion->agregarOpcion($arr_Opciones[$i]);
                $idOpcion = $obj_Opcion->buscarUltimo();
                $obj_Cuestionario->agregarPROP($id, $idOpcion);
            }
        }

        exit("1");

    } 
    elseif ($_POST['dml'] == 'update')
    {
        $id = $_POST['idPregunta'];
        $pregunta = $_POST['PreguntaConsulta'];

        $registros = $obj_Cuestionario->buscarNumeroRespuestasIDPROP($id);
        
        //Si no hay ninguna respuesta se puede actualizar la pregunta
        if($registros->numero == 0){
            $obj_Pregunta->actualizarDescripcionPregunta($id, $pregunta);

            exit("1");
        } else {
            exit("2");
        }
    } 
    elseif ($_POST['dml'] == 'delete')
    {
        $id = $_POST['id'];
        $tipo = $_POST['tipo'];

        $registros = $obj_Cuestionario->buscarNumeroRespuestasIDPROP($id);
        
        //Si no hay ninguna respuesta se puede eliminar la pregunta
        if($registros->numero == 0){
            //Eliminar PROP
            $arr_Opciones = $obj_Cuestionario->buscarPROPIDPregunta($id);
            $obj_Cuestionario->eliminarPROP($id);

            //Eliminar Opciones si es de tipo opción multiple
            if ($tipo == 'Opción múltiple'){
                
                foreach($arr_Opciones as $opcion){
                    $obj_Opcion->eliminarOpcion($opcion["prop_id_opcion"]);
                }
            }

            //Eliminar PREGUNTA
            $obj_Pregunta->eliminarPregunta($id);

            exit("1");
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
            $orden = 'null';
            $obj_Pregunta->actualizarActivoPregunta($id, $Activo, $orden);

            // Selecciona las preguntas activas
            $arr_Preguntas = $obj_Pregunta->buscarPreguntasActivas();
            // Se pasa el arreglo y se actualiza su orden
            $x = 1;
            foreach($arr_Preguntas as $pregunta){
                $obj_Pregunta->actualizarOrdenPregunta($pregunta['preg_id_pregunta'], $x);
                $x++;
            }
        }
        //Si el estado es f
        elseif($Activo == 'f')
        {
            $Activo = 'TRUE';
            $ultimo = $obj_Pregunta->buscarUltimoOrden();
            $orden = $ultimo->ultimo + 1;
            $obj_Pregunta->actualizarActivoPregunta($id, $Activo, $orden);
        }

        exit("1");
    } 
    elseif (isset($_POST['update'])) 
    {
        foreach($_POST['positions'] as $position) {
            $index = $position[0];
            $newPosition = $position[1];
            $result = $obj_Pregunta->actualizarOrdenPregunta($index, $newPosition);
        }
        
        exit('1');
    }
    else
    {
        exit("0");
    }
?>