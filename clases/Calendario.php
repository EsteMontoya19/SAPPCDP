<?php 
    class Calendario
    {
        //Permite Consultar los dias de inicio y fin de un periodo de asueto académico como semana santa del calendario activo
        //TODO Verificado en la BD
        function consultarAsueto()
        {
            $SQL_Bus_Asueto = 
            "   SELECT cale_inicio_asueto, cale_fin_asueto
                FROM Calendario 
                WHERE cale_activo = true 
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Asueto);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }
        
        //Permite Consultar el inicio del periodo de vacaciones administrativas correspondientes al semestre del calendario activo
        //TODO Verificado en la BD
        function consultarVacacionesAdministrativas()
        {
            $SQL_Bus_Vac_Admin = 
            "   SELECT cale_inicio_admin, cale_fin_admin
                FROM Calendario 
                WHERE cale_activo = true 
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Vac_Admin);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //Permite insertar un dia festivo en la base de datos
        //? Falta completar variable $SQL
        function agregarCalendario($id_calendario, $fecha)
        {

            $SQL_Ins_Calendario = 
            "   INSERT INTO Calendario ()
                VALUES ();
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Calendario);
            $bd->cerrarBD();

        }

        //Permite actualizar un dia festivo en la base de datos
        //? Falta completar variable $SQL
        function actualizarCalendario($id_calendario)
        {

            $SQL_Act_Calendario =
            "   UPDATE Calendario
                SET
                WHERE cale_id_calendario = $id_calendario;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Act_Calendario);
            $bd->cerrarBD();

        }
    }
?>