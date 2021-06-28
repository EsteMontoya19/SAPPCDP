<?php
  class Moderador
  {
    //Eliminar un moderador dado el id de una persona
    function eliminarModerador($persona)
    {
      
      $SQL_Eli_Moderador = 
        "DELETE FROM Moderador_Dia
        WHERE mode_id_moderador = (SELECT mode_id_moderador
                                 FROM Moderador
                                 WHERE pers_id_persona = $persona);
        DELETE FROM Moderador
        WHERE pers_id_persona = $persona;
        ";


      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Eli_Moderador);
      $bd->cerrarBD();
    }

    //Buscar un moderador dado el id de una persona
    function buscarModerador($persona)
		{
			$SQL_Bus_Moderador = 
			"	SELECT DISTINCT M.mode_id_moderador, M.mode_num_cuenta, M.pers_id_persona, M.mode_fecha_inicio, M.mode_fecha_fin, M.mode_hora_inicio, M.mode_hora_fin
        FROM Moderador M, Persona P
        WHERE M.pers_id_persona = $persona
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
    function buscarModeradorDias($moderador)
		{
			$SQL_Bus_Moderador = 
			"	SELECT DISTINCT D.dia_id_dia, D.dia_nombre
        FROM Dia D, Moderador_Dia MD, Moderador M
        WHERE MD.mode_id_moderador = $moderador AND MD.dia_id_dia = D.dia_id_dia
			";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Bus_Moderador);
      $bd->cerrarBD();
      return ($transaccion_1->traerRegistros());
		}

    //Buscar todos los moderadores activos
    function buscarModeradoresActivos(){
      $SQL_Buscar_Moderador = 
        "
          SELECT DISTINCT MODE_ID_MODERADOR, PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
          FROM Moderador M, Persona P, Usuario U
          WHERE M.PERS_ID_PERSONA=P.PERS_ID_PERSONA AND U.PERS_ID_PERSONA=P.PERS_ID_PERSONA AND USUA_ACTIVO = 'TRUE'
          ORDER BY PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
        ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Buscar_Moderador);
      $bd->cerrarBD();
      return ($transaccion_1->traerRegistros());
    }

    //Agregar un moderador
    function agregarModerador ($persona, $numCuenta, $fechaInicio, $fechaFin, $horaInicio, $horaFin) {

      $SQL_REGISTRO_MODERADOR = 
      "INSERT INTO Moderador (pers_id_persona, mode_num_cuenta, mode_fecha_inicio, mode_fecha_fin, mode_hora_inicio, mode_hora_fin)
        VALUES ($persona, '$numCuenta', '$fechaInicio', '$fechaFin', '$horaInicio', '$horaFin');
      ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_REGISTRO_MODERADOR);
      $bd->cerrarBD();
    }
    
    //Agregar los días de un moderador
    function agregarDiasModerador($persona, $dia) {

      $SQL_REGISTRO_DIA_MODERADOR = 
        "INSERT INTO Moderador_Dia (mode_id_moderador, dia_id_dia) VALUES ((SELECT mode_id_moderador
                                                                            FROM Moderador
                                                                            WHERE pers_id_persona = $persona), $dia)
        ";
      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_REGISTRO_DIA_MODERADOR);
      $bd->cerrarBD();
    }

    //Actualiza todos los datos de un moderador dado el id
    function actualizarModerador ($persona, $numCuenta, $fechaInicio, $fechaFin, $horaInicio, $horaFin) {

      //? Validamos si ya tiene otro registro
      $SQL_VALIDACION_MODERADOR = 
      "SELECT *
      FROM Moderador
      WHERE pers_id_persona = $persona";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_VALIDACION_MODERADOR);
      $existe = $transaccion_1->traerObjeto(0);
      $bd->cerrarBD();

      if($existe != null) {

      $SQL_ACTUALIZACION_MODERADOR = 
        "UPDATE Moderador 
          SET mode_num_cuenta= '$numCuenta', mode_fecha_inicio= '$fechaInicio', mode_fecha_fin= '$fechaFin', mode_hora_inicio= '$horaInicio', mode_hora_fin= '$horaFin'
          WHERE pers_id_persona = $persona
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_ACTUALIZACION_MODERADOR);
        $bd->cerrarBD();
      } else {
        $this->agregarModerador($persona, $numCuenta, $fechaInicio, $fechaFin, $horaInicio, $horaFin);
      }
    }

    //Elimina los días de un moderador dado el id del moderador
    function eliminarDiasModerador ($persona) {
      
      $SQL_BORRAR_DIAS_MODERADOR= 
      "DELETE FROM Moderador_Dia
        WHERE mode_id_moderador = (SELECT mode_id_moderador
                                  FROM Moderador
                                  WHERE pers_id_persona = $persona);
      ";
      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_BORRAR_DIAS_MODERADOR);
      $bd->cerrarBD();
    }

    //Busca el nombre del moderador dado el id de moderador
    function buscarModeradorNombre($id){
			$SQL_Bus_Moderador = 
			"	
        SELECT DISTINCT PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
        FROM Moderador M, Persona P
        WHERE M.PERS_ID_PERSONA=P.PERS_ID_PERSONA AND MODE_ID_MODERADOR = $id
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

  

