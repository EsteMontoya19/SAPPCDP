<?php 

class Pregunta
{
    //Agrega una pregunta, con los atributos descripción y activo
    function agregarPregunta($pregunta, $activo)
    {
        $SQL_INS_PREGUNTA =
        "
            INSERT INTO PREGUNTA (PREG_DESCRIPCION, PREG_ACTIVO)
			    VALUES ('$pregunta', '$activo');
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_INS_PREGUNTA);
        $bd->cerrarBD();
    }

    //Actualiza la descripción de una pregunta dado su ID
    function actualizarPregunta($id, $pregunta)
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
    function actualizarActivoPregunta($id, $activo)
    {
        $SQL_UPD_PREGUNTA =
        "
            UPDATE PREGUNTA
            SET PREG_ACTIVO = '$activo'
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
            SELECT PREG_ID_PREGUNTA, PREG_DESCRIPCION, PREG_ACTIVO
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
            SELECT PREG_ID_PREGUNTA, PREG_DESCRIPCION, PREG_ACTIVO
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
            SELECT PREG_ID_PREGUNTA, PREG_DESCRIPCION, PREG_ACTIVO
            FROM PREGUNTA
            WHERE PREG_ACTIVO = 'TRUE'
            ORDER BY PREG_ID_PREGUNTA ASC
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

    //Elimina una pregunta dado su ID
    function eliminarPregunta($id)
    {   

        $SQL_DEL_CONSTANCIA =
        "
            DELETE FROM PREGUNTA
            WHERE PREG_ID_PREGUNTA = $id
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_DEL_CONSTANCIA);
        $bd->cerrarBD();
    }

}


?>