<?php
  class Correo
  {
    function agregarCorreo($persona, $tipo, $correo)
    {
      $SQL_Ins_Correo =
      " INSERT INTO correo (corr_id_pers, corr_tipo, corr_direccion)
        VALUES ($persona, $tipo, '$correo');
      ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Ins_Correo);
      $bd->cerrarBD();
    }

    function actualizarCorreo($persona, $tipo, $correo)
    {
      $SQL_Act_Correo =
      " UPDATE correo
        SET corr_direccion = '$correo'
        WHERE corr_id_pers = $persona AND corr_tipo = $tipo;
      ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Act_Correo);
      $bd->cerrarBD();
    }

    function eliminarCorreo($persona)
    {
      $SQL_Eli_Correo= 
			" DELETE FROM correo
				WHERE corr_id_pers = $persona;
			";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Eli_Correo);
      $bd->cerrarBD();
    }

    function buscarCorreo($persona, $tipo)
		{
			$SQL_Bus_Correo = 
			"	SELECT corr_id_corr, corr_tipo, corr_direccion
				FROM correo
				WHERE corr_id_pers = $persona AND corr_tipo = $tipo;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Correo);
			$obj_Correo = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}
  }
?>
