<?php 
    //? Clase verificada en la BD 04/10/2021
    class Nombramiento {
        //Permite buscar todas las coordinaciones y traer sus datos
        function buscarTodosNombramientos()
        {
            $SQL_Bus_Nombramientos = 
            "   
                SELECT NOMB_ID_NOMBRAMIENTO, NOMB_DESCRIPCION 
                FROM NOMBRAMIENTO;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Nombramientos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Permite buscar una coordinación a partir de su id
        function buscarNombramiento($id)
        {
            $SQL_Bus_Nombramiento =
            "   
                SELECT NOMB_ID_NOMBRAMIENTO, NOMB_DESCRIPCION 
                FROM NOMBRAMIENTO
                WHERE NOMB_ID_NOMBRAMIENTO = $id
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Nombramiento);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //Permite buscar una coordinación a partir de su nombre
        function buscarNombramientoNombre($nombre)
        {
            $SQL_Bus_Nombramiento =
            "   
                SELECT NOMB_ID_NOMBRAMIENTO, NOMB_DESCRIPCION 
                FROM NOMBRAMIENTO
                WHERE LOWER(NOMB_DESCRIPCION) = LOWER('$nombre');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Nombramiento);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //Permite agregar un nombramiento nueva
        function agregarNombramiento($descripcion)
        {
            $SQL_Agr_Nombramiento =
            "   
                INSERT INTO NOMBRAMIENTO (NOMB_DESCRIPCION)
                VALUES ('$descripcion');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Agr_Nombramiento);
            $bd->cerrarBD();
        }

        //Permite actualizar una coordinación a partir de su id
        function actualizarNombramiento($id, $nombre)
        {
            $SQL_Act_Nombramiento =
            "   
                UPDATE NOMBRAMIENTO
                SET NOMB_DESCRIPCION = '$nombre'
                WHERE NOMB_ID_NOMBRAMIENTO = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Act_Nombramiento);
            $bd->cerrarBD();
        }
    }
?>
