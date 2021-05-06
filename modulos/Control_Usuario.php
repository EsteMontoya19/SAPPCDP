<?php

  include('../clases/BD.php');
  include('../clases/Usuario.php');
  include('../clases/Persona.php');
  include('../clases/Moderador.php');
  include('../clases/Administrador.php');
  include('../clases/Busqueda.php');
  //*TODO: Aqui debo crear clases para cada rol que tengo

  $obj_Persona = new Persona();
  $obj_Usuario = new Usuario();
  $obj_Moderador = new Moderador();
  $obj_Busqueda = new Busqueda();
  $obj_Administrador = new Administrador();

  //Arreglos necesarios
  $arr_dias = $obj_Busqueda->selectDias();      
  
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
      //TODO: Aqui se tiene que conseguir el id de la persona.
      
      //? Datos de usuario
      $nombreUsuario = $_POST['strNombreUsuario'];
      $rol = (integer) $_POST['intUsuarioRol'];
      $pregunta = (integer) $_POST['UsuarioPregunta'];
      $recuperacion = $_POST['UsuarioRespuesta'];
      $contrasenia = $_POST['strContrasenia01'];
      $estado = isset($_POST['bEstado']) ? $_POST['bEstado'] : TRUE; //? El admin los crea en activo, debo poner en profesor el estado como false
      
      //?Datos según rol
      
      switch($rol){
        case 1:
          $num_trabajador = $_POST['intNum_Trabajador'];
          $rfc = $_POST['lbRfc'];
        
          //TODO: Falta probar
        break;  

        case 2:
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

          //TODO: Falta probar
        break; 

        case 3:
          $num_trabajador = $_POST['intNum_Trabajador'];
          $rfc = $_POST['lbRfc'];
          //TODO: Código profesor
        break; 
      }

      $obj_Persona->agregarPersona($nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono);
      $persona = $obj_Persona->buscarUltimo();

      $obj_Usuario->agregarUsuario($persona, $rol, $pregunta, $nombreUsuario, $contrasenia, $recuperacion, $estado);
      
      switch($rol){
        case 1: 
          $obj_Administrador->agregarAdministrador($persona, $num_trabajador, $rfc);
        break;

        case 2:
          $obj_Moderador->agregarModerador($persona, $num_cuenta, $fechaInicio, $fechaFin, $horaInicio, $horaFin, $diasModerador );
          foreach($diasModerador as $id){
            $obj_Moderador->agregarDiasModerador($id);
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

    if(!isset($usuario_existente->usua_nombre)) {
      $nombre = $_POST['strUsuarioNombre'];
      $primerApellido = $_POST['strUsuarioPrimerApe'];
      $segundoApellido = $_POST['strUsuarioSegundoApe'];
      $correo = $_POST['strUsuarioCorreo'];
      $telefono = $_POST['strUsuarioTelefono'];
      $nombreUsu = $_POST['strNombreUsuario'];
      $usuario = $_POST['idUsuario'];
      $persona = $_POST['idPersona'];
      $rol = $_POST['intUsuarioRol'];
      $tipo = 1;
      $domicilio = NULL;
      $estudio = NULL;
      $nacimiento = NULL;
      $genero = NULL;

      $obj_Usuario->actualizarUsuario($rol, $usuario, $nombreUsu);
      $obj_Correo->actualizarCorreo($persona, $tipo, $correo);
      $obj_Telefono->actualizarTelefono($persona, $tipo, $telefono);
      $obj_Persona->actualizarPersona($persona, $domicilio, $estudio, $nombre, $primerApellido, $segundoApellido, $nacimiento, $genero);

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
