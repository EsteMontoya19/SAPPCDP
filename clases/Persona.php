<?php
//Registra una persona
//? Verificado en la BD 02/07/2021
//? Se añadió a la tabla el atributo rfc
//? Clase actualizada a las reglas de los prefijos 06/10/21
class Persona
{
    function agregarPersona($nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono, $rfc, $sexo)
    {
      //Aquí iría una validación pero puede ser que ya se esté haciendo en otra parte
        $SQL_Ins_Persona =
        " INSERT INTO Persona (
          pers_nombre,
          pers_apellido_paterno,
          pers_apellido_materno,
          pers_correo,
          pers_telefono,
          pers_sexo,
          pers_rfc)
        VALUES ('$nombre', '$apellidoPaterno', '$apellidoMaterno', '$correo', '$telefono', '$sexo', '$rfc');
      ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Ins_Persona);
        $bd->cerrarBD();
        $this->id_persona = Persona::buscarUltimo(); //? Supongo aqui asigna un atributo
    }

    //Busca el último registro de persona
    //? Verificado en la BD 02/07/2021
    public static function buscarUltimo()
    {
        $bd = new BD();
        $SQL_Bus_Persona_Seq = "
        SELECT last_value
        FROM persona_pers_id_persona_seq;"; //Que hace este last_value : Muestra el ultimo valor ingresado

        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Persona_Seq);
        $obj_Persona_Seq = $transaccion_1->traerObjeto(0);
        $Persona_Seq = $obj_Persona_Seq->last_value;
        $bd->cerrarBD();

        return $Persona_Seq;
    }

    //Actualiza todos los datos de una persona dado el id de la persona
    //? Verificado en la BD 02/07/2021
    //? Se añadió a la tabla el atributo rfc
    function actualizarPersona($persona, $nombre, $apellidoPaterno, $apellidoMaterno, $correo, $telefono, $rfc, $sexo)
    {

        $SQL_Act_Persona =
        "UPDATE Persona
         SET pers_nombre = '$nombre', pers_apellido_paterno = '$apellidoPaterno',
            pers_apellido_materno = '$apellidoMaterno', pers_correo = '$correo',
            pers_telefono = '$telefono', pers_rfc = '$rfc', pers_sexo = '$sexo'
         WHERE pers_id_persona = $persona;
      ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Persona);
        $bd->cerrarBD();
        $this->id_persona = Persona::buscarUltimo();
    }

    //? Se utiliza para actualizar los datos posibles desde la interfaz de Mi Cuenta
    function actualizarPersonaCuenta($persona, $correo, $telefono)
    {

        $SQL_Act_Persona =
        "UPDATE Persona
         SET pers_correo = '$correo', pers_telefono = '$telefono'
         WHERE pers_id_persona = $persona;
      ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Persona);
        $bd->cerrarBD();
        $this->id_persona = Persona::buscarUltimo();
    }

    //Elimina el registro de un persona dado el id
    //? Verificado en la BD 02/07/2021
    //!  Update o delete en «persona» viola la llave foránea «fk_profesor_relations_persona» en la tabla «profesor»
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

    //Busca una persona dado el id
    //? Verificado en la BD 02/07/2021
    function buscarPersona($persona)
    {
      $SQL_Bus_Persona =
      "	SELECT pers_id_persona, pers_nombre, pers_apellido_paterno, pers_apellido_materno, 
          pers_correo, pers_telefono, pers_rfc, pers_sexo
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

    function buscarPersonaRFC($rfc)
		{
			$SQL_Bus_Persona = 
			"	SELECT pers_id_persona, pers_nombre, pers_apellido_paterno, pers_apellido_materno, 
                pers_correo, pers_telefono, pers_rfc
				FROM persona
				WHERE pers_rfc = '$rfc';
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Persona);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

    //Busca una persona dado el id
    //? Verificado en la BD 02/07/2021
    function personaExistente($persona)
		{
			$SQL_Bus_Persona = 
			"	SELECT pers_id_persona, pers_nombre, pers_apellido_paterno, pers_apellido_materno, 
                pers_correo, pers_telefono, pers_rfc
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

    function rolesPersona ($idPersona) {
      $SQL_Bus_Persona = 
			"	SELECT count (*) as roles_persona
        FROM Usuario U
        INNER JOIN Persona P ON U.usua_id_persona = P.pers_id_persona
        WHERE P.pers_id_persona = $idPersona
        GROUP BY U.usua_id_persona
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
