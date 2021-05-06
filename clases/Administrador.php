<?php
  class Administrador
  {


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

      if(isset($existe != null)) {
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
    
    //TODO: Adaptar demas funciones a Administrador

    /*
    function buscarUltimo()
    {
      $bd = new BD();
      $SQL_Bus_Persona_Seq = "SELECT last_value FROM persona_pers_id_persona_seq;"; //Que hace este last_value

      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Bus_Persona_Seq);
      $obj_Persona_Seq = $transaccion_1->traerObjeto(0);
      $Persona_Seq = $obj_Persona_Seq->last_value;
      $bd->cerrarBD();

      return $Persona_Seq;
    }

    function actualizarPersona($persona, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono)
    {

      $SQL_Act_Persona =
      " UPDATE persona
        SET pers_nombre = '$nombre', pers_apellido_paterno = '$apellidoPaterno', pers_apellido_materno = '$apellidoMaterno', pers_correo = '$correo', pers_telefono = '$telefono'
        WHERE pers_id_persona = $persona;
      ";
    
      
      $bd = new BD();
  		$bd->abrirBD();
  		$transaccion_1 = new Transaccion($bd->conexion);
  		$transaccion_1->enviarQuery($SQL_Act_Persona);
  		$bd->cerrarBD();
  		$this->id_persona = Persona::buscarUltimo();
    }

    function eliminarPersona($persona)
    {
      $SQL_Eli_Persona= 
			" DELETE FROM persona
				WHERE pers_id_persona = $persona;
			";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Eli_Persona);
      $bd->cerrarBD();
    }*/
  }
?>
