<?php
	class Cuenta
  	{
		//Busca un usuario dado el usuario y la contraseña
        function buscarUsuarioSistema($usuario, $contrasena)
		{
			$SQL_Bus_Usuario = 
			"	SELECT U.usua_id_usuario, U.pers_id_persona, P.pers_nombre, P.pers_apellido_paterno, P.pers_apellido_materno, R.rol_nombre,R.rol_id_rol
				FROM Usuario U, Persona P, Rol R
				WHERE U.pers_id_persona = P.pers_id_persona AND U.rol_id_rol = R.rol_id_rol AND U.usua_num_usuario = '$usuario' AND U.usua_contrasena = '$contrasena';
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Usuario);
			$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}
    }
?>