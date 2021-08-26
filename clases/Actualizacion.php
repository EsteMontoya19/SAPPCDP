<?php
    //? Esta clase se crea para realizar los cambios automaticos.
    class Actualizacion
    {
        //? Funciones para lso cambios de estado automaticos
        function buscarCursosPorCancelarAutogestivos() {
            $SQL_Bus_Grupo =
            "SELECT G.grup_id_grupo, MIN(sesi_fecha) AS primer_sesion, sesi_hora_fin
            FROM Grupo G, Curso C, Sesion S
            WHERE G.curs_id_curso = C.curs_id_curso AND 
                  S.grup_id_grupo = G.grup_id_grupo AND 
                  G.moap_id_modalidad = 3  AND
                  G.grup_num_inscritos <= 5
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
            WHERE G.curs_id_curso = C.curs_id_curso AND 
                  S.grup_id_grupo = G.grup_id_grupo AND 
                  G.moap_id_modalidad = 2  AND
                  G.grup_num_inscritos <= 2
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
            WHERE G.curs_id_curso = C.curs_id_curso AND 
                  S.grup_id_grupo = G.grup_id_grupo AND 
                  G.moap_id_modalidad = 1  AND
                  G.grup_num_inscritos <= 10
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
        function buscarCursosFinalizados () {
            $SQL_Bus_Grupo =
            "SELECT * 
            FROM Grupo 
            WHERE esta_id_estado = 4
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
            WHERE G.curs_id_curso = C.curs_id_curso
                AND S.grup_id_grupo = G.grup_id_grupo
                AND G.esta_id_estado = 2
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
            WHERE G.curs_id_curso = C.curs_id_curso
                AND S.grup_id_grupo = G.grup_id_grupo
                AND G.esta_id_estado = 3
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
             SET  esta_id_estado = $estado,
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