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
            "   SELECT prse_id_pregunta, prse_pregunta, prse_activo
                FROM Pregunta_Seguridad;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Preg);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }

        

        function numeroDias (){
            $SQL_Bus_Eventos =
            "SELECT COUNT (dia_id_dia)
             FROM Dia
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Eventos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
        }
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
        function selectCursosActivos()
        {
            $SQL_Bus_Cursos =
            "   
                SELECT CURS_ID_CURSOS, CURS_NOMBRE, CURS_NUM_SESIONES, CURS_TIPO, CURS_NIVEL
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
    }
?>