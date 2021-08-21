<?php
    class Rol
    {
        //Buscar todos los roles
        //? Verificado en la BD 02/07/2021
        function buscarRoles()
        {
            $SQL_Bus_Rol = 
            "   
                SELECT rol_id_rol, rol_nombre
                FROM rol;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Rol);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Buscar el rol dado el id de usuario
        //? Verificado en la BD 02/07/2021
        function rolUsuario ($usuario) {

            $SQL_Rol_Usuario = 
            "   SELECT R.rol_id_rol, R.rol_nombre
                FROM Rol R, Usuario U
                WHERE U.rol_id_rol = R.rol_id_rol AND U.usua_id_usuario = $usuario
            ";
            $bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Rol_Usuario);
			$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
        }
    }
?>