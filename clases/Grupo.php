<?php
    class Grupo
    {
        //Permite agregar un grupo presencial
        function agregarGrupo($moderador, $profesor, $curso, $salon, $calendario, $cupo, $estado, $activo, $modalidad, $tipo_grupo, $inicio_insc, $fin_insc)
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
            $this->id_grupo = Grupo::buscarUltimo();
        }

        //Permite agregar un grupo en línea
        function agregarGrupoWebinar($moderador, $profesor, $curso, $plataforma, $calendario, $reunion, $acceso, $clave, $cupo, $estado, $activo, $modalidad, $tipo_grupo, $inicio_insc, $fin_insc)
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
            $this->id_grupo = Grupo::buscarUltimo();
        }

        //Permite actualizar un grupo presencial
        function actualizarGrupo($grupo, $moderador, $profesor, $salon, $cupo, $estado, $activo, $inicio_insc, $fin_insc)
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

        function buscarUltimo()
        {
            $bd = new BD();
            $SQL_Bus_Grupo_Seq = "SELECT last_value FROM grupo_grup_id_grup_seq;";

            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupo_Seq);
            $obj_Grupo_Seq = $transaccion_1->traerObjeto(0);
            $Grupo_Seq = $obj_Grupo_Seq->last_value;
            $bd->cerrarBD();

            return $Grupo_Seq;
        }

        //Permite obtener todos los grupos de modalidad Presencial
        function buscarTodosGruposPresencial()
        {
            $SQL_Bus_Cursos = 
            "   SELECT g.grup_id_grupo id_grupo, g.prof_id_profesor id_profesor, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_cursos, curs_nombre, grup_cupo,  grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado,
                    (edif_nombre || '/' ||salo_nombre) salon, 
                    (SELECT pers_nombre || ' ' || pers_apellido_paterno || ' ' || pers_apellido_materno
					 FROM grupo g, moderador m, persona p
					 WHERE g.mode_id_moderador = m.mode_id_moderador AND m.pers_id_persona = p.pers_id_persona
					) as moderador
                FROM grupo g, profesor p, persona pr, curso c, plataforma pl, calendario ca, salon s, edificio e 
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
                    AND g.cale_id_calendario = ca.cale_id_calendario AND g.salo_id_salon = s.salo_id_salon AND s.edif_id_edificio = e.edif_id_edificio
                    AND lower(grup_modalidad) NOT LIKE '%linea%'
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
                    grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado,
                    (SELECT pers_nombre || ' ' || pers_apellido_paterno || ' ' || pers_apellido_materno
					 FROM grupo g, moderador m, persona p
					 WHERE g.mode_id_moderador = m.mode_id_moderador AND m.pers_id_persona = p.pers_id_persona
					) as moderador
                FROM grupo g, profesor p, persona pr, curso c, plataforma pl, calendario ca
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
                    AND g.plat_id_plataforma = pl.plat_id_plataforma AND g.cale_id_calendario = ca.cale_id_calendario 
                    AND lower(grup_modalidad) LIKE '%linea%'
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
        function buscarGrupo($id)
        {
            $SQL_Bus_Curso = 
            "   SELECT g.grup_id_grupo id_grupo, g.prof_id_profesor id_profesor, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_cursos, curs_nombre, grup_cupo,  grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado,
                    (edif_nombre || '/' ||salo_nombre) salon,
                    (SELECT pers_nombre || ' ' || pers_apellido_paterno || ' ' || pers_apellido_materno
					 FROM grupo g, moderador m, persona p
					 WHERE g.mode_id_moderador = m.mode_id_moderador AND m.pers_id_persona = p.pers_id_persona
                        AND g.grup_id_grupo = $id;
					) as moderador
                FROM grupo g, profesor p, persona pr, curso c, plataforma pl, calendario ca, salon s, edificio e 
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
                    AND g.cale_id_calendario = ca.cale_id_calendario AND g.salo_id_salon = s.salo_id_salon AND s.edif_id_edificio = e.edif_id_edificio
                    AND lower(grup_modalidad) NOT LIKE '%linea%' AND g.grup_id_grupo = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Curso);
            $obj_Grupo = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        function buscarGrupoTipoEvento($id)
        {
            $SQL_Bus_Curso = 
            "   SELECT grup_id_grup, even_id_tiev
                FROM grupo, evento
                WHERE even_id_even = grup_id_even AND grup_id_grup = $id;
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
            "   SELECT g.grup_id_grupo id_grupo, g.prof_id_profesor id_profesor, pers_nombre, pers_apellido_paterno, pers_apellido_materno,
                    g. curs_id_cursos, curs_nombre, 
                    g.plat_id_plataforma id_plataforma, plat_nombre plataforma, grup_reunion, grup_acceso, grup_clave_acceso, grup_cupo,  
                    grup_activo, grup_modalidad, grup_tipo, grup_inicio_insc, grup_fin_insc, grup_estado,
                    (SELECT pers_nombre || ' ' || pers_apellido_paterno || ' ' || pers_apellido_materno
					 FROM grupo g, moderador m, persona p
					 WHERE g.mode_id_moderador = m.mode_id_moderador AND m.pers_id_persona = p.pers_id_persona
                        AND g.grup_id_grupo = $id;
					) as moderador
                FROM grupo g, profesor p, persona pr, curso c, plataforma pl, calendario ca
                WHERE g.prof_id_profesor = p.prof_id_profesor AND p.pers_id_persona = pr.pers_id_persona AND g.curs_id_cursos = c.curs_id_cursos 
                    AND g.plat_id_plataforma = pl.plat_id_plataforma AND g.cale_id_calendario = ca.cale_id_calendario 
                    AND lower(grup_modalidad) LIKE '%linea%' AND g.grup_id_grupo = $id;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Curso);
            $obj_Grupo = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        function buscarTipoEvento($id)
        {
            $SQL_Bus_Curso = 
            "   SELECT even_id_tiev
                FROM grupo, evento
                WHERE  even_id_even = grup_id_even AND grup_id_grup = $id
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