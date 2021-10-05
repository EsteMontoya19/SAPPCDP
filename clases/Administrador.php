<?php
  class Administrador
  {
    //? Clase actualizada a las reglas de los prefijos 04/10/21

    //Buscar los datos de un administrador dado el id persona
    //? La original Administrador(Tabla) ya no se incluye en la nueva versión de BD
    function buscarAdministrador($persona)
		{
			$SQL_Bus_Administrador = 
			"	SELECT PR.prof_id_persona, prof_num_trabajador, pers_rfc
        FROM Persona PE, Profesor PR
        WHERE PE.pers_id_persona = PR.prof_id_persona AND PE.pers_id_persona = $persona
			";

			$bd = new BD();
			$bd->abrirBD();
			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Bus_Administrador);
			$bd->cerrarBD();
			return ($transaccion_1->traerObjeto(0));
		}

    //Buscar el npumero de administradores activos
    //? La original Administrador(Tabla) ya no se incluye en la nueva versión de BD
    function administradoresActivos () {
      $SQL_Bus_Administrador = 
			"SELECT COUNT (usua_id_usuario)
        FROM Usuario 
        WHERE usua_activo = TRUE AND usua_id_rol = 1
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