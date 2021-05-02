<?php
  class Moderador
  {

    function eliminarModerador($persona)
    {
      
      $SQL_Eli_Moderador = 
        "DELETE FROM Monitor_Dia
        WHERE moni_id_monitor = (SELECT moni_id_monitor
                                 FROM Monitor
                                 WHERE pers_id_persona = $persona);
        DELETE FROM Monitor
        WHERE pers_id_persona = $persona;
        ";


      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Eli_Moderador);
      $bd->cerrarBD();
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

  }
  
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

  

