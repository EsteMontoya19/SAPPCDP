<?php
	class Asistencia
  	{
        //Agregar sesión
        function agregarAsistencia ($idSesion, $inscripcion, $asistio)
    	{	
			if(!isset($asistio) || $asistio == "") {
				$asistio = "FALSE";
			} 
			
			$SQL_Asistencia_Sesion =
			"INSERT INTO Asistencia (sesi_id_sesiones, insc_id_inscripcion, asis_presente)
			 VALUES ($idSesion, $inscripcion, $asistio);
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Asistencia_Sesion);
			$bd->cerrarBD();
		}

		//Buscar los registros de asistencia por el id el grupo
        function buscarAsistenciasGrupo($id_grupo)
        {
			$SQL_Bus_Asistencia =
			"SELECT A.sesi_id_sesiones, A.insc_id_inscripcion, A.asis_presente, I.prof_id_profesor, S.grup_id_grupo, S.sesi_fecha,
					S.sesi_hora_inicio, S.sesi_hora_fin
			FROM Asistencia A, Sesion S, Inscripcion I
			WHERE S.sesi_id_sesiones = A.sesi_id_sesiones AND
				  A.insc_id_inscripcion = I.insc_id_inscripcion AND
				  S.grup_id_grupo = $id_grupo
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Asistencia);
			$bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

		/*
        //Actualizar sesión
        function actualizarSesion($id_sesion, $id_grupo, $fecha_sesion, $hora_inicio_sesion ,$hora_fin_sesion)
    	{
			$SQL_Act_Sesion =
			"	
				UPDATE Sesion
				SET sesi_fecha = '$fecha_sesion', sesi_hora_inicio = '$hora_inicio_sesion', sesi_hora_fin = '$hora_fin_sesion'
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

        

        //Buscar sesiones de un grupo
        function buscarSesionIDSesion($id_sesion)
        {
			$SQL_Bus_Sesion =
			"	
				SELECT sesi_id_sesiones, grup_id_grupo, sesi_fecha, sesi_hora_inicio, sesi_hora_fin
				FROM sesion
				WHERE sesi_id_sesiones = $id_sesion; 
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Sesion);
			$obj_Sesion = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
        }

		//Buscar número de sesiones por id del grupo
		function numSesionesGrupo($idGrupo) {

			$SQL_Bus_Sesion =
			"SELECT COUNT(grup_id_grupo) numero
			 FROM sesion
			 WHERE grup_id_grupo = $idGrupo
			 GROUP BY grup_id_grupo 
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Sesion);
			$obj_Sesion = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

		//Buscar la fecha y hora de la primer sesión de un grupo 
		function buscarMinSesion($idGrupo){
			$SQL_Bus_Sesion =
			"
				SELECT to_char(sesi_fecha, 'DD-MM-YYYY') fecha, to_char(sesi_hora_inicio, 'HH:MM') hora_ini, to_char(sesi_hora_fin, 'HH:MM') hora_fin
				FROM sesion
				WHERE sesi_id_sesiones = (
					SELECT MIN(sesi_id_sesiones) sesi_id_sesiones 
					FROM sesion 
					WHERE grup_id_grupo = $idGrupo
					) 
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Sesion);
			$obj_Sesion = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

		//Buscar día y mes de la primer sesión de un grupo 
		function buscarMinSesionDM($idGrupo){
			$SQL_Bus_Sesion =
			"
			SELECT to_char(sesi_fecha, 'DD') dia, to_char(to_timestamp (to_char(sesi_fecha, 'MM')::text, 'MM'), 'TMmon') mes
			FROM sesion
			WHERE sesi_id_sesiones = (
				SELECT MIN(sesi_id_sesiones) sesi_id_sesiones 
				FROM sesion 
				WHERE grup_id_grupo = $idGrupo
				)
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Sesion);
			$obj_Sesion = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

		// Busca las fechas y hora de sesiones de un grupo
		function buscarFechaSesiones($idGrupo){
			$SQL_Bus_Sesion =
			"SELECT to_char(sesi_fecha, 'DD-MM-YYYY') fecha, sesi_hora_inicio, sesi_hora_fin
			 FROM SESION 
			 WHERE GRUP_ID_GRUPO = $idGrupo
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Sesion);
			$bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
		}

		// Busca las fechas de sesiones (unicamente día y mes) de un grupo
		function buscarDiaMesSesiones($idGrupo){
			$SQL_Bus_Sesion =
			"SELECT to_char(sesi_fecha, 'DD') dia, to_char(to_timestamp (to_char(sesi_fecha, 'MM')::text, 'MM'), 'TMmon') mes
			 FROM SESION 
			 WHERE GRUP_ID_GRUPO = $idGrupo
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Sesion);
			$bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
		}

		/* Estas funciones ayudan a saber en formato de letra una fecha intruducida que siga el formato DD-MM-YYYY
		Ambas se utilizan en la creción de PDF's 
		function conocerDiaSemanaFecha($fecha) {
			$dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
			$dia = $dias[date('w', strtotime($fecha))];
			return $dia;
		}

		function obtenerFechaEnLetra($fecha){
			$dia= $this->conocerDiaSemanaFecha($fecha);
			$num = date("j", strtotime($fecha));
			$anno = date("Y", strtotime($fecha));
			$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
			$mes = $mes[(date('m', strtotime($fecha))*1)-1];
			return $dia.' '.$num.' de '.$mes.' del '.$anno;
		/*}
		*/
		 
    }
?>