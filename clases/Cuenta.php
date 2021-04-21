<?php
	class Cuenta
  	{
        function buscarUsuarioSistema($usuario, $contrasena)
		{
			$SQL_Bus_Usuario = 
			"	SELECT usua_id_usua, pers_id_pers, pers_nombre, pers_primer_ape, rol_nombre,rol_id_rol
				FROM usuario, persona, rol
				WHERE usua_id_pers = pers_id_pers AND usua_id_rol = rol_id_rol AND usua_nombre = '$usuario' AND usua_contra = '$contrasena';
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