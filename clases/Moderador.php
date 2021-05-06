<?php
  class Moderador
  {

    function eliminarModerador($persona)
    {
      
      $SQL_Eli_Moderador = 
        "DELETE FROM Moderador_Dia
        WHERE mode_id_monitor = (SELECT mode_id_monitor
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

    function buscarModeradoresActivos(){
      $SQL_Buscar_Moderador = 
        "
          SELECT DISTINCT MODE_ID_MODERADOR, PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
          FROM Moderador M, Persona P, Usuario U
          WHERE M.PERS_ID_PERSONA=P.PERS_ID_PERSONA AND USUA_ACTIVO = 'TRUE'
          ORDER BY PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
        ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Buscar_Moderador);
      $bd->cerrarBD();
      return ($transaccion_1->traerRegistros());
    }

      function agregarModerador ($persona, $numCuenta, $fechaInicio, $fechaFin, $horaInicio, $horaFin, $dias) {

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

      function agregarDiasModerador($dia) {
        
        $ULTIMA_PERSONA = 
          "SELECT last_value FROM moderador_mode_id_moderador_seq
          "; 

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($ULTIMA_PERSONA);
        $obj_Moderador_Seq = $transaccion_1->traerObjeto(0);
        $id_moderador = $obj_Moderador_Seq->last_value;
        $bd->cerrarBD();

        $SQL_REGISTRO_DIA_MODERADOR = 
          "INSERT INTO Moderador_Dia (mode_id_moderador, dia_id_dia) VALUES ($id_moderador, $dia)
          ";
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_REGISTRO_DIA_MODERADOR);
        $bd->cerrarBD();
      }
    }
    
    //TODO: Adaptar demas funciones a Moderador
  
  
    /*
    function agregarTelefono($persona, $tipo, $telefono)
    {
      $SQL_Ins_Telefono =
      " INSERT INTO telefono (tele_id_pers, tele_tipo, tele_numero)
        VALUES ($persona, $tipo, '$telefono');
      ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Ins_Telefono);
      $bd->cerrarBD();
    }

    function actualizarTelefono($persona, $tipo, $telefono)
    {
      $SQL_Act_Telefono =
      " UPDATE telefono
        SET tele_numero = '$telefono'
        WHERE tele_id_pers = $persona AND tele_tipo = $tipo;
      ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Act_Telefono);
      $bd->cerrarBD();
    }

    function buscarTelefono($persona, $tipo)
		{
			$SQL_Bus_Telefono = 
			"	SELECT tele_id_tele, tele_tipo, tele_numero
				FROM telefono
				WHERE tele_id_pers = $persona AND tele_tipo = $tipo;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Telefono);
			$obj_Telefono = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}*/ 

    
    

    ?>

  

