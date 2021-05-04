<?php
    class Horario
    {
        function agregarHorario($dia, $salon, $grupo, $hora_inicio, $hora_fin)
        {
            $SQL_Ins_Horario =
            "   INSERT INTO horario_grupo(hogr_id_dia, hogr_id_salo, hogr_id_grup, hogr_hora_inicio, hogr_hora_fin)
                VALUES ($dia, $salon, $grupo, '$hora_inicio', '$hora_fin');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Horario);
            $bd->cerrarBD();
        }
        function buscarTodosHorarios($id)
        {
            $SQL_Bus_Horario =
            "   SELECT hogr_id_hogr, hogr_id_dia, hogr_id_salo, hogr_hora_inicio, hogr_hora_fin
                FROM dia, salon, horario_grupo, grupo 
                WHERE dia_id_dia = hogr_id_dia AND salo_id_salon = hogr_id_salon AND hogr_id_grup = $id
                GROUP BY hogr_id_hogr, hogr_id_dia, hogr_id_salo, hogr_hora_inicio, hogr_hora_fin
                ORDER BY hogr_id_dia;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Horario);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        function buscarHorarioWeb($id)
        {
            $SQL_Bus_Horario =
            "   SELECT hogr_id_hogr, hogr_id_dia, hogr_id_salo, hogr_hora_inicio, hogr_hora_fin
                FROM dia, salon, horario_grupo, grupo 
                WHERE dia_id_dia = hogr_id_dia AND salo_id_salon = hogr_id_salon AND hogr_id_grup = $id
                GROUP BY hogr_id_hogr, hogr_id_dia, hogr_id_salo, hogr_hora_inicio, hogr_hora_fin
                ORDER BY hogr_id_dia;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Horario);
            $obj_Horario = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        function actualizarHorario($horario, $dia, $salon, $hora_inicio, $hora_fin)
        {
            $SQL_Actua_Horario =
            "   UPDATE horario_grupo
                SET hogr_id_dia = $dia, hogr_id_salo = $salon, hogr_hora_inicio = '$hora_inicio', hogr_hora_fin = '$hora_fin'
                WHERE hogr_id_hogr = $horario;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Actua_Horario);
            $bd->cerrarBD();
        }

        function eliminarHorario($horario)
        {
            $SQL_Eli_Horario = 
            " DELETE FROM horario_grupo
              WHERE hogr_id_hogr = $horario;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Eli_Horario);
            $bd->cerrarBD();
        }

        function eliminarTodosHorario($grupo)
        {
            $SQL_Eli_Horarios = 
            " DELETE FROM horario_grupo
              WHERE hogr_id_grup = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Eli_Horarios);
            $bd->cerrarBD();
        }
    }
?>