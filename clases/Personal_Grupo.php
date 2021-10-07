<?php
//? Clase actualizada a las reglas de los prefijos 05/10/21
//! Revisar TODO -> actualizarPersonal()
class Personal_Grupo
{
    //Obtiene los datos del instructor de un grupo
    function buscarInstructor($grupo)
    {
        $SQL_Bus_Instructor =
        "
                SELECT g.pegr_id_usuario usr_instructor, u.usua_id_persona, pers_nombre, pers_apellido_paterno, pers_apellido_materno, g.pegr_id_constancia
                FROM personal_grupo g, usuario u, persona p
                WHERE g.pegr_id_grupo = $grupo AND u.usua_id_rol = 2
                    AND g.pegr_id_usuario = u.usua_id_usuario AND u.usua_id_persona = p.pers_id_persona;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Instructor);
        $bd->cerrarBD();
        return($transaccion_1->traerObjeto(0));
    }

    //Obtiene los datos del moderador de un grupo
    function buscarModerador($grupo)
    {
        $SQL_Bus_Moderador =
        "   SELECT g.pegr_id_usuario usr_moderador, u.usua_id_persona, pers_nombre, pers_apellido_paterno, pers_apellido_materno, g.pegr_id_constancia
                FROM personal_grupo g, usuario u, persona p
                WHERE g.pegr_id_grupo = $grupo AND u.usua_id_rol = 3
                    AND g.pegr_id_usuario = u.usua_id_usuario AND u.usua_id_persona = p.pers_id_persona;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Moderador);
        $bd->cerrarBD();
        return($transaccion_1->traerObjeto(0));
    }

    //Obtiene los datos del  instructor o moderador de un grupo, creado por si es necesario
    function buscarPersonal($grupo, $rol)
    {
        $SQL_Bus_Personal =
        "   SELECT g.pegr_id_usuario, u.usua_id_persona, pers_nombre, pers_apellido_paterno, pers_apellido_materno
                FROM personal_grupo g, usuario u, persona p
                WHERE g.pegr_id_grupo = $grupo AND usua_id_rol = $rol
                    AND g.pegr_id_usuario = u.usua_id_usuario AND u.usua_id_persona = p.pers_id_persona;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Personal);
        $bd->cerrarBD();
        return($transaccion_1->traerObjeto(0));
    }

    //Permite actualizar el Instructor de un grupo, hecho esto se pierde el registro de quien era el instructor antes
    function actualizarInstructor($grupo, $idusuario)
    {
        $SQL_Act_Instructor =
        "   UPDATE personal_grupo
                SET pegr_id_usuario = 1
                WHERE pegr_id_grupo = 1 AND pegr_id_usuario = (SELECT DISTINCT p.pegr_id_usuario
                                                            FROM personal_grupo p, usuario u
                                                            WHERE pegr_id_grupo = $grupo AND usua_id_rol = $idusuario
                                                                AND p.pegr_id_usuario = u.usua_id_usuario);
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Instructor);
        $bd->cerrarBD();
    }

    //Permite actualizar el moderador de un grupo, hecho esto se pierde el registro de quien era el moderador antes
    function actualizarModerador($grupo, $idusuario)
    {
        $SQL_Act_Moderador =
        "   UPDATE personal_grupo
                SET pegr_id_usuario = $idusuario
                WHERE pegr_id_grupo = $grupo AND pegr_id_usuario = (SELECT p.pegr_id_usuario
                                                            FROM personal_grupo p, usuario u
                                                            WHERE pegr_id_grupo = 1 AND usua_id_rol = 3 
                                                                AND p.pegr_id_usuario = u.usua_id_usuario);
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Moderador);
        $bd->cerrarBD();
    }

    //Permite actualizar el Instructor o moderador de un grupo, hecho esto se pierde el registro de quien era el instructor/moderador antes
    // TODO: Preguntar sobre esta consulta
    //! Puede contener errores -> En una ocasión notificó que se actualizaban varios registros en lugar de uno
    function actualizarPersonal($grupo, $idUsuario, $rol)
    {
        $SQL_Act_Personal =
        "   UPDATE personal_grupo
                SET pegr_id_usuario = $idUsuario
                WHERE pegr_id_grupo = $grupo AND pegr_id_usuario = (SELECT p.pegr_id_usuario
                                                            FROM personal_grupo p, usuario u
                                                            WHERE p.pegr_id_grupo = $grupo AND u.usua_id_rol = $rol
                                              S                  AND p.pegr_id_usuario = u.usua_id_usuario);
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Personal);
        $bd->cerrarBD();
    }

    //Permite agregar instructor o moderador al grupo
    function agregarPersonal($grupo, $idusuario)
    {
        $SQL_Agr_Personal =
        "   INSERT INTO Personal_Grupo(pegr_id_grupo, pegr_id_usuario, pegr_id_constancia)
                VALUES ($grupo, $idusuario, null);
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Agr_Personal);
        $bd->cerrarBD();
    }

    //Permite quitar el personal de un grupo
    function quitarPersonal($grupo, $idusuario)
    {
        $SQL_Qui_Personal =
        "   DELETE FROM personal_grupo
                WHERE pegr_id_grupo = $grupo AND pegr_id_usuario = $idusuario;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Qui_Personal);
        $bd->cerrarBD();
    }

    //Permite asignar una constancia al instructor o moderador de un grupo
    function asignarConstancia($grupo, $idusuario, $idConstancia)
    {
        $SQL_Asig_Personal =
        "   UPDATE personal_grupo
                SET pegr_id_constancia = $idConstancia
                WHERE pegr_id_grupo = $grupo AND pegr_id_usuario = $idusuario;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Asig_Personal);
        $bd->cerrarBD();
    }
}
