<?php
	session_start();

  	class ControlAcceso
  	{
    	function ControlAcceso()
    	{
			include_once('../clases/Valida.php');
			include_once('../clases/Acceder.php');

			$_strUsuario = $_POST['strUsuario'];
			$_strContrasena = $_POST['strContrasena'];

			$ban1 = true;
			$Valida = new Valida();

			if ($_strUsuario == "") $Valida->ponerValidacion("Usuario", "Debe ingresar su nombre de usuario.");
			if ($_strContrasena == "") $Valida->ponerValidacion("Contrasena", "Debe ingresar su contraseña.");

			$arr_Mensaje = $Valida->obtenerValidacion();

			if(count($arr_Mensaje) > 0) {
				$ban1 = false;
			}
			if (!$ban1) {
				include_once("index.php");
				exit;
			}

			$Acceder_1 = new Acceder;

			$_strContrasena = $_strContrasena;

			$blnUsuario = $Acceder_1->buscar($_strUsuario, $_strContrasena);

			if(!$blnUsuario)
			{
				$ban1 = false;
				$Valida->ponerValidacion("UsuarioContrasena", "El usuario o contraseña no son correctos");
				$arr_Mensaje = $Valida->obtenerValidacion();
				include_once("../sistema/login.php");
				exit;
			}
			else
			{
				$estado = $Acceder_1->validarEstado($_strUsuario, $_strContrasena);
				if($estado){
					include_once("../sistema/inicio.php");
					exit;
				}
				else{
					$ban1 = false;
					$Valida->ponerValidacion("UsuarioContrasena", "El usuario no se encuentra activo");
					$arr_Mensaje = $Valida->obtenerValidacion();
					include_once("../sistema/login.php");
					exit;
				}
			}
		}
	}
  $ControlAcceso_1 = new ControlAcceso();
?>
