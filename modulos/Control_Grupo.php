<?php

  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');

  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();

  if($_POST['dml'] == 'insert')
  {
    //Obtiene la modalidad del grupo
    $modalidad = $_POST['GrupoModalidad'];
    
    if(!isset($modalidad == 'En línea')) {

      $moderador = $_POST[''];
      $profesor = $_POST[''];
      $curso = $_POST[''];
      $plataforma = $_POST[''];
      $calendario = $_POST[''];
      $reunion = $_POST[''];
      $acceso = $_POST[''];
      $clave = $_POST[''];
      $cupo = $_POST[''];
      $estado = $_POST[''];
      $activo = $_POST[''];
      $modalidad = $_POST[''];
      $tipo_grupo = $_POST[''];
      $inicio_insc = $_POST[''];
      $fin_insc = $_POST[''];

      $obj_Grupo->agregarGrupoWebinar($moderador, $profesor, $curso, $plataforma, $calendario, $reunion, $acceso, $clave, $cupo, $estado, $activo, $modalidad, $tipo_grupo, $inicio_insc, $fin_insc);
      $id_grupo = $obj_Grupo->buscarIDGrupo($moderador, $profesor, $curso, $plataforma, $calendario, $reunion, $acceso, $clave, $cupo, $estado, $activo, $modalidad, $tipo_grupo, $inicio_insc, $fin_insc);

      foreach ($arr_Sesiones as $valor) {
        $id_grupo = $_POST[''];
        $fecha_sesion = $_POST[''];
        $hora_sesion = $_POST[''];

        $obj_Sesion -> agregarSesion($id_grupo, $fecha_sesion, $hora_sesion);
      }
      
      echo 1;
    } elseif($modalidad == 'Presencial') {

      $moderador = $_POST[''];
      $profesor = $_POST[''];
      $curso = $_POST[''];
      $salon = $_POST[''];
      $calendario = $_POST[''];
      $cupo = $_POST[''];
      $estado = $_POST[''];
      $activo = $_POST[''];
      $modalidad = $_POST[''];
      $tipo_grupo = $_POST[''];
      $inicio_insc = $_POST[''];
      $fin_insc = $_POST[''];

      $obj_Grupo->agregarGrupo($moderador, $profesor, $curso, $salon, $calendario, $cupo, $estado, $activo, $modalidad, $tipo_grupo, $inicio_insc, $fin_insc);
      $id_grupo = $obj_Grupo->buscarIDGrupo($moderador, $profesor, $curso, $salon, $calendario, $cupo, $estado, $activo, $modalidad, $tipo_grupo, $inicio_insc, $fin_insc)
        
      foreach ($arr_Sesiones as $clave -> $valor) {
        $id_grupo = $_POST[''];
        $fecha_sesion = $_POST[''];
        $hora_sesion = $_POST[''];

        $obj_Sesion -> agregarSesion($id_grupo, $fecha_sesion, $hora_sesion);
      }

      echo 1;

    } else {

      echo 2;
    }
      
  }
  elseif($_POST['dml'] == 'update')
  {

    $IDGrupo = $_POST[''];
    $grupo_existente = $obj_Grupo->buscarIDGrupo($IDGrupo);

    if(!isset($grupo_existente->_VARIABLEIDGRUPO_) & $modalidad == 'En línea') {



      echo 1;
    } elseif($grupo_existente->_VARIABLEIDGRUPO_) & $modalidad == 'Presencial'){



      echo 1;

    } else {
      echo 2;
    }
  
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
  elseif($_POST['dml'] == 'cambio')
  {
    // Aqui hay que cambiar por que si ya tiene historicos no se puede eliminar pero si dar de baja
    // en el campo grup_activo que es booleano.
    $usuario = $_POST['id'];
    $estatus = $_POST['estatus'];

    if ($estatus == 't')
    {
      $estatus = 'FALSE';
      $obj_Usuario->modificarEstatus($usuario,$estatus);
    }
    elseif($estatus == 'f')
    {
      $estatus = 'TRUE';
      $obj_Usuario->modificarEstatus($usuario, $estatus);
    }

    echo 1;
  }
?>
