<?php
    //? Clase verificada en la BD 04/10/2021
    class Inscripcion
    {
        //? Agrega una observación la cual se describe en la toma de asistencias
        function agregarObservaciones ($inscripcion , $observacion) {
            $SQL_Ins_Ins =
            "UPDATE INSCRIPCION
                SET INSC_OBSERVACION = '$observacion'
                WHERE INSC_ID_INSCRIPCION = $inscripcion;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Ins);
            $bd->cerrarBD();
        }
        
        //Registrar una inscripción
        function agregarInscripcion($grupo, $profesor, $constancia)
        {
            /*Se modifico esta función borrando la sub-consulta para hacer más eficiente el programa y ahorrarse esa sub-consulta por cada ejecución de la función*/
            $SQL_Ins_Ins =
            "INSERT INTO INSCRIPCION(INSC_ID_GRUPO, INSC_ID_PROFESOR, INSC_ACTIVO, INSC_ID_CONSTANCIA)
                VALUES ($grupo, $profesor, true, $constancia);

                UPDATE GRUPO
                SET GRUP_NUM_INSCRITOS =  GRUP_NUM_INSCRITOS + 1
                WHERE GRUP_ID_GRUPO = $grupo
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Ins);
            $bd->cerrarBD();
        }

        //Busca el ultimo valor registrado
        function buscarUltimo()
        {
            $bd = new BD();
            $SQL_Bus_Inscripcion_Seq = 
                "
                    SELECT last_value
                    FROM inscripcion_insc_id_inscripcion_seq;
                ";

            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Inscripcion_Seq);
            $obj_Inscripcion_Seq = $transaccion_1->traerObjeto(0);
            $Inscripcion_Seq = $obj_Inscripcion_Seq->last_value;
            $bd->cerrarBD();

            return $Inscripcion_Seq;
        }

        //Buscar una inscripción dado el id del grupo y del profesor
        function buscarInscripcion($grupo, $profesor)
        {
            $SQL_Bus_Inscripcion =
			"SELECT INSC_ID_INSCRIPCION, INSC_ID_CONSTANCIA, INSC_ID_GRUPO, INSC_ID_PROFESOR, INSC_ACTIVO
                FROM INSCRIPCION
                WHERE INSC_ID_GRUPO = $grupo AND INSC_ID_PROFESOR = $profesor
            ";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Inscripcion);
			$obj_Inscripcion = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return $obj_Inscripcion;
        }

        //? Busca todos los valores de una inscripcion mediante su id
        function buscarInscripcionId($inscripcion)
        {
            $SQL_Bus_Inscripcion =
			"SELECT INSC_ID_INSCRIPCION, INSC_ID_CONSTANCIA, INSC_ID_GRUPO, INSC_ID_PROFESOR, INSC_ACTIVO
                FROM INSCRIPCION
                WHERE INSC_ID_INSCRIPCION = $inscripcion;
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
        function buscarVigenciaInscripcion($grupo)
        {
            $SQL_Bus_Inscripcion =
			"SELECT *
                FROM GRUPO
                WHERE GRUP_ID_GRUPO = $grupo AND CURRENT_DATE >= GRUP_INICIO_INSC AND CURRENT_DATE <= GRUP_FIN_INSC
            ";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Inscripcion);
			$obj_Inscripcion = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return $obj_Inscripcion;
        }

        //Permte cancelar la inscripción de un profesor a un grupo, a partir del id del grupo y su id de profesor.
        function cancelarInscripcion($grupo, $profesor)
        {
            $SQL_Canc_Insc = 
            "UPDATE INSCRIPCION
                SET INSC_ACTIVO = FALSE
                WHERE INSC_ID_GRUPO = $grupo AND INSC_ID_PROFESOR = $profesor;
                            
                UPDATE GRUPO
                SET GRUP_NUM_INSCRITOS =  GRUP_NUM_INSCRITOS - 1
                WHERE GRUP_ID_GRUPO = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Canc_Insc);
            $bd->cerrarBD();
        }
    }
?>