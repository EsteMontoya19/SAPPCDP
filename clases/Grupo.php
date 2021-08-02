<?php
class Grupo
{

    //? 

    function buscarModeradorGrupo ($grupo) {
        $SQL_Bus_Grupo =
        "SELECT U.usua_id_usuario, P.pers_id_persona, PG.grup_id_grupo, P.pers_nombre, P.pers_apellido_paterno, P.pers_apellido_materno
        FROM Personal_Grupo PG, Usuario U, Persona P
        WHERE PG.usua_id_usuario = U.usua_id_usuario  AND P.pers_id_persona = U.pers_id_persona
                AND U.rol_id_rol = 3 AND PG.grup_id_grupo = $grupo
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Grupo);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));

    }

    //Permite agregar cualquier tipo de grupo
    //? Verificado en la BD 06/07/2021
    /*No agrega el instructor ni moderador en este método, en el caso de estado y modalidad ahora manda ID*/
    function agregarGrupo(
        $curso,
        $salon,
        $plataforma,
        $url,
        $acceso,
        $clave,
        $cupo,
        $estado,
        $activo,
        $modalidad,
        $tipo_grupo,
        $inicio_insc,
        $fin_insc
    ) {
        $SQL_Ins_Grupo =
        "   INSERT INTO Grupo (curs_id_curso, salo_id_salon, cale_id_calendario, plat_id_plataforma, grup_url, grup_id_acceso, grup_clave_acceso,  
                            grup_cupo, esta_id_estado, grup_publicado, moap_id_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc)
                VALUES ($curso, $salon, (SELECT cale_id_calendario
                                        FROM Calendario
                                        WHERE cale_activo = TRUE), 
                $plataforma, '$url', '$acceso','$clave', $cupo, '$estado', $activo, '$modalidad', '$tipo_grupo', '$inicio_insc', '$fin_insc')
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Ins_Grupo);
        $bd->cerrarBD();
    }

    //Permite Actualizar Cualquier tipo de grupo
    //? Verificado en la BD 06/07/2021
    /*No actualiza curs_id_cursos, grup_modalidad, grup_activo ni cale_id_calendario. Por los requerimientos del sistema.
    El estado debe mandar el ID, el instructor y moderador se actualizan en otro método de personal_grupo*/
    function actualizarGrupo($grupo, $tipo_grupo, $estado, $cupo, $inicio_insc, $fin_insc, $salon, $plataforma, $url, $acceso, $clave)
    {
        $SQL_Actua_Grupo =
        "   UPDATE grupo
                SET grup_tipo = '$tipo_grupo', esta_id_estado = '$estado',
                grup_cupo = $cupo, grup_inicio_insc = '$inicio_insc', grup_fin_insc = '$fin_insc',
                salo_id_salon = $salon, plat_id_plataforma = $plataforma, grup_url = '$url', grup_id_acceso = '$acceso', grup_clave_acceso = '$clave'
                WHERE grup_id_grupo = $grupo;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Actua_Grupo);
        $bd->cerrarBD();
    }

    //Busca los correos de los profesores inscritos a un grupo.
    //? Verificado en la BD 06/07/2021
    function buscarCorreosDeParticipantes($ID)
    {
        $SQL_Bus_Cursos =
        "SELECT ( Pers.pers_apellido_paterno || ' ' || pers_apellido_materno || ' ' || Pers.pers_nombre) AS nombre , Pers.pers_correo, 
                    Prof.prof_id_profesor, Pers.pers_id_persona, I.insc_id_inscripcion, I.insc_observacion
            FROM Persona Pers, Inscripcion I, Grupo G, Profesor Prof
            WHERE G.grup_id_grupo = $ID AND I.grup_id_grupo = G.grup_id_grupo AND I.prof_id_profesor = Prof.prof_id_profesor AND Prof.pers_id_persona = Pers.pers_id_persona
                  AND I.insc_activo = TRUE ORDER BY nombre
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cursos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    function buscarAcreedorConstancia($idGrupo)
    {
        $SQL_Acreedor_Constancia =
        "SELECT DISTINCT ( P.pers_apellido_paterno || ' ' || P.pers_apellido_materno || ' ' || P.pers_nombre) AS nombre, Prof.prof_id_profesor,P.pers_id_persona, I.insc_id_inscripcion 
		FROM Persona P, Profesor Prof, Inscripcion I, Asistencia A
		WHERE P.pers_id_persona = Prof.pers_id_persona
		AND I. prof_id_profesor = Prof.prof_id_profesor
		AND I.insc_id_inscripcion = A.insc_id_inscripcion
		AND I.grup_id_grupo = $idGrupo
		AND P.pers_id_persona NOT IN (SELECT P.pers_id_persona
								FROM Persona P, Profesor Prof , Inscripcion I, Asistencia A, Sesion S
								WHERE P. pers_id_persona = Prof.pers_id_persona
								AND I. prof_id_profesor = Prof.prof_id_profesor
								AND I.insc_id_inscripcion = A.insc_id_inscripcion
								AND S.sesi_id_sesiones = A.sesi_id_sesiones
								AND I.insc_activo = TRUE
								AND I.grup_id_grupo = $idGrupo
								AND A.asis_presente = FALSE
								GROUP BY P.pers_id_persona, P.pers_nombre, P.pers_apellido_paterno, P.pers_apellido_materno, 
										A.asis_presente);
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Acreedor_Constancia);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    //Permite Consultar cualquier tipo de grupo
    //?Verificado en la BD 06/07/2021
    function buscarGrupo($id)
    {
        $SQL_Bus_Curso =
        "   SELECT g.grup_id_grupo, p.usua_id_usuario, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g.curs_id_curso, curs_nombre, curs_tipo, curs_nivel,  curs_num_sesiones,
                    g.plat_id_plataforma, grup_url, grup_id_acceso, grup_clave_acceso, grup_cupo,
                    grup_publicado, moap_id_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, esta_id_estado,
                    (SELECT pers_apellido_paterno || ' ' || pers_apellido_materno || ' ' || pers_nombre
                    FROM personal_grupo g, usuario u, persona p
                    WHERE rol_id_rol = 3 AND g.grup_id_grupo = $id 
                        AND g.usua_id_usuario = u.usua_id_usuario AND u.pers_id_persona = p.pers_id_persona
                    ) as moderador
                FROM grupo g, personal_grupo p, usuario u,persona pr, curso c, calendario ca 
                WHERE rol_id_rol = 2 AND g.grup_id_grupo = p.grup_id_grupo AND p.usua_id_usuario = u.usua_id_usuario
                    AND u.pers_id_persona = pr.pers_id_persona AND g.curs_id_curso = c.curs_id_curso 
                    AND g.cale_id_calendario = ca.cale_id_calendario 
                    AND g.grup_id_grupo = $id;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Curso);
        $obj_Grupo = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Permite Consultar todos los grupos sin importar la modalidad
    //? Verificado en la BD 06/07/2021
    //? Ahora regresa el id de usuario del profesor y no su id de profesor.
    function buscarTodosGrupos()
    {
        $SQL_Bus_Cursos =
        "   SELECT DISTINCT g.grup_id_grupo, p.usua_id_usuario, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_curso, curs_nombre, grup_num_inscritos,
                    g.plat_id_plataforma, grup_url, grup_id_acceso, grup_clave_acceso, grup_cupo,  
                    grup_publicado, moap_nombre grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, esta_nombre grup_estado
                FROM grupo g, personal_grupo p, usuario u, persona pr, curso c, calendario ca, modalidad_aprendizaje m, estado e
                WHERE rol_id_rol = 2 AND g.grup_id_grupo = p.grup_id_grupo AND p.usua_id_usuario = u.usua_id_usuario
                    AND u.pers_id_persona = pr.pers_id_persona AND g.curs_id_curso = c.curs_id_curso 
                    AND g.cale_id_calendario = ca.cale_id_calendario 
                    AND m.moap_id_modalidad = g.moap_id_modalidad AND e.esta_id_estado = g.esta_id_estado
                ORDER BY g.grup_id_grupo DESC;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cursos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //? Se utiliza para saber que grupos se le asiganaron al moderador
    function buscarTodosGruposAsignados($idUsuario)
    {
        $SQL_Bus_Cursos =
        "   SELECT g.grup_id_grupo, p.usua_id_usuario, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_curso, curs_nombre, grup_num_inscritos,
                    g.plat_id_plataforma, grup_url, grup_id_acceso, grup_clave_acceso, grup_cupo,  
                    grup_publicado, moap_nombre grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, esta_nombre grup_estado
                FROM grupo g, personal_grupo p, usuario u, persona pr, curso c, calendario ca, modalidad_aprendizaje m, estado e
                WHERE rol_id_rol = 3 AND g.grup_id_grupo = p.grup_id_grupo AND p.usua_id_usuario = u.usua_id_usuario
                    AND u.pers_id_persona = pr.pers_id_persona AND g.curs_id_curso = c.curs_id_curso 
                    AND g.cale_id_calendario = ca.cale_id_calendario 
                    AND m.moap_id_modalidad = g.moap_id_modalidad AND e.esta_id_estado = g.esta_id_estado
                    AND U.usua_id_usuario = $idUsuario
                ORDER BY g.grup_id_grupo DESC;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cursos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    /*
        Permite consultar todos los grupos que deben ser mostrados para
        los profesores, para ello deben estar publicados, en Inscripciones(estado pendiente) y públicos
    */
    //? Verificado en la BD 06/07/2021
    //? Ahora regresa el id de usuario del profesor y no su id de profesor.
    function buscarGruposProfesores()
    {
        $SQL_Bus_Cursos =
        "SELECT g.grup_id_grupo, p.usua_id_usuario, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    curs_nombre, curs_tipo, curs_nivel, curs_objetivos, grup_cupo,  grup_num_inscritos, g.moap_id_modalidad,
                    moap_nombre, to_char(grup_inicio_insc, 'DD') diaini, to_char(to_timestamp (to_char(grup_inicio_insc, 'MM')::text, 'MM'), 'TMmon') mesini, 
                    to_char(grup_fin_insc, 'DD') diafin, to_char(to_timestamp (to_char(grup_fin_insc, 'MM')::text, 'MM'), 'TMmon') mesfin
                FROM grupo g, personal_grupo p, usuario u,persona pr, curso c, calendario ca, modalidad_aprendizaje m, estado e 
                WHERE grup_tipo = 'Público' AND g.esta_id_estado = 3 AND grup_publicado = true AND rol_id_rol = 2
                    AND g.grup_id_grupo = p.grup_id_grupo AND p.usua_id_usuario = u.usua_id_usuario
                    AND u.pers_id_persona = pr.pers_id_persona AND g.curs_id_curso = c.curs_id_curso 
                    AND g.cale_id_calendario = ca.cale_id_calendario 
                    AND m.moap_id_modalidad = g.moap_id_modalidad AND e.esta_id_estado = g.esta_id_estado
                ORDER BY g.grup_id_grupo ASC;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cursos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    // Permite Cambiar estatus_activo grupo
    //? Verificado en la BD 06/07/2021
    function cambiarEstatus($id, $activo)
    {
        $SQL_Act_Curso =
        "   UPDATE grupo
                SET grup_publicado = $activo
                WHERE grup_id_grupo = $id;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Curso);
        $bd->cerrarBD();
    }

    //Permite obtener los grupos a los cuales se ha inscrito un profesor
    //? Verificado en la BD 06/07/2021
    function gruposInscritosxProfesor($idProfesor)
    {
        $SQL_Act_Curso =
        " SELECT G.GRUP_ID_GRUPO, G.moap_id_modalidad, moap_nombre, CONS_ID_CONSTANCIAS,
                    CURS_NOMBRE, CALE_SEMESTRE, ESTA_NOMBRE, insc_activo, curs_nivel, curs_tipo
                FROM INSCRIPCION I, GRUPO G, CURSO C, CALENDARIO CA, MODALIDAD_APRENDIZAJE M, ESTADO E
                WHERE I.PROF_ID_PROFESOR = $idProfesor
                    AND I.GRUP_ID_GRUPO = G.GRUP_ID_GRUPO 
                    AND G.CURS_ID_CURSO = C.CURS_ID_CURSO  
                    AND G.CALE_ID_CALENDARIO = CA.CALE_ID_CALENDARIO 
                    AND G.MOAP_ID_MODALIDAD = M.MOAP_ID_MODALIDAD
                    AND E.ESTA_ID_ESTADO = G.ESTA_ID_ESTADO
                    /*AND I.insc_activo = TRUE*/
                ORDER BY I.GRUP_ID_GRUPO ASC;
            ";
            
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Curso);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Permite obtener todos los grupos activos a los cuales se ha inscrito un profesor
    //? Verificado en la BD 06/07/2021
    function gruposInscritosActivosxProfesor($idProfesor)
    {
        $SQL_Act_Curso =
        "   
            SELECT I.PROF_ID_PROFESOR, I.GRUP_ID_GRUPO
            FROM INSCRIPCION I, GRUPO G, CURSO C, CALENDARIO CA 
            WHERE I.PROF_ID_PROFESOR = $idProfesor
                AND I.GRUP_ID_GRUPO = G.GRUP_ID_GRUPO 
                AND G.CURS_ID_CURSO = C.CURS_ID_CURSO
                AND G.CALE_ID_CALENDARIO = CA.CALE_ID_CALENDARIO 
                AND grup_publicado = true
                AND insc_activo = true
            ORDER BY I.GRUP_ID_GRUPO ASC;
            ";
            
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Curso);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }
        
    //Busca los datos de un grupo autogestivo dado el id del grupo
    //TODO Verificado en la BD 07/07/2021
    function buscarDatosAutogestivo($id)
    {
        $SQL_Bus_Grupo =
        "  
                SELECT grup_url
                FROM GRUPO 
                WHERE moap_id_modalidad = 3  
                AND GRUP_ID_GRUPO=$id; 
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Grupo);
        $obj_Grupo = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Verificado en la BD 06/07/2021
    //? Ahora verifica la modalidad mediante el id
    function buscarDatosEnLinea($id)
    {
        $SQL_Bus_Grupo =
        "  
                SELECT PLAT_NOMBRE, grup_url, GRUP_ID_ACCESO, grup_clave_acceso
                FROM GRUPO G, PLATAFORMA PA
                WHERE G.PLAT_ID_PLATAFORMA=PA.PLAT_ID_PLATAFORMA AND moap_id_modalidad = 2  
                AND GRUP_ID_GRUPO=$id; 
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Grupo);
        $obj_Grupo = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //? Verificado en la BD 06/07/2021
    //?Ahora regresa el id de la modalidad, pero verifica que sea el correspondiente a presencial.
    function buscarDatosPresencial($id)
    {
        $SQL_Bus_Grupo =
        "   
                SELECT moap_id_modalidad, SALO_NOMBRE, EDIF_NOMBRE 
                FROM GRUPO G, SALON S, EDIFICIO E
                WHERE G.SALO_ID_SALON=S.SALO_ID_SALON AND S.EDIF_ID_EDIFICIO = E.EDIF_ID_EDIFICIO 
                AND moap_id_modalidad = 1 AND G.GRUP_ID_GRUPO=$id;

            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Grupo);
        $obj_Grupo = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Permite eliminar un grupo independientemente de si es en modo presencial o en linea
    //? Verificado en la BD 06/07/2021
    //?No debe utilizarse esta función
    function eliminarGrupo($grupo)
    {
        $SQL_Eli_Grupo =
        " DELETE FROM grupo
              WHERE grup_id_grupo = $grupo;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Eli_Grupo);
        $bd->cerrarBD();
    }

    //Busca el ultimo grupo registrado
    //? Verificado en la BD 06/07/2021
    function buscarUltimo()
    {
        $bd = new BD();
        $SQL_Bus_Grupo_Seq = "SELECT last_value FROM grupo_grup_id_grupo_seq;";
        //posible alternativa de solución para la tabla. SELECT last_value(grup_id_grupo) Over (partition by grup_id_grupo order by grup_id_grupo DESC) FROM grupo

        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Grupo_Seq);
        $obj_Grupo_Seq = $transaccion_1->traerObjeto(0);
        $Grupo_Seq = $obj_Grupo_Seq->last_value;
        $bd->cerrarBD();

        return $Grupo_Seq;
    }

    //Busca todos los datos de un grupo dado el id.
    //? Verificado en la BD 06/07/2021
    //? Se cambia ahora, regresa los id de usuario del profesor y el moderador, a su vez lo que regresa es el id de modalidad y estado.
    function buscarSoloGrupo($id)
    {
        $SQL_Bus_SoloGrupo =
        "
                SELECT g.grup_id_grupo, curs_id_curso, salo_id_salon, plat_id_plataforma, cale_id_calendario, grup_url, grup_id_acceso, grup_clave_acceso,  
                    grup_cupo, esta_id_estado, grup_publicado, moap_id_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_num_inscritos,
                    p.usua_id_usuario usr_instructor, (SELECT p.usua_id_usuario
                        FROM personal_grupo p, usuario u
                        WHERE grup_id_grupo = $id AND rol_id_rol = 3 AND p.usua_id_usuario = u.usua_id_usuario) as usr_moderador
                FROM Grupo g, personal_grupo p, usuario u
                WHERE g.grup_id_grupo = $id AND rol_id_rol = 2
                    AND g.grup_id_grupo = p.grup_id_grupo AND p.usua_id_usuario = u.usua_id_usuario;
                ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_SoloGrupo);
            $obj_Grupo = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
    }
        
    function buscarGrupoCompleto($id)
    {
        $SQL_Bus_Grupo =
        "SELECT G.GRUP_ID_GRUPO, G.CURS_ID_CURSO, CURS_NOMBRE, CURS_TIPO, CURS_NIVEL, CURS_OBJETIVOS, CURS_REQ_TECNICOS, CURS_CONOCIMIENTOS, 
            G.MOAP_ID_MODALIDAD, MOAP_NOMBRE, ESTA_NOMBRE, PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO, 
            GRUP_CUPO, GRUP_NUM_INSCRITOS, GRUP_INICIO_INSC, GRUP_FIN_INSC, GRUP_PUBLICADO, GRUP_TIPO, G.PLAT_ID_PLATAFORMA,
            G.grup_id_acceso, G.grup_clave_acceso,
            CALE_ID_CALENDARIO, GRUP_URL, GRUP_ID_ACCESO, GRUP_CLAVE_ACCESO, GRUP_CUPO, GRUP_NUM_INSCRITOS,
            (SELECT P.plat_nombre
             FROM Grupo G, Plataforma P
             WHERE G.plat_id_plataforma = P.plat_id_plataforma
                   AND G.grup_id_grupo = $id) AS plat_nombre,
                   
             (SELECT (S.salo_nombre || ' Edificio: ' || E.edif_nombre) AS salon
              FROM Salon S, Grupo G, Edificio E
              WHERE S.salo_id_salon = G.salo_id_salon
                      AND G.grup_id_grupo = $id
                     AND S.EDIF_ID_EDIFICIO = E.EDIF_ID_EDIFICIO) AS salo_nombre,
            (SELECT count (sesi_id_sesiones)
			  FROM Sesion 
			  WHERE grup_id_grupo = $id
			  GROUP BY grup_id_grupo) AS num_sesiones,
            (SELECT MA.moap_nombre
			 FROM Modalidad_Aprendizaje MA, Grupo G
			 WHERE MA.moap_id_modalidad = G.moap_id_modalidad
	   			 	AND G.grup_id_grupo = $id) AS moap_nombre,
            (SELECT (P.pers_nombre || ' ' || P.pers_apellido_paterno || ' ' || P.pers_apellido_materno) AS Moderador
            FROM Personal_Grupo PG, Usuario U, Persona P
            WHERE U.usua_id_usuario = PG.usua_id_usuario AND P.pers_id_persona = U.pers_id_persona 
                AND U.rol_id_rol = 3 AND PG.grup_id_grupo = $id) AS moderador
                    
        FROM GRUPO G, CURSO C, MODALIDAD_APRENDIZAJE M, ESTADO E, 
            PERSONAL_GRUPO PG, USUARIO U, PERSONA P
        WHERE 	G.CURS_ID_CURSO = C.CURS_ID_CURSO 
            AND G.MOAP_ID_MODALIDAD = M.MOAP_ID_MODALIDAD
            AND G.ESTA_ID_ESTADO = E.ESTA_ID_ESTADO
            AND G.GRUP_ID_GRUPO = PG.GRUP_ID_GRUPO
            AND PG.USUA_ID_USUARIO = U.USUA_ID_USUARIO
            AND U.PERS_ID_PERSONA = P.PERS_ID_PERSONA
            AND ROL_ID_ROL = 2
            AND G.GRUP_ID_GRUPO = $id
            

            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $obj_Grupo = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
    }
    function idUsuarioModeradorGrupo($id)
    {
        $SQL_Bus_Grupo =
        "
                SELECT P.USUA_ID_USUARIO
                FROM PERSONAL_GRUPO P, USUARIO U
                WHERE P.USUA_ID_USUARIO = U.USUA_ID_USUARIO 
                    AND ROL_ID_ROL = 3
                    AND GRUP_ID_GRUPO = $id
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $obj_Grupo = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
    }

    //Busca los grupos que imparte un profesor
    //? Verificado en la BD 06/07/2021
    //? Se cambia la logica ahora el id hace referencia al id de usuario del profesor
    function buscarGruposImpartidosxInstructor($id)
    {
        $SQL_Bus_Grupos =
        "SELECT G.GRUP_ID_GRUPO, G.grup_publicado, M.moap_id_modalidad, moap_nombre,
                    CURS_NOMBRE, CALE_SEMESTRE, grup_num_inscritos, esta_nombre
                FROM Personal_Grupo P, GRUPO G, CURSO C, Modalidad_Aprendizaje M, CALENDARIO CA, Estado E
                WHERE P.usua_id_usuario = $id
                    AND G.CURS_ID_CURSO = C.CURS_ID_CURSO AND G.grup_id_grupo = P.grup_id_grupo
                    AND G.moap_id_modalidad = M.moap_id_modalidad
                    AND G.CALE_ID_CALENDARIO = CA.CALE_ID_CALENDARIO
                    AND G.ESTA_ID_ESTADO = E.ESTA_ID_ESTADO
                ORDER BY GRUP_ID_GRUPO ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
    }

    //Permite Consultar las inscripciones de un grupo
    //? Verificado en la BD 06/07/2021
    function buscarInscripcionesxGrupo($ID)
    {
        $SQL_Bus_Cursos =
        "
            SELECT insc_id_inscripcion, pers_apellido_paterno, pers_apellido_materno, pers_nombre, pers_correo, insc_aprobado
            FROM Inscripcion I, Profesor p, Persona E 
            WHERE I.prof_id_profesor = P.prof_id_profesor 
                AND P.pers_id_persona = E.pers_id_persona AND grup_id_grupo = $ID 
                AND I.insc_activo = TRUE
            ORDER BY pers_apellido_paterno ASC;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cursos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Permite consultar el nombre de un curso por el ID del grupo
    //? Verificado en la BD 06/07/2021
    /*SELECT curs_nombre, curs_nivel, curs_tipo, mode_id_moderador, prof_id_profesor, plat_id_plataforma, salo_id_salon, grup_modalidad
                FROM Curso C, Grupo G
            WHERE C.curs_id_cursos=G.curs_id_cursos AND grup_id_grupo = $ID;*/
    function buscarNombreCursoxGrupo($ID)
    {
        $SQL_Bus_Curso =
        "   
                SELECT curs_nombre, curs_nivel, curs_tipo, P.usua_id_usuario, plat_id_plataforma, salo_id_salon, M.moap_id_modalidad, moap_nombre, 
                    (SELECT P.usua_id_usuario
                    FROM Personal_grupo P, Usuario U
                    WHERE P.usua_id_usuario = U.usua_id_usuario AND rol_id_rol = 3 AND p.grup_id_grupo = $ID) as id_moderador
                FROM Curso C, Grupo G, Personal_grupo P, Usuario U, Modalidad_Aprendizaje M
                WHERE C.curs_id_curso=G.curs_id_curso AND g.grup_id_grupo = P.grup_id_grupo
                    AND P.usua_id_usuario = U.usua_id_usuario AND G.moap_id_modalidad = M.moap_id_modalidad
                    AND rol_id_rol = 2 AND G.grup_id_grupo = $ID;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Curso);
        $obj_Grupo = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

        

    //? Ninguno de los siguientes métodos se utiliza actualmente 24/06/2021
    //? Deprecated
    /*Los métodos a partir de aqui están diferenciados pero los de arriba estan creados para permitir un trato indiferente para los 2 tipos de cursos, para una facilidad de manejo*/
    //Permite agregar un grupo presencial
    function agregarGrupoPresencial($moderador, $profesor, $curso, $salon, $calendario, $cupo, $estado, $activo, $modalidad, $tipo_grupo, $inicio_insc, $fin_insc)
    {
        $SQL_Ins_Grupo =
        "   INSERT INTO Grupo (mode_id_moderador, prof_id_profesor, curs_id_cursos, salo_id_salon, cale_id_calendario, 
                    grup_cupo, grup_estado, grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc)
                VALUES ($moderador, $profesor, $curso, $salon, $calendario, $cupo, $estado, $activo, $modalidad, $tipo_grupo, $inicio_insc, $fin_insc);
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Ins_Grupo);
        $bd->cerrarBD();
        //$this->id_grupo = Grupo::buscarUltimo();
    }

    //Permite agregar un grupo en línea
    function agregarGrupoWebinar(
        $moderador,
        $profesor,
        $curso,
        $plataforma,
        $calendario,
        $reunion,
        $acceso,
        $clave,
        $cupo,
        $estado,
        $activo,
        $modalidad,
        $tipo_grupo,
        $inicio_insc,
        $fin_insc
    ) {
        $SQL_Ins_Grupo =
        "   INSERT INTO Grupo (mode_id_moderador, prof_id_profesor, curs_id_cursos,  plat_id_plataforma, cale_id_calendario, grup_reunion, grup_acceso, grup_clave_acceso,  
                    grup_cupo, grup_estado, grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc)
                VALUES ($moderador, $profesor, $curso, $plataforma, $calendario, $reunion, $acceso, $clave, $cupo, $estado, $activo, $modalidad, $tipo_grupo, $inicio_insc, $fin_insc);
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Ins_Grupo);
        $bd->cerrarBD();
        //$this->id_grupo = Grupo::buscarUltimo();
    }

    //Permite actualizar un grupo presencial
    function actualizarGrupoPresencial($grupo, $moderador, $profesor, $salon, $cupo, $estado, $activo, $inicio_insc, $fin_insc)
    {
        $SQL_Actua_Grupo =
        "   UPDATE grupo
                SET mode_id_moderador = $moderador, prof_id_profesor = $profesor, salo_id_salon = $salon, grup_cupo = $cupo, 
                    grup_estado = $estado, grup_activo = $activo, grup_inicio_insc = $inicio_insc, grup_fin_insc = $fin_insc
                WHERE grup_id_grupo = $grupo;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Actua_Grupo);
        $bd->cerrarBD();
    }

    //Permite actualizar un grupo en linea
    function actualizarGrupoWeb($grupo, $moderador, $profesor, $plataforma, $reunion, $acceso, $clave, $cupo, $estado, $activo, $inicio_insc, $fin_insc)
    {
        $SQL_Actua_Grupo =
        "   UPDATE grupo
                SET mode_id_moderador = $moderador, prof_id_profesor = $profesor, plat_id_plataforma = $plataforma, grup_reunion = $reunion, grup_acceso = $acceso, grup_clave_acceso = $clave,
                grup_cupo = $cupo, grup_estado = $estado, grup_activo = $activo, grup_inicio_insc = $inicio_insc, grup_fin_insc = $fin_insc
                WHERE grup_id_grupo = $grupo;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Actua_Grupo);
        $bd->cerrarBD();
    }

    //Permite obtener todos los grupos de modalidad Presencial
    function buscarTodosGruposPresencial()
    {
        $SQL_Bus_Cursos =
        "   SELECT g.grup_id_grupo, g.curs_id_curso, curs_nombre, ( edif_nombre || salo_nombre) as salon, g.esta_id_estado, esta_nombre,
                    g.moap_id_modalidad, moap_nombre, grup_url, grup_id_acceso, grup_clave_acceso, grup_cupo, grup_num_inscritos, grup_publicado,
                    grup_tipo, grup_inicio_insc, grup_fin_insc, pg.usua_id_usuario, pers_nombre, pers_apellido_paterno, pers_apellido_materno
                FROM Grupo g, Curso c, salon s, edificio ed,estado e, modalidad_aprendizaje m, personal_grupo pg, usuario u, persona pe
                WHERE g.curs_id_curso = c.curs_id_curso AND g.salo_id_salon = s.salo_id_salon AND s.edif_id_edificio = ed.edif_id_edificio 
                    AND g.esta_id_estado = e.esta_id_estado	AND g.moap_id_modalidad = m.moap_id_modalidad AND g.grup_id_grupo = pg.grup_id_grupo 
                    AND pg.usua_id_usuario = u.usua_id_usuario	AND u.pers_id_persona = pe.pers_id_persona AND rol_id_rol = 2 
                    AND g.moap_id_modalidad = 1
                ORDER BY grup_id_grupo ASC;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cursos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Permite obtener todos los grupos de modalidad en Linea
    //? Verificado en la BD 06/07/2021
    function buscarTodosWebinar()
    {
        $SQL_Bus_Cursos =
        "   SELECT g.grup_id_grupo, g.curs_id_curso, curs_nombre, g.plat_id_plataforma, plat_nombre, g.esta_id_estado, esta_nombre,
                    g.moap_id_modalidad, moap_nombre, grup_url, grup_id_acceso, grup_clave_acceso, grup_cupo, grup_num_inscritos, grup_publicado,
                    grup_tipo, grup_inicio_insc, grup_fin_insc, pg.usua_id_usuario, pers_nombre, pers_apellido_paterno, pers_apellido_materno
                FROM Grupo g, Curso c, plataforma p, estado e, modalidad_aprendizaje m, personal_grupo pg, usuario u, persona pe
                WHERE g.curs_id_curso = c.curs_id_curso AND g.plat_id_plataforma = p.plat_id_plataforma AND g.esta_id_estado = e.esta_id_estado
                    AND g.moap_id_modalidad = m.moap_id_modalidad AND g.grup_id_grupo = pg.grup_id_grupo AND pg.usua_id_usuario = u.usua_id_usuario
                    AND u.pers_id_persona = pe.pers_id_persona AND rol_id_rol = 2 AND g.moap_id_modalidad = 2
                ORDER BY grup_id_grupo ASC;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cursos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //permite obtener un grupo presencial por id
    //Acoplar este método y el siguiente para que muestren los datos del formulario unicamente, no necesitas los id realmente.
    //? Verificado en la BD 06/07/2021
    function buscarGrupoPresencial($id)
    {
        $SQL_Bus_Curso =
        "   SELECT g.grup_id_grupo, g.curs_id_curso, curs_nombre, ( edif_nombre || salo_nombre) as salon, g.esta_id_estado, esta_nombre,
                    g.moap_id_modalidad, moap_nombre, grup_url, grup_id_acceso, grup_clave_acceso, grup_cupo, grup_num_inscritos, grup_publicado,
                    grup_tipo, grup_inicio_insc, grup_fin_insc, pg.usua_id_usuario, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    (SELECT pers_nombre || ' ' || pers_apellido_paterno || ' ' || pers_apellido_materno 
                    FROM personal_grupo pg, usuario u, persona p
                    WHERE pg.grup_id_grupo = $id AND pg.usua_id_usuario = u.usua_id_usuario AND u.pers_id_persona = p.pers_id_persona
                        AND rol_id_rol = 3) as moderador
                FROM Grupo g, Curso c, salon s, edificio ed,estado e, modalidad_aprendizaje m, personal_grupo pg, usuario u, persona pe
                WHERE g.curs_id_curso = c.curs_id_curso AND g.salo_id_salon = s.salo_id_salon AND s.edif_id_edificio = ed.edif_id_edificio 
                    AND g.esta_id_estado = e.esta_id_estado	AND g.moap_id_modalidad = m.moap_id_modalidad AND g.grup_id_grupo = pg.grup_id_grupo 
                    AND pg.usua_id_usuario = u.usua_id_usuario	AND u.pers_id_persona = pe.pers_id_persona AND rol_id_rol = 2 
                    AND g.moap_id_modalidad = 1 AND g.grup_id_grupo = $id;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Curso);
        $obj_Grupo = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //permite obtener un grupo en linea por id
    //? Verificado en la BD 06/07/2021
    function buscarGrupoWeb($id)
    {
        $SQL_Bus_Curso =
        "   SELECT g.grup_id_grupo, g.curs_id_curso, curs_nombre, g.plat_id_plataforma, plat_nombre, g.esta_id_estado, esta_nombre,
                    g.moap_id_modalidad, moap_nombre, grup_url, grup_id_acceso, grup_clave_acceso, grup_cupo, grup_num_inscritos, grup_publicado,
                    grup_tipo, grup_inicio_insc, grup_fin_insc, pg.usua_id_usuario, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    (SELECT pers_nombre || ' ' || pers_apellido_paterno || ' ' || pers_apellido_materno 
                    FROM personal_grupo pg, usuario u, persona p
                    WHERE pg.grup_id_grupo = $id AND pg.usua_id_usuario = u.usua_id_usuario AND u.pers_id_persona = p.pers_id_persona
                        AND rol_id_rol = 3) as moderador
                FROM Grupo g, Curso c, plataforma p, estado e, modalidad_aprendizaje m, personal_grupo pg, usuario u, persona pe
                WHERE g.curs_id_curso = c.curs_id_curso AND g.plat_id_plataforma = p.plat_id_plataforma AND g.esta_id_estado = e.esta_id_estado
                    AND g.moap_id_modalidad = m.moap_id_modalidad AND g.grup_id_grupo = pg.grup_id_grupo AND pg.usua_id_usuario = u.usua_id_usuario
                    AND u.pers_id_persona = pe.pers_id_persona AND rol_id_rol = 2 AND g.moap_id_modalidad = 2 AND g.grup_id_grupo = $id;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Curso);
        $obj_Grupo = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }
}
