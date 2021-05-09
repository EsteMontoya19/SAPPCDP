<?php

  include('../clases/BD.php');
  include('../clases/Curso.php');

  $obj_Curso = new Curso();

  if($_POST['dml'] == 'cambio')
  {
    $curso = $_POST['id'];
    $estatus = $_POST['estatus'];

    if ($estatus == 't')
    {
      $estatus = 'FALSE';
      $obj_Curso->modificarEstatus($curso,$estatus);
    }
    elseif($estatus == 'f')
    {
      $estatus = 'TRUE';
      $obj_Curso->modificarEstatus($curso, $estatus);
    }

    echo 1;
  }

  //! Todo lo siguiente viene de Usuarios, se debe cambiar conforme se avance a cursos

  if($_POST['dml'] == 'insert'){
    $nombre = $_POST['strNombreCurso'];
    $cursoExistente = $obj_Curso->buscarCursoNombre($nombre);

    if(!isset($cursoExistente->curs_nombre)){
      
      //Datos del curso
      $nombre = $_POST['strNombreCurso'];
      $tipo = $_POST['intTipoCurso'];
      $nivel = $_POST['intNivel'];
      $req_tecnicos = $_POST['strReqTec'];
      $objetivos = $_POST['strObjCurso'];
      $conocimientos = $_POST['strConNeces'];
      $num_sesiones = $_POST['strNumeroSesiones'];
      $temario = null;//Funcional en lo que se logra crear el directorio para los archivos y guardar solo la url
      

      $obj_Curso->agregarCurso($tipo, $nombre, $num_sesiones, $req_tecnicos, $conocimientos, $nivel, $objetivos, $temario, true);
      echo 1;

    } else {
      echo 2;
    }
  }
  
  if($_POST['dml'] == 'update')
  {
    $curso = $_POST['idCurso'];
    $nombre = $_POST['strNombreCurso'];
    $curso_existente = $obj_Curso->buscarCursoNombre($nombre);
    $esElMismo = 0;
    if($curso == $curso_existente->curs_id_curso && $nombre == $curso_existente->curs_nombre){
      $esElMismo = 1;
    }
    
    if(!isset($curso_existente->curs_id_curso) || $esElMismo == 1) {
     //? Datos de curso
       
      $tipo = $_POST['intTipoCurso'];
      $num_sesiones = $_POST['strNumeroSesiones'];
      $req_tecnicos = $_POST['strReqTec'];
      $conocimientos = $_POST['strConNeces'];
      $nivel = $_POST['intNivel']; 
      $objetivo = $_POST['strObjCurso'];
      $temario = null; //!$_POST['temario'];
      $activo = isset($_POST['bEstado']) ? $_POST['bEstado'] : TRUE; //TODO Ver como funciona este dato en el formulario

      $obj_Curso->actualizarCurso($curso, $tipo, $nombre, $num_sesiones, $req_tecnicos, $conocimientos, $nivel, $objetivo, $temario, $activo);
      echo 1;
    } else {
      echo 2;
    }
  }
  /*
  elseif($_POST['dml'] == 'delete')
  {
    $usuario = $_POST['id'];
    $persona = $_POST['persona'];
    
    $obj_Usuario->eliminarUsuario($usuario); 
    $obj_Moderador->eliminarModerador($persona);
    $obj_Persona->eliminarPersona($persona);

    echo 1;
  }*/

?>