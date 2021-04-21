<?php
    class Rol
    {
        function buscarRoles()
        {
            $SQL_Bus_Rol = 
            "   SELECT rol_id_rol, rol_nombre
                FROM rol;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Rol);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
    }
?>