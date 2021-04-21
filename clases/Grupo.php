<?php
    class Grupo
    {
        function agregarGrupo($estatus_grupo, $evento, $modalidad, $profesor, $clave, $cupo)
        {
            $SQL_Ins_Grupo =
            "   INSERT INTO grupo(grup_id_esgr, grup_id_even, grup_id_mogr, grup_id_prof, grup_clave, grup_cupo)
                VALUES ($estatus_grupo, $evento, $modalidad, $profesor, '$clave', $cupo);
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Grupo);
            $bd->cerrarBD();
            $this->id_grupo = Grupo::buscarUltimo();
        }

        function agregarGrupoWebinar($estatus_grupo, $evento, $modalidad, $tipo_grupo, $clave, $cupo, $costo, $descuento)
        {
            $SQL_Ins_Grupo =
            "   INSERT INTO grupo(grup_id_esgr, grup_id_even, grup_id_mogr, grup_id_tigr, grup_clave, grup_cupo, grup_costo, grup_descuento)
                VALUES ($estatus_grupo, $evento, $modalidad, $tipo_grupo, '$clave', $cupo, $costo, $descuento);
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Ins_Grupo);
            $bd->cerrarBD();
            $this->id_grupo = Grupo::buscarUltimo();
        }

        function actualizarGrupo($grupo, $estatus_grupo, $evento, $modalidad, $profesor, $clave, $cupo)
        {
            $SQL_Actua_Grupo =
            "   UPDATE grupo
                SET grup_id_esgr = $estatus_grupo, grup_id_even = $evento, grup_id_mogr = $modalidad, grup_id_prof = $profesor, grup_clave = '$clave', grup_cupo = $cupo
                WHERE grup_id_grup = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Actua_Grupo);
            $bd->cerrarBD();
        }

        function actualizarGrupoWeb($grupo, $estatus_grupo, $evento, $modalidad, $clave, $cupo)
        {
            $SQL_Actua_Grupo =
            "   UPDATE grupo
                SET grup_id_esgr = $estatus_grupo, grup_id_even = $evento, grup_id_mogr = $modalidad, grup_clave = '$clave', grup_cupo = $cupo
                WHERE grup_id_grup = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Actua_Grupo);
            $bd->cerrarBD();
        }

        function eliminarGrupo($grupo)
        {
            $SQL_Eli_Grupo = 
            " DELETE FROM grupo
              WHERE grup_id_grup = $grupo;
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

        function buscarTodosGrupos()
        {
            $SQL_Bus_Cursos = 
            "   SELECT grup_id_grup, grup_clave, tigr_nombre, esgr_nombre, grup_cupo, pers_nombre, pers_primer_ape, pers_segundo_ape, even_nombre, mogr_nombre
                FROM grupo, tipo_grupo, estatus_grupo, persona, profesor, evento, modalidad_grupo
                WHERE esgr_id_esgr = grup_id_esgr AND prof_id_prof = grup_id_prof AND pers_id_pers = prof_id_pers AND even_id_even = grup_id_even AND grup_id_mogr = mogr_id_mogr
                ORDER BY grup_id_grup ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Cursos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        function buscarTodosWebinar()
        {
            $SQL_Bus_Cursos = 
            "   SELECT grup_id_grup, grup_clave, tigr_nombre, esgr_nombre, grup_cupo, even_nombre, mogr_nombre
                FROM grupo, tipo_grupo, estatus_grupo, evento, modalidad_grupo
                WHERE tigr_id_tigr = grup_id_tigr AND esgr_id_esgr = grup_id_esgr AND even_id_even = grup_id_even AND grup_id_mogr = mogr_id_mogr AND even_id_tiev = 4
                ORDER BY grup_id_grup ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Cursos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        function buscarGrupo($id)
        {
            $SQL_Bus_Curso = 
            "   SELECT grup_id_grup, grup_id_tigr, grup_id_mogr, grup_id_esgr, grup_cupo, grup_id_even, grup_id_prof, grup_costo, grup_descuento
                FROM grupo, tipo_grupo, estatus_grupo, persona, profesor, evento, modalidad_grupo
                WHERE  esgr_id_esgr = grup_id_esgr AND prof_id_prof = grup_id_prof AND pers_id_pers = prof_id_pers AND even_id_even = grup_id_even AND mogr_id_mogr = grup_id_mogr AND grup_id_grup = $id
                ORDER BY grup_id_grup ASC;
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

        function buscarGrupoWeb($id)
        {
            $SQL_Bus_Curso = 
            "   SELECT grup_id_grup, grup_id_tigr, grup_id_mogr, grup_id_esgr, grup_cupo, grup_id_even, grup_costo, grup_descuento
                FROM grupo, tipo_grupo, estatus_grupo, evento, modalidad_grupo
                WHERE tigr_id_tigr = grup_id_tigr AND esgr_id_esgr = grup_id_esgr AND even_id_even = grup_id_even AND mogr_id_mogr = grup_id_mogr AND grup_id_grup = $id
                ORDER BY grup_id_grup ASC;
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