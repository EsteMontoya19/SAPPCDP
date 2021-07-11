<?php
    class Busqueda
    {
        //Consultar coordinaciones: id y nombre.
        //? Verificado en la BD 01/07/2021
        function selectCoordinaciones()
        {
            $SQL_Bus_Eventos =
            "   SELECT coor_id_coordinacion, coor_nombre
                FROM Coordinacion
                ORDER BY coor_id_coordinacion ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Eventos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }       

        //Consultar niveles: id y nombre.
        //? Verificado en la BD 01/07/2021
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
        //? Verificado en la BD 01/07/2021
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
        //? Verificado en la BD 01/07/2021
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
        //TODO Verificado en la BD 01/07/2021
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

        //Consultar las preguntas de seguridad: id, pregunta y estado.
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
        //TODO Verificado en la BD 01/07/2021
        function selectSalones()
        {
            $SQL_Bus_Salones =
            "   
                SELECT SALO_ID_SALON, EDIF_NOMBRE, SALO_NOMBRE 
                FROM SALON S, EDIFICIO E
                WHERE S.EDIF_ID_EDIFICIO = E.EDIF_ID_EDIFICIO
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
        //TODO Verificado en la BD 01/07/2021
        //?Falta PLAT_ACTIVO
        function selectPlataformas()
        {
            $SQL_Bus_Plataformas =
            "   
                SELECT PLAT_ID_PLATAFORMA, PLAT_NOMBRE, PLAT_ACTIVO
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
        //TODO Verificado en la BD 01/07/2021  
        function selectCursosActivos()
        {
            $SQL_Bus_Cursos =
            "   
                SELECT CURS_ID_CURSO, CURS_NOMBRE, CURS_NUM_SESIONES, CURS_TIPO, CURS_NIVEL
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

        //Consulta un salon y el edificio al que pertenece dado el id del salón
        //TODO Verificado en la BD 01/07/2021
        function selectSalon($id)
        {
            $SQL_Bus_Salon =
            "   
                SELECT EDIF_NOMBRE, SALO_NOMBRE 
                FROM SALON S, EDIFICIO E
                WHERE S.EDIF_ID_EDIFICIO = E.EDIF_ID_EDIFICIO AND SALO_ID_SALON = $id
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Salon);
            $obj_Busqueda = $transaccion_1->traerObjeto(0);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }

        //Consulta Todos los estados que puede tener un grupo
        //TODO Verificado en la BD 01/07/2021
        function selectEstadosGrupo()
        {
            $SQL_Bus_Estados =
            "   
                SELECT esta_id_estado, esta_nombre
                FROM Estado;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Estados);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Consulta un estado de un grupo por ID
        //TODO Verificado en la BD 01/07/2021
        function selectEstadoGrupo($id)
        {
            $SQL_Bus_Estado =
            "   
                SELECT esta_id_estado, esta_nombre 
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

        //Consulta un estado de un grupo por nombre
        //TODO Verificado en la BD 01/07/2021
        function selectEstadoGrupoxNombre($nombre)
        {
            $SQL_Bus_Estado =
            "   
                SELECT esta_id_estado, esta_nombre 
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

        //Consulta todas las modalidades de aprendizaje
        //TODO Verificado en la BD 01/07/2021
        function selectModalidadesAprendizaje()
        {
            $SQL_Bus_Modalidades_Aprendizaje =
            "   
                SELECT moap_id_modalidad, moap_nombre, moap_activo
                FROM Modalidad_Aprendizaje;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Modalidades_Aprendizaje);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Consulta todas las modalidades de aprendizaje activas
        //TODO Verificado en la BD 01/07/2021
        function selectModalidadesAprendizajeActivas()
        {
            $SQL_Bus_Modalidades_Aprendizaje =
            "   
                SELECT moap_id_modalidad, moap_nombre, moap_activo
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
        //TODO Verificado en la BD 01/07/2021
        function selectModalidadAprendizaje($id)
        {
            $SQL_Bus_Modalidad_Aprendizaje =
            "   
                SELECT moap_id_modalidad, moap_nombre, moap_activo
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

        //Consulta una modalidad de aprendizaje por nombre
        //TODO Verificado en la BD 01/07/2021
        function selectModalidadAprendizajexNombre($nombre)
        {
            $SQL_Bus_Modalidad_Aprendizaje =
            "   
                SELECT moap_id_modalidad, moap_nombre, moap_activo
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

        //Consulta los cursos que ha tomado un profesor y las veces que lo ha hecho
        function selectVecesInscritoCurso($profesor)
        {
            $SQL_Bus_Veces_Inscrito =
            "   
                SELECT curs_id_curso, COUNT(*) as veces_inscrito
                FROM Inscripcion i, grupo g
                WHERE insc_activo = true AND prof_id_profesor = $profesor
                    AND i.grup_id_grupo = g.grup_id_grupo
                GROUP BY curs_id_curso;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Veces_Inscrito);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //Consulta la cantidad de grupos que ha inscrito un profesor en un semestre (calendario)
        function selectCantidadGruposInscritos($profesor)
        {
            $SQL_Bus_Cant_Grupos =
            "   
                SELECT prof_id_profesor, COUNT(*) as cantidad_grupos
                FROM inscripcion i, grupo g
                WHERE insc_activo = true AND prof_id_profesor = $profesor
                    AND i.grup_id_grupo = g.grup_id_grupo
                    AND cale_id_calendario = (SELECT cale_id_calendario FROM Calendario WHERE cale_activo = true)
                GROUP BY prof_id_profesor;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Cant_Grupos);
            $bd->cerrarBD();
            return ($transaccion_1->traerObjeto(0));
        }
    }
?>