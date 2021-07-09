<?php
  class Moderador
  {
    //Eliminar un moderador dado el id de una persona
    //TODO Verificado en la BD 02/07/2021
    function eliminarModerador($persona)
    {
      
      $SQL_Eli_Moderador = 
        "
          DELETE FROM Moderador_Dia
          WHERE mode_id_moderador = (SELECT mode_id_moderador
                    FROM HORARIO_MODERADOR HM, USUARIO U
                    WHERE HM.USUA_ID_USUARIO = U.USUA_ID_USUARIO AND ROL_ID_ROL = 3
                        AND PERS_ID_PERSONA = $persona);
          DELETE FROM HORARIO_MODERADOR
          WHERE mode_id_moderador = (SELECT mode_id_moderador
                    FROM HORARIO_MODERADOR HM, USUARIO U
                    WHERE HM.USUA_ID_USUARIO = U.USUA_ID_USUARIO AND ROL_ID_ROL = 3
                        AND PERS_ID_PERSONA = $persona);
        ";


      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Eli_Moderador);
      $bd->cerrarBD();
    }

    //Buscar un moderador dado el id de una persona
    //TODO Verificado en la BD 02/07/2021
    function buscarServidorSocial($persona)
		{
			$SQL_Bus_Moderador = 
			"	SELECT DISTINCT seso_id_servidor, pers_id_persona, seso_num_cuenta
        FROM Servidor_Social
        WHERE pers_id_persona = $persona
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Moderador);
			$obj_Persona = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

    function buscarModerador($persona)
		{
			$SQL_Bus_Moderador = 
			"	SELECT DISTINCT HM.mode_id_moderador, pers_id_persona, HM.mode_fecha_inicio, HM.mode_fecha_fin, HM.mode_hora_inicio, HM.mode_hora_fin
        FROM Usuario U
        INNER JOIN Horario_Moderador HM ON U.usua_id_usuario = HM.usua_id_usuario
        WHERE pers_id_persona = $persona
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
    //? Verificado en la BD 04/07/2021
    function buscarModeradorDias($persona)
		{
			$SQL_Bus_Moderador = 
			"	SELECT DISTINCT D.dia_id_dia , D.dia_nombre
        FROM Usuario U
        INNER JOIN Horario_Moderador HM ON U.usua_id_usuario = HM.usua_id_usuario
        INNER JOIN Moderador_Dia MD ON HM.mode_id_moderador = MD.mode_id_moderador
        INNER JOIN Dia D ON MD.dia_id_dia = D.dia_id_dia
        WHERE pers_id_persona = $persona
			";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Bus_Moderador);
      $bd->cerrarBD();
      return ($transaccion_1->traerRegistros());
		}

    //Buscar todos los moderadores activos
    //TODO Verificado en la BD 02/07/2021
    function buscarModeradoresActivos(){
      $SQL_Buscar_Moderador = 
        "
          SELECT DISTINCT U.usua_id_usuario usr_moderador, MODE_ID_MODERADOR, PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
          FROM HORARIO_MODERADOR HM, USUARIO U, PERSONA P
          WHERE HM.USUA_ID_USUARIO = U.USUA_ID_USUARIO AND U.PERS_ID_PERSONA = P.PERS_ID_PERSONA AND ROL_ID_ROL = 3
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
    //TODO Verificado en la BD 02/07/2021
    //? Se quitó el campo $numCuenta(número de cuenta)
    function agregarModerador ($persona, $numCuenta, $fechaInicio, $fechaFin, $horaInicio, $horaFin) {

      $SQL_REGISTRO_MODERADOR = 
      "INSERT INTO HORARIO_MODERADOR (usua_id_usuario, mode_fecha_inicio, mode_fecha_fin, mode_hora_inicio, mode_hora_fin)
        VALUES ($persona, '$fechaInicio', '$fechaFin', '$horaInicio', '$horaFin');
      ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_REGISTRO_MODERADOR);
      $bd->cerrarBD();
    }
    
    //Agregar los días de un moderador
    //TODO Verificado en la BD 02/07/2021
    function agregarDiasModerador($persona, $dia) {

      $SQL_REGISTRO_DIA_MODERADOR = 
        "INSERT INTO Moderador_Dia (mode_id_moderador, dia_id_dia) VALUES ((SELECT MODE_ID_MODERADOR
                                                                              FROM HORARIO_MODERADOR HM, USUARIO U, PERSONA P
                                                                              WHERE HM.USUA_ID_USUARIO = U.USUA_ID_USUARIO AND U.PERS_ID_PERSONA = P.PERS_ID_PERSONA AND ROL_ID_ROL = 3 AND P.PERS_ID_PERSONA = $persona), $dia)
        ";
      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_REGISTRO_DIA_MODERADOR);
      $bd->cerrarBD();
    }

    //Actualiza todos los datos de un moderador dado el id
    //TODO Verificado en la BD 02/07/2021
    //? Se cambió pers_id_persona por usua_id_usuario, se quitó mode_num_cuenta
    function actualizarModerador ($persona, $fechaInicio, $fechaFin, $horaInicio, $horaFin) {

      //? Validamos si ya tiene otro registro
      $SQL_VALIDACION_MODERADOR = 
      "
        SELECT *
        FROM HORARIO_MODERADOR
        WHERE usua_id_usuario = (SELECT usua_id_usuario
                                FROM USUARIO U, PERSONA P
                                WHERE U.PERS_ID_PERSONA = P.PERS_ID_PERSONA AND ROL_ID_ROL = 3 AND P.PERS_ID_PERSONA = $persona)
      ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_VALIDACION_MODERADOR);
      $existe = $transaccion_1->traerObjeto(0);
      $bd->cerrarBD();

      if($existe != null) {

      $SQL_ACTUALIZACION_MODERADOR = 
        "
          UPDATE HORARIO_MODERADOR 
          SET mode_fecha_inicio= '$fechaInicio', mode_fecha_fin= '$fechaFin', mode_hora_inicio= '$horaInicio', mode_hora_fin= '$horaFin'
          WHERE usua_id_usuario = (SELECT usua_id_usuario
                                    FROM USUARIO U, PERSONA P
                                    WHERE U.PERS_ID_PERSONA = P.PERS_ID_PERSONA AND ROL_ID_ROL = 3 AND P.PERS_ID_PERSONA = $persona)
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
    //TODO Verificado en la BD 02/07/2021
    function eliminarDiasModerador ($persona) {
      
      $SQL_BORRAR_DIAS_MODERADOR= 
      "DELETE FROM Moderador_Dia
        WHERE mode_id_moderador = (SELECT MODE_ID_MODERADOR
                                    FROM HORARIO_MODERADOR HM, USUARIO U, PERSONA P
                                    WHERE HM.USUA_ID_USUARIO = U.USUA_ID_USUARIO AND U.PERS_ID_PERSONA = P.PERS_ID_PERSONA AND ROL_ID_ROL = 3 AND P.PERS_ID_PERSONA = $persona);
      ";
      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_BORRAR_DIAS_MODERADOR);
      $bd->cerrarBD();
    }

    //Busca el nombre del moderador dado el id de moderador
    //TODO Verificado en la BD 02/07/2021
    function buscarModeradorNombre($id){
			$SQL_Bus_Moderador = 
			"	
        SELECT DISTINCT PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
        FROM HORARIO_MODERADOR HM, USUARIO U, PERSONA P
        WHERE HM.USUA_ID_USUARIO = U.USUA_ID_USUARIO AND U.PERS_ID_PERSONA = P.PERS_ID_PERSONA AND ROL_ID_ROL = 3 AND MODE_ID_MODERADOR = $id
			";

      $bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Moderador);
			$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

    //TODO Verificado en la BD 07/07/2021
    //Buscar Moderador dado el id de usuario
    function buscarModeradorIDUsuario($id){
			$SQL_Bus_Moderador = 
			"	
        SELECT PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
          FROM USUARIO U, PERSONA P
          WHERE U.PERS_ID_PERSONA = P.PERS_ID_PERSONA 
        AND ROL_ID_ROL = 3 
        AND USUA_ID_USUARIO =  $id
			";

      $bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Moderador);
			$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}
  }
?>

  

