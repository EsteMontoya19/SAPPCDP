<?php
//? Clase actualizada a las reglas de los prefijos 04/10/21
class Usuario
{
    //Actualizar el estatus dado el id y el estatus
    //? Verificado en la BD 02/07/2021
    function modificarEstatus($usuario, $estatus)
    {
        $SQL_Persona_Est=
        "
				UPDATE Usuario
				SET usua_activo = $estatus
				WHERE usua_id_usuario = $usuario
			";


        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Persona_Est);
        $bd->cerrarBD();
    }

    //Agregar un usuario
    //? Verificado en la BD 02/07/2021
    //? La original usua_respuesta ($recuperacion) ya no se incluye en la nueva versión de BD
    function agregarUsuario($persona, $rol, $pregunta, $nombreUsuario, $contrasenia, $estado)
    {
   //? El id de la pregunta es NULL por que aún no tenemos nada en esos catálogos
        $SQL_Ins_Usuario =
        "	
				INSERT INTO usuario (usua_id_persona, usua_id_rol, usua_id_pregunta, usua_num_usuario, usua_contrasena, usua_activo)
				VALUES ($persona, $rol, null, '$nombreUsuario', '$contrasenia', '$estado');
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Ins_Usuario);
        $bd->cerrarBD();
    }

    //Actualizar un usuario dado el id de la persona
    //? Verificado en la BD 02/07/2021
    function actualizarUsuario($idPersona, $rol, $pregunta, $nombreUsuario, $contrasenia)
    {
        $SQL_Act_Usuario=
        "UPDATE Usuario
			SET usua_id_rol = $rol , usua_id_pregunta= null, usua_num_usuario= '$nombreUsuario', usua_contrasena= '$contrasenia'
			WHERE usua_id_persona = $idPersona AND usua_id_rol = $rol;
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Usuario);
        $bd->cerrarBD();
    }

    //Eliminar el resgitro de un usuario dado el id de usuario
    //? Verificado en la BD 02/07/2021
    function eliminarUsuario($usuario)
    {
        $SQL_Eli_Usuario=
        " 	
				DELETE FROM usuario
				WHERE usua_id_usuario = $usuario;
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Eli_Usuario);
        $bd->cerrarBD();
    }

    //Buscar todoas los usuarios
    //? Verificado en la BD 02/07/2021
    //? La original usua_respuesta y prse_pregunta ya no se incluye en la nueva versión de BD
    function buscarTodosUsuarios()
    {
        $SQL_Bus_usuarios =
        "
            SELECT U.usua_id_usuario,P.pers_id_persona, P.pers_nombre, P.pers_apellido_paterno, P.pers_apellido_materno,U.usua_id_rol, U.usua_num_usuario, R.rol_nombre, U.usua_activo
            FROM persona P, usuario U , rol R
            WHERE P.pers_id_persona = U.usua_id_persona AND R.rol_id_rol = U.usua_id_rol
            ORDER BY U.usua_activo, P.pers_id_persona DESC, R.rol_id_rol
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_usuarios);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Buscar un usuario dado el id de usuario
    //? Verificado en la BD 02/07/2021
    //? La original prse_id_pregunta ya no se incluye en la nueva versión de BD
    function buscarUsuario($intIdUsuario)
    {
        $SQL_Bus_Usuario =
        "SELECT U.usua_id_usuario, U.usua_id_rol, R.rol_nombre, U.usua_num_usuario, U.usua_contrasena, U.usua_activo
				FROM Rol R, Usuario U
				WHERE R.rol_id_rol = U.usua_id_rol AND U.usua_id_usuario = $intIdUsuario;
			";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Usuario);
            $obj_Usuario = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
    }
    function buscarUsuarioPersona($persona, $rol)
    {
        $SQL_Bus_Usuario =
        "	SELECT U.usua_id_usuario, U.usua_id_rol, R.rol_nombre, U.usua_num_usuario, U.usua_contrasena, U.usua_activo
				FROM Rol R, Usuario U
				WHERE R.rol_id_rol = U.usua_id_rol AND U.usua_id_persona = $persona AND U.usua_id_rol = $rol;
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Usuario);
        $obj_Usuario = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Bucar datos de un usuario dado el nombre de usuario
    //? Verificado en la BD 02/07/2021
    //? La original usua_respuesta y prse_pregunta ya no se incluye en la nueva versión de BD
    function buscarNombreUsuario($nombreUsu)
    {
        $SQL_Bus_Usuario =
        "SELECT U.usua_id_usuario, U.usua_id_rol, U.usua_num_usuario, U.usua_contrasena
				 FROM Rol R, Usuario U
				 WHERE R.rol_id_rol = U.usua_id_rol AND U.usua_num_usuario = '$nombreUsu';
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Usuario);
        $obj_Usuario = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }


        //Eliminar registro de una persona dado el id de usuario
        //? Verificado en la BD 02/07/2021
    function eliminarPersonaRol($intIdPersonaRol)
    {
        $SQLDEL_PersonaRol =
        "
				DELETE FROM usuario
				WHERE usua_id_usuario =  $intIdPersonaRol
			";
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQLDEL_PersonaRol);
        $bd->cerrarBD();
    }
}
