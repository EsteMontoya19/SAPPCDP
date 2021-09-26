<?php

class Evaluacion {

    //Agregar una pregunta y su respuesta
    //PROP_ID_PREGUNTA_OPCION, PREG_ID_PREGUNTA, OPCI_ID_OPCION, PROP_TIPO
    function agregarPROP($pregunta, $opcion, $tipo)
    {
        $SQL_INS_PROP =
        "
            INSERT INTO PREGUNTA_OPCION (PREG_ID_PREGUNTA, OPCI_ID_OPCION, PROP_TIPO)
			    VALUES ($pregunta, $opcion, '$tipo');
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_INS_PROP);
        $bd->cerrarBD();
    }

    //Actualiza una pregunta y su respuesta
    function actualizarPROP($id, $pregunta, $opcion, $tipo)
    {
        $SQL_UPD_PROP =
        "
            UPDATE PREGUNTA_OPCION
            SET PREG_ID_PREGUNTA = $pregunta, OPCI_ID_OPCION = $opcion, PROP_TIPO = '$tipo' 
            WHERE PROP_ID_PREGUNTA_OPCION = $id
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_UPD_PROP);
        $bd->cerrarBD();
    }

    //Buscar una pregunta y su respuesta dado un ID de PREGRUNTA-OPCION
    function buscarPROPID($id)
    {
        $SQL_BUS_PROP =
        "
            SELECT PROP_ID_PREGUNTA_OPCION, PREG_ID_PREGUNTA, OPCI_ID_OPCION, PROP_TIPO
            FROM PREGUNTA_OPCION
            WHERE PROP_ID_PREGUNTA_OPCION = $id
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PROP);
        $obj_Evaluacion = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Buscar respuestas dado un ID de PREGRUNTA
    function buscarPROPIDPregunta($id)
    {
        $SQL_BUS_PROP =
        "
            SELECT PROP_ID_PREGUNTA_OPCION, PREG_ID_PREGUNTA, OPCI_ID_OPCION, PROP_TIPO
            FROM PREGUNTA_OPCION
            WHERE PREG_ID_PREGUNTA = $id
            ORDER BY PROP_ID_PREGUNTA_OPCION ASC
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PROP);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    //Elimina la relacion que existe entre una pregunta y una respuesta
    function eliminarPROP($id)
    {
        $SQL_DEL_PROP =
        "
            DELETE FROM PREGUNTA_OPCION
            WHERE PROP_ID_PREGUNTA_OPCION = $id
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_DEL_PROP);
        $bd->cerrarBD();
    }
}

?>