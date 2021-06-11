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
  
  if ($_POST['dml'] == 'update') {
    
    $nombreUsu = $_POST['strNombreUsuario'];
    $usuario_existente = $obj_Usuario->buscarNombreUsuario($nombreUsu);
    $idPersona = $_POST['idPersona'];
    $idUsuario = $_POST['idUsuario'];

    $esElMismo = 0;

    //?Se valida si el nombre de usuario es el mismo que otro, omitiendo a el nombre usuario actual
    if($nombreUsu == $usuario_existente->usua_num_usuario && $idUsuario == $usuario_existente->usua_id_usuario){
      $esElMismo = 1;
    } else {
      exit("2");
    }

    if(!isset($usuario_existente->usua_num_usuario) || $esElMismo == 1) {  
  
    //? Datos de usuario
    $idPersona = $_POST['idPersona'];
    $nombreUsuario = $_POST['strNombreUsuario'];
    $rol = (integer) $_POST['hideRol'];
    $pregunta = (integer) $_POST['UsuarioPregunta'];
    $recuperacion = $_POST['UsuarioRespuesta'];
    $contrasenia = $_POST['strContrasenia01'];

    $obj_Usuario->actualizarUsuario($idPersona, $rol, $pregunta, $nombreUsuario, $contrasenia, $recuperacion);

    exit("1");
  }
}
?>