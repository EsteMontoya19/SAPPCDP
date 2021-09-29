<?php 

class Opcion
{

    //Agrega una opcion
    function agregarOpcion($opcion)
    {
        $SQL_INS_OPCION =
        "
            INSERT INTO OPCION (OPCI_DESCRIPCION)
			VALUES ('$opcion');
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_INS_OPCION);
        $bd->cerrarBD();
    }

    //Actualiza una opcion
    function actualizarOpcion($id, $opcion)
    {
        $SQL_UPD_OPCION =
        "
            UPDATE OPCION
            SET OPCI_DESCRIPCION = '$opcion'
            WHERE OPCI_ID_OPCION = $id
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_UPD_OPCION);
        $bd->cerrarBD();
    }

    //Busca una opcion dado su ID
    function buscarOpcionID($id)
    {
        $SQL_BUS_OPCION =
        "
            SELECT OPCI_ID_OPCION, OPCI_DESCRIPCION
            FROM OPCION
            WHERE OPCI_ID_OPCION = $id
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_OPCION);
        $obj_Opcion = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Busca la ultima opcion registrada
    function buscarUltimo()
    {
        $bd = new BD();
        
        $SQL_BUS_OPCION =
        "
            SELECT last_value FROM opcion_opci_id_opcion_seq;
		";
        
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_OPCION);
        
        $obj_Pregunta_Seq = $transaccion_1->traerObjeto(0);
        $pregunta_Seq = $obj_Pregunta_Seq->last_value;
        $bd->cerrarBD();

        return $pregunta_Seq;
    }

    //Elimina una opcion dado su ID
    function eliminarOpcion($id)
    {

        $SQL_DEL_OPCION =
        "
            DELETE FROM OPCION
            WHERE OPCI_ID_OPCION = $id
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_DEL_OPCION);
        $bd->cerrarBD();
    }

}

?>