<?php
  include('../clases/BD.php');
  include('../clases/Grupo.php');
  include('../clases/Sesion.php');
  include('../clases/Curso.php');
  include('../clases/Inscripcion.php');
  include('../clases/Profesor.php');

  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Inscripcion = new Inscripcion();
  $obj_Profesor = new Profesor();

  if($_POST['dml'] == 'insert')
  {
    
    $curso = $_POST['ID_Curso'];
    $tipo = $_POST['GrupoTipo'];
    $estado = $_POST['GrupoEstatus'];
    $profesor = $_POST['ID_Profesor'];
    $cupo = $_POST['GrupoCupo'];
    $inicio_insc = $_POST['GrupoInicioInscripcion'];
    $fin_insc = $_POST['GrupoFinInscripcion'];
    $modalidad = $_POST['GrupoModalidad'];
    
    //? Puede que un grupo no tenga moderador
    if (!isset($_POST['ID_Moderador']) || $_POST['ID_Moderador'] == "" || $_POST['ID_Moderador'] == 0) {       
      $moderador = "null";
    } else {
      $moderador = $_POST['ID_Moderador'];
    }
    
    //? Esto es por que si esta desactivado no manda nada
    if (isset($_POST['ID_Status'])) { 
      //? No se puede publicar un curso sin aprobar
      if ($estado != "Aprobado"){
        exit("2");
      }
      $publicado = $_POST['ID_Status'];
    } else {
      $publicado = "false";
    }
    
    //? Se crea un arreglo de sesiones
    $numSesionesTotales= (integer) $_POST['numSesiones'];
    $sesion = array();
    $hora_inicio = array();
    $hora_fin = array();
    for ($iCont = 1 ; $iCont <= $numSesionesTotales ; $iCont++) {
      $sesion[$iCont] = $_POST['SesionFecha'.$iCont];
      $hora_inicio[$iCont] = $_POST['SesionHoraInicio'.$iCont];
      $hora_fin[$iCont] = $_POST['SesionHoraFin'.$iCont];
    }
    
    //? Se verifica la modalidad
    if(isset($modalidad) && $modalidad == "Presencial"){
      $salon = $_POST['ID_Salon']; 
      $plataforma = "null";
      $acceso = "null";
      $reunion = "null";
      $clave = "null";
    } else if (isset($modalidad) && $modalidad == "En línea"){
      $plataforma = $_POST['ID_Plataforma'];
      $acceso = $_POST['URL_Acceso'];
      $reunion = $_POST['ID_Reunion'];
      $clave = $_POST['Clave_Acceso'];
      $salon = "null";
    } else {
      exit('2');
    }

    
    $obj_Grupo->agregarGrupo($moderador, $profesor, $curso, $salon, $plataforma, $reunion, $acceso, $clave, $cupo, $estado, $publicado,
                              $modalidad, $tipo, $inicio_insc, $fin_insc);
                              
    $id_grupo = $obj_Grupo->buscarUltimo();

    for ($iCont = 1 ; $iCont <= $numSesionesTotales ; $iCont++) {
      $obj_Sesion -> agregarSesion($id_grupo, $sesion[$iCont], $hora_inicio[$iCont], $hora_fin[$iCont]);
    }

    exit('1');
  }


  elseif($_POST['dml'] == 'update')
  {

    $grupo = $_POST['idGrupo'];

    $tipo_grupo = $_POST['GrupoTipo'];
    $modalidad = $_POST['ifModalidad'];
    $estado = $_POST['GrupoEstatus'];
    $profesor = $_POST['ID_Profesor'];
    $cupo = $_POST['GrupoCupo'];
    $inicio_insc = $_POST['GrupoInicioInscripcion'];
    $fin_insc = $_POST['GrupoFinInscripcion'];
    
    //? Puede que un grupo no tenga moderador
    if (!isset($_POST['ID_Moderador']) || $_POST['ID_Moderador'] == "" || $_POST['ID_Moderador'] == 0) {       
      $moderador = "null";
    } else {
      $moderador = $_POST['ID_Moderador'];
    }

    if ($modalidad == 'En línea'){
      $salon = 'NULL';
      $plataforma = $_POST['ID_Plataforma'];
      $reunion = $_POST['ID_Reunion'];
      $acceso = $_POST['URL_Acceso'];
      $clave = $_POST['Clave_Acceso'];
    } else {
      $salon = $_POST['ID_Salon'];
      $plataforma = 'NULL';
      $reunion = 'NULL';
      $acceso = 'NULL';
      $clave = 'NULL';
    }

    $obj_Grupo->actualizarGrupo($grupo, $tipo_grupo, $estado, $profesor, $moderador, $cupo, $inicio_insc, $fin_insc, $salon, $plataforma, $reunion, $acceso, $clave);

    $arr_idSesiones = $_POST['idSesion'];
    $arr_FechasSesiones = $_POST['SesionFecha'];
    $arr_HorasSesionesI = $_POST['SesionHoraInicio'];
    $arr_HorasSesionesF = $_POST['SesionHoraFin'];

    for ($i=0;$i<sizeof($arr_FechasSesiones);$i++) {
      $sesion=$arr_idSesiones[$i];
      $fecha_sesion = $arr_FechasSesiones[$i];
      $hora_inicio = $arr_HorasSesionesI[$i];
      $hora_fin = $arr_HorasSesionesF[$i];
      
      $obj_Sesion -> actualizarSesion($sesion, $grupo, $fecha_sesion, $hora_inicio,$hora_fin);
    }

    echo 1;
  }
  elseif($_POST['dml'] == 'delete')
  {
    $IDGrupo = $_POST['id'];

    //Buscar que no tenga inscripciones 
    //$obj_Grupo->buscarInscripciones($IDGrupo);
    //verificar si hay inscripciones
    //Si no tiene inscripciones, buscar las sesiones y eliminarlas

    $obj_Sesion->eliminarSesiones($IDGrupo);
    $obj_Grupo->eliminarGrupo($IDGrupo);

    echo 1;

  }
  elseif($_POST['dml'] == 'actualizarEstatus'){
    $grupo = $_POST['id'];
    $estatus = $_POST['estatus'];

    
    if ($estatus == 't'){
      $estatus = 'FALSE'; 
      $obj_Grupo->cambiarEstatus($grupo, $estatus);
    } elseif ($estatus == 'f') {
      
      $grupoActual = $obj_Grupo->buscarSoloGrupo($grupo);

      /* //! Validación comentada ya que por ahora se uede registrar un curso sin moderador por falta de personal
      if (!isset($grupoActual->mode_id_moderador) ){
        exit("2");
      } */

      if (!isset($grupoActual->prof_id_profesor) ) {
        exit("3");
      } else if ($grupoActual->grup_estado != "Aprobado"){
        exit("4");
      }
      $estatus = 'TRUE';
      $obj_Grupo->cambiarEstatus($grupo, $estatus);
    }
    exit("1");
  }

  if ($_POST['dml'] == 'sesiones'){
    $idCurso = $_POST['idCurso'];

    $obj_Curso = new Curso ();
    $sesiones = $obj_Curso->buscarNumSesiones($idCurso);

    echo $sesiones->curs_num_sesiones;

  } 

  if ($_POST['dml'] == 'inscripcion') {
    $persona = $_POST['persona'];
    $grupo = $obj_Grupo->buscarGrupo($_POST['grupo']);
    $profesor = $obj_Profesor->buscarProfesor($persona);
    $inscrito =  $obj_Inscripcion->buscarInscripcion($grupo->grup_id_grupo, $profesor->prof_id_profesor);

    //? Prueba para hacer las comparaciones
    /*$file = fopen("Mensajes.txt", "a");
      fwrite($file, $grupo->grup_id_grupo.PHP_EOL);
      fwrite($file, count($grupos_profesor).PHP_EOL);
      fwrite($file, $inscrito.PHP_EOL);
      fclose($file);*/

    if  (isset($inscrito) && $inscrito != "") {
      exit("2");
    } else {
      $grupos_profesor = $obj_Grupo->gruposInscritosActivosxProfesor($profesor->prof_id_profesor);
      //Obtiene todas las sesiones del grupo al que se desea inscribir
      $sesiones_nuevo = $obj_Sesion->buscarSesionesIDGrupo($grupo->grup_id_grupo);
      $cantidad_grupos_profesor = sizeof($grupos_profesor);
      $contador_grupo = 0;

      foreach ($grupos_profesor as $grupo_inscrito){
        $contador_grupo += 1;

        //Obtiene todas las sesiones del $grupo_inscrito, que es uno de los grupos a los que actualmente esta inscrito
        $obj_Sesion2 = new Sesion();
        $sesiones_inscritas = $obj_Sesion2->buscarSesionesIDGrupo($grupo_inscrito['grup_id_grupo']);
        
        //Se crean variables primera sesion y ultima sesion para poder realizar las comparaciones pertinentes
        $ultima_sesion_inscritas = count($sesiones_inscritas) - 1;
        $ultima_sesion_nuevo = count($sesiones_nuevo) - 1;
        $primera_sesion = 0;

        /*si el grupo inscrito en su última sesion < grupo a inscribir en su primera sesion
        no hay traslape porque todas las sesiones del grupo inscrito terminan antes de que comiencen las del grupo a inscribir*/
        if($sesiones_inscritas[$ultima_sesion_inscritas]['sesi_fecha'] < $sesiones_nuevo[$primera_sesion]['sesi_fecha']){
          /*solo si se ha terminado de reccorrer la lista de grupos inscritos del profesor se permite inscribir*/
          if($contador_grupo == $cantidad_grupos_profesor){
            //? Esto lo inscribe
             $obj_Inscripcion->agregarInscripcion($grupo->grup_id_grupo, $profesor->prof_id_profesor);
             exit("1");
          }
        } else {
          /*Si el grupo inscrito en su ultima sesión == grupo a inscribir en su primera sesion
          Puede haber traslape si las horas son las mismas*/
          if($sesiones_inscritas[$ultima_sesion_inscritas]['sesi_fecha'] == $sesiones_nuevo[$primera_sesion]['sesi_fecha']){
            /*Si la sesion inscrita en hora fin es menor o igual a la nueva en su hora de inicio o 
            Si la sesion inscrita en su hora de inicio era mayor o igual a la nueva en su hora de fin, no hay traslape,
            se deberá verificar en este caso que es el ultimo grupo de la lista de grupos inscritos que tiene el profesor para que permita inscribirlo*/
            if($sesiones_inscritas[$ultima_sesion_inscritas]['sesi_hora_fin'] <= $sesiones_nuevo[$primera_sesion]['sesi_hora_inicio'] || 
              $sesiones_inscritas[$ultima_sesion_inscritas]['sesi_hora_inicio'] >= $sesiones_nuevo[$primera_sesion]['sesi_hora_fin']){
                if($contador_grupo == $cantidad_grupos_profesor){
                  //? Esto Lo inscribe
                  $obj_Inscripcion->agregarInscripcion($grupo->grup_id_grupo, $profesor->prof_id_profesor);
                  exit("1");
                }
            } else {
              exit('3');
            }
          } else {  
        
            /*si grupo inscrito en primera sesion > grupo a inscribir en ultima sesión 
            no hay traslape porque el grupo a inscribir tiene todas sus sesiones antes que el grupo inscrito*/
            if ($sesiones_inscritas[$primera_sesion]['sesi_fecha'] > $sesiones_nuevo[$ultima_sesion_nuevo]['sesi_fecha']){
              if($contador_grupo == $cantidad_grupos_profesor){
                //? Esto lo inscribe
                $obj_Inscripcion->agregarInscripcion($grupo->grup_id_grupo, $profesor->prof_id_profesor);
                exit("1");
              }
            } else {
              /*Si el grupo inscrito en su primera sesión es = al nuevo en su ultima sesión, solo se verifica que no haya traslape en las horas*/
              if($sesiones_inscritas[$primera_sesion]['sesi_fecha'] == $sesiones_nuevo[$ultima_sesion_nuevo]['sesi_fecha']){
                /*Si la sesion inscrita en hora fin es menor o igual a la nueva en su hora de inicio o 
                Si la sesion inscrita en su hora de inicio era mayor o igual a la nueva en su hora de fin, no hay traslape,
                se deberá verificar en este caso que es el ultimo grupo de la lista de grupos inscritos que tiene el profesor para que permita inscribirlo*/
                if($sesiones_inscritas[$primera_sesion]['sesi_hora_fin'] <= $sesiones_nuevo[$ultima_sesion_nuevo]['sesi_hora_inicio'] || 
                $sesiones_inscritas[$primera_sesion]['sesi_hora_inicio'] >= $sesiones_nuevo[$ultima_sesion_nuevo]['sesi_hora_fin']){
                  if($contador_grupo == $cantidad_grupos_profesor){
                    //?
                    $obj_Inscripcion->agregarInscripcion($grupo->grup_id_grupo, $profesor->prof_id_profesor);
                    exit("1");
                  }
                } else {
                  exit('3');
                }
                
              } else {
                
                //Se tienen que comparar todas las sesiones porque puede existir traslape
                foreach ($sesiones_nuevo as $sesion_grupo_nuevo){
                  foreach($sesiones_inscritas as $sesion_grupo_inscrito){
                    if ($sesion_grupo_nuevo['sesi_fecha'] == $sesion_grupo_inscrito['sesi_fecha']) {
                      /*Si la sesion inscrita en hora fin es menor o igual a la nueva en su hora de inicio o  
                      Si la sesion inscrita en su hora de inicio era mayor o igual a la nueva en su hora de fin, no hay traslape,
                      no se pone nada dentro de ese if porque debe validar todas las sesiones, para que en caso de ser correcto en la primera no lo inscriba inmediatamente*/
                      if($sesion_grupo_inscrito['sesi_hora_fin'] <= $sesion_grupo_nuevo['sesi_hora_inicio'] || 
                      $sesion_grupo_inscrito['sesi_hora_inicio'] >= $sesion_grupo_nuevo['sesi_hora_fin']){
                      } else {  
                          exit("3");
                      }
                    }
                  }
                }
                /*Ahora si termino las validaciones y no hay traslape, solo si se ha terminado de reccorrer la lista de grupos inscritos del profesor se permite inscribir*/
                if($contador_grupo == $cantidad_grupos_profesor){
                  //? Esto lo permite inscribir
                  $obj_Inscripcion->agregarInscripcion($grupo->grup_id_grupo, $profesor->prof_id_profesor);
                  exit("1");
                }
              }
            }
            
          }
        }
      }
      //? Dejar inscribir en este punto que termina el for each en caso de haber pasado todas las valoraciones de todos los grupos en caso de no funcionar el otro.

    }
  }
?>