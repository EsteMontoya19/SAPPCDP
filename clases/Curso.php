<?php
    //? Verificado que toda la clase funciona en la BD 04/10/2021
    class Curso {
        // Esta función Busca un Curso y obtiene un objeto con ID, Nombre y Número de sesiones
        function buscarCurso($id) {
            $SQL_Bus_Curso =
            "   
                SELECT CURS_ID_CURSO, CURS_NOMBRE, CURS_TIPO, CURS_NUM_SESIONES, CURS_ACTIVO, CURS_NIVEL, CURS_REQ_TECNICOS, CURS_CONOCIMIENTOS, CURS_OBJETIVOS,CURS_TEMARIO
                FROM CURSO
                WHERE CURS_ID_CURSO = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Curso);
            $obj_Curso = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //Busca el número de sesiones de un curso
        function buscarNumSesiones($id) {
            $SQL_Bus_Curso =
            "   
                SELECT CURS_NUM_SESIONES
                FROM CURSO
                WHERE CURS_ID_CURSO = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Curso);
            $obj_Curso = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //Busca todos los datos de un curso dado el nombre, tipo y nivel.
        function buscarCursoNombre($curso, $tipo, $nivel) {
            $SQL_Bus_Curso =
            "   
                SELECT CURS_ID_CURSO, CURS_NOMBRE, CURS_TIPO, CURS_NUM_SESIONES, CURS_ACTIVO, CURS_NIVEL, CURS_REQ_TECNICOS, CURS_CONOCIMIENTOS, CURS_OBJETIVOS,CURS_TEMARIO
                FROM CURSO
                WHERE LOWER(CURS_NOMBRE) = LOWER('$curso') AND LOWER(CURS_TIPO) = LOWER('$tipo') AND LOWER(CURS_NIVEL) = LOWER('$nivel');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Curso);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //Busca todos los cursos 
        function buscarTodosCursos()
		{
			$SQL_Bus_cursos =
			"	
                SELECT DISTINCT CURS_ID_CURSO, CURS_NOMBRE, CURS_TIPO, CURS_NIVEL, CURS_NUM_SESIONES, CURS_ACTIVO
                FROM CURSO;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_cursos);
			$bd->cerrarBD();
			return ($transaccion_1->traerRegistros());
		}

        //Actualiza el estatus de un curso dado el id y el estatus
        function modificarEstatus($curso, $estatus)
		{
			$SQL_Curso_Est=
            "
                UPDATE CURSO
                SET CURS_ACTIVO = $estatus
                WHERE CURS_ID_CURSO = $curso;
            ";


			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Curso_Est);
			$bd->cerrarBD();
		}

        //Actualiza todos los datos de un curso dado el ID así como los demás atributos
        function actualizarCurso($curso, $tipo, $nombre, $num_sesiones, $req_tecnicos, $conocimientos, $nivel, $objetivo, $temario, $activo)
        {
            $SQL_Act_Curso=
			"
                UPDATE CURSO  
                SET CURS_TIPO='$tipo', CURS_NOMBRE='$nombre', CURS_NUM_SESIONES=$num_sesiones, 
                    CURS_REQ_TECNICOS='$req_tecnicos', CURS_CONOCIMIENTOS='$conocimientos', CURS_NIVEL='$nivel', 
                    CURS_OBJETIVOS='$objetivo', CURS_TEMARIO='$temario', CURS_ACTIVO=$activo
                WHERE CURS_ID_CURSO = $curso;
            ";
			
            $bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Act_Curso);
			$bd->cerrarBD();
        }

        //Permite insertar un registro en la base de datos
        function agregarCurso($tipo, $nombre, $sesiones, $tecnicos, $conocimientos, $nivel, $objetivos, $temario, $activo)
        {

            $SQL_Ins_Curso = 
            "   
                INSERT INTO CURSO (CURS_TIPO, CURS_NOMBRE, CURS_NUM_SESIONES, CURS_REQ_TECNICOS, CURS_CONOCIMIENTOS, CURS_NIVEL, CURS_OBJETIVOS, CURS_TEMARIO, CURS_ACTIVO)
                VALUES ('$tipo', '$nombre', $sesiones, '$tecnicos', '$conocimientos', '$nivel', '$objetivos', '$temario', '$activo');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Curso);
            $bd->cerrarBD();

        }
    
    }
    
?>