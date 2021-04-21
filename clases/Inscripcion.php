<?php
    class Inscripcion
    {
        function agregarInscripcion($persona, $grupo, $estatus_ins, $fecha)
        {
            $SQL_Ins_Ins =
            "   INSERT INTO inscripcion(insc_id_grup, insc_id_esin, insc_id_pers, insc_fecha_inicio)
                VALUES ($grupo, $estatus_ins, $persona, '$fecha');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Ins);
            $bd->cerrarBD();
        }

        function actualizarInscripcion($inscripcion, $tipo)
        {
            $SQL_Actu_Ins =
            "   UPDATE inscripcion SET insc_id_esin = $tipo WHERE insc_id_insc = $inscripcion;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Actu_Ins);
            $bd->cerrarBD();
        }

        function eliminarInscripcion($persona, $grupo)
        {
            $SQL_Eli_Ins = 
            "   DELETE FROM inscripcion
                WHERE insc_id_pers = $persona AND insc_id_grup = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Eli_Ins);
            $bd->cerrarBD();
        }

        function eliminarInscripciones($persona)
        {
            $SQL_Eli_Ins = 
            " DELETE FROM inscripcion
            WHERE insc_id_pers = $persona;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Eli_Ins);
            $bd->cerrarBD();
        }

        function buscarInscripcion($persona, $grupo)
        {
            $SQL_Bus_Ins = 
            "   SELECT insc_id_insc, insc_id_grup, insc_id_pers
                FROM inscripcion
                WHERE insc_id_pers = $persona AND insc_id_grup = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Ins);
            $obj_Usuario = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
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