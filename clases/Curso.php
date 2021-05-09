<?php
    class Curso {
        // Esta función Busca un Curso y obtiene un objeto con ID, Nombre y Número de sesiones
        function buscarCurso($id) {
            $SQL_Bus_Curso =
            "   SELECT CURS_ID_CURSOS, CURS_NOMBRE, CURS_TIPO, CURS_NUM_SESIONES, CURS_ACTIVO, CURS_NIVEL, CURS_REQ_TECNICOS, CURS_CONOCIMIENTOS, CURS_OBJETIVOS
                FROM CURSO
                WHERE CURS_ID_CURSOS = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Curso);
            $obj_Curso = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        function buscarNumSesiones($id) {
            $SQL_Bus_Curso =
            "   SELECT CURS_NUM_SESIONES
                FROM CURSO
                WHERE CURS_ID_CURSOS = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Curso);
            $obj_Curso = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        function buscarTodosCursos()
		{
			$SQL_Bus_cursos =
			"	SELECT DISTINCT curs_id_cursos,curs_nombre, curs_tipo, curs_nivel, curs_num_sesiones, curs_activo
				FROM curso;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_cursos);
			$bd->cerrarBD();
			return ($transaccion_1->traerRegistros());
		}

        function modificarEstatus($curso, $estatus)
		{
			$SQL_Curso_Est="
			UPDATE Curso
			SET curs_activo = $estatus
			WHERE curs_id_cursos = $curso";


			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Curso_Est);
			$bd->cerrarBD();
		}

        function actualizarCurso($curso, $tipo, $nombre, $num_sesiones, $req_tecnicos, $conocimientos, $nivel, $objetivo, $temario, $activo)
        {
            $SQL_Act_Curso=
			"
                UPDATE Curso   
                SET CURS_TIPO=$tipo, CURS_NOMBRE=$nombre, CURS_NUM_SESIONES=$num_sesiones, 
                CURS_REQ_TECNICOS=$req_tecnicos, CURS_CONOCIMIENTOS=$conocimientos, CURS_NIVEL=$nivel, 
                CURS_OBJETIVOS=$objetivo, CURS_TEMARIO=$temario, CURS_ACTIVO=$activo
                WHERE curs_id_cursos = $curso;
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
            "   INSERT INTO Curso (curs_tipo, curs_nombre, curs_num_sesiones, curs_req_tecnicos, curs_conocimientos, curs_nivel, curs_objetivos, curs_temario, curs_activo)
                VALUES ($tipo, $nombre, $sesiones, $tecnicos, $conocimientos, $nivel, $objetivos, $temario, $activo);
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Curso);
            $bd->cerrarBD();

        }
    
    }
?>