<?php
    class Busqueda
    {
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
        function selectPregunta()
        {
            $SQL_Bus_Preg = 
            "   SELECT prse_id_pregunta, prse_pregunta
                FROM Pregunta_Seguridad;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Preg);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        //*TODO: Modificar clases siguientes

        function selectSalones()
        {
            $SQL_Bus_Eventos =
            "   SELECT salo_id_salo, salo_nombre
                FROM salon
                ORDER BY salo_nombre ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Eventos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }  
        function selectPlataformas()
        {
            $SQL_Bus_Plataformas =
            "   
                SELECT PLAT_ID_PLATAFORMA, PLAT_NOMBRE
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
        function selectCursos()
        {
            $SQL_Bus_Cursos =
            "   
                SELECT CURS_ID_CURSOS, CURS_NOMBRE, CURS_TIPO, CURS_NUM_SESIONES
                FROM CURSO
                ORDER BY CURS_NOMBRE ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Cursos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        function selectModalidadGrupo()
        {
            $SQL_Bus_Eventos =
            "   SELECT mogr_id_mogr, mogr_nombre
                FROM modalidad_grupo
                ORDER BY mogr_nombre ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Eventos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        function selectEstatusGrupo()
        {
            $SQL_Bus_Eventos =
            "   SELECT esgr_id_esgr, esgr_nombre
                FROM estatus_grupo
                ORDER BY esgr_nombre ASC;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Eventos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
        function selectTipoEvento()
        {
            $SQL_Bus_Tipo_Evento = 
            "   SELECT tiev_id_tiev, tiev_nombre
                FROM tipo_evento;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Tipo_Evento);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        

        function selectProcedencia()
        {
            $SQL_Bus_Proc = 
            "   SELECT proc_id_proc, proc_nombre
                FROM procedencia;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Proc);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        function selectSistema()
        {
            $SQL_Bus_Sist = 
            "   SELECT sist_id_sist, sist_nombre 
                FROM sistema;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Sist);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        function selectGrado()
        {
            $SQL_Bus_Grad = 
            "   SELECT grac_id_grac, grac_nombre 
                FROM grado_academico;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grad);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        function selectEstatusEstudio()
        {
            $SQL_Bus_Sist = 
            "   SELECT eses_id_eses, eses_nombre
                FROM estatus_estudio
                ORDER BY eses_nombre;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Sist);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        function selectEmprendimientoEstado()
        {
            $SQL_Bus_EmpreEsta = 
            "   SELECT esem_id_emes, esem_nombre
                FROM estatus_emprendimiento;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_EmpreEsta);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
    }
?>