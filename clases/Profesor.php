<?php
    class Profesor
    {
		function buscarProfesor($persona)
		{
			$SQL_Bus_Profesor = 
			"SELECT P.prof_id_profesor, P.pers_id_persona, P.prof_num_trabajador, P.prof_semblanza, P.prof_rfc
			 FROM Profesor P, Persona PE
			 WHERE P.pers_id_persona = PE.pers_id_persona AND P.pers_id_persona = $persona
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Profesor);
			$obj_Profesor = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
        }

		function buscarProfesorNiveles ($profesor) {
			$SQL_Bus_Niveles = 
			"SELECT N.nive_id_nivel, N.nive_nombre
			 FROM Nivel N, Profesor P, Profesor_Nivel PN
			 WHERE PN.prof_id_profesor = $profesor AND N.nive_id_nivel = PN.nive_id_nivel
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Niveles);
			$obj_Profesor = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerRegistros());
		}
		function buscarProfesorModalidades ($profesor) {
			$SQL_Bus_Niveles = 
			"SELECT M.moda_id_modalidad, M.moda_nombre
			 FROM Modalidad M, Profesor P, Profesor_Modalidad PM
			 WHERE PM.prof_id_profesor = $profesor AND M.moda_id_modalidad = PM.moda_id_modalidad
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Niveles);
			$obj_Profesor = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerRegistros());
		}
		function buscarProfesorCoordinaciones ($profesor) {
			$SQL_Bus_Niveles = 
			"SELECT C.coor_id_coordinacion, C.coor_nombre
			 FROM Coordinacion C, Profesor P, Profesor_Coordinacion PC
			 WHERE PC.prof_id_profesor = $profesor AND C.coor_id_coordinacion = PC.coor_id_coordinacion
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Niveles);
			$obj_Profesor = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerRegistros());
		}

		//*TODO: Falta mdificar las clases siguientes


        function agregarProfesor($persona, $numero, $semblanza, $constancia, $cv, $cedula, $titulo, $ine, $curp, $banco)
        {
            $SQL_Ins_Profesor = 
            "   INSERT INTO profesor (prof_id_pers, prof_numero, prof_semblanza, prof_constancia, prof_cv, prof_cedula, prof_titulo, prof_ine, prof_curp, prof_banco)
                VALUES($persona, '$numero', '$semblanza', '$constancia', '$cv', '$cedula', '$titulo', '$ine', '$curp', '$banco');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Profesor);
            $bd->cerrarBD();
        }

        function actualizarProfesor($profesor, $numero, $semblanza, $constancia, $cv, $cedula, $titulo, $ine, $curp, $banco)
		{
			$SQL_Act_Profesor = 
			" 	UPDATE profesor
				SET prof_numero = $numero, prof_semblanza = '$semblanza', prof_constancia = '$constancia', prof_cv = '$cv', prof_cedula = '$cedula', prof_titulo = '$titulo', prof_ine = '$ine', prof_curp = '$curp', prof_banco = '$banco'
			 	WHERE prof_id_prof = $profesor;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Act_Profesor);
			$bd->cerrarBD();
        }

        function eliminarProfesor($profesor)
		{
			$SQL_Eli_Profesor = 
			" 	DELETE FROM profesor
				WHERE prof_id_prof = $profesor;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Eli_Profesor);
			$bd->cerrarBD();
		}
        
        function buscarGruposProfesor($profesor)
		{
			$SQL_Bus_Profesor = 
			"	SELECT grup_id_grup
                FROM grupo
                WHERE grup_id_prof = $profesor;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Profesor);
			$obj_Profesor = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

        function buscarTodosProfesores()
        {
            $SQL_Bus_Profesores =
            "	SELECT pers_id_pers, prof_id_prof, pers_nombre, pers_primer_ape, pers_segundo_ape, corr_direccion, tele_numero
                FROM persona, correo, telefono, profesor
                WHERE pers_id_pers = prof_id_pers AND pers_id_pers = corr_id_pers AND pers_id_pers = tele_id_pers AND corr_tipo = 1 AND tele_tipo = 3
                GROUP BY pers_id_pers, prof_id_prof, pers_nombre, pers_primer_ape, pers_segundo_ape, corr_direccion, tele_numero
                ORDER BY prof_id_prof ASC;
            ";
    
                $bd = new BD();
                $bd->abrirBD();
                $transaccion_1 = new Transaccion($bd->conexion);
                $transaccion_1->enviarQuery($SQL_Bus_Profesores);
                $bd->cerrarBD();
                return ($transaccion_1->traerRegistros());
        }

		function buscarUltimo()
		{
			$bd = new BD();
			$SQL_Bus_Profesor_Seq = "SELECT last_value FROM profesor_prof_id_prof_seq;";

			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Profesor_Seq);
			$obj_Profesor_Seq = $transaccion_1->traerObjeto(0);
			$Profesor_Seq = $obj_Profesor_Seq->last_value;
			$bd->cerrarBD();

			return $Profesor_Seq;
		}

		function buscarProfesoresActivos(){
			$SQL_Bus_Profesores =
            "	
				SELECT PROF_ID_PROFESOR, PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
				FROM Profesor P, Persona A
				WHERE A.PERS_ID_PERSONA=P.PERS_ID_PERSONA
				ORDER BY PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
            ";
    
                $bd = new BD();
                $bd->abrirBD();
                $transaccion_1 = new Transaccion($bd->conexion);
                $transaccion_1->enviarQuery($SQL_Bus_Profesores);
                $bd->cerrarBD();
                return ($transaccion_1->traerRegistros());
		}
    }
?>