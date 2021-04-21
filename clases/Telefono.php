<?php

  class Telefono
  {
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

    function eliminarTelefono($persona)
    {
      $SQL_Eli_Telefono= 
			" DELETE FROM telefono
				WHERE tele_id_pers = $persona;
			";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Eli_Telefono);
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
		}
  }
?>
