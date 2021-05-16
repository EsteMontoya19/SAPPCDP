<?php
  include('../clases/BD.php');
  include('../clases/Grupo.php');
  include('../clases/Sesion.php');
  include('../clases/Curso.php');

  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();

  if($_POST['dml'] == 'insert')
  {
    
    $curso = $_POST['ID_Curso'];
    $tipo = $_POST['GrupoTipo'];
    $estado = $_POST['GrupoEstatus'];
    $profesor = $_POST['ID_Profesor'];
    $moderador = $_POST['ID_Moderador'];
    $cupo = $_POST['GrupoCupo'];
    $inicio_insc = $_POST['GrupoInicioInscripcion'];
    $fin_insc = $_POST['GrupoFinInscripcion'];
    $modalidad = $_POST['GrupoModalidad'];
    
    //? Esto es por que si esta desactivado no manda nada
    if (isset($_POST['ID_Status'])) {       
      $publicado = $_POST['ID_Status'];
    } else {
      $publicado = "false";
    }
    
    //? Se crea un arreglo de sesiones
    $numSesionesTotales= (integer) $_POST['numSesiones'];
    $sesion = array();
    $horas = array();
    for ($iCont = 1 ; $iCont <= $numSesionesTotales ; $iCont++) {
      $sesion[$iCont] = $_POST['SesionFecha'.$iCont];
      $horas[$iCont] = $_POST['SesionHora'.$iCont];
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
      $obj_Sesion -> agregarSesion($id_grupo, $sesion[$iCont], $horas[$iCont]);
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
    $moderador = $_POST['ID_Moderador'];

    $cupo = $_POST['GrupoCupo'];
    $inicio_insc = $_POST['GrupoInicioInscripcion'];
    $fin_insc = $_POST['GrupoFinInscripcion'];

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
    $arr_HorasSesiones = $_POST['SesionHora'];

    for ($i=0;$i<sizeof($arr_FechasSesiones);$i++) {
      $sesion=$arr_idSesiones[$i];
      $fecha_sesion = $arr_FechasSesiones[$i];
      $hora_sesion = $arr_HorasSesiones[$i];
      
      $obj_Sesion -> actualizarSesion($sesion, $grupo, $fecha_sesion, $hora_sesion);
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

      if (!isset($grupoActual->mode_id_moderador) ){
        exit("2");
      } else if (!isset($grupoActual->prof_id_profesor) ) {
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
?>
