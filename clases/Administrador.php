<?php
  class Administrador
  {
    //Buscar los datos de un administrador dado el id
    function buscarAdministrador($persona)
		{
			$SQL_Bus_Administrador = 
			"	SELECT A.admi_id_administrador, A.pers_id_persona, A.admi_num_trabajador, A.admi_rfc
        FROM Administrador A, Persona P
        WHERE A.pers_id_persona = $persona
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Administrador);
			$obj_Persona = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

    //Agregar un administrador
    function agregarAdministrador($persona, $num_trabajador, $rfc)
    {
      //Aquí iría una validación pero puede ser que ya se esté haciendo en otra parte
      $SQL_Ins_Administrador =
      " INSERT INTO Administrador (pers_id_persona, admi_num_trabajador, admi_rfc)
        VALUES ($persona, '$num_trabajador', '$rfc');
      ";
      
      $bd = new BD();
  		$bd->abrirBD();
  		$transaccion_1 = new Transaccion($bd->conexion);
  		$transaccion_1->enviarQuery($SQL_Ins_Administrador);
  		$bd->cerrarBD();
    }

    //Actualizar todos los datos de un administrador dado el id
    function actualizarAdministrador($persona, $num_trabajador, $rfc)
		{
      //? Validamos si ya tiene otro registro
      $SQL_VALIDACION_ADMINISTRADOR = 
      "SELECT *
       FROM administrador
       WHERE pers_id_persona = $persona";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_VALIDACION_ADMINISTRADOR);
      $existe = $transaccion_1->traerObjeto(0);
      $bd->cerrarBD();

      if($existe != null) {
        $SQL_Act_Usuario= 
        " UPDATE Administrador
          SET admi_num_trabajador = '$num_trabajador' , admi_rfc= '$rfc'
          WHERE pers_id_persona = $persona;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Usuario);
        $bd->cerrarBD();
      } else {
        $this->agregarAdministrador($persona, $num_trabajador, $rfc);
      }
		}    

    //Buscar todos los administradores activos
    function administradoresActivos () {
      $SQL_Bus_Administrador = 
			"SELECT COUNT (A.admi_id_administrador)
       FROM Administrador A, Persona P, Usuario U
       WHERE A.pers_id_persona = P.pers_id_persona AND P.pers_id_persona = U.pers_id_persona AND U.usua_activo = TRUE
       GROUP BY A.admi_id_administrador
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Administrador);
			$obj_Persona = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();

			return ($obj_Persona->count);
    }
  }
?>
