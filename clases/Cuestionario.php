<?php

class Cuestionario {

    //? Agregar una pregunta y su respuesta
    //PROP_ID_PREGUNTA_OPCION, PREG_ID_PREGUNTA, OPCI_ID_OPCION, PROP_TIPO
    function agregarPROP($pregunta, $opcion)
    {
        $SQL_INS_PROP =
        "INSERT INTO PREGUNTA_OPCION (PROP_ID_PREGUNTA_OPCION, PROP_ID_OPCION)
		   VALUES ($pregunta, $opcion);
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_INS_PROP);
        $bd->cerrarBD();
    }

    //Actualiza una pregunta y su respuesta
    function actualizarPROP($id, $pregunta, $opcion)
    {
        $SQL_UPD_PROP =
        "UPDATE PREGUNTA_OPCION
         SET PROP_ID_PREGUNTA = $pregunta, PROP_ID_OPCION = $opcion
         WHERE PROP_ID_PREGUNTA_OPCION = $id
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_UPD_PROP);
        $bd->cerrarBD();
    }

    //? Buscar una pregunta y su respuesta dado un ID de PREGRUNTA-OPCION
    function buscarPROPID($id)
    {
        $SQL_BUS_PROP =
        "SELECT PROP_ID_PREGUNTA_OPCION, PROP_ID_PREGUNTA, PROP_ID_OPCION
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

    //? Buscar respuestas dado un ID de PREGRUNTA
    function buscarPROPIDPregunta($id)
    {
        $SQL_BUS_PROP =
        "SELECT PROP_ID_PREGUNTA_OPCION, PROP_ID_PREGUNTA, PROP_ID_OPCION
         FROM PREGUNTA_OPCION
         WHERE PROP_ID_PREGUNTA = $id
         ORDER BY PROP_ID_PREGUNTA_OPCION ASC
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PROP);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    //? Elimina la relacion que existe entre una pregunta y una respuesta
    function eliminarPROP($id)
    {
        $SQL_DEL_PROP =
        "DELETE FROM PREGUNTA_OPCION
         WHERE PROP_ID_PREGUNTA_OPCION = $id
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_DEL_PROP);
        $bd->cerrarBD();
    }

    //? Buscar las preguntas activas a realizar en el cuestionario
    function buscarPreguntasCuestionario()
    {
        $SQL_BUS_PROP =
        "SELECT DISTINCT PREG.PREG_ID_PREGUNTA, PREG.PREG_TIPO, PREG.PREG_DESCRIPCION, PREG_ORDEN
         FROM PREGUNTA_OPCION PROP, PREGUNTA PREG
         WHERE PROP.PROP_ID_PREGUNTA = PREG.PREG_ID_PREGUNTA AND
            PREG.PREG_ACTIVO = TRUE
         ORDER BY PREG.PREG_ORDEN ASC
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PROP);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }
}

?>