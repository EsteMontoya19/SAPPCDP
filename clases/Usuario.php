<?php
	class Usuario
  	{
		function modificarEstatus($usuario, $estatus)
		{
			$SQL_Persona_Est="
			UPDATE Usuario
			SET usua_activo = $estatus
			WHERE usua_id_usuario = $usuario";


			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Persona_Est);
			$bd->cerrarBD();
		}

		function agregarUsuario($persona, $rol, $pregunta, $nombreUsuario, $contrasenia, $recuperacion, $estado)
    	{
			$SQL_Ins_Usuario =
			"	INSERT INTO usuario (pers_id_persona, rol_id_rol, prse_id_pregunta, usua_num_usuario, usua_contrasena, usua_respuesta, usua_activo)
				VALUES ($persona, $rol, $pregunta, '$nombreUsuario', '$contrasenia', '$recuperacion', '$estado');
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Ins_Usuario);
			$bd->cerrarBD();
		}

		function actualizarUsuario($idPersona, $rol, $pregunta, $nombreUsuario, $contrasenia, $recuperacion)
		{
			$SQL_Act_Usuario= 
			" 	UPDATE Usuario
				SET rol_id_rol = $rol , prse_id_pregunta= $pregunta, usua_num_usuario= '$nombreUsuario', usua_contrasena= '$contrasenia', usua_respuesta= '$recuperacion'
				WHERE pers_id_persona = $idPersona;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Act_Usuario);
			$bd->cerrarBD();
		}

		function eliminarUsuario($usuario)
		{
			$SQL_Eli_Usuario= 
			" 	DELETE FROM usuario
				WHERE usua_id_usuario = $usuario;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Eli_Usuario);
			$bd->cerrarBD();
		}

		function buscarTodosUsuarios()
		{
			$SQL_Bus_usuarios =
			"	SELECT U.usua_id_usuario,P.pers_id_persona, P.pers_nombre, P.pers_apellido_paterno, P.pers_apellido_materno,U.rol_id_rol, U.usua_num_usuario, R.rol_nombre, U.usua_activo
				FROM persona P, usuario U , rol R
				WHERE P.pers_id_persona = U.pers_id_persona AND R.rol_id_rol = U.rol_id_rol
				ORDER BY U.usua_activo, P.pers_id_persona DESC, R.rol_id_rol
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_usuarios);
			$bd->cerrarBD();
			return ($transaccion_1->traerRegistros());
		}


		function buscarUsuario($intIdUsuario)
		{
			$SQL_Bus_Usuario = 
			"	SELECT U.usua_id_usuario, U.rol_id_rol, R.rol_nombre, U.prse_id_pregunta, PS.prse_pregunta, U.usua_num_usuario, U.usua_contrasena, U.usua_respuesta, U.usua_activo
				FROM Rol R, Usuario U, Pregunta_Seguridad PS
				WHERE R.rol_id_rol = U.rol_id_rol AND U.prse_id_pregunta = PS.prse_id_pregunta AND U.usua_id_usuario = $intIdUsuario;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Usuario);
			$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

		function buscarNombreUsuario($nombreUsu)
		{
			$SQL_Bus_Usuario = 
			"	SELECT usua_id_usuario, rol_id_rol, prse_id_pregunta, usua_num_usuario, U.usua_contrasena, usua_respuesta
				FROM rol, usuario
				WHERE rol_id_rol = rol_id_rol AND usua_num_usuario = '$nombreUsu';
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Usuario);
			$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

		function eliminarPersonaRol($intIdPersonaRol){
			$SQLDEL_PersonaRol = "DELETE FROM usuario
				WHERE usua_id_usuario =  $intIdPersonaRol";
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQLDEL_PersonaRol);
			$bd->cerrarBD();
		}

		//*CLASE ACTUALIZADA
	}
?>
