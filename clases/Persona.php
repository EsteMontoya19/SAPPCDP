<?php
  class Persona
  {
    function agregarPersona($estudio, $domicilio, $nombre, $primerApellido, $segundoApellido, $nacimiento, $genero)
    {
      if($estudio == NULL)
      {
        $SQL_Ins_Persona =
        " INSERT INTO persona(pers_nombre, pers_primer_ape, pers_segundo_ape)
          VALUES ('$nombre', '$primerApellido', '$segundoApellido');
        ";
      }
      else
      {
        if($domicilio == NULL)
        {
          $SQL_Ins_Persona =
          " INSERT INTO persona(pers_id_estu, pers_nombre, pers_primer_ape, pers_segundo_ape, pers_nacimiento, pers_genero)
    	      VALUES ($estudio, '$nombre', '$primerApellido', '$segundoApellido', '$nacimiento', $genero);
          ";
        }
        else
        {
          $SQL_Ins_Persona =
          " INSERT INTO persona(pers_id_estu, pers_id_domi, pers_nombre, pers_primer_ape, pers_segundo_ape, pers_nacimiento, pers_genero)
    	      VALUES ($estudio, $domicilio, '$nombre', '$primerApellido', '$segundoApellido', '$nacimiento', $genero);
          ";
        }
      }

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
      $SQL_Bus_Persona_Seq = "SELECT last_value FROM persona_pers_id_pers_seq;";

      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Bus_Persona_Seq);
      $obj_Persona_Seq = $transaccion_1->traerObjeto(0);
      $Persona_Seq = $obj_Persona_Seq->last_value;
      $bd->cerrarBD();

      return $Persona_Seq;
    }

    function actualizarPersona($persona, $domicilio, $estudio, $nombre, $primerApellido, $segundoApellido, $nacimiento, $genero)
    {
      if($estudio == NULL)
      {
        $SQL_Act_Persona =
        " UPDATE persona
          SET pers_nombre = '$nombre', pers_primer_ape = '$primerApellido', pers_segundo_ape = '$segundoApellido'
          WHERE pers_id_pers = $persona;
        ";
      }
      else
      {
        if($domicilio == NULL)
        {
          $SQL_Act_Persona =
          " UPDATE persona
            SET pers_id_estu = $estudio, pers_nombre = '$nombre', pers_primer_ape = '$primerApellido', pers_segundo_ape = '$segundoApellido', pers_nacimiento = '$nacimiento', pers_genero = $genero
            WHERE pers_id_pers = $persona;
          ";
        }
        else
        {
          $SQL_Act_Persona =
          " UPDATE persona
            SET pers_id_domi = $domicilio, pers_id_estu = $estudio, pers_nombre = '$nombre', pers_primer_ape = '$primerApellido', pers_segundo_ape = '$segundoApellido', pers_nacimiento = '$nacimiento', pers_genero = $genero
            WHERE pers_id_pers = $persona;
          ";
        }
      }
      
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
				WHERE pers_id_pers = $persona;
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
			"	SELECT pers_id_pers, pers_id_estu, pers_nombre, pers_primer_ape, pers_segundo_ape, pers_nacimiento, pers_genero
				FROM persona
				WHERE pers_id_pers = $persona;
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
