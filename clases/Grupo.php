<?php
    class Grupo
    {
        //Permite agregar cualquier tipo de grupo
        function agregarGrupo($moderador, $profesor, $curso, $salon, $plataforma, $reunion, $acceso, $clave, $cupo, $estado, $activo,
         $modalidad, $tipo_grupo, $inicio_insc, $fin_insc)
        {
            $SQL_Ins_Grupo = 
            "   INSERT INTO Grupo (mode_id_moderador, prof_id_profesor, curs_id_cursos, salo_id_salon, cale_id_calendario, plat_id_plataforma, grup_reunion, grup_acceso, grup_clave_acceso,  
                            grup_cupo, grup_estado, grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc)
                            VALUES ($moderador, $profesor, $curso, $salon, (SELECT cale_id_calendario
                                                                            FROM Calendario
                                                                            WHERE cale_activo = TRUE), 
                                    $plataforma, '$reunion', '$acceso','$clave', $cupo, '$estado', $activo, '$modalidad', '$tipo_grupo', '$inicio_insc', '$fin_insc')
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Grupo);
            $bd->cerrarBD();

        }

        //Permite Actualizar Cualquier tipo de grupo
        //No actualiza curs_id_cursos, grup_modalidad, grup_activo ni cale_id_calendario. Por los requerimientos del sistema.
        function actualizarGrupo($grupo, $tipo_grupo, $estado, $profesor, $moderador, $cupo, $inicio_insc, $fin_insc, $salon, $plataforma, $reunion, $acceso, $clave)
        { 
            $SQL_Actua_Grupo =
            "   UPDATE grupo
                SET grup_tipo = '$tipo_grupo', grup_estado = '$estado', prof_id_profesor = $profesor, mode_id_moderador = $moderador,
                grup_cupo = $cupo, grup_inicio_insc = '$inicio_insc', grup_fin_insc = '$fin_insc',
                salo_id_salon = $salon, plat_id_plataforma = $plataforma, grup_reunion = '$reunion', grup_acceso = '$acceso', grup_clave_acceso = '$clave'
                WHERE grup_id_grupo = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Actua_Grupo);
            $bd->cerrarBD();
        }

        //Busca los correos de los profesores inscritos a un grupo.
        function buscarCorreosDeParticipantes($ID)
        {
            $SQL_Bus_Cursos = 
            "   
            SELECT ( Pers.pers_apellido_paterno || ' ' || pers_apellido_materno || ' ' || Pers.pers_nombre) AS nombre , Pers.pers_correo 
            FROM Persona Pers, Inscripcion I, Grupo G, Profesor Prof
            WHERE G.grup_id_grupo = $ID AND I.grup_id_grupo = G.grup_id_grupo AND I.prof_id_profesor = Prof.prof_id_profesor AND Prof.pers_id_persona = Pers.pers_id_persona
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Cursos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Permite Consultar cualquier tipo de grupo
        function buscarGrupo($id)
        {
            $SQL_Bus_Curso = 
            "   SELECT g.grup_id_grupo, g.prof_id_profesor, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_cursos, curs_nombre, curs_tipo, curs_nivel,  curs_num_sesiones,
                    g.plat_id_plataforma, grup_reunion, grup_acceso, grup_clave_acceso, grup_cupo,  
                    grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado,
                    (SELECT pers_apellido_paterno || ' ' || pers_apellido_materno || ' ' || pers_nombre
					 FROM grupo g, moderador m, persona p
					 WHERE g.mode_id_moderador = m.mode_id_moderador AND m.pers_id_persona = p.pers_id_persona
                        AND g.grup_id_grupo = $id
					) as moderador
                FROM grupo g, profesor p, persona pr, curso c, calendario ca 
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
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
        function buscarTodosGrupos()
        {
            $SQL_Bus_Cursos = 
            "   SELECT g.grup_id_grupo, g.prof_id_profesor, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_cursos, curs_nombre, grup_num_inscritos,
                    g.plat_id_plataforma, grup_reunion, grup_acceso, grup_clave_acceso, grup_cupo,  
                    grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado
                FROM grupo g, profesor p, persona pr, curso c, calendario ca 
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
                    AND g.cale_id_calendario = ca.cale_id_calendario 
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
        los profesores, para ello deben estar publicados, aprobados y públicos
        */
        function buscarGruposProfesores()
        {
            $SQL_Bus_Cursos = 
            "   SELECT g.grup_id_grupo, g.prof_id_profesor, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_cursos, curs_nombre, curs_tipo, curs_num_sesiones, curs_nivel, curs_objetivos,
                    g.plat_id_plataforma, grup_reunion, grup_acceso, grup_clave_acceso, grup_cupo,  grup_num_inscritos,
                    grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado
                FROM grupo g, profesor p, persona pr, curso c, calendario ca 
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
                    AND g.cale_id_calendario = ca.cale_id_calendario AND grup_tipo = 'Público' AND grup_estado = 'Aprobado' AND grup_activo = true
                ORDER BY g.grup_id_grupo DESC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Cursos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        // Permite Cambiar estatus_activo grupo
        function cambiarEstatus($id, $activo)
        {
            $SQL_Act_Curso = 
            "   UPDATE grupo
                SET grup_activo = $activo
                WHERE grup_id_grupo = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Act_Curso);
            $bd->cerrarBD();
        }

        //Permite obtener los grupos a los cuales se ha inscrito un profesor
        function gruposInscritosxProfesor($idProfesor)
        {
            $SQL_Act_Curso = 
            "   
            SELECT I.PROF_ID_PROFESOR, I.GRUP_ID_GRUPO, C.CURS_ID_CURSOS, GRUP_MODALIDAD, CONS_ID_CONSTANCIAS,
                CURS_NOMBRE, CURS_NUM_SESIONES, G.PLAT_ID_PLATAFORMA, GRUP_REUNION, CALE_SEMESTRE
            FROM INSCRIPCION I, GRUPO G, CURSO C, PROFESOR P, CALENDARIO CA
            WHERE I.PROF_ID_PROFESOR = $idProfesor
                AND I.GRUP_ID_GRUPO = G.GRUP_ID_GRUPO 
                AND G.CURS_ID_CURSOS = C.CURS_ID_CURSOS 
                AND G.PROF_ID_PROFESOR = P.PROF_ID_PROFESOR 
                AND G.CALE_ID_CALENDARIO = CA.CALE_ID_CALENDARIO 
            ORDER BY I.GRUP_ID_GRUPO DESC;
            ";
            
            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Act_Curso);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Permite obtener todos los grupos activos a los cuales se ha inscrito un profesor
        function gruposInscritosActivosxProfesor($idProfesor)
        {
            $SQL_Act_Curso = 
            "   
            SELECT I.PROF_ID_PROFESOR, I.GRUP_ID_GRUPO
            FROM INSCRIPCION I, GRUPO G, CURSO C, PROFESOR P, CALENDARIO CA 
            WHERE I.PROF_ID_PROFESOR = $idProfesor
                AND I.GRUP_ID_GRUPO = G.GRUP_ID_GRUPO 
                AND G.CURS_ID_CURSOS = C.CURS_ID_CURSOS 
                AND G.PROF_ID_PROFESOR = P.PROF_ID_PROFESOR 
                AND G.CALE_ID_CALENDARIO = CA.CALE_ID_CALENDARIO 
                AND grup_activo = true
            ORDER BY I.GRUP_ID_GRUPO DESC;
            ";
            
            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Act_Curso);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        function buscarDatosEnLinea($id)
        {
            $SQL_Bus_Grupo = 
            "  
                SELECT PLAT_NOMBRE, GRUP_ACCESO
                FROM GRUPO G, PLATAFORMA PA
                WHERE G.PLAT_ID_PLATAFORMA=PA.PLAT_ID_PLATAFORMA AND GRUP_MODALIDAD='En línea' 
                AND GRUP_ID_GRUPO=$id 
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo);
            $obj_Grupo = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        function buscarDatosPresencial($id)
        {
            $SQL_Bus_Grupo = 
            "   
                SELECT GRUP_MODALIDAD, SALO_NOMBRE, EDIF_NOMBRE 
                FROM GRUPO G, PLATAFORMA PA, SALON S, EDIFICIO E
                WHERE G.SALO_ID_SALON=S.SALO_ID_SALON AND S.EDIF_ID_EDIFICIO = E.EDIF_ID_EDIFICIO 
                AND GRUP_MODALIDAD='Presencial' AND GRUP_ID_GRUPO=$id

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
        function buscarSoloGrupo($id){
            $SQL_Bus_SoloGrupo = 
            "
                SELECT grup_id_grupo, mode_id_moderador, prof_id_profesor, curs_id_cursos,  salo_id_salon, plat_id_plataforma, cale_id_calendario, grup_reunion, grup_acceso, grup_clave_acceso,  
                    grup_cupo, grup_estado, grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_num_inscritos
                FROM Grupo
                WHERE grup_id_grupo = $id
                ";

                $bd = new BD();
                $bd->abrirBD();
                $transaccion_1 = new Transaccion($bd->conexion);
                $transaccion_1->enviarQuery($SQL_Bus_SoloGrupo);
                $obj_Grupo = $transaccion_1->traerObjeto(0);
                $bd->cerrarBD();
                return ($transaccion_1->traerObjeto(0));
        }

        //Busca los grupos que imparte un profesor
        function buscarGruposImpartidosxProfesor($id){
			$SQL_Bus_Grupos =
            "	
                SELECT GRUP_ID_GRUPO, C.CURS_ID_CURSOS, GRUP_MODALIDAD,
                    CURS_NOMBRE, CURS_NUM_SESIONES, G.PLAT_ID_PLATAFORMA, 
                    GRUP_REUNION, CALE_SEMESTRE, grup_num_inscritos, GRUP_ACTIVO
                FROM GRUPO G, CURSO C, PROFESOR P, CALENDARIO CA
                WHERE G.PROF_ID_PROFESOR = $id
                    AND G.CURS_ID_CURSOS = C.CURS_ID_CURSOS 
                    AND G.PROF_ID_PROFESOR = P.PROF_ID_PROFESOR 
                    AND G.CALE_ID_CALENDARIO = CA.CALE_ID_CALENDARIO
                ORDER BY GRUP_ACTIVO DESC,
                        GRUP_ID_GRUPO DESC;
            ";

                $bd = new BD();
                $bd->abrirBD();
                $transaccion_1 = new Transaccion($bd->conexion);
                $transaccion_1->enviarQuery($SQL_Bus_Grupos);
                $bd->cerrarBD();
                return ($transaccion_1->traerRegistros());
		}

        //Permite Consultar las inscripciones de un grupo 
        function buscarInscripcionesxGrupo($ID)
        {
            $SQL_Bus_Cursos = 
            "   
            SELECT pers_apellido_paterno, pers_apellido_materno, pers_nombre, pers_correo
            FROM Inscripcion I, Profesor p, Persona E 
            WHERE I.prof_id_profesor = P.prof_id_profesor 
            AND P.pers_id_persona = E.pers_id_persona AND grup_id_grupo = $ID 
            ORDER BY pers_apellido_paterno, pers_apellido_materno, pers_nombre DESC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Cursos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Permite consultar el nombre de un curso por el ID del grupo
        function buscarNombreCursoxGrupo($ID){
            $SQL_Bus_Curso = 
            "   
                SELECT curs_nombre, curs_nivel, curs_tipo, mode_id_moderador, prof_id_profesor, plat_id_plataforma, salo_id_salon, grup_modalidad
                FROM Curso C, Grupo G
                WHERE C.curs_id_cursos=G.curs_id_cursos AND grup_id_grupo = $ID;
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
        function agregarGrupoWebinar($moderador, $profesor, $curso, $plataforma, $calendario, $reunion, $acceso, $clave, $cupo, $estado, $activo, $modalidad, 
        $tipo_grupo, $inicio_insc, $fin_insc)
        {
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
            "   SELECT g.grup_id_grupo, g.prof_id_profesor, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_cursos, curs_nombre, grup_cupo,  grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado,
                    (edif_nombre || '/' ||salo_nombre) salon 
                    /*(SELECT pers_nombre || ' ' || pers_apellido_paterno || ' ' || pers_apellido_materno
					 FROM grupo g, moderador m, persona p
					 WHERE g.mode_id_moderador = m.mode_id_moderador AND m.pers_id_persona = p.pers_id_persona
					) as moderador*/
                FROM grupo g, profesor p, persona pr, curso c, plataforma pl, calendario ca, salon s, edificio e 
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
                    AND g.cale_id_calendario = ca.cale_id_calendario AND g.salo_id_salon = s.salo_id_salon AND s.edif_id_edificio = e.edif_id_edificio
                    AND lower(grup_modalidad) NOT LIKE '%l_nea%'
                ORDER BY g.grup_id_grupo DESC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Cursos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Permite obtener todos los grupos de modalidad en Linea
        function buscarTodosWebinar()
        {
            $SQL_Bus_Cursos = 
            "   SELECT g.grup_id_grupo, g.prof_id_profesor, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g.curs_id_cursos, curs_nombre, 
                    g.plat_id_plataforma id_plataforma, plat_nombre plataforma, grup_reunion, grup_acceso, grup_clave_acceso, grup_cupo,  
                    grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado
                    /*(SELECT pers_nombre || ' ' || pers_apellido_paterno || ' ' || pers_apellido_materno
					 FROM grupo g, moderador m, persona p
					 WHERE g.mode_id_moderador = m.mode_id_moderador AND m.pers_id_persona = p.pers_id_persona
					) as moderador*/
                FROM grupo g, profesor p, persona pr, curso c, plataforma pl, calendario ca
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
                    AND g.plat_id_plataforma = pl.plat_id_plataforma AND g.cale_id_calendario = ca.cale_id_calendario 
                    AND lower(grup_modalidad) LIKE '%l_nea%'
                ORDER BY g.grup_id_grupo DESC;
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
        function buscarGrupoPresencial($id)
        {
            $SQL_Bus_Curso = 
            "   SELECT g.grup_id_grupo, g.prof_id_profesor, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_cursos, curs_nombre, grup_cupo,  grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado,
                    (edif_nombre || '/' ||salo_nombre) salon,
                    (SELECT pers_nombre || ' ' || pers_apellido_paterno || ' ' || pers_apellido_materno
					 FROM grupo g, moderador m, persona p
					 WHERE g.mode_id_moderador = m.mode_id_moderador AND m.pers_id_persona = p.pers_id_persona
                        AND g.grup_id_grupo = $id
					) as moderador
                FROM grupo g, profesor p, persona pr, curso c, plataforma pl, calendario ca, salon s, edificio e 
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
                    AND g.cale_id_calendario = ca.cale_id_calendario AND g.salo_id_salon = s.salo_id_salon AND s.edif_id_edificio = e.edif_id_edificio
                    AND lower(grup_modalidad) NOT LIKE '%l_nea%' AND g.grup_id_grupo = $id;
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
        function buscarGrupoWeb($id)
        {
            $SQL_Bus_Curso = 
            "   SELECT g.grup_id_grupo, g.prof_id_profesor, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_cursos, curs_nombre, 
                    g.plat_id_plataforma id_plataforma, plat_nombre plataforma, grup_reunion, grup_acceso, grup_clave_acceso, grup_cupo,  
                    grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado,
                    (SELECT pers_nombre || ' ' || pers_apellido_paterno || ' ' || pers_apellido_materno
					 FROM grupo g, moderador m, persona p
					 WHERE g.mode_id_moderador = m.mode_id_moderador AND m.pers_id_persona = p.pers_id_persona
                        AND g.grup_id_grupo = $id
					) as moderador
                FROM grupo g, profesor p, persona pr, curso c, plataforma pl, calendario ca
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
                    AND g.plat_id_plataforma = pl.plat_id_plataforma AND g.cale_id_calendario = ca.cale_id_calendario 
                    AND lower(grup_modalidad) LIKE '%l_nea%' AND g.grup_id_grupo = $id;
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
?>