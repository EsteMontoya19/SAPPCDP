<?php
  class Persona
  {
    function agregarPersona($nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono)
    {
      //Aquí iría una validación pero puede ser que ya se esté haciendo en otra parte
      $SQL_Ins_Persona =
      " INSERT INTO Persona (pers_nombre, pers_apellido_paterno, pers_apellido_materno, pers_correo, pers_telefono)
        VALUES ('$nombre', '$apellidoPaterno', '$apellidoMaterno', '$correo', '$telefono');
      ";
      
      $bd = new BD();
  		$bd->abrirBD();
  		$transaccion_1 = new Transaccion($bd->conexion);
  		$transaccion_1->enviarQuery($SQL_Ins_Persona);
  		$bd->cerrarBD();
  		$this->id_persona = Persona::buscarUltimo();
    }

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
    }

    function buscarPersona($persona)
		{
			$SQL_Bus_Persona = 
			"	SELECT pers_id_persona, pers_nombre, pers_apellido_paterno, pers_apellido_materno, pers_correo, pers_telefono
				FROM persona
				WHERE pers_id_persona = $persona;
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Persona);
			$obj_Persona = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}
  }
?>
