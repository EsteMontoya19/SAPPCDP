<?php
  class Administrador
  {
    //Buscar los datos de un administrador dado el id persona
    //? Verificado en la BD 02/07/2021
    //? La original Administrador(Tabla) ya no se incluye en la nueva versión de BD
    function buscarAdministrador($persona)
		{
			$SQL_Bus_Administrador = 
			"	
        SELECT PR.pers_id_persona, prof_num_trabajador, pers_rfc
        FROM Persona PE, Profesor PR
        WHERE PE.pers_id_persona = PR.pers_id_persona AND PE.pers_id_persona = $persona
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Administrador);
			$obj_Persona = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

    //Buscar el npumero de administradores activos
    //? Verificado en la BD 02/07/2021
    //? La original Administrador(Tabla) ya no se incluye en la nueva versión de BD
    function administradoresActivos () {
      $SQL_Bus_Administrador = 
			"
        SELECT COUNT (usua_id_usuario)
        FROM Usuario 
        WHERE usua_activo = TRUE AND rol_id_rol = 1
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Administrador);
			$obj_Persona = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();

			return ($obj_Persona->count);
    }

    //? Funciones ya no necesarias 02/07/2021
    /*
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
    */
  }
?>
