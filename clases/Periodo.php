<?php
    class Periodo
    {
        function agregarPeriodo($grupo, $periodo_ini, $periodo_fin, $periodo_tipo)
        {
            $SQL_Ins_Periodo =
            "   INSERT INTO periodo(peri_id_grup, peri_inicio, peri_fin, peri_tipo)
                VALUES ($grupo, '$periodo_ini', '$periodo_fin', $periodo_tipo);
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Periodo);
            $bd->cerrarBD();
        }

        function agregarPeriodoWeb($grupo, $periodo_ini, $periodo_tipo)
        {
            $SQL_Ins_Periodo =
            "   INSERT INTO periodo(peri_id_grup, peri_inicio, peri_tipo)
                VALUES ($grupo, '$periodo_ini', $periodo_tipo);
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Periodo);
            $bd->cerrarBD();
        }

        function actualizarPeriodo($periodo, $fecha_inicio, $fecha_fin)
        {
           $SQL_Actua_Periodo =
            "  UPDATE periodo
                SET peri_inicio = '$fecha_inicio', peri_fin = '$fecha_fin'
                WHERE peri_id_peri = $periodo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Actua_Periodo);
            $bd->cerrarBD();
        }

        function actualizarPeriodoWeb($periodo, $fecha_inicio)
        {
            $SQL_Actua_Periodo =
            "   UPDATE periodo
                SET peri_inicio = '$fecha_inicio'
                WHERE peri_id_peri = $periodo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Actua_Periodo);
            $bd->cerrarBD();
        }

        function eliminarTodosPeriodos($grupo)
        {
            $SQL_Eli_Periodos = 
            " DELETE FROM periodo
              WHERE peri_id_grup = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Eli_Periodos);
            $bd->cerrarBD();
        }

        function buscarPeriodoIns($id)
        {
            $SQL_Bus_Horario =
            "   SELECT peri_id_peri, peri_id_grup, peri_inicio, peri_fin
                FROM periodo
                WHERE peri_id_grup = $id AND peri_tipo = 1;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Horario);
            $obj_Grupo = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }
        function buscarPeriodoCur($id)
        {
            $SQL_Bus_Horario =
            "   SELECT peri_id_peri, peri_id_grup, peri_inicio, peri_fin
                FROM periodo
                WHERE peri_id_grup = $id AND peri_tipo = 2;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Horario);
            $obj_Grupo = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        function buscarPeriodoWeb($id)
        {
            $SQL_Bus_Horario =
            "   SELECT peri_id_peri, peri_id_grup, peri_inicio
                FROM periodo
                WHERE peri_id_grup = $id AND peri_tipo = 2;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Horario);
            $obj_Grupo = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }
    }
?>