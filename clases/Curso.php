<?php
    class Curso {
        // Esta función Busca un Curso y obtiene un objeto con ID, Nombre y Número de sesiones
        function buscarCurso($id) {
            $SQL_Bus_Curso =
            "   SELECT CURS_ID_CURSOS, CURS_NOMBRE, CURS_NUM_SESIONES
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
    }
?>