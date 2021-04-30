<?php

  include('../clases/BD.php');
  include('../clases/Usuario.php');
  include('../clases/Persona.php');
  include('../clases/Moderador.php');
  //Aqui debo crear clases para cada rol que tengo
  include('../clases/Correo.php');

  $obj_Persona = new Persona();
  $obj_Usuario = new Usuario();
  $obj_Moderador = new Moderador();
  $obj_Correo = new Correo();

  if($_POST['dml'] == 'insert')
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
      $rol = $_POST['intUsuarioRol'];
      $pregunta = $_POST['UsuarioPregunta'];
      $recuperacion = $_POST['UsuarioRespuesta'];
      $contrasenia = $_POST['strContrasenia01'];
      $tipo = 1;
      $domicilio = NULL;
      $estudio = NULL;
      $nacimiento = NULL;
      $genero = NULL;

      $obj_Persona->agregarPersona($estudio, $domicilio, $nombre, $primerApellido, $segundoApellido, $nacimiento, $genero);
      $persona = $obj_Persona->id_persona;

      $obj_Telefono->agregarTelefono($persona, $tipo, $telefono);
      $obj_Correo->agregarCorreo($persona, $tipo, $correo);
      $obj_Usuario->agregarUsuario($persona, $pregunta, $nombreUsu, $contrasenia, $recuperacion);

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
