<?php
  include('../clases/BD.php');
  include('../clases/Grupo.php');
  include('../clases/Sesion.php');
  include('../clases/Curso.php');
  include('../clases/Inscripcion.php');
  include('../clases/Profesor.php');
  include('../clases/Calendario.php');
  include('../clases/Festivo.php');
  include('../clases/Personal_Grupo.php');
  include('../clases/Busqueda.php');

  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();
  $obj_Inscripcion = new Inscripcion();
  $obj_Profesor = new Profesor();
  $obj_personal_grupo = new Personal_Grupo();
  $obj_Busqueda = new Busqueda();

  if($_POST['dml'] == 'insert')
  {
    //Se inicializan las variables con los datos enviados por POST
    $curso = $_POST['ID_Curso'];
    $tipo = $_POST['GrupoTipo'];
    $estado = $_POST['GrupoEstatus'];
    $profesor = $_POST['ID_Profesor'];
    $cupo = $_POST['GrupoCupo'];
    $inicio_insc = $_POST['GrupoInicioInscripcion'];
    $fin_insc = $_POST['GrupoFinInscripcion'];
    $modalidad = $_POST['GrupoModalidad'];
    
    //? Puede que un grupo no tenga moderador
    if (!isset($_POST['ID_Moderador']) || $_POST['ID_Moderador'] == '' || $_POST['ID_Moderador'] == 0) {       
      $moderador = 'null';
    } else {
      $moderador = $_POST['ID_Moderador'];
    }
    
    //? Esto es por que si esta desactivado no manda nada
    if (isset($_POST['ID_Status'])) { 
      //? No se puede publicar un curso con estado Cancelado o Finalizado
      if ($estado == 1 || $estado == 4){
        exit('2');
      }
      $publicado = $_POST['ID_Status'];
    } else {
      $publicado = 'false';
    }
    
    //? Se crea un arreglo de sesiones
    $numSesionesTotales= (integer) $_POST['numSesiones'];
    $sesion = array();
    $hora_inicio = array();
    $hora_fin = array();

    //Se crean las variables que contienen los dias festivos, asueto y vacaciones administrativas
    $obj_dias_festivos = new Festivo();
    $obj_calendario = new Calendario();
    $arr_dias_festivos = $obj_dias_festivos->buscarDiasFestivosActivos();//Busca los dias festivos
    $asueto = $obj_calendario->consultarAsueto();//Busca el periodo de asueto academico
    $vacaciones_Administrativas = $obj_calendario->consultarVacacionesAdministrativas();//Busca el periodo de vacaciones administrativas

    //Se recorre el arreglo de sesiones para asignarles y validar cada una
    for ($iCont = 1 ; $iCont <= $numSesionesTotales ; $iCont++) {
      $sesion[$iCont] = $_POST['SesionFecha'.$iCont];
      $hora_inicio[$iCont] = $_POST['SesionHoraInicio'.$iCont];
      $hora_fin[$iCont] = $_POST['SesionHoraFin'.$iCont];
      
      //Aqui se validan primero los dias festivos
      if(isset($arr_dias_festivos) || $arr_dias_festivos != ''){ 
        foreach ($arr_dias_festivos as $dia_festivo){
          //Compara la fecha de la sesión con el dia festivo y si es igual no permite registrar el grupo
          if($dia_festivo['dife_fecha'] == $sesion[$iCont]){
            exit('3');
          }
        }
      }

      //Aqui se valida que la fecha de la sesión no se encuentre dentro del periodo de vacaciones administrativas
      if(isset($vacaciones_Administrativas) || $vacaciones_Administrativas != ''){
        //Compara la fecha de la sesión con las vacaciones administrativas y si se encuentra contenido en el periodo no permite registrar el grupo
        if($sesion[$iCont] >= $vacaciones_Administrativas->cale_inicio_admin && $sesion[$iCont] <= $vacaciones_Administrativas->cale_fin_admin){
          exit('4');
        }
      }

      //Aqui se verifica que la fecha de la sesion no se encuentre dentro del periodo de asueto
      if(isset($asueto) || $asueto != ''){
        //Compara la fecha de la sesión con el asueto y si se encuentra contenido en el asueto no permite registrar el grupo
        if($sesion[$iCont] >= $asueto->cale_inicio_asueto && $sesion[$iCont] <= $asueto->cale_fin_asueto){
          exit('5');
        }
      }
    }
    
    //? Se verifica la modalidad y se asignan las variables nulas dependiendo la modalidad
    if(isset($modalidad) && $modalidad == 1){
      $salon = $_POST['ID_Salon'];
      $plataforma = 'NULL';
      $url = 'NULL';
      $acceso = 'NULL';
      $clave = 'NULL';
    } elseif (isset($modalidad) && $modalidad == 2){
      $salon = 'NULL';
      $plataforma = $_POST['ID_Plataforma'];
      $url = $_POST['URL_Acceso'];
      $acceso = $_POST['ID_Reunion'];
      $clave = $_POST['Clave_Acceso'];
    } elseif (isset($modalidad) && $modalidad == 3){
      $salon = 'NULL';
      $plataforma = 'NULL';
      $url = $_POST['URL_Plataforma'];
      $acceso = 'NULL';
      $clave = 'NULL';
    }

    //Se agrega el registro del grupo
    $obj_Grupo->agregarGrupo($curso, $salon, $plataforma, $url, $acceso, $clave, $cupo, $estado, $publicado,
                            $modalidad, $tipo, $inicio_insc, $fin_insc);
                              
    //Se busca el id del ultimo registro
    $id_grupo = $obj_Grupo->buscarUltimo();

    //Se recorre el arreglo de sesiones, hora inicio y hora fin
    for ($iCont = 1 ; $iCont <= $numSesionesTotales ; $iCont++) {
      //Se agregan las sesiones del grupo
      $obj_Sesion -> agregarSesion($id_grupo, $sesion[$iCont], $hora_inicio[$iCont], $hora_fin[$iCont]);
    }

    //Se agrega al maestro siempre y al moderador en caso de existir.
    $obj_personal_grupo->agregarPersonal($id_grupo, $profesor);
    //Aqui se comprueba si el moderador existe y lo agrega o no
    if($moderador != 'null'){
      $obj_personal_grupo->agregarPersonal($id_grupo, $moderador);
    }
    exit('1');
  }


  elseif($_POST['dml'] == 'update')
  {
    //Se inicializan las variables con los datos enviados por POST
    $grupo = $_POST['idGrupo'];
    $tipo_grupo = $_POST['GrupoTipo'];
    $modalidad = $_POST['ifModalidad'];
    $estado = $_POST['GrupoEstatus'];
    $profesor = $_POST['ID_Profesor'];
    $cupo = $_POST['GrupoCupo'];
    $inicio_insc = $_POST['GrupoInicioInscripcion'];
    $fin_insc = $_POST['GrupoFinInscripcion'];
    
    //? Puede que un grupo no tenga moderador
    if (!isset($_POST['ID_Moderador']) || $_POST['ID_Moderador'] == '' || $_POST['ID_Moderador'] == 0) {
      $moderador = 'null';
    } else {
      $moderador = $_POST['ID_Moderador'];
    }

    // Se verifica la modalidad y se asignan las variables nulas dependiendo la modalidad
    if ($modalidad == 2){
      $salon = 'NULL';
      $plataforma = $_POST['ID_Plataforma'];
      $url = $_POST['URL_Acceso'];
      $acceso = $_POST['ID_Reunion'];
      $clave = $_POST['Clave_Acceso'];
    } elseif ($modalidad == 1) {
      $salon = $_POST['ID_Salon'];
      $plataforma = 'NULL';
      $url = 'NULL';
      $acceso = 'NULL';
      $clave = 'NULL';
    } else {
      $salon = 'NULL';
      $plataforma = 'NULL';
      $url = $_POST['URL_Plataforma'];
      $acceso = 'NULL';
      $clave = 'NULL';
    }

    //Se actualiza el grupo
    $obj_Grupo->actualizarGrupo($grupo, $tipo_grupo, $estado, $cupo, $inicio_insc, $fin_insc, $salon, $plataforma, $url, $acceso, $clave);
    

    //Se inicializan los arreglos de id sesiones, fecha, hora de inicio y hora fin.
    $arr_idSesiones = $_POST['idSesion'];
    $arr_FechasSesiones = $_POST['SesionFecha'];
    $arr_HorasSesionesI = $_POST['SesionHoraInicio'];
    $arr_HorasSesionesF = $_POST['SesionHoraFin'];

    //Se recorren los arreglos de id sesiones, fecha, hora de inicio y hora fin.
    for ($i=0;$i<sizeof($arr_FechasSesiones);$i++) {
      $sesion=$arr_idSesiones[$i];
      $fecha_sesion = $arr_FechasSesiones[$i];
      $hora_inicio = $arr_HorasSesionesI[$i];
      $hora_fin = $arr_HorasSesionesF[$i];
      //Se actualiza la sesión
      $obj_Sesion -> actualizarSesion($sesion, $grupo, $fecha_sesion, $hora_inicio,$hora_fin);
    }

    //Se actualiza el personal del grupo
    $obj_personal_grupo->actualizarInstructor($grupo, $profesor);
    //? Se verifica que tiene el moderador porque de eso depende si se actualizará o agregara.
    $moderador_anterior = $obj_personal_grupo->buscarModerador($grupo);

    if (isset($moderador_anterior->usr_moderador)){
      if($moderador == 'null'){
        $obj_personal_grupo->quitarPersonal($grupo, $moderador_anterior->usr_moderador);      
      } else {
        $obj_personal_grupo->actualizarModerador($grupo, $moderador);
      }
    } else {
      if ($moderador != 'null'){
        $obj_personal_grupo->agregarPersonal($grupo, $moderador);
      }
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
        exit('2');
      } */

      if (!isset($grupoActual->usr_instructor) ) {
        exit('3');
      } else if ($grupoActual->esta_id_estado == 4){
        exit('4');
      }
      $estatus = 'TRUE';
      $obj_Grupo->cambiarEstatus($grupo, $estatus);
    }
    exit('1');
  }

  if ($_POST['dml'] == 'sesiones'){
    $idCurso = $_POST['idCurso'];

    $obj_Curso = new Curso ();
    $sesiones = $obj_Curso->buscarNumSesiones($idCurso);

    if (isset($sesiones->curs_num_sesiones)){
      echo $sesiones->curs_num_sesiones;
    } else {
      echo 0;
    }
  } 

  if ($_POST['dml'] == 'inscripcion') {
    $persona = $_POST['persona'];
    $grupo = $obj_Grupo->buscarGrupo($_POST['grupo']);
    $profesor = $obj_Profesor->buscarProfesor($persona);

    //Esta variable guarda los cursos y cantidad de veces que se ha inscrito a ellos
    $cursos_inscritos = $obj_Busqueda->selectVecesInscritoCurso($profesor->prof_id_profesor);
    
    if(isset($cursos_inscritos)){
      /* SI se encuentran cursos incritos, para cada uno se compara si es el mismo id que el del curso del nuevo grupo
       y en caso de ya haberse inscrito 2 veces no se le permite inscribirse de nuevo como fue solicitado*/
      foreach ($cursos_inscritos as $curso_inscrito){
        if ($curso_inscrito['curs_id_curso'] == $grupo->curs_id_curso && $curso_inscrito['veces_inscrito'] == 2){
          exit('6');
        }
      }
    }

    //Guarda la cantidad de grupos que ha inscrito un profesor en un semestre
    $cantidad_grupos_inscritos = $obj_Busqueda->selectCantidadGruposInscritos($profesor->prof_id_profesor);
    if(isset($cantidad_grupos_inscritos)){
      /*Compara si la cantidad de grupos inscritos por el profesor en el semestre ya son 10 y de ser así
      se ha llegado a los máximos que puede inscribir por semestre por lo que ya no le permite inscribirse
      */
      if($cantidad_grupos_inscritos->cantidad_grupos == 5/*10*/){
        exit('7');
      }
    }

    $inscrito =  $obj_Inscripcion->buscarInscripcion($grupo->grup_id_grupo, $profesor->prof_id_profesor);

    if  (isset($inscrito) && $inscrito != '') {
      exit('2');
    } else {
      $grupos_profesor = $obj_Grupo->gruposInscritosActivosxProfesor($profesor->prof_id_profesor);
      //? En caso de que el profesor no tenga ningún grupo inscrito, en automatico debe inscribir ya que no hay
      //? translape ni nada que validar
      if (!isset($grupos_profesor) || $grupos_profesor == ''){
        $obj_Inscripcion->agregarInscripcion($grupo->grup_id_grupo, $profesor->prof_id_profesor);
        exit('1');
      }
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
            exit('1');
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
                  exit('1');
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
                exit('1');
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
                    exit('1');
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
                          exit('3');
                      }
                    }
                  }
                }
                /*Ahora si termino las validaciones y no hay traslape, solo si se ha terminado de reccorrer la lista de grupos inscritos del profesor se permite inscribir*/
                if($contador_grupo == $cantidad_grupos_profesor){
                  //? Esto lo permite inscribir
                  $obj_Inscripcion->agregarInscripcion($grupo->grup_id_grupo, $profesor->prof_id_profesor);
                  exit('1');
                }
              }
            }
            
          }
        }
      }
      //? Dejar inscribir en este punto que termina el for each en caso de haber pasado todas las valoraciones de todos los grupos en caso de no funcionar el otro
    }
  }
  //? Prueba para hacer las comparaciones
    /*$file = fopen('Mensajes.txt', 'a');
      fwrite($file, $grupo->grup_id_grupo.PHP_EOL);
      fwrite($file, count($grupos_profesor).PHP_EOL);
      fwrite($file, $inscrito.PHP_EOL);
      fclose($file);*/
?>