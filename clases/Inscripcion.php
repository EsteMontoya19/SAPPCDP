<?php
    class Inscripcion
    {
        //Registrar una inscripción
        //TODO Verificado en la BD 04/07/2021
        function agregarInscripcion($grupo, $profesor)
        {
            /*Se modifico esta función borrando la sub-consulta para hacer más eficiente el programa y ahorrarse esa sub-consulta por cada ejecución de la función*/
            $SQL_Ins_Ins =
            "INSERT INTO Inscripcion(grup_id_grupo, prof_id_profesor,insc_activo)
            VALUES ($grupo, $profesor, true);
            UPDATE Grupo
            SET grup_num_inscritos =  grup_num_inscritos + 1
            WHERE grup_id_grupo = $grupo
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Ins);
            $bd->cerrarBD();
        }

        //Buscar una inscripción dado el id del grupo y del profesor
        //TODO Verificado en la BD 04/07/2021
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

        //Busca todos los datos de un grupo dado el id, además de que el día actual se encuentre dentro del rango de fechas de inscripcion.
        //TODO Verificado en la BD 04/07/2021
        function buscarVigenciaInscripcion($grupo)
        {
            $SQL_Bus_Inscripcion =
			"SELECT *
            FROM Grupo
            WHERE grup_id_grupo = $grupo AND CURRENT_DATE >= grup_inicio_insc AND CURRENT_DATE <= grup_fin_insc
            ";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Inscripcion);
			$obj_Inscripcion = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return $obj_Inscripcion;
        }



        //? Ninguno de los siguientes métodos se utiliza actualmente 24/06/2021
        //Busca el id del grupo dado el ID de inscripción
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

        //Cuenta el número de inscripciones que tiene un grupo dado el id.
        //Se deja de utilizar por que se añadió el atributo número de inscritos
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