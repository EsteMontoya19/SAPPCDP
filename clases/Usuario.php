<?php
	class Usuario
  	{
    	function agregarUsuario($rol, $persona, $pregunta, $nombreUsu, $contrasenia, $recuperacion)
    	{
			$SQL_Ins_Usuario =
			"	INSERT INTO usuario (usua_id_rol, usua_id_pers, usua_id_preg, usua_nombre, usua_contra, usua_respuesta, usua_estado)
				VALUES ($rol, $persona, $pregunta, '$nombreUsu', '$contrasenia', '$recuperacion', TRUE);
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Ins_Usuario);
			$bd->cerrarBD();
		}

		function actualizarUsuario($rol, $usuario, $nombreUsu)
		{
			$SQL_Act_Usuario= 
			" 	UPDATE usuario
				SET usua_nombre = '$nombreUsu', usua_id_rol = $rol
				WHERE usua_id_usua = $usuario;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Act_Usuario);
			$bd->cerrarBD();
		}

		function actualizarContrasena($usuario, $contra)
		{
			$SQL_Act_Usuario= 
			" 	UPDATE usuario
				SET usua_contra = '$contra'
				WHERE usua_id_usua = $usuario;
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
				WHERE usua_id_usua = $usuario;
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
			"	SELECT pers_id_pers, usua_id_usua, pers_nombre, pers_primer_ape, pers_segundo_ape, usua_estado, rol_nombre
				FROM persona, usuario , rol r
				WHERE pers_id_pers = usua_id_pers AND rol_id_rol = usua_id_rol AND rol_id_rol <> 6
				ORDER BY usua_id_usua ASC;
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
			"	SELECT usua_id_usua, usua_id_rol, usua_id_preg, usua_nombre, usua_contra, usua_respuesta
				FROM rol, usuario
				WHERE rol_id_rol = usua_id_rol AND usua_id_usua = $intIdUsuario;
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
			"	SELECT usua_id_usua, usua_id_rol, usua_id_preg, usua_nombre, usua_contra, usua_respuesta
				FROM rol, usuario
				WHERE rol_id_rol = usua_id_rol AND usua_nombre = '$nombreUsu';
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Usuario);
			$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

		function modificarEstatus($usuario, $estatus)
		{
			$SQL_Persona_Est="
			UPDATE usuario
			SET usua_estado = $estatus
			WHERE usua_id_usua = $usuario";


			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Persona_Est);
			$bd->cerrarBD();
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
	}
?>
