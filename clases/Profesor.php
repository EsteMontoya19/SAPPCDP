<?php
    class Profesor
    {
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

        function buscarProfesor($profesor)
		{
			$SQL_Bus_Profesor = 
			"	SELECT prof_id_prof, prof_id_pers, prof_numero, prof_semblanza, prof_constancia, prof_cv, prof_cedula, prof_titulo, prof_ine, prof_curp, prof_banco
				FROM profesor
				WHERE prof_id_prof = $profesor;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Profesor);
			$obj_Profesor = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
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
    }
?>