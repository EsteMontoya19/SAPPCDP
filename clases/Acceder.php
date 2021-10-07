<?php
include('BD.php');

//? Clase actualizada a las reglas de los prefijos 04/10/21

class Acceder
{
    public $_usuario;
    public $_contrasena;
    public $_id_persona;
    public $_id_rol;

    function buscar($strUsuario, $strContrasena)
    {
        $SQL_Busq_Usuario =
        " 	SELECT U.usua_id_usuario, U.usua_id_persona, U.usua_id_rol, R.rol_nombre, U.usua_num_usuario,
				U.usua_contrasena, U.usua_activo
      			FROM Usuario U, Rol R
      			WHERE R.rol_id_rol = U.usua_id_rol AND U.usua_num_usuario = '$strUsuario' AND usua_contrasena = '$strContrasena';
			";

        $bd = new BD();
        $bd->abrirBD();

        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Busq_Usuario);

        if ($transaccion_1->contarNumeroRegistros()==0) {
            return false;
        }

        $obj_Usuario = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        $this->id_usuario = $obj_Usuario->usua_num_usuario;
        $this->id_contrasena = $obj_Usuario->usua_contrasena;
        $this->id_rol = $obj_Usuario->usua_id_rol;
        $this->id_persona = $obj_Usuario->usua_id_persona;
        $this->estado = $obj_Usuario->usua_activo;

        return true;
    }

    function validarEstado($strUsuario, $strContrasena)
    {
        $SQL_Busq_Usuario =
        " 	SELECT U.usua_id_usuario, U.usua_id_persona, U.usua_id_rol, R.rol_nombre, U.usua_num_usuario, U.usua_contrasena, U.usua_activo
				FROM Usuario U, Rol R
				WHERE R.rol_id_rol = U.usua_id_rol AND U.usua_num_usuario = '$strUsuario' AND usua_contrasena = '$strContrasena'
				AND U.usua_activo = true;
			";

        $bd = new BD();
        $bd->abrirBD();

        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Busq_Usuario);

        if ($transaccion_1->contarNumeroRegistros()==0) {
            return false;
        }

        $obj_Usuario = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();

        $this->id_usuario = $obj_Usuario->usua_num_usuario;
        $this->id_contrasena = $obj_Usuario->usua_contrasena;
        $this->id_rol = $obj_Usuario->usua_id_rol;
        $this->id_persona = $obj_Usuario->usua_id_persona;
        $this->estado = $obj_Usuario->usua_activo;

         return true;
    }
}