<?php
	class Sesion
  	{
        //Agregar sesión
        function agregarSesion($id_grupo, $fecha_sesion, $hora_sesion)
    	{
			$SQL_Ins_Sesion =
			"	
				INSERT INTO Sesion (grup_id_grupo, sesi_fecha, sesi_hora)
				VALUES ($id_grupo, );
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Ins_Sesion);
			$bd->cerrarBD();
		}

        //Actualizar sesión
        function actualizarSesion($id_sesion, $id_grupo, $fecha_sesion, $hora_sesion)
    	{
			$SQL_Act_Sesion =
			"	
				UPDATE Sesion
				SET sesi_fecha = $fecha_sesion, sesi_hora = $hora_sesion
				WHERE sesi_id_sesiones = $id_sesion AND grup_id_grupo = $id_grupo;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Act_Sesion);
			$bd->cerrarBD();
		}

        //Eliminar sesión
        function eliminarSesion($id_sesion)
    	{
			$SQL_Eli_Sesion =
			"	
				DELETE FROM Sesion
				WHERE sesi_id_sesiones = $id_sesion;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Eli_Sesion);
			$bd->cerrarBD();
		}

        //Buscar sesión
        function buscarSesion($id_grupo)
        {
			$SQL_Bus_Sesion =
			"	
			SELECT sesi_id_sesiones, grup_id_grupo, sesi_fecha, sesi_hora
			FROM sesion
			WHERE grup_id_grupo = $id_grupo 
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Sesion);
			$bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Buscar sesiones de un grupo
        function buscarSesiones($id_sesion)
        {
			$SQL_Bus_Sesion =
			"	
				SELECT sesi_id_sesiones, grup_id_grupo, sesi_fecha, sesi_hora
				FROM sesion
				WHERE sesi_id_sesiones = $id_sesion; 
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Sesion);
			$bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
    }
?>