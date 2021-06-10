<?php
	class PreguntaSeguridad
  	{
        //Agregar PreguntaSeguridad
        function agregarPreguntaSeguridad ($PreguntaSeguridad)
    	{
			$SQL_Ins_PreguntaSeguridad =
			"
				INSERT INTO Pregunta_Seguridad(prse_pregunta)
				VALUES ('$PreguntaSeguridad');
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Ins_PreguntaSeguridad);
			$bd->cerrarBD();
			
		}

        //Actulizar PreguntaSeguridad
        function actulizarPreguntaSeguridad ($PreguntaSeguridad, $id)
    	{
			$SQL_Act_PreguntaSeguridad =
			"	
				UPDATE Pregunta_Seguridad
				SET prse_pregunta = '$PreguntaSeguridad'
				WHERE prse_id_pregunta = $id
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Act_PreguntaSeguridad);
			$bd->cerrarBD();
		}

		//Buscar PreguntaSeguridad por ID
        function buscarPreguntaSeguridad ($id)
    	{
			$SQL_Bus_PreguntaSeguridad =
			"	
				SELECT prse_pregunta 
				FROM Pregunta_Seguridad
				WHERE prse_id_pregunta = $id
			";

			$bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_PreguntaSeguridad);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
		}

		//Buscar PreguntaSeguridad por Nombre
        function buscarPreguntaSeguridadNombre ($pregunta)
    	{
			$SQL_Bus_PreguntaSeguridad =
			"	
				SELECT COUNT(prse_id_pregunta) as numero
				FROM Pregunta_Seguridad
				WHERE prse_pregunta = '$pregunta'
			";

			$bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_PreguntaSeguridad);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
		}
		
        //Buscar Todas las PreguntaSeguridad
        function buscarTodasPreguntaSeguridad ()
    	{
			$SQL_Bus_PreguntasSeguridad =
			"	
				SELECT prse_id_pregunta, prse_pregunta 
				FROM Pregunta_Seguridad 
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_PreguntasSeguridad);
			$bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
		}
    }
?>