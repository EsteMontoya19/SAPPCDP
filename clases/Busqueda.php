<?php

    //? Clase actualizada a las reglas de los prefijos 04/10/21

class Busqueda
{   

    //? Da la información de un grupo presencial
    function salonGrupo($grupo)
    {
        $SQL_Bus_Modalidades_Aprendizaje =
        "SELECT salo_id_salon, salo_nombre, edif_id_edificio, edif_nombre
            FROM Salon S, Grupo G, Edificio E
            WHERE salo_id_salon = grup_id_salon AND edif_id_edificio = salo_id_edificio
                AND grup_id_grupo = $grupo
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Modalidades_Aprendizaje);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    function selectNombramientos()
    {
        $SQL_Bus_Plataformas =
        " SELECT nomb_id_nombramiento, nomb_descripcion
            FROM Nombramiento
            ORDER BY nomb_descripcion
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Plataformas);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }
    //Consultar coordinaciones: id y nombre.
    function selectCoordinaciones()
    {
        $SQL_Bus_Eventos =
        "   SELECT coor_id_coordinacion, coor_nombre
            FROM Coordinacion
            ORDER BY coor_nombre ASC;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Eventos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }       

    //Consultar niveles: id y nombre.
    function selectNiveles()
    {
        $SQL_Bus_Eventos =
        "   SELECT nive_id_nivel, nive_nombre
            FROM Nivel
            ORDER BY nive_id_nivel ASC;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Eventos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Consultar modalidades: id y nombre.
    function selectModalidades()
    {
        $SQL_Bus_Eventos =
        "   SELECT moda_id_modalidad, moda_nombre
            FROM Modalidad
            ORDER BY moda_id_modalidad ASC;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Eventos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Consultar días: id y nombre.
    function selectDias()
    {
        $SQL_Bus_Eventos =
        "   SELECT dia_id_dia, dia_nombre
            FROM dia
            ORDER BY dia_id_dia ASC;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Eventos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Consultar roles: id y nombre.
    function selectRoles()
    {
        $SQL_Bus_Rol = 
        "   SELECT rol_id_rol, rol_nombre
            FROM Rol;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Rol);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //? Consultar las preguntas de seguridad: id, pregunta y estado.
    function selectPregunta()
    {
        $SQL_Bus_Preg = 
        "   SELECT prse_id_pregunta, prse_nombre, prse_activo
            FROM Pregunta_Seguridad;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Preg);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Consultar los salones: id, edificio al que pertenece y el nombre del salón.
    function selectSalones()
    {
        $SQL_Bus_Salones =
        "SELECT SALO_ID_SALON, EDIF_NOMBRE, SALO_NOMBRE 
        FROM SALON S, EDIFICIO E
        WHERE S.SALO_ID_EDIFICIO = E.EDIF_ID_EDIFICIO
        ORDER BY EDIF_NOMBRE, SALO_NOMBRE;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Salones);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }  

    //Consultarn las plataformas: id, nombre y estado.
    function selectPlataformas()
    {
        $SQL_Bus_Plataformas =
        "SELECT PLAT_ID_PLATAFORMA, PLAT_NOMBRE, PLAT_ACTIVO
         FROM PLATAFORMA
         ORDER BY PLAT_NOMBRE
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Plataformas);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Consultarn cursos activos: id, nombre, número de sesiones, tipo y nivel.
    function selectCursosActivos()
    {
        $SQL_Bus_Cursos =
        "SELECT CURS_ID_CURSO, CURS_NOMBRE, CURS_NUM_SESIONES, CURS_TIPO, CURS_NIVEL
        FROM CURSO
        WHERE CURS_ACTIVO = TRUE
        ORDER BY CURS_NOMBRE ASC;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cursos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //? Consulta un salon y el edificio al que pertenece dado el id del salón
    function selectSalon($id)
    {
        $SQL_Bus_Salon =
        "SELECT EDIF_NOMBRE, SALO_NOMBRE 
         FROM SALON S, EDIFICIO E
         WHERE S.SALO_ID_EDIFICIO = E.EDIF_ID_EDIFICIO AND SALO_ID_SALON = $id
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Salon);
        $obj_Busqueda = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Consulta Todos los estados que puede tener un grupo
    function selectEstadosGrupo()
    {
        $SQL_Bus_Estados =
        "SELECT esta_id_estado, esta_nombre
         FROM Estado;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Estados);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //? Consulta un estado de un grupo por ID
    function selectEstadoGrupo($id)
    {
        $SQL_Bus_Estado =
        "SELECT esta_id_estado, esta_nombre 
         FROM Estado
         WHERE esta_id_estado = $id;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Estado);
        $obj_Busqueda = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Consulta un estado de un grupo por nombre
    function selectEstadoGrupoxNombre($nombre)
    {
        $SQL_Bus_Estado =
        "SELECT esta_id_estado, esta_nombre 
         FROM Estado
         WHERE LOWER(esta_nombre) = LOWER($nombre);
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Estado);
        $obj_Busqueda = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Consulta todas las modalidades de aprendizaje
    function selectModalidadesAprendizaje()
    {
        $SQL_Bus_Modalidades_Aprendizaje =
        "SELECT moap_id_modalidad, moap_nombre, moap_activo
         FROM Modalidad_Aprendizaje;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Modalidades_Aprendizaje);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //? Consulta todas las modalidades de aprendizaje activas
    function selectModalidadesAprendizajeActivas()
    {
        $SQL_Bus_Modalidades_Aprendizaje =
        "SELECT moap_id_modalidad, moap_nombre, moap_activo
         FROM Modalidad_Aprendizaje
         WHERE moap_activo = true;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Modalidades_Aprendizaje);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Consulta una modalidad de aprendizaje por ID
    function selectModalidadAprendizaje($id)
    {
        $SQL_Bus_Modalidad_Aprendizaje =
        "SELECT moap_id_modalidad, moap_nombre, moap_activo
         FROM Modalidad_Aprendizaje
         WHERE moap_id_modalidad = $id;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Modalidad_Aprendizaje);
        $obj_Busqueda = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Consulta una modalidad de aprendizaje por nombre
    function selectModalidadAprendizajexNombre($nombre)
    {
        $SQL_Bus_Modalidad_Aprendizaje =
        "SELECT moap_id_modalidad, moap_nombre, moap_activo
         FROM Modalidad_Aprendizaje
         WHERE LOWER(moap_nombre) = LOWER($nombre);
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Modalidad_Aprendizaje);
        $obj_Busqueda = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Consulta los cursos que ha tomado un profesor y las veces que lo ha hecho
    function selectVecesInscritoCurso($profesor)
    {
        $SQL_Bus_Veces_Inscrito =
        "SELECT grup_id_curso, COUNT(*) as veces_inscrito
        FROM Inscripcion i, grupo g
        WHERE insc_activo = true AND insc_id_profesor = $profesor
            AND i.insc_id_grupo = g.grup_id_grupo
        GROUP BY grup_id_curso;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Veces_Inscrito);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //? Consulta la cantidad de grupos que ha inscrito un profesor en un semestre (calendario)
    function selectCantidadGruposInscritos($profesor)
    {
        $SQL_Bus_Cant_Grupos =
        "SELECT insc_id_profesor, COUNT(*) as cantidad_grupos
        FROM inscripcion i, grupo g
        WHERE insc_activo = true AND insc_id_profesor = $profesor
            AND i.insc_id_grupo = g.grup_id_grupo
            AND grup_id_calendario = (SELECT cale_id_calendario FROM Calendario WHERE cale_activo = true)
        GROUP BY insc_id_profesor;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cant_Grupos);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Consulta una constancia a través de su ID
    function selectConstanciaID($id)
    {
        $SQL_Bus_Constancia =
        "SELECT cons_id_constancia, cons_url, cons_estado, cons_descargada 
        FROM Constancia
        WHERE cons_id_constancia = $id;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Constancia);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Consulta un id de profesor a través de su id de usuario
    function buscarProfesorID($id)
    {
        $SQL_Bus_IDProfesor =
        "SELECT prof_id_profesor 
         FROM usuario u, profesor p
         WHERE u.usua_id_persona = p.prof_id_persona
            AND usua_id_usuario = $id
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_IDProfesor);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Consulta un id de constancia de personal a partir de su id de usuario
    function buscarConstanciaPersonal($idUsuario, $idGrupo)
    {
        $SQL_Bus_Constancia =
        "SELECT p.pegr_id_constancia, cons_estado, cons_url 
        FROM personal_grupo p, Constancia c
        WHERE c.cons_id_constancia = p.pegr_id_constancia AND pegr_id_grupo = $idGrupo
            AND pegr_id_usuario = $idUsuario
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Constancia);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Consulta el horario del moderador a partir de un id de usuario
    function buscarHorarioModerador($idUsuario)
    {
        $SQL_Bus_Horario =
        "SELECT mode_fecha_inicio, mode_fecha_fin, mode_hora_inicio, mode_hora_fin, mode_id_moderador 
        FROM horario_moderador
        WHERE mode_id_usuario = $idUsuario
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Horario);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    /* //! Importante
    Este método permite consultar los días en que un moderador está disponible
    (Lunes-Sábado), en orden de 1 - 6 respectivamente. 
    Para evitar afectar otras modalidades se recomienda dejarlo de esta manera
    y no modificar la tabla dia, ya que si se cambia el valor que fue asignado 
    ya no funcionará la validación de los dias que un moderador se encuentra 
    disponible al momento de asignarle un grupo
    */
    function buscarDiasModerador($idModerador)
    {
        $SQL_Bus_Dias_Moderador =
        "SELECT modi_id_dia 
         FROM Moderador_dia
         WHERE modi_id_moderador = $idModerador
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Dias_Moderador);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //? Consulta los datos de un profesor a partir de su id de constancia
    function buscarProfesorPorIDConstancia($idConstancia)
    {
        $SQL_Bus_Profesor =
        "SELECT pers_nombre, pers_apellido_paterno, pers_apellido_materno,c.cons_id_constancia 
         FROM Constancia c, Inscripcion i, Profesor t, persona p
        WHERE c.cons_id_constancia = $idConstancia 
            AND c.cons_id_constancia = i.insc_id_constancia 
            AND i.insc_id_profesor = t.prof_id_profesor
            AND t.prof_id_persona = p.pers_id_persona;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Profesor);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }
}
?>