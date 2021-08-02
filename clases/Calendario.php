<?php 
    class Calendario
    {
        //? Registra un nuevo calendario
        function agregarCalendario ($semestre, $inicioCiclo, $finCiclo, $inicioExamenes, $finExamenes, $inicioInter, $finInter, $inicioAsueto, $finAsueto, $inicioAdmin, $finAdmin)
    	{
			$SQL_BUS_CALENDARIO =
			"INSERT INTO Calendario (cale_semestre, cale_inicio_ciclo, cale_fin_ciclo, cale_inicio_examenes, 
                        cale_fin_examenes, cale_inicio_asueto, cale_fin_asueto, cale_inicio_intersemestral, 
                        cale_fin_intersemestral, cale_inicio_admin, cale_fin_admin, cale_activo)
            VALUES ('$semestre', '$inicioCiclo', '$finCiclo', '$inicioExamenes', '$finExamenes', '$inicioAsueto', '$finAsueto', '$inicioInter'
                , '$finInter', '$inicioAdmin', '$finAdmin', FALSE)
			";
			
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_BUS_CALENDARIO);
			$bd->cerrarBD();
		}

        function agregarInhabiles ($calendario , $diaInhabil)
    	{
			$SQL_BUS_CALENDARIO =
			"INSERT INTO Dia_festivo (cale_id_calendario, dife_fecha) VALUES ($calendario, '$diaInhabil');
			";
			
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_BUS_CALENDARIO);
			$bd->cerrarBD();
		}

        function eliminarInhabiles ($id)
    	{
			$SQL_BUS_CALENDARIO =
			"DELETE FROM Dia_festivo 
             WHERE cale_id_calendario = $id
			";
			
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_BUS_CALENDARIO);
			$bd->cerrarBD();
		}

        //Permite actualizar un dia festivo en la base de datos
        //? Falta completar variable $SQL
        function actualizarCalendario($id, $semestre, $inicioCiclo, $finCiclo, $inicioExamenes, $finExamenes, $inicioInter, $finInter, $inicioAsueto, $finAsueto, $inicioAdmin, $finAdmin)
        {

            $SQL_Act_Calendario =
            "UPDATE Calendario
             SET    cale_semestre = '$semestre', cale_inicio_ciclo = '$inicioCiclo', cale_fin_ciclo = '$finCiclo', cale_inicio_examenes = '$inicioExamenes', 
                        cale_fin_examenes = '$finExamenes', cale_inicio_asueto = '$inicioAsueto', cale_fin_asueto = '$finAsueto', cale_inicio_intersemestral = '$inicioInter', 
                        cale_fin_intersemestral = '$finInter', cale_inicio_admin = '$inicioAdmin', cale_fin_admin = '$finAdmin'
             WHERE cale_id_calendario = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Act_Calendario);
            $bd->cerrarBD();

        }

        //Busca el último registro de persona
        //? Verificado en la BD 02/07/2021
        function buscarUltimo()
        {
            $bd = new BD();
            $SQL_BUS_CALENDARIO = 
            "SELECT last_value
            FROM calendario_cale_id_calendario_seq;"; //Que hace este last_value : Muestra el ultimo valor ingresado

            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_BUS_CALENDARIO);
            $obj_Calendario = $transaccion_1->traerObjeto(0);
            $Calendario_seq = $obj_Calendario->last_value;
            $bd->cerrarBD();

            return $Calendario_seq;
        }
        
        function buscarCalendarios()
        {
            $SQL_BUS_CALENDARIO = 
            "SELECT cale_id_calendario, cale_semestre, cale_inicio_ciclo, cale_fin_ciclo, cale_inicio_examenes,
                    cale_fin_examenes, cale_inicio_asueto, cale_fin_asueto, cale_inicio_intersemestral, cale_fin_intersemestral,
                    cale_inicio_admin, cale_fin_admin, cale_activo
            FROM Calendario
            ORDER BY cale_activo, cale_id_calendario
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_BUS_CALENDARIO);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //? Busca cuantos calendarios activos hay, regresando el numero total de calendarios activos
        function buscarCalendarioActivo()
        {
            $SQL_BUS_CALENDARIO = 
            "SELECT cale_id_calendario, cale_semestre, cale_inicio_ciclo, cale_fin_ciclo, cale_inicio_examenes,
                    cale_fin_examenes, cale_inicio_asueto, cale_fin_asueto, cale_inicio_intersemestral, cale_fin_intersemestral,
                    cale_inicio_admin, cale_fin_admin, cale_activo
             FROM Calendario
             WHERE cale_activo = TRUE
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_BUS_CALENDARIO);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //? Busca un calendario en especifico, recibiendo su id
        function buscarCalendario($id)
        {
            $SQL_BUS_CALENDARIO = 
            "SELECT cale_id_calendario, cale_semestre, cale_inicio_ciclo, cale_fin_ciclo, cale_inicio_examenes,
                    cale_fin_examenes, cale_inicio_asueto, cale_fin_asueto, cale_inicio_intersemestral, cale_fin_intersemestral,
                    cale_inicio_admin, cale_fin_admin, cale_activo
             FROM Calendario
             WHERE cale_id_calendario = $id
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_BUS_CALENDARIO);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //? Busca los dias festivos relacionados con el calendario enviado
        function buscarDiasFestivos($idCalendario)
        {
            $SQL_BUS_CALENDARIO = 
            "SELECT DF.dife_id_dia_festivo, DF.cale_id_calendario, DF.dife_fecha
            FROM Dia_festivo DF, Calendario C
            WHERE DF.cale_id_calendario = C.cale_id_calendario AND
                  DF.cale_id_calendario = $idCalendario
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_BUS_CALENDARIO);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //? Cambiar Estado del Calendario
        function cambiarEstatusCalendario ($activo, $id, $idActivo)
    	{
			$SQL_BUS_CALENDARIO = 
            "UPDATE Calendario
             SET cale_activo = '$activo'
             WHERE cale_id_calendario = $id;

             UPDATE Calendario
             SET cale_activo = 'FALSE'
             WHERE cale_id_calendario = $idActivo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_BUS_CALENDARIO);
            $bd->cerrarBD();
		}
        
        
        
        
        //Permite Consultar los dias de inicio y fin de un periodo de asueto académico como semana santa del calendario activo
        //? Verificado en la BD
        function consultarAsueto()
        {
            $SQL_Bus_Asueto = 
            "   SELECT cale_inicio_asueto, cale_fin_asueto
                FROM Calendario 
                WHERE cale_activo = true 
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Asueto);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }
        
        //Permite Consultar el inicio del periodo de vacaciones administrativas correspondientes al semestre del calendario activo
        //? Verificado en la BD
        function consultarVacacionesAdministrativas()
        {
            $SQL_Bus_Vac_Admin = 
            "   SELECT cale_inicio_admin, cale_fin_admin
                FROM Calendario 
                WHERE cale_activo = true 
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Vac_Admin);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

    }
?>