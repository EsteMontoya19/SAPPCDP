<?php
    class Instructor
    {
		//Buscar un Instructor dado el id
		//? Verificado  en la BD 03/07/2021
    	//? El atributo rfc ahora pertenece a la tabla Persona
		function buscarInstructor($persona)
		{
			$SQL_Bus_Instructor =
			"
				SELECT P.prof_id_profesor, P.pers_id_persona, P.prof_num_trabajador, 
					P.prof_semblanza, PE.pers_rfc, PE.pers_nombre,
					PE.pers_apellido_paterno, PE.pers_apellido_materno
			 	FROM Profesor P, Persona PE
			 	WHERE P.pers_id_persona = PE.pers_id_persona AND P.pers_id_persona = $persona
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Instructor);
			$obj_Instructor = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
        }

		
		//Buscar el id de todos los grupos que imparte un Instructor dado el id de profesor 
		//? Verificado  en la BD 03/07/2021
        function buscarGruposInstructor($instructor)
		{
			$SQL_Bus_Instructor = 
			"	
				SELECT grup_id_grupo
				FROM personal_grupo PG, usuario U, Persona PE, Profesor P
				WHERE PG.usua_id_usuario = U.usua_id_usuario AND U.pers_id_persona = PE.pers_id_persona AND
				PE.pers_id_persona = P.pers_id_persona AND rol_id_rol = 2 AND prof_id_profesor = $instructor
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Instructor);
			$obj_Instructor = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

		//buscar todos los profesores activos
		//? Verificado  en la BD 03/07/2021
		function buscarInstructoresActivos(){
			$SQL_Bus_Instructores =
            "	
				SELECT DISTINCT U.usua_id_usuario usr_instructor, PROF_ID_PROFESOR, PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
				FROM Profesor P, Persona A, Usuario U
				WHERE A.PERS_ID_PERSONA=P.PERS_ID_PERSONA AND U.PERS_ID_PERSONA=P.PERS_ID_PERSONA AND USUA_ACTIVO = TRUE AND ROL_ID_ROL = 2
				ORDER BY PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
            ";
    
                $bd = new BD();
                $bd->abrirBD();
                $transaccion_1 = new Transaccion($bd->conexion);
                $transaccion_1->enviarQuery($SQL_Bus_Instructores);
                $bd->cerrarBD();
                return ($transaccion_1->traerRegistros());
		}

		//Busca el nombre del Instructor dado el id de profesor
		//? Verificado  en la BD 03/07/2021
		function buscarInstructorNombre($id){
			$SQL_Bus_Instructor = 
			"	
				SELECT DISTINCT PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
				FROM Profesor P, Persona PE
				WHERE P.PERS_ID_PERSONA=PE.PERS_ID_PERSONA AND PROF_ID_PROFESOR = $id
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Instructor);
			$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}
    }
?>