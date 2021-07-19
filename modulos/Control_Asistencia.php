<?php
  include('../clases/BD.php');
  include('../clases/Asistencia.php');
  include('../clases/Grupo.php');
  include('../clases/Inscripcion.php');
  include('../clases/Sesion.php');

  include('../clases/Profesor.php');
  include('../clases/Calendario.php');
  include('../clases/Festivo.php');
  include('../clases/Personal_Grupo.php');
  include('../clases/Busqueda.php');

  //? Objetos necesarios
  $obj_Asistencias = new Asistencia();
  $obj_Inscripcion = new Inscripcion();
  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();


//? Todo el codigo para registrar asistencias

  
  //? Verificamos si el grupo ya tiene registros de asistencia creados
  $asistencias = $obj_Asistencias->buscarAsistenciasGrupo($_POST['idGrupo']);
  $sesiones = $obj_Sesion->buscarSesionesIDGrupo($_POST['idGrupo']);

  if(!isset($asistencias) || count($asistencias) == 0) {
    $inscritos = $obj_Grupo->buscarCorreosDeParticipantes($_POST['idGrupo']);

    //? Si no hay inscritos salimos ya de la función
    if (!isset($inscritos) || count($inscritos) == 0) {
      exit("2");
    } else {
      //? recorremos a los inscritos
      foreach ($inscritos as $iCont => $inscrito) {
        //? Obtenemos los datos de la inscripción
        $inscripcion = $obj_Inscripcion->buscarInscripcion($_POST['idGrupo'] , $inscrito['prof_id_profesor']);
        $checkbox = $inscripcion->insc_id_inscripcion . "_asistencia_" . ($iCont + 1);

        //? Creamos asistencia para cada sesion
        foreach ($sesiones as $jCont => $sesion) {
          $obj_Asistencias->agregarAsistencia($sesion['sesi_id_sesiones'], $inscripcion->insc_id_inscripcion, isset($_POST[$checkbox]) ? $_POST[$checkbox] : null);
        }

        exit("1");
      }
    }
  }
?>