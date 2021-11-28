<?php
//? Clase verificada en la BD 04/10/2021
class Moderador
{
    //Eliminar un moderador dado el id de una persona
    function eliminarModerador($persona)
    {
        $SQL_Eli_Moderador =
        "
          DELETE FROM MODERADOR_DIA
          WHERE MODI_ID_MODERADOR = (SELECT MODI_ID_MODERADOR
                                    FROM HORARIO_MODERADOR, USUARIO
                                    WHERE MODE_ID_USUARIO = USUA_ID_USUARIO AND USUA_ID_ROL = 3
                                        AND USUA_ID_PERSONA = $persona);
          DELETE FROM HORARIO_MODERADOR
          WHERE MODE_ID_MODERADOR = (SELECT MODE_ID_MODERADOR
                                    FROM HORARIO_MODERADOR, USUARIO
                                    WHERE MODE_ID_USUARIO = USUA_ID_USUARIO AND USUA_ID_ROL = 3
                                        AND USUA_ID_PERSONA = $persona);
        ";


        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Eli_Moderador);
        $bd->cerrarBD();
    }

    //Buscar un Servidor Social dado el id de una persona
    function buscarServidorSocial($persona)
    {
        $SQL_Bus_Moderador =
        "	
        SELECT DISTINCT SESO_ID_SERVIDOR, SESO_ID_PERSONA, SESO_NUM_CUENTA
        FROM SERVIDOR_SOCIAL
        WHERE SESO_ID_PERSONA = $persona
			";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Moderador);
            $obj_Persona = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
    }

    //Buscar un Servidor Social dado el numero de cuenta de una persona
    function buscarServidorSocialNumCuenta($numCuenta)
    {
            $SQL_Bus_Moderador =
            "	
        SELECT DISTINCT seso_id_servidor, pers_id_persona, seso_num_cuenta
        FROM Servidor_Social
        WHERE seso_num_cuenta = '$numCuenta'
			";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Moderador);
            $obj_Persona = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
    }
    
    //Buscar datos de un moderador dado el ID persona
    function buscarModerador($persona)
    {
        $SQL_Bus_Moderador =
        "	
        SELECT DISTINCT MODE_ID_MODERADOR, MODE_FECHA_INICIO, MODE_FECHA_FIN, MODE_HORA_INICIO, MODE_HORA_FIN
        FROM HORARIO_MODERADOR, USUARIO 
        WHERE MODE_ID_USUARIO = USUA_ID_USUARIO AND USUA_ID_PERSONA = $persona
			";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Moderador);
            $obj_Persona = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
    }

    //Buscar los días (id y nombre) de un moderador dado el id del moderador
    function buscarModeradorDias($persona)
    {
        $SQL_Bus_Moderador =
        "	
        SELECT DISTINCT DIA_ID_DIA , DIA_NOMBRE
        FROM USUARIO U
          INNER JOIN HORARIO_MODERADOR ON USUA_ID_USUARIO = MODE_ID_USUARIO
          INNER JOIN MODERADOR_DIA ON MODE_ID_MODERADOR = MODI_ID_MODERADOR
          INNER JOIN DIA ON MODI_ID_DIA = DIA_ID_DIA
        WHERE USUA_ID_PERSONA = $persona
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Moderador);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Buscar todos los moderadores activos
    function buscarModeradoresActivos()
    {
        $SQL_Buscar_Moderador =
        "
          SELECT DISTINCT USUA_ID_USUARIO USR_MODERADOR, MODE_ID_MODERADOR, PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
          FROM HORARIO_MODERADOR HM, USUARIO U, PERSONA P
          WHERE MODE_ID_USUARIO = USUA_ID_USUARIO AND USUA_ID_PERSONA = PERS_ID_PERSONA AND USUA_ID_ROL = 3
              AND USUA_ACTIVO = 'TRUE'
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Buscar_Moderador);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Agregar un moderador
    function agregarModerador($persona, $fechaInicio, $fechaFin, $horaInicio, $horaFin)
    {

        $SQL_REGISTRO_MODERADOR =
        "
        INSERT INTO HORARIO_MODERADOR (MODE_ID_USUARIO, MODE_FECHA_INICIO, MODE_FECHA_FIN, MODE_HORA_INICIO, MODE_HORA_FIN)
        VALUES ($persona, '$fechaInicio', '$fechaFin', '$horaInicio', '$horaFin');
      ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_REGISTRO_MODERADOR);
        $bd->cerrarBD();
    }

    //Agrega un servidor social
    function agregarServidor($persona, $seso_num_cuenta)
    {

        $SQL_REGISTRO_MODERADOR =
        "
        INSERT INTO SERVIDOR_SOCIAL (SESO_ID_PERSONA, SESO_NUM_CUENTA)
        VALUES ($persona, '$seso_num_cuenta');
      ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_REGISTRO_MODERADOR);
        $bd->cerrarBD();
    }
    
    //Agregar los días de un moderador
    function agregarDiasModerador($persona, $dia)
    {

        $SQL_REGISTRO_DIA_MODERADOR =
        "
        INSERT INTO MODERADOR_DIA (MODI_ID_MODERADOR, MODI_ID_DIA) VALUES ((SELECT MODE_ID_MODERADOR
        FROM HORARIO_MODERADOR, USUARIO, PERSONA
        WHERE MODE_ID_USUARIO = USUA_ID_USUARIO AND USUA_ID_PERSONA = PERS_ID_PERSONA AND USUA_ID_ROL = 3 AND PERS_ID_PERSONA = $persona), $dia)
      ";
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_REGISTRO_DIA_MODERADOR);
        $bd->cerrarBD();
    }

    //Actualiza los datos de un servidor social
    function actualizarServidor($persona, $seso_num_cuenta)
    {

        $SQL_ACTUALIZACION_SERVIDOR =
        "
        UPDATE SERVIDOR_SOCIAL
        SET SESO_NUM_CUENTA = '$seso_num_cuenta' 
        WHERE SESO_ID_PERSONA = $persona
      ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_ACTUALIZACION_SERVIDOR);
        $bd->cerrarBD();
    }

    //Actualiza todos los datos de un moderador dado el id
    function actualizarModerador($persona, $fechaInicio, $fechaFin, $horaInicio, $horaFin)
    {

      //? Validamos si ya tiene otro registro
        $SQL_VALIDACION_MODERADOR =
        "
      SELECT *
      FROM HORARIO_MODERADOR
      WHERE MODE_ID_USUARIO = (SELECT USUA_ID_USUARIO
                              FROM USUARIO, PERSONA
                              WHERE USUA_ID_PERSONA = PERS_ID_PERSONA AND USUA_ID_ROL = 3 AND PERS_ID_PERSONA = $persona)
      ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_VALIDACION_MODERADOR);
        $existe = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();

        if ($existe != null) {
            $SQL_ACTUALIZACION_MODERADOR =
            "
          UPDATE HORARIO_MODERADOR 
          SET MODE_FECHA_INICIO= '$fechaInicio', MODE_FECHA_FIN= '$fechaFin', MODE_HORA_INICIO= '$horaInicio', MODE_HORA_FIN= '$horaFin'
          WHERE MODE_ID_USUARIO = (SELECT USUA_ID_USUARIO
                                    FROM USUARIO, PERSONA 
                                    WHERE USUA_ID_PERSONA = PERS_ID_PERSONA AND USUA_ID_ROL = 3 AND PERS_ID_PERSONA = $persona)
        ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_ACTUALIZACION_MODERADOR);
            $bd->cerrarBD();
        } else {
            $this->agregarModerador($persona, $fechaInicio, $fechaFin, $horaInicio, $horaFin);
        }
    }

    //Elimina los días de un moderador dado el id del moderador
    function eliminarDiasModerador($persona)
    {
      
        $SQL_BORRAR_DIAS_MODERADOR=
        "
        DELETE FROM MODERADOR_DIA
        WHERE MODI_ID_MODERADOR = (SELECT MODE_ID_MODERADOR
                                  FROM HORARIO_MODERADOR, USUARIO, PERSONA
                                  WHERE MODE_ID_USUARIO = USUA_ID_USUARIO AND USUA_ID_PERSONA = PERS_ID_PERSONA AND USUA_ID_ROL = 3 AND PERS_ID_PERSONA = $persona);
      ";
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_BORRAR_DIAS_MODERADOR);
        $bd->cerrarBD();
    }

    //Busca el nombre del moderador dado el id de moderador
    function buscarModeradorNombre($id)
    {
        $SQL_Bus_Moderador =
        " 
        SELECT DISTINCT PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
        FROM HORARIO_MODERADOR, USUARIO, PERSONA
        WHERE MODE_ID_USUARIO = USUA_ID_USUARIO AND USUA_ID_PERSONA = PERS_ID_PERSONA AND USUA_ID_ROL = 3 AND MODE_ID_MODERADOR = $id
      ";

        $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Moderador);
            $obj_Usuario = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
    }

    //? Verificado  en la BD 07/07/2021
    function buscarModeradorIDUsuario($id)
    {
        $SQL_Bus_Moderador =
        "	SELECT PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO, USUA_ID_USUARIO
        FROM USUARIO, PERSONA 
        WHERE USUA_ID_PERSONA = PERS_ID_PERSONA 
          AND USUA_ID_ROL = 3 
          AND USUA_ID_USUARIO = $id	
			";

        $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Moderador);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
    }
}
