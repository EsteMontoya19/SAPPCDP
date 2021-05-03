<?php
    class Curso {
        // Esta función Busca un Curso y obtiene un arreglo con ID, Nombre Tipo y Número de sesiones
        function buscarCurso() {
            $SQL_Bus_Curso =
            "   SELECT CURS_ID_CURSOS, CURS_NOMBRE, CURS_TIPO, CURS_NUM_SESIONES
                FROM CURSO
                ORDER BY CURS_NOMBRE ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Curso);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
    }
?>