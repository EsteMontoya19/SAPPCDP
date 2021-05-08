<?php

  include('../../clases/BD.php');
  include('../../clases/Grupo.php');
  include('../../clases/Sesion.php');

  $obj_Grupo = new Grupo();
  $obj_Sesion = new Sesion();

  if($_POST['dml'] == 'insert')
  {
    $curso = $_POST['ID_Curso'];
    $tipo_grupo = $_POST['GrupoTipo'];
    $modalidad = $_POST['GrupoModalidad'];
    $estado = $_POST['GrupoEstatus'];
    $profesor = $_POST['ID_Profesor'];
    $moderador = $_POST['ID_Moderador'];
    $cupo = $_POST['GrupoCupo'];
    $inicio_insc = $_POST['GrupoInicioInscripcion'];
    $fin_insc = $_POST['GrupoFinInscripcion'];

    $plataforma = $_POST['ID_Plataforma'];
    $calendario = $_POST['']; //TODO Hace falta pasar el id del calendario
    $reunion = $_POST['ID_Reunion'];
    $acceso = $_POST['URL_Acceso'];
    $clave = $_POST['Clave_Acceso'];
    $salon = $_POST['ID_Salon']; 
    
    $activo = $_POST['']; //TODO Hace falta El campo activo...?

    $obj_Grupo->agregarGrupo($moderador, $profesor, $curso, $salon, $plataforma, $calendario, $reunion, $acceso, $clave, $cupo, $estado, $activo,
    $modalidad, $tipo_grupo, $inicio_insc, $fin_insc);
    //TODO Hace falta completar el metodo en la clase
    $id_grupo_ultimo = $obj_Grupo->buscarUltimo();

    //TODO Buscar que funcione traer un arreglo e insertarlo en la BD
    foreach ($arr_Sesiones as $valor) {
      $id_grupo = $id_grupo_ultimo; //TODO Hace Falta buscar el ID Ultimo para enviar al registro de sesiones
      $fecha_sesion = $_POST['SesionFecha'];
      $hora_sesion = $_POST['SesionHora'];

      $obj_Sesion -> agregarSesion($id_grupo, $fecha_sesion, $hora_sesion);

      echo 1;
    
    }
    echo 2; 
  }
  elseif($_POST['dml'] == 'update')
  {

    $grupo = $_POST['ID_Grupo'];
    $curso = $_POST['ID_Curso'];
    $tipo_grupo = $_POST['GrupoTipo'];
    $modalidad = $_POST['GrupoModalidad'];
    $estado = $_POST['GrupoEstatus'];
    $profesor = $_POST['ID_Profesor'];
    $moderador = $_POST['ID_Moderador'];
    $cupo = $_POST['GrupoCupo'];
    $inicio_insc = $_POST['GrupoInicioInscripcion'];
    $fin_insc = $_POST['GrupoFinInscripcion'];
    $plataforma = $_POST['ID_Plataforma'];
    $calendario = $_POST['']; //TODO Hace falta pasar el id del calendario
    $reunion = $_POST['ID_Reunion'];
    $acceso = $_POST['URL_Acceso'];
    $clave = $_POST['Clave_Acceso'];
    $salon = $_POST['ID_Salon'];
    $activo = $_POST['']; //TODO Hace falta El campo activo...?

    $obj_Grupo->actualizarGrupo($grupo, $moderador, $profesor, $salon, $plataforma, $reunion, $acceso, $clave, 
    $cupo, $estado, $activo, $inicio_insc, $fin_insc);
    
    
      echo 1;

    
      echo 2;
  
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
