<?php 
    //? Clase verificada en la BD 04/10/2021
    class Festivo
    {
        //Permite Consultar todos los dias festivos de un calendario 
        function buscarDiasFestivos($id_calendario)
        {
            $SQL_Bus_Festivos = 
            "   
                SELECT DIFE_ID_DIA_FESTIVO, DIFE_FECHA
                FROM DIA_FESTIVO
                WHERE DIFE_ID_CALENDARIO = $id_calendario 
                ORDER BY DIFE_ID_DIA_FESTIVO ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Festivos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        
        //Permite Consultar todos los dias festivos del calendario activo
        function buscarDiasFestivosActivos()
        {
            $SQL_Bus_Festivos = 
            "   
                SELECT DIFE_ID_DIA_FESTIVO, DIFE_FECHA
                FROM DIA_FESTIVO, CALENDARIO
                WHERE DIFE_ID_CALENDARIO = CALE_ID_CALENDARIO AND CALE_ACTIVO = TRUE
                ORDER BY DIFE_ID_DIA_FESTIVO ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Festivos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Permite insertar un dia festivo en la base de datos
        function agregarDiaFestivo($id_calendario, $fecha)
        {

            $SQL_Ins_Dia_Festivo = 
            "   
                INSERT INTO DIA_FESTIVO (DIFE_ID_CALENDARIO, DIFE_FECHA)
                VALUES ('$id_calendario', '$fecha');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Dia_Festivo);
            $bd->cerrarBD();

        }

        //Permite actualizar un dia festivo en la base de datos
        function actualizarDiaFestivo($id_dia_festivo, $id_calendario, $fecha)
        {

            $SQL_Act_Dia_Festivo = 
            "   
                UPDATE DIA_FESTIVO
                SET DIFE_ID_CALENDARIO = $id_calendario, DIFE_FECHA = $fecha
                WHERE DIFE_ID_DIA_FESTIVO = $id_dia_festivo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Act_Dia_Festivo);
            $bd->cerrarBD();

        }
    }
?>