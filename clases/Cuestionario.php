<?php

class Cuestionario {

    //? Agregar una pregunta y su respuesta
    //PROP_ID_PREGUNTA_OPCION, PREG_ID_PREGUNTA, OPCI_ID_OPCION, PROP_TIPO
    function agregarPROP($pregunta, $opcion)
    {
        $SQL_INS_PROP =
        "INSERT INTO PREGUNTA_OPCION (PROP_ID_PREGUNTA, PROP_ID_OPCION)
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
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Buscar respuestas dado un ID de PREGRUNTA
    function buscarPROPIDPregunta($id)
    {
        $SQL_BUS_PROP =
        "SELECT PROP_ID_PREGUNTA_OPCION, PROP_ID_PREGUNTA, PROP_ID_OPCION, OPCI_DESCRIPCION
            FROM PREGUNTA_OPCION, OPCION
            WHERE PROP_ID_OPCION = OPCI_ID_OPCION AND PROP_ID_PREGUNTA = $id
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
         WHERE PROP_ID_PREGUNTA = $id
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

    //? Busca las respuesta de opción multiple registradas en una pregunta
    function buscarOpcionesPregunta($pregunta) {
        $SQL_BUS_PROP =
        "SELECT prop_id_opcion, prop_id_pregunta, opci_descripcion
         FROM Pregunta_Opcion, Opcion
         WHERE prop_id_opcion = opci_id_opcion AND prop_id_pregunta = $pregunta
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PROP);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

        

    function buscarNumeroRespuestasIDPROP($id)
    {

        $SQL_BUS_PROP = 
        "
            SELECT COUNT(*) numero
            FROM RESPUESTA, PREGUNTA_OPCION
            WHERE PROP_ID_PREGUNTA_OPCION = RESP_ID_PREGUNTA_OPCION AND PROP_ID_PREGUNTA = $id
        ";
        
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_PROP);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Busca el ID de las preguntas que se respondieron en un grupo
    function buscarCuestionarioGrupo($id)
    {

        $SQL_BUS_CUESTIONARIO =
        "SELECT PREG_ID_PREGUNTA, PREG_DESCRIPCION, PREG_TIPO, COUNT(PREG_ID_PREGUNTA) CANTIDAD
            FROM PREGUNTA, PREGUNTA_OPCION, RESPUESTA, INSCRIPCION
            WHERE 	PROP_ID_PREGUNTA = PREG_ID_PREGUNTA
                AND PROP_ID_PREGUNTA_OPCION = RESP_ID_PREGUNTA_OPCION
                AND RESP_ID_INSCRIPCION = INSC_ID_INSCRIPCION
                AND INSC_ID_GRUPO = $id
            GROUP BY PREG_ID_PREGUNTA
            ORDER BY PREG_ID_PREGUNTA
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_CUESTIONARIO);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    //? Registra una respuesta, primero en pregunta opcion y despues directo en la tabla de respuesta
    function registrarRespuesta ($inscripcion, $pregunta, $opcion, $texto) {

        if($opcion == "null" ) {

        $SQL_BUS_RESPUESTA =
            "SELECT prop_id_pregunta_opcion, prop_id_pregunta, prop_id_opcion 
            FROM pregunta_opcion
            WHERE prop_id_pregunta = $pregunta AND prop_id_opcion is null
            ";
        } else {
            $SQL_BUS_RESPUESTA =
                "SELECT prop_id_pregunta_opcion, prop_id_pregunta, prop_id_opcion 
                FROM pregunta_opcion
                WHERE prop_id_pregunta = $pregunta AND prop_id_opcion = $opcion
                ";
        }

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_RESPUESTA);
        $opcionPregunta = $transaccion_1->traerObjeto(0)->prop_id_pregunta_opcion;
        $bd->cerrarBD();
        
        $SQL_BUS_RESPUESTA =
            "INSERT INTO Respuesta (resp_id_inscripcion, resp_id_pregunta_opcion, resp_texto) 
                VALUES ($inscripcion , $opcionPregunta, '$texto') ;

            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_RESPUESTA);
        $bd->cerrarBD();
    }

    //? Busca las respuestas que ha tenido una pregunta dado su ID
    function buscarRespuestasPregunta($id, $idPregunta)
    {

        $SQL_BUS_PREGUNTA =
        "SELECT PROP_ID_OPCION, COUNT(PROP_ID_OPCION) CANTIDAD
            FROM PREGUNTA, PREGUNTA_OPCION, RESPUESTA, INSCRIPCION
            WHERE 	PROP_ID_PREGUNTA = PREG_ID_PREGUNTA
                AND PROP_ID_PREGUNTA_OPCION = RESP_ID_PREGUNTA_OPCION
                AND RESP_ID_INSCRIPCION = INSC_ID_INSCRIPCION
                AND INSC_ID_GRUPO = $id
                AND PREG_ID_PREGUNTA = $idPregunta
            GROUP BY PROP_ID_OPCION
            ORDER BY PROP_ID_OPCION
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        
        $transaccion_1->enviarQuery($SQL_BUS_PREGUNTA);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    //? BUSCA LAS RESPUESTAS ABIERTAS DADO UN ID DE PREGUNTA
    function buscarRespuestaTexto($idGrupo, $idPregunta)
    {
        $SQL_BUS_RESPUESTA = 
        "
            SELECT RESP_TEXTO 
            FROM RESPUESTA, PREGUNTA_OPCION, INSCRIPCION
            WHERE RESP_ID_PREGUNTA_OPCION = PROP_ID_PREGUNTA_OPCION
                AND RESP_ID_INSCRIPCION = INSC_ID_INSCRIPCION
                AND RESP_TEXTO IS NOT NULL
                AND PROP_ID_PREGUNTA = $idPregunta
                AND INSC_ID_GRUPO = $idGrupo
            ORDER BY RESP_ID_INSCRIPCION
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_RESPUESTA);
        $bd->cerrarBD();

        return ($transaccion_1->traerRegistros(0));
    }

    //? BUSCA LAS RESPUESTAS ABIERTAS DADO UN ID DE PREGUNTA
    function buscarRespuestaTextoSi($idGrupo, $idPregunta)
    {
        $SQL_BUS_RESPUESTA = 
        "
            SELECT RESP_TEXTO 
            FROM RESPUESTA, PREGUNTA_OPCION, INSCRIPCION
            WHERE RESP_ID_PREGUNTA_OPCION = PROP_ID_PREGUNTA_OPCION
                AND RESP_ID_INSCRIPCION = INSC_ID_INSCRIPCION
                AND RESP_TEXTO IS NOT NULL
                AND PROP_ID_OPCION = 1
                AND PROP_ID_PREGUNTA = $idPregunta
                AND INSC_ID_GRUPO = $idGrupo
            ORDER BY RESP_ID_INSCRIPCION
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_RESPUESTA);
        $bd->cerrarBD();

        return ($transaccion_1->traerRegistros(0));
    }

    function buscarRespuestaTextoNo($idGrupo, $idPregunta)
    {
        $SQL_BUS_RESPUESTA = 
        "
            SELECT RESP_TEXTO 
            FROM RESPUESTA, PREGUNTA_OPCION, INSCRIPCION
            WHERE RESP_ID_PREGUNTA_OPCION = PROP_ID_PREGUNTA_OPCION
                AND RESP_ID_INSCRIPCION = INSC_ID_INSCRIPCION
                AND RESP_TEXTO IS NOT NULL
                AND PROP_ID_OPCION = 2
                AND PROP_ID_PREGUNTA = $idPregunta
                AND INSC_ID_GRUPO = $idGrupo
            ORDER BY RESP_ID_INSCRIPCION
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BUS_RESPUESTA);
        $bd->cerrarBD();

        return ($transaccion_1->traerRegistros(0));
    }


}

?>