<?php 
    class Nombramiento {
        //Permite buscar todas las coordinaciones y traer sus datos
        function buscarTodosNombramientos()
        {
            $SQL_Bus_Nombramientos = 
            "   SELECT nomb_id_nombramiento, nomb_descripcion 
                FROM Nombramiento;
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
            "   SELECT nomb_id_nombramiento, nomb_descripcion 
                FROM Nombramiento
                WHERE nomb_id_nombramiento = $id
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
            "   SELECT nomb_id_nombramiento, nomb_descripcion 
                FROM Nombramiento
                WHERE LOWER(nomb_descripcion) = LOWER('$nombre');
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
            "   INSERT INTO Nombramiento (nomb_descripcion)
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
            "   UPDATE Nombramiento
                SET nomb_descripcion = '$nombre'
                WHERE nomb_id_nombramiento = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Act_Nombramiento);
            $bd->cerrarBD();
        }
    }
?>