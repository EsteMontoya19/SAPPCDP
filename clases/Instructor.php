<?php
	//? Clase verificada  en la BD 04/10/2021
    class Instructor
    {
		//Buscar un Instructor dado el id
		function buscarInstructor($persona)
		{
			$SQL_Bus_Instructor =
			"
				SELECT PROF_ID_PROFESOR, PROF_ID_PERSONA, PROF_NUM_TRABAJADOR, 
					PROF_SEMBLANZA, PERS_RFC, PERS_NOMBRE,
					PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
				FROM PROFESOR, PERSONA
				WHERE PROF_ID_PERSONA = PERS_ID_PERSONA AND PROF_ID_PERSONA = $persona
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
        function buscarGruposInstructor($instructor)
		{
			$SQL_Bus_Instructor = 
			"	
				SELECT PEGR_ID_GRUPO
				FROM PERSONAL_GRUPO, USUARIO, PERSONA, PROFESOR
				WHERE PEGR_ID_USUARIO = USUA_ID_USUARIO AND USUA_ID_PERSONA = PERS_ID_PERSONA AND
					PERS_ID_PERSONA = PROF_ID_PERSONA AND USUA_ID_ROL = 2 AND PROF_ID_PROFESOR = $instructor
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
		function buscarInstructoresActivos(){
			$SQL_Bus_Instructores =
            "	
				SELECT DISTINCT USUA_ID_USUARIO USR_INSTRUCTOR, PROF_ID_PROFESOR, PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
				FROM USUARIO, PERSONA, PROFESOR
				WHERE USUA_ID_PERSONA = PERS_ID_PERSONA AND PERS_ID_PERSONA = PROF_ID_PERSONA 
					AND USUA_ID_ROL = 2 AND USUA_ACTIVO = TRUE
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
		function buscarInstructorNombre($id){
			$SQL_Bus_Instructor = 
			"	
			SELECT DISTINCT PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
			FROM PROFESOR, PERSONA 
			WHERE PROF_ID_PERSONA = PERS_ID_PERSONA AND PROF_ID_PROFESOR = $id
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