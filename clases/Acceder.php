<?php
	include('BD.php');

  	class Acceder
  	{
  		public $_usuario;
  		public $_contrasena;
  		public $_id_persona;
  		public $_id_rol;

		function buscar($strUsuario, $strContrasena)
  		{
			$SQL_Busq_Usuario =
			" 	SELECT U.usua_id_usuario, U.pers_id_persona, U.rol_id_rol, R.rol_nombre, U.preg_id_pregunta, U.usua_num_usuario,
					   U.usua_contrasena, U.usua_respuesta, U.usua_activo
      			FROM Usuario U, Rol R
      			WHERE R.rol_id_rol = U.rol_id_rol AND U.usua_num_usuario = '$strUsuario' AND usua_contrasena = '$strContrasena';
			";

			$bd = new BD();
			$bd->abrirBD();

			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Busq_Usuario);

			if($transaccion_1->contarNumeroRegistros()==0)
    		{
      			return false;
    		}

    		$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();
			
			$this->id_usuario = $obj_Usuario->usua_num_usuario;
			$this->id_contrasena = $obj_Usuario->usua_contrasena;
			$this->id_rol = $obj_Usuario->rol_id_rol;
			$this->id_persona = $obj_Usuario->pers_id_persona;
			$this->estado = $obj_Usuario->usua_activo;

			 return true;
		}

		function validarEstado($strUsuario, $strContrasena)
  		{
			$SQL_Busq_Usuario =
			" 	SELECT U.usua_id_usuario, U.pers_id_persona, U.rol_id_rol, R.rol_nombre, U.preg_id_pregunta, U.usua_num_usuario,
					   U.usua_contrasena, U.usua_respuesta, U.usua_activo
	   			FROM Usuario U, Rol R
	   			WHERE R.rol_id_rol = U.rol_id_rol AND U.usua_num_usuario = '$strUsuario' AND usua_contrasena = '$strContrasena'
				   	  AND U.usua_activo = true;
			";

			$bd = new BD();
			$bd->abrirBD();

			$transaccion_1 = new Transaccion($bd->conexion);
			$transaccion_1->enviarQuery($SQL_Busq_Usuario);

			if($transaccion_1->contarNumeroRegistros()==0)
    		{
      			return false;
    		}

    		$obj_Usuario = $transaccion_1->traerObjeto(0);
			$bd->cerrarBD();

			$this->id_usuario = $obj_Usuario->usua_num_usuario;
			$this->id_contrasena = $obj_Usuario->usua_contrasena;
			$this->id_rol = $obj_Usuario->rol_id_rol;
			$this->id_persona = $obj_Usuario->pers_id_persona;
			$this->estado = $obj_Usuario->usua_activo;

			 return true;
		}

function buscarLogin($intIdUsuario){
		$SQLBUS_Login =
    "	SELECT pero_id_persona,pero_login, pero_password,
			pero_id_pregunta, pero_respuesta, alum_id_alumno, alum_num_cuenta,
			pero_id_rol FROM
			persona_rol, rol, alumno WHERE
			alum_id_persona=pero_id_persona AND
			rol_id_rol=pero_id_rol AND
			pero_login='$intIdUsuario'
			";
		//echo "$SQLBUS_Usuario";
		$bd = new BD();
		$bd->abrirBD();
		$transaccion_1 = new Transaccion($bd->conexion);
		$transaccion_1->enviarQuery($SQLBUS_Login);

		if($transaccion_1->contarNumeroRegistros()==0){
            return false;
        }
		$obj_Usuario = $transaccion_1->traerObjeto(0);
		$bd->cerrarBD();

		$this->_usuario		= $obj_Usuario->pero_login;
		$this->_contrasena	= $obj_Usuario->pero_password;
		$this->_id_rol		= $obj_Usuario->pero_id_rol;
		$this->_id_persona	= $obj_Usuario->pero_id_persona;
		$this->_id_alumno	= $obj_Usuario->alum_id_alumno;
		$this->_id_pregunta	= $obj_Usuario->pero_id_pregunta;
		$this->_respuesta	= $obj_Usuario->pero_respuesta;

		 return true;

	}

	function modificar($cvepersona, $strcontrasena, $intIdPregunta, $strRespuesta){

		$SQLACT_PersonaRol= "
		UPDATE PERSONA_ROL SET pero_password='$strcontrasena',
		pero_id_pregunta=$intIdPregunta,
		pero_respuesta='$strRespuesta'
		where pero_id_persona=$cvepersona
		";

//echo "$SQLACT_PersonaRol";

		$bd = new BD();
		$bd->abrirBD();
		$transaccion_1 = new Transaccion($bd->conexion);
		$transaccion_1->enviarQuery($SQLACT_PersonaRol);
		$bd->cerrarBD();
	}

	function agregarPersonaRol($intIdRol, $intIdPersona,$strUsuario, $strContrasenia){
		$SQLINS_PersonaRol =
			"INSERT INTO PERSONA_ROL(pero_id_rol, pero_id_persona, pero_login,
			pero_password
			)
			VALUES ($intIdRol, $intIdPersona, '$strUsuario', '$strContrasenia')
		 ";

		//echo"$SQLINS_PersonaRol";
		$bd = new BD();
		$bd->abrirBD();
		$transaccion_1 = new Transaccion($bd->conexion);
		$transaccion_1->enviarQuery($SQLINS_PersonaRol);
		$bd->cerrarBD();
	}

function buscarTodosPersonaRolAdmSerSoc(){
		$SQLBUS_PersonaRolAdmSerSoc =
		"SELECT pero_id_persona_rol, pers_nombre, pefi_apaterno, pefi_amaterno,
		pero_login, pero_password FROM PERSONA, PERSONA_FISICA, PERSONA_ROL
		WHERE pers_id_persona=pefi_id_persona AND
        pero_id_persona=pers_id_persona AND
		(pero_id_rol=10 or pero_id_rol=9)
		";
		//echo $SQLBUS_PersonaRolAdmSerSoc;
		$bd = new BD();
		$bd->abrirBD();
		$transaccion_1 = new Transaccion($bd->conexion);
		$transaccion_1->enviarQuery($SQLBUS_PersonaRolAdmSerSoc);
		$bd->cerrarBD();
		return ($transaccion_1->traerRegistros());
	}
	function eliminarPersonaRol($intIdPersonaRol){
		$SQLDEL_PersonaRol = "
			DELETE FROM PERSONA_ROL WHERE
			pero_id_persona_rol=$intIdPersonaRol
		";
		$bd = new BD();
		$bd->abrirBD();
		$transaccion_1 = new Transaccion($bd->conexion);
		$transaccion_1->enviarQuery($SQLDEL_PersonaRol);
		$bd->cerrarBD();
	}

function buscarPersonaRol($intIdPersonaRol){

		$SQLBUS_PersonaRol = "
		SELECT * FROM PERSONA_ROL
		WHERE pero_id_persona_rol = $intIdPersonaRol";
//	echo "$SQLBUS_PersonaRol";
		$bd = new BD();
		$bd->abrirBD();
		$transaccion_1 = new Transaccion($bd->conexion);
		$transaccion_1->enviarQuery($SQLBUS_PersonaRol);
		$bd->cerrarBD();
		if ($transaccion_1->contarNumeroRegistros() == 1) {
			$obj_Activo = $transaccion_1->traerObjeto(0);
			$this->_id_persona= $obj_Activo->pero_id_persona;
			$this->_login= $obj_Activo->pero_login;
			$this->_id_rol= $obj_Activo->pero_id_rol;
			$this->_password= $obj_Activo->pero_password;
			return true;
		}
		else {
			return false;
		}

	}


	function modificarPersonaRol($intIdPersonaRol,$intIdRol,$strUsuario, $strContrasenia){

		$SQLACT_PersonaRolU= "
		UPDATE PERSONA_ROL SET pero_password='$strContrasenia',
		pero_login='$strUsuario', pero_id_rol=$intIdRol
		where pero_id_persona_rol = $intIdPersonaRol
		";
//echo "$SQLACT_PersonaRolU";
		$bd = new BD();
		$bd->abrirBD();
		$transaccion_1 = new Transaccion($bd->conexion);
		$transaccion_1->enviarQuery($SQLACT_PersonaRolU);
		$bd->cerrarBD();
	}
}
?>
