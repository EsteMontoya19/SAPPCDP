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

  /*
  if($_POST['dml'] == 'insert')
  {
    $nombreUsu = $_POST['strNombreUsuario'];
    $usuario_existente = $obj_Usuario->buscarNombreUsuario($nombreUsu);
    
    if(!isset($usuario_existente->usua_num_usuario)) {
      
      //?Datos de persona
      $nombre = $_POST['strUsuarioNombre'];
      $apellidoPaterno = $_POST['strUsuarioPrimerApe'];
      $apellidoMaterno = $_POST['strUsuarioSegundoApe'];
      $correo = $_POST['strUsuarioCorreo'];
      $telefono = $_POST['strUsuarioTelefono'];
      
      //? Datos de usuario
      $nombreUsuario = $_POST['strNombreUsuario'];
      $rol = (integer) $_POST['intUsuarioRol'];
      $pregunta = (integer) $_POST['UsuarioPregunta'];
      $recuperacion = $_POST['UsuarioRespuesta'];
      $contrasenia = $_POST['strContrasenia01'];
      $estado = isset($_POST['bEstado']) ? $_POST['bEstado'] : TRUE; //? El admin los crea en activo, debo poner en profesor el estado como false
      
      //?Datos según rol
      
      switch($rol){
        case 1: //Administrador
          $num_trabajador = $_POST['intNum_Trabajador'];
          $rfc = $_POST['strRFC'];
        break;  

        case 2: //Moderador
          //*? Creado para guardar los inputs. Solo guarda los que tienen algo
          $diasModerador=array();
          foreach($arr_dias as $dia){
            static $bandera =  1; 
            
            if(isset($_POST['strDiaServicio'.$bandera]) && $_POST['strDiaServicio'.$bandera] != "" ) {
              $diasModerador[$bandera] = $_POST['strDiaServicio'.$bandera];
            } 
            $bandera++;
          }

          $num_cuenta = $_POST['lbNumCuenta'];
          $fechaInicio = $_POST['strFechaInicio'];
          $fechaFin = $_POST['strFechaFin']; 
          $horaInicio = $_POST['strHoraInicio']; 
          $horaFin = $_POST['strHoraFin'];
        break; 

        case 3: //Profesor
          $num_trabajador = $_POST['intNum_Trabajador'];
          $rfc = $_POST['strRFC'];
          $semblanza = $_POST['strSemblanza'];
          //*? Creado para guardar los inputs. Solo guarda los que tienen algo
          $nivelesProfesor=array();
          $bandera =  1; 
          foreach($arr_niveles as $nivel){
            if(isset($_POST['strNivel'.$bandera]) && $_POST['strNivel'.$bandera] != "" ) {
              $nivelesProfesor[$bandera] = $_POST['strNivel'.$bandera];
            } 
            $bandera++;
          }

          $modalidadesProfesor=array();
          $bandera =  1; 
          foreach($arr_modalidades as $modalidad){
            if(isset($_POST['strModalidad'.$bandera]) && $_POST['strModalidad'.$bandera] != "" ) {
              $modalidadesProfesor[$bandera] = $_POST['strModalidad'.$bandera];
            } 
            $bandera++;
          }

          $coordinacionesProfesor=array();
          $bandera =  1; 
          foreach($arr_coordinaciones as $coordinacion){
            if(isset($_POST['strCoordinacion'.$bandera]) && $_POST['strCoordinacion'.$bandera] != "" ) {
              $coordinacionesProfesor[$bandera] = $_POST['strCoordinacion'.$bandera];
            } 
            $bandera++;
          }
        break; 
      }

      $obj_Persona->agregarPersona($nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono);
      $persona = $obj_Persona->buscarUltimo();

      $obj_Usuario->agregarUsuario($persona, $rol, $pregunta, $nombreUsuario, $contrasenia, $recuperacion, $estado);
      
      switch($rol){
        case 1: //Administrador
          $obj_Administrador->agregarAdministrador($persona, $num_trabajador, $rfc);
        break;

        case 2: //Moderador
          $obj_Moderador->agregarModerador($persona, $num_cuenta, $fechaInicio, $fechaFin, $horaInicio, $horaFin );
          foreach($diasModerador as $id){
            $obj_Moderador->agregarDiasModerador($persona, $id);
          }
        break;

        case 3: //Profesor
          $obj_Profesor->agregarProfesor($persona, $num_trabajador, $semblanza, $rfc);
          
          foreach($nivelesProfesor as $id){
            $obj_Profesor->agregarNivelesProfesor($persona, $id);
          }
          foreach($modalidadesProfesor as $id){
            $obj_Profesor->agregarModalidadesProfesor($persona, $id);
          }
          foreach($coordinacionesProfesor as $id){
            $obj_Profesor->agregarCoordinacionesProfesor($persona, $id);
          }
        break;
      }
      

      echo 1;
    } else {
      echo 2;
    }
      
  }
  else*/
  
  if($_POST['dml'] == 'update')
  {
    $curso = $_POST['idCurso'];
    $curso_existente = $obj_Curso->buscarCurso($curso);

    $esElMismo = 0;
    if($curso == $curso_existente->curs_id_curso){
      $esElMismo = 1;
    }
    
    if(!isset($curso_existente->curs_id_curso) || $esElMismo == 1) {
     //? Datos de curso
      $tipo = $_POST['intTipoCurso'];
      $nombre = $_POST['strNombreCurso'];
      $num_sesiones = $_POST['strNumeroSesiones'];
      $req_tecnicos = $_POST['strReqTec'];
      $conocimientos = $_POST['strConNeces'];
      $nivel = $_POST['intNivel']; 
      $objetivo = $_POST['strObjCurso'];
      $temario = $_POST['temario'];
      $activo = isset($_POST['bEstado']) ? $_POST['bEstado'] : TRUE; //TODO Ver como funciona este dato en el formulario
          
      $obj_Curso->modificarCurso($curso, $tipo, $nombre, $num_sesiones, $req_tecnicos, $conocimientos, $nivel, $objetivo, $temario, $activo);
      
    

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