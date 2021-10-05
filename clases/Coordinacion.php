<?php 
    //? Clase actualizada a las reglas de los prefijos 05/10/21

    class Coordinacion{
        //? Permite buscar todas las coordinaciones y traer sus datos
        function buscarTodasCoordinaciones()
        {
            $SQL_Bus_Coordinaciones = 
            "   SELECT coor_id_coordinacion, coor_nombre 
                FROM Coordinacion;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Coordinaciones);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //? Permite buscar una coordinación a partir de su id
        function buscarCoordinacion($id)
        {
            $SQL_Bus_Coordinacion =
            "   SELECT coor_id_coordinacion, coor_nombre 
                FROM Coordinacion
                WHERE coor_id_coordinacion = $id
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Coordinacion);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //? Permite buscar una coordinación a partir de su nombre
        function buscarCoordinacionNombre($nombre)
        {
            $SQL_Bus_Coordinacion =
            "   SELECT coor_id_coordinacion, coor_nombre 
                FROM Coordinacion
                WHERE LOWER(coor_nombre) = LOWER('$nombre');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Coordinacion);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //? Permite agregar una coordinación nueva
        function agregarCoordinacion($id)
        {
            $SQL_Agr_Coordinacion =
            "   INSERT INTO Coordinacion (coor_nombre)
                VALUES ('$id');
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Agr_Coordinacion);
            $bd->cerrarBD();
        }

        //? Permite actualizar una coordinación a partir de su id
        function actualizarCoordinacion($id, $nombre)
        {
            $SQL_Act_Coordinacion =
            "   UPDATE Coordinacion
                SET coor_nombre = '$nombre'
                WHERE coor_id_coordinacion = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Act_Coordinacion);
            $bd->cerrarBD();
        }
    }
?>