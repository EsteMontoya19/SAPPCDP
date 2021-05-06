<?php

  include('../clases/BD.php');
  include('../clases/Usuario.php');
  include('../clases/Persona.php');
  include('../clases/Moderador.php');
  include('../clases/Profesor.php');
  include('../clases/Administrador.php');
  include('../clases/Busqueda.php');

  $obj_Persona = new Persona();
  $obj_Usuario = new Usuario();
  $obj_Moderador = new Moderador();
  $obj_Profesor = new Profesor();
  $obj_Busqueda = new Busqueda();
  $obj_Administrador = new Administrador();

  //Arreglos necesarios
  $arr_dias = $obj_Busqueda->selectDias();  
  $arr_niveles = $obj_Busqueda->selectNiveles();   
  $arr_modalidades = $obj_Busqueda->selectModalidades();
  $arr_coordinaciones = $obj_Busqueda->selectCoordinaciones();
  
  if($_POST['dml'] == 'insert')
  {
    $nombreUsu = $_POST['strNombreUsuario'];
    $usuario_existente = $obj_Usuario->buscarNombreUsuario($nombreUsu);
    
    if(!isset($usuario_existente->usua_nombre)) {
      
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
  elseif($_POST['dml'] == 'update')
  {
    $nombreUsu = $_POST['strNombreUsuario'];
    $usuario_existente = $obj_Usuario->buscarNombreUsuario($nombreUsu);
    $idPersona = $_POST['idPersona'];
    $idUsuario = $_POST['id'];

    if(!isset($usuario_existente->usua_nombre)) {
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
    
     //TODO: Aqui esta todo a registar, debe cambiar a actualizar
    $obj_Persona->actualizarPersona($idPersona, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono);
    $obj_Usuario->actualizarUsuario($idPersona, $rol, $pregunta, $nombreUsuario, $contrasenia, $recuperacion);
    
      
    switch($rol){
      case 1: //Administrador
        $obj_Administrador->actualizarAdministrador($idPersona, $num_trabajador, $rfc);
      break;

      case 2: //Moderador
        $obj_Moderador->actualizarModerador($idPersona, $num_cuenta, $fechaInicio, $fechaFin, $horaInicio, $horaFin);
        $obj_Moderador->eliminarDiasModerador($idPersona);
        foreach($diasModerador as $id){
          $obj_Moderador->agregarDiasModerador($idPersona, $id);
        }
      break;

      case 3: //Profesor
        $obj_Profesor->actualizarProfesor($idPersona, $num_trabajador, $semblanza, $rfc);
        
        $obj_Profesor->eliminarNivelesProfesor($idPersona);
        foreach($nivelesProfesor as $id){
          $obj_Profesor->agregarNivelesProfesor($idPersona, $id);
        }
        $obj_Profesor->eliminarModalidadesProfesor($idPersona);
        foreach($modalidadesProfesor as $id){
          $obj_Profesor->agregarModalidadesProfesor($idPersona, $id);
        }
        $obj_Profesor->eliminarCoordinacionesProfesor($idPersona);
        foreach($coordinacionesProfesor as $id){
          $obj_Profesor->agregarCoordinacionesProfesor($idPersona, $id);
        }
      break;
    }

      echo 1;
    } else {
      echo 2;
    }
  }
  elseif($_POST['dml'] == 'delete')
  {
    $usuario = $_POST['id'];
    $persona = $_POST['persona'];
    
    $obj_Usuario->eliminarUsuario($usuario); 
    $obj_Moderador->eliminarModerador($persona);
    $obj_Persona->eliminarPersona($persona);

    echo 1;
  }
  elseif($_POST['dml'] == 'cambio')
  {
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
