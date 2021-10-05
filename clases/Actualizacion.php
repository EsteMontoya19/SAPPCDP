<?php
    //? Clase actualizada a las reglas de los prefijos 04/10/21

    class Actualizacion
    {
        //? Funciones para lso cambios de estado automaticos
        function buscarConstanciasVencidas() {
            $SQL_Bus_Constancias =
            "SELECT * 
            FROM Constancia C
            WHERE current_date >= C.cons_fecha + interval '1year' 
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Constancias);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        function buscarCursosPorCancelarAutogestivos() {
            $SQL_Bus_Grupo =
            "SELECT G.grup_id_grupo, MIN(sesi_fecha) AS primer_sesion, sesi_hora_fin
            FROM Grupo G, Curso C, Sesion S
            WHERE G.grup_id_curso = C.curs_id_curso AND 
                  S.sesi_id_grupo = G.grup_id_grupo AND 
                  G.grup_id_modalidad = 3  AND
                  G.grup_num_inscritos <= 5 AND grup_id_estado = 3
            GROUP BY G.grup_id_grupo, sesi_hora_fin
            HAVING MIN(sesi_fecha) <= current_date  
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        function buscarCursosPorCancelarEnLinea() {
            $SQL_Bus_Grupo =
            "SELECT G.grup_id_grupo, MIN(sesi_fecha) AS primer_sesion, sesi_hora_fin
            FROM Grupo G, Curso C, Sesion S
            WHERE G.grup_id_curso = C.curs_id_curso AND 
                  S.sesi_id_grupo = G.grup_id_grupo AND 
                  G.grup_id_modalidad = 2  AND
                  G.grup_num_inscritos <= 2 AND grup_id_estado = 3
            GROUP BY G.grup_id_grupo, sesi_hora_fin
            HAVING MIN(sesi_fecha) <= current_date 
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        function buscarCursosPorCancelarPresencial() {
            $SQL_Bus_Grupo =
            "SELECT G.grup_id_grupo, MIN(sesi_fecha) AS primer_sesion, sesi_hora_fin
            FROM Grupo G, Curso C, Sesion S
            WHERE G.grup_id_curso = C.curs_id_curso AND 
                  S.sesi_id_grupo = G.grup_id_grupo AND 
                  G.grup_id_modalidad = 1  AND
                  G.grup_num_inscritos <= 10 AND grup_id_estado = 3
            GROUP BY G.grup_id_grupo, sesi_hora_fin
            HAVING MIN(sesi_fecha) <= current_date
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        function buscarCursosCancelados () {
            $SQL_Bus_Grupo =
            "SELECT * 
            FROM Grupo 
            WHERE grup_id_estado = 1 AND grup_publicado = 'TRUE';
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        function buscarCursosFinalizados () {
            $SQL_Bus_Grupo =
            "SELECT * 
            FROM Grupo 
            WHERE grup_id_estado = 4 AND grup_publicado = 'TRUE';
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        function buscarCursosEnCurso () {
            $SQL_Bus_Grupo =
            "SELECT G.grup_id_grupo, MAX(sesi_fecha) AS fecha_fin, sesi_hora_fin
            FROM Grupo G, Curso C, Sesion S
            WHERE G.grup_id_curso = C.curs_id_curso
                AND S.sesi_id_grupo = G.grup_id_grupo
                AND G.grup_id_estado = 2
            GROUP BY G.grup_id_grupo, sesi_hora_fin
            HAVING MAX(sesi_fecha) <= current_date AND sesi_hora_fin <= current_time
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //? Funciones para lso cambios de estado automaticos
        function buscarCursosPendientes () {
            $SQL_Bus_Grupo =
            "SELECT G.grup_id_grupo, MIN(sesi_fecha) AS fecha_inicio, sesi_hora_inicio
            FROM Grupo G, Curso C, Sesion S
            WHERE G.grup_id_curso = C.curs_id_curso
                AND S.sesi_id_grupo = G.grup_id_grupo
                AND G.grup_id_estado = 3
            GROUP BY G.grup_id_grupo, sesi_hora_inicio
            HAVING MIN(sesi_fecha) <= current_date AND sesi_hora_inicio <= current_time
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //? Funcion que permite actualizar los estados de un grupo
        function actualizarEstadoGrupo ($grupo, $estado) {
            $SQL_Bus_Grupo =
            "UPDATE Grupo
             SET  grup_id_estado = $estado,
             WHERE grup_id_grupo = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $bd->cerrarBD();
        }
    }
?>