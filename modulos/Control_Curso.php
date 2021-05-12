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
    if(isset($cursoExistente->curs_nombre) ) { //? Si no es un  nombre nuevo
      if (($cursoExistente->curs_nivel == $_POST['intNivel'] && $cursoExistente->curs_tipo == $_POST['intTipoCurso']) ){
        exit("2");
      }
    } 

    if (isset($_FILES['temario']['name']) && $_FILES['temario']['name'] != '') { //? Si lleno el temario
      $file = is_uploaded_file($_FILES['temario']['tmp_name']);
      $rutaTemporal = $_FILES['temario']['tmp_name'];
      $rutaNueva = "../recursos/PDF/Temarios/";
      $nuevoNombre = "Temario_".$_POST['intTipoCurso']."_".$_POST['strNombreCurso']."_".$_POST['intNivel'].".pdf";
      move_uploaded_file($_FILES['temario']['tmp_name'], $rutaNueva.$nuevoNombre);
      $temario = $rutaNueva.$nuevoNombre;

      //Datos del curso
      $nombre = $_POST['strNombreCurso'];
      $tipo = $_POST['intTipoCurso'];
      $nivel = $_POST['intNivel'];
      $req_tecnicos = $_POST['strReqTec'];
      $objetivos = $_POST['strObjCurso'];
      $conocimientos = $_POST['strConNeces'];
      $num_sesiones = $_POST['strNumeroSesiones'];      

      $obj_Curso->agregarCurso($tipo, $nombre, $num_sesiones, $req_tecnicos, $conocimientos, $nivel, $objetivos, $temario, true);
      exit("1");
    } else {
      exit("3");
    }
    exit("1");
  }
  
  if($_POST['dml'] == 'update')
  {

    $nombre = $_POST['strNombreCurso'];
    $cursoExistente = $obj_Curso->buscarCursoNombre($nombre);
    $cursoActual = $obj_Curso->buscarCurso($_POST['idCurso']);

    if(!isset($cursoExistente->curs_nombre) || $cursoActual->curs_id_cursos == $cursoExistente->curs_id_cursos) { //? Si no hay curso con ese nombre o si es el mismo curso 
      if (isset($_FILES['temario']['name']) || $_FILES['temario']['name'] != ''){ //? Si se actualizó el temario
       
        $file = is_uploaded_file($_FILES['temario']['tmp_name']);
        $rutaTemporal = $_FILES['temario']['tmp_name'];
        $rutaPasada = $cursoActual->curs_temario;
        $rutaNueva = "../recursos/PDF/Temarios/";
        $nuevoNombre = "Temario_".$_POST['intTipoCurso']."_".$_POST['strNombreCurso']."_".$_POST['intNivel'].".pdf";
        unlink("$rutaPasada");
        move_uploaded_file($_FILES['temario']['tmp_name'], $rutaNueva.$nuevoNombre);
        $temario = $rutaNueva.$nuevoNombre;

      } else { //? Si no modifico el temario
        $rutaPasada = $cursoActual->curs_temario;
        $rutaNueva = "../recursos/PDF/Temarios/";
        $nuevoNombre = "Temario_".$_POST['intTipoCurso']."_".$_POST['strNombreCurso']."_".$_POST['intNivel'].".pdf";
        rename("$rutaPasada", "$rutaNueva"."$nuevoNombre");
        $temario = $rutaNueva.$nuevoNombre;      
      }

    } else { //? Si hay un curso con ese nombre o el que hay no es el mismo 
      if ($cursoExistente->curs_nivel != $_POST['intNivel'] || $cursoExistente->curs_tipo != $_POST['intTipoCurso']) { //? Si cambia en tipo o nivel
        $rutaPasada = $cursoActual->curs_temario;
        $rutaNueva = "../recursos/PDF/Temarios/";
        $nuevoNombre = "Temario_".$_POST['intTipoCurso']."_".$_POST['strNombreCurso']."_".$_POST['intNivel'].".pdf";
        rename("$rutaPasada", "$rutaNueva"."$nuevoNombre");
        $temario = $rutaNueva.$nuevoNombre;  
      } else {  //? Si no cambia ni en nivel ni en tipo y no tiene el mimso ID esta totalmente igual

        exit('2');
      }
    }

    $curso = $_POST['idCurso'];
    $nombre = $_POST['strNombreCurso'];
    $tipo = $_POST['intTipoCurso'];
    $num_sesiones = $_POST['strNumeroSesiones'];
    $req_tecnicos = $_POST['strReqTec'];
    $conocimientos = $_POST['strConNeces'];
    $nivel = $_POST['intNivel']; 
    $objetivo = $_POST['strObjCurso'];
    $activo = isset($_POST['bEstado']) ? $_POST['bEstado'] : TRUE; //TODO Ver como funciona este dato en el formulario

    $obj_Curso->actualizarCurso($curso, $tipo, $nombre, $num_sesiones, $req_tecnicos, $conocimientos, $nivel, $objetivo, $temario, $activo);
    
    echo 1;
  } else {
    echo 2;
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