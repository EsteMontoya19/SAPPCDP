<?php

class Pregunta
{
    //Agrega una pregunta, con los atributos descripción y activo
    //! El valor nulo en la columna «preg_orden» de la relación «pregunta» viola la restricción de no nulo
    function agregarPregunta($pregunta, $activo, $orden, $tipo)
    {
        $SQL_INS_PREGUNTA =
        "
            INSERT INTO PREGUNTA (PREG_DESCRIPCION, PREG_ACTIVO, PREG_ORDEN, PREG_TIPO)
			    VALUES ('$pregunta', '$activo', $orden, '$tipo');
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_INS_PREGUNTA);
        $bd->cerrarBD();
    }

    //Actualiza la descripción de una pregunta dado su ID
    function actualizarPregunta($id, $pregunta, $orden)
    {
        $SQL_UPD_PREGUNTA =
        "
            UPDATE PREGUNTA
            SET PREG_DESCRIPCION = '$pregunta', PREG_ORDEN = $orden
            WHERE PREG_ID_PREGUNTA = $id
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_UPD_PREGUNTA);
        $bd->cerrarBD();
    }

    //Actualiza la descripción de una pregunta dado su ID
    function actualizarDescripcionPregunta($id, $pregunta)
    {
        $SQL_UPD_PREGUNTA =
        "
            UPDATE PREGUNTA
            SET PREG_DESCRIPCION = '$pregunta'
            WHERE PREG_ID_PREGUNTA = $id
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_UPD_PREGUNTA);
        $bd->cerrarBD();
    }

    //Actualiza el activo de una pregunta dado su ID
    function actualizarActivoPregunta($id, $activo, $orden)
    {
        $SQL_UPD_PREGUNTA =
        "
            UPDATE PREGUNTA
            SET PREG_ACTIVO = '$activo', PREG_ORDEN = $orden
            WHERE PREG_ID_PREGUNTA = $id
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_UPD_PREGUNTA);
        $bd->cerrarBD();
    }

    //Actualiza el orden de una pregunta dado su ID
    function actualizarOrdenPregunta($id, $orden)
    {
        $SQL_UPD_PREGUNTA =
        "
            UPDATE PREGUNTA
            SET PREG_ORDEN = $orden
            WHERE PREG_ID_PREGUNTA = $id
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_UPD_PREGUNTA);
        $bd->cerrarBD();
    }

    //Busca todas las preguntas
    function buscarPreguntas()
    {
        $SQL_BUS_PREGUNTA =
        "
            SELECT PREG_ID_PREGUNTA, PREG_DESCRIPCION, PREG_ACTIVO, PREG_TIPO, PREG_ORDEN
            FROM PREGUNTA
            ORDER BY PREG_ID_PREGUNTA ASC
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PREGUNTA);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    //Busca una pregunta dado su ID
    function buscarPreguntaID($id)
    {
        $SQL_BUS_PREGUNTA =
        "
            SELECT PREG_ID_PREGUNTA, PREG_DESCRIPCION, PREG_ACTIVO, PREG_ORDEN, PREG_TIPO
            FROM PREGUNTA
            WHERE PREG_ID_PREGUNTA = $id
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PREGUNTA);
        $obj_Opcion = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Busca preguntas activas
    function buscarPreguntasActivas()
    {
        $SQL_BUS_PREGUNTA =
        "
            SELECT PREG_ID_PREGUNTA, PREG_DESCRIPCION, PREG_ACTIVO, PREG_TIPO, PREG_ORDEN
            FROM PREGUNTA
            WHERE PREG_ACTIVO = 'TRUE'
            ORDER BY PREG_ORDEN ASC
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PREGUNTA);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    //Busca el ultimo registrp agregado a la tabla Pregunta
    function buscarUltimo()
    {
        $bd = new BD();

        $SQL_BUS_PREGUNTA =
        "
            SELECT last_value FROM pregunta_preg_id_pregunta_seq; 
        ";

        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PREGUNTA);
        
        $obj_Pregunta_Seq = $transaccion_1->traerObjeto(0);
        $pregunta_Seq = $obj_Pregunta_Seq->last_value;
        $bd->cerrarBD();

        return $pregunta_Seq;
    }

    //Busca el maximo dentro del orden
    function buscarUltimoOrden()
    {
        $SQL_BUS_PREGUNTA =
        "
            SELECT MAX(PREG_ORDEN) ultimo FROM PREGUNTA
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PREGUNTA);
        $obj_Opcion = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Elimina una pregunta dado su ID
    function eliminarPregunta($id)
    {

        $SQL_DEL_PREGUNTA =
        "
            DELETE FROM PREGUNTA 
            WHERE PREG_ID_PREGUNTA  = $id
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_DEL_PREGUNTA);
        $bd->cerrarBD();
    }
}
