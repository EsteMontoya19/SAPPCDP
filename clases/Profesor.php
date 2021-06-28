<?php
    class Profesor
    {
		//Buscar un profesor dado el id
		function buscarProfesor($persona)
		{
			$SQL_Bus_Profesor =
			"SELECT P.prof_id_profesor, P.pers_id_persona, P.prof_num_trabajador, P.prof_semblanza, P.prof_rfc, PE.pers_nombre,
					PE.pers_apellido_paterno, PE.pers_apellido_materno
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

		//Buscar los niveles de un profesor dado el id del profesor
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

		//Buscar las modalidades de un profesor dado el id del profesor
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

		//Buscar las coordinaciones de un profesor dado el id del profesor
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

		//Agregar el registro de un profesor
		function agregarProfesor($persona, $numTrabajador, $semblanza, $rfc)
		{
		//Aquí iría una validación pero puede ser que ya se esté haciendo en otra parte
		$SQL_Ins_Profesor =
		" INSERT INTO Profesor (pers_id_persona, prof_num_trabajador, prof_semblanza, prof_rfc) VALUES 
			($persona,'$numTrabajador', '$semblanza', '$rfc');
		";
		
		$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Ins_Profesor);
			$bd->cerrarBD();
		}

		//Agregar el nivel de un profesor dado su id
		function agregarNivelesProfesor($persona, $nivel) {
	
			$SQL_REGISTRO_NIVEL_PROFESOR = 
			  "INSERT INTO Profesor_Nivel (prof_id_profesor, nive_id_nivel) VALUES ((SELECT prof_id_profesor
																					FROM Profesor
																					WHERE pers_id_persona = $persona), $nivel)
			  ";
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_REGISTRO_NIVEL_PROFESOR);
			$bd->cerrarBD();
		}

		//Agregar la modalidad de un profesor dado su id
		function agregarModalidadesProfesor($persona, $modalidad) {
			$SQL_REGISTRO_MODALIDAD_PROFESOR = 
			  "INSERT INTO Profesor_Modalidad (prof_id_profesor, moda_id_modalidad) VALUES ((SELECT prof_id_profesor
																							FROM Profesor
																							WHERE pers_id_persona = $persona), $modalidad)
			  ";
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_REGISTRO_MODALIDAD_PROFESOR);
			$bd->cerrarBD();
		}

		//Agregar la coordinación de un profesor dado su id
		function agregarCoordinacionesProfesor($persona, $coordinacion) {
			$SQL_REGISTRO_COORDINACION_PROFESOR = 
			  "INSERT INTO Profesor_Coordinacion (prof_id_profesor, coor_id_coordinacion) VALUES ((SELECT prof_id_profesor
																									FROM Profesor
																									WHERE pers_id_persona = $persona), $coordinacion)
			  ";
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_REGISTRO_COORDINACION_PROFESOR);
			$bd->cerrarBD();
		}

		//Actualizar el registro de un profesor dado su id
		function actualizarProfesor($persona, $num_trabajador, $semblanza, $rfc)
		{
			//? Validamos si ya tiene otro registro
			$SQL_VALIDACION_PROFESOR = 
			"SELECT *
			FROM Profesor
			WHERE pers_id_persona = $persona";
	
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_VALIDACION_PROFESOR);
			$existe = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();

			if($existe != null) {


				$SQL_Act_Profesor = 
				" 	UPDATE Profesor
					SET prof_num_trabajador = '$num_trabajador', prof_semblanza = '$semblanza', prof_rfc = '$rfc'
					WHERE pers_id_persona = $persona;
				";

				$bd = new BD();
				$bd->abrirBD();
				$transaccion_1 = new Transaccion($bd->conexion);
				$transaccion_1->enviarQuery($SQL_Act_Profesor);
				$bd->cerrarBD();
			} else {
				$this->agregarProfesor($persona, $num_trabajador, $semblanza, $rfc);
			}
        }

		//Eliminar el registro de un profesor dado el id de una persona
		function eliminarNivelesProfesor ($persona) {
        
			$SQL_BORRAR_NIVELES_PROFESOR= 
			"DELETE FROM Profesor_Nivel
			 WHERE prof_id_profesor = (SELECT prof_id_profesor
										FROM Profesor
										WHERE pers_id_persona = $persona);
			";
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_BORRAR_NIVELES_PROFESOR);
			$bd->cerrarBD();
		}

		//Eliminar la modalidad de un profesor dado su id
		function eliminarModalidadesProfesor ($persona) {
        
			$SQL_BORRAR_MODALIDADES_PROFESOR= 
			"DELETE FROM Profesor_Modalidad
			 WHERE prof_id_profesor = (SELECT prof_id_profesor
										FROM Profesor
										WHERE pers_id_persona = $persona);
			";
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_BORRAR_MODALIDADES_PROFESOR);
			$bd->cerrarBD();
		}

		//Eliminar la coordinación de un profesor dado su id
		function eliminarCoordinacionesProfesor ($persona) {
        
			$SQL_BORRAR_COORDINACIONES_PROFESOR= 
			"DELETE FROM Profesor_Coordinacion
			 WHERE prof_id_profesor = (SELECT prof_id_profesor
										FROM Profesor
										WHERE pers_id_persona = $persona);
			";
			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_BORRAR_COORDINACIONES_PROFESOR);
			$bd->cerrarBD();
		}

		//Eliminar el registro de un profesor dado el id del profesor
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
        
		//Buscar todos los grupos que imparte un profesor 
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

		//Buscar datos de todos los profesores
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

		//Buscar el último profesor registrado
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

		//buscar todos los profesores activos
		function buscarProfesoresActivos(){
			$SQL_Bus_Profesores =
            "	
				SELECT DISTINCT PROF_ID_PROFESOR, PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
				FROM Profesor P, Persona A, Usuario U
				WHERE A.PERS_ID_PERSONA=P.PERS_ID_PERSONA AND U.PERS_ID_PERSONA=P.PERS_ID_PERSONA AND USUA_ACTIVO = TRUE
				ORDER BY PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
            ";
    
                $bd = new BD();
                $bd->abrirBD();
                $transaccion_1 = new Transaccion($bd->conexion);
                $transaccion_1->enviarQuery($SQL_Bus_Profesores);
                $bd->cerrarBD();
                return ($transaccion_1->traerRegistros());
		}

		//buscar los datos de un profesor dado el número de trabajador
		function buscarNumTrabajador ($numTrabajador) {

			$SQL_Bus_Profesor = 
			"SELECT prof_id_profesor, pers_id_persona, prof_num_trabajador, prof_semblanza, prof_rfc
			 FROM Profesor
			 WHERE prof_num_trabajador = '$numTrabajador'
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Profesor);
			$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

		//Busca el nombre del profesor dado el id de profesor
		function buscarProfesorNombre($id){
			$SQL_Bus_Profesor = 
			"	
				SELECT DISTINCT PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
				FROM Profesor P, Persona PE
				WHERE P.PERS_ID_PERSONA=PE.PERS_ID_PERSONA AND PROF_ID_PROFESOR = $id
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Profesor);
			$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}
    }
?>