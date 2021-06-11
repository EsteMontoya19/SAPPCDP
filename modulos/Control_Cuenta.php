<?php
  include('../clases/BD.php');
  include('../clases/Usuario.php');

  $obj_Usuario = new Usuario();



  if ($_POST['dml'] == 'contrasena'){
    $usuario = $obj_Usuario->buscarUsuario($_POST['idUsuario']);

    $nombreUsuario = $_POST['strUsuario'];
    $contrasena = $_POST['strContrasena'];

    //? Verifica que los usuarios y contraseñas introducidas sean los mismos del usuario del perfil
    if($usuario->usua_num_usuario == $nombreUsuario && $usuario->usua_contrasena == $contrasena) {
        exit("1");
    }
    exit("2");

  }

  if($_POST['dml'] == 'update')
  {
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
  }

  elseif($_POST['dml'] == 'contra')
  {
    $id_usuario = $_POST['idUsuario'];
    $usuario = $obj_Usuario->buscarUsuario($id_usuario);
    $contrasenia = $_POST['strContrasenia01'];

    if($usuario->usua_contra == $contrasenia)
    {
        $n_contrasena = $_POST['strContrasenia02'];
        $obj_Usuario->actualizarContrasena($id_usuario, $n_contrasena);
        echo 1;
    }
    else
    {
        echo 2;
    }
  }

?>