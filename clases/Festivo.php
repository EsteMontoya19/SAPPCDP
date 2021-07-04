<?php 
    class Festivo
    {
        //Permite Consultar todos los dias festivos de un calendario 
        //TODO Verificado en la BD 02/07/2021
        function buscarDiasFestivos($id_calendario)
        {
            $SQL_Bus_Festivos = 
            "   SELECT dife_id_dia_festivo, dife_fecha
                FROM dia_festivo
                WHERE cale_id_calendario = $id_calendario 
                ORDER BY dife_id_dia_festivo ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Festivos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        
        //Permite Consultar todos los dias festivos del calendario activo
        //TODO Verificado en la BD 02/07/2021
        function buscarDiasFestivosActivos()
        {
            $SQL_Bus_Festivos = 
            "   SELECT dife_id_dia_festivo, dife_fecha
                FROM dia_festivo d, calendario c 
                WHERE d.cale_id_calendario =  c.cale_id_calendario AND cale_activo = true
                ORDER BY dife_id_dia_festivo ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Festivos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Permite insertar un dia festivo en la base de datos
        //TODO Verificado en la BD 02/07/2021
        function agregarDiaFestivo($id_calendario, $fecha)
        {

            $SQL_Ins_Dia_Festivo = 
            "   INSERT INTO dia_festivo (cale_id_calendario, dife_fecha)
                VALUES ('$id_calendario', '$fecha');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Dia_Festivo);
            $bd->cerrarBD();

        }

        //Permite actualizar un dia festivo en la base de datos
        //TODO Verificado en la BD 02/07/2021
        function actualizarDiaFestivo($id_dia_festivo, $id_calendario, $fecha)
        {

            $SQL_Act_Dia_Festivo = 
            "   UPDATE dia_festivo
                SET cale_id_calendario = $id_calendario, dife_fecha = $fecha)
                WHERE dife_id_dia_festivo = $id_dia_festivo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Act_Dia_Festivo);
            $bd->cerrarBD();

        }
    }
?>