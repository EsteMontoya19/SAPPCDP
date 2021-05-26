<?php
    class Inscripcion
    {
        function agregarInscripcion($grupo, $profesor)
        {
            $SQL_Ins_Ins =
            "INSERT INTO Inscripcion(grup_id_grupo, prof_id_profesor)
             VALUES ($grupo, $profesor);

             UPDATE Grupo 
             SET grup_num_inscritos = (SELECT grup_num_inscritos 
						               FROM Grupo
						               WHERE grup_id_grupo = $grupo) + 1
             WHERE grup_id_grupo = $grupo
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Ins);
            $bd->cerrarBD();
        }

        function buscarInscripcion($grupo, $profesor)
        {
            $SQL_Bus_Inscripcion = 
			"SELECT insc_id_inscripcion, cons_id_constancias, grup_id_grupo, prof_id_profesor
             FROM inscripcion
             WHERE grup_id_grupo = $grupo AND prof_id_profesor = $profesor
            ";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Inscripcion);
			$obj_Inscripcion = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return $obj_Inscripcion;
        }

        function buscarGrupoPorInsc($inscripcion)
        {
            $SQL_Bus_Ins = 
            "   SELECT insc_id_grup
                FROM inscripcion
                WHERE insc_id_insc = $inscripcion
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Ins);
            $obj_Usuario = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        function numeroAlumnos($grupo)
        {
            $SQL_Bus_numAlum = 
            "   SELECT COUNT(*) AS numeroAlumnos
                FROM inscripcion
                WHERE insc_id_grup = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_numAlum);
            $obj_Usuario = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }
    }
?>