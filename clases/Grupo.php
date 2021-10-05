<?php
//? Clase verificada en la BD 04/10/2021
class Grupo
{
    //? Trea los datos necesario para mostrar los cursos privados qie se encuentran Pendientes
    function buscarGruposPrivados () {
        $SQL_GRUPO = 
        "
            SELECT GRUP_ID_GRUPO, CURS_NOMBRE, CURS_TIPO, CURS_NIVEL, 
                    GRUP_ID_CURSO, GRUP_ID_PLATAFORMA, GRUP_ID_CALENDARIO, 
                    GRUP_ID_SALON, GRUP_ID_ESTADO, GRUP_ID_MODALIDAD, GRUP_URL, 
                    GRUP_ID_ACCESO, GRUP_CLAVE_ACCESO, GRUP_CUPO, 
                    GRUP_NUM_INSCRITOS, GRUP_PUBLICADO, GRUP_TIPO, 
                    GRUP_INICIO_INSC, GRUP_FIN_INSC
            FROM GRUPO, CURSO 
            WHERE GRUP_TIPO LIKE 'PRIVADO'
                AND GRUP_ID_ESTADO = 3
                AND CURS_ID_CURSO = GRUP_ID_CURSO;
        ";
        
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_GRUPO);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }
    //? Se utiliza para cambiar el estado de manera automatica
    function cambiarEstadoGrupo ($grupo, $estado) {
        $SQL_Bus_Grupo =
        "
            UPDATE GRUPO
            SET GRUP_ID_ESTADO = $estado
            WHERE GRUP_ID_GRUPO = $grupo;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Grupo);
        $bd->cerrarBD();
    }

    //Busca datos del instructor
    function buscarDatosInstructorGrupo ($grupo) {
        $SQL_Bus_Grupo =
        "
            SELECT PERS_ID_PERSONA, PERS_NOMBRE, PERS_APELLIDO_PATERNO, 
                    PERS_APELLIDO_MATERNO, PERS_CORREO, PERS_TELEFONO, 
                    PERS_RFC, PROF_SEMBLANZA
            FROM GRUPO, PERSONAL_GRUPO, USUARIO, PERSONA, PROFESOR PR
            WHERE GRUP_ID_GRUPO = PEGR_ID_GRUPO 
                AND USUA_ID_USUARIO = PEGR_ID_USUARIO 
                AND PERS_ID_PERSONA = USUA_ID_PERSONA
                AND PROF_ID_PERSONA = PERS_ID_PERSONA 
                AND GRUP_ID_GRUPO = $grupo AND USUA_ID_ROL = 2;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Grupo);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));

    }

    //? Busca el moderador asignado para un grupo
    function buscarModeradorGrupo ($grupo) {
        $SQL_Bus_Grupo =
        "
            SELECT USUA_ID_USUARIO, PERS_ID_PERSONA, PEGR_ID_GRUPO, 
                    PERS_NOMBRE, PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO
            FROM PERSONAL_GRUPO, USUARIO, PERSONA
            WHERE PEGR_ID_USUARIO = USUA_ID_USUARIO  
                AND PERS_ID_PERSONA = USUA_ID_PERSONA
                AND USUA_ID_ROL = 3 AND PEGR_ID_GRUPO = $grupo
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Grupo);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));

    }

    //Permite agregar cualquier tipo de grupo
    /*No agrega el instructor ni moderador en este método, en el caso de estado y modalidad ahora manda ID*/
    function agregarGrupo($curso,$salon,$plataforma,$url,$acceso,$clave,$cupo,$estado,
                        $activo,$modalidad,$tipo_grupo,$inicio_insc,$fin_insc) {
        $SQL_Ins_Grupo =
        "   
            INSERT INTO GRUPO (GRUP_ID_CURSO, GRUP_ID_SALON, GRUP_ID_CALENDARIO, 
                    GRUP_ID_PLATAFORMA, GRUP_URL, GRUP_ID_ACCESO, GRUP_CLAVE_ACCESO,  
                    GRUP_CUPO, GRUP_ID_ESTADO, GRUP_PUBLICADO, GRUP_ID_MODALIDAD, 
                    GRUP_TIPO, GRUP_INICIO_INSC, GRUP_FIN_INSC)
            VALUES ($curso, $salon, (SELECT CALE_ID_CALENDARIO
                                    FROM CALENDARIO
                                    WHERE CALE_ACTIVO = TRUE), 
                $plataforma, '$url', '$acceso','$clave', $cupo, '$estado', $activo, 
                '$modalidad', '$tipo_grupo', '$inicio_insc', '$fin_insc')
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Ins_Grupo);
        $bd->cerrarBD();
    }

    //Permite Actualizar Cualquier tipo de grupo
    /*No actualiza curs_id_cursos, grup_modalidad, grup_activo ni cale_id_calendario. Por los requerimientos del sistema.
    El estado debe mandar el ID, el instructor y moderador se actualizan en otro método de personal_grupo*/
    function actualizarGrupo($grupo, $tipo_grupo, $estado, $cupo, $inicio_insc, $fin_insc, $salon, $plataforma, $url, $acceso, $clave) {
        $SQL_Actua_Grupo =
        "   
            UPDATE GRUPO
            SET GRUP_TIPO = '$tipo_grupo', 
                GRUP_ID_ESTADO = '$estado',
                GRUP_CUPO = $cupo, 
                GRUP_INICIO_INSC = '$inicio_insc', 
                GRUP_FIN_INSC = '$fin_insc',
                GRUP_ID_SALON = $salon, 
                GRUP_ID_PLATAFORMA = $plataforma, 
                GRUP_URL = '$url', 
                GRUP_ID_ACCESO = '$acceso', 
                GRUP_CLAVE_ACCESO = '$clave'
            WHERE GRUP_ID_GRUPO = $grupo;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Actua_Grupo);
        $bd->cerrarBD();
    }

    //Busca los correos de los profesores inscritos a un grupo.
    function buscarCorreosDeParticipantes($grupo) {
        $SQL_Bus_Cursos =
        "
            SELECT (PERS_APELLIDO_PATERNO || ' ' || PERS_APELLIDO_MATERNO || ' ' || PERS_NOMBRE) AS NOMBRE , 
                    PERS_CORREO, PROF_ID_PROFESOR, PERS_ID_PERSONA, 
                    INSC_ID_INSCRIPCION, INSC_OBSERVACION, INSC_ID_CONSTANCIA
            FROM PERSONA, INSCRIPCION, GRUPO, PROFESOR
            WHERE GRUP_ID_GRUPO = $grupo 
                AND INSC_ID_GRUPO = GRUP_ID_GRUPO 
                AND INSC_ID_PROFESOR = PROF_ID_PROFESOR 
                AND PROF_ID_PERSONA = PERS_ID_PERSONA
                AND INSC_ACTIVO = TRUE ORDER BY NOMBRE
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cursos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    function buscarNoAcreedoresConstancia($idGrupo) {
        $SQL_Acreedor_Constancia =
        "
            SELECT (PERS_APELLIDO_PATERNO || ' ' || PERS_APELLIDO_MATERNO || ' ' || PERS_NOMBRE) AS NOMBRE, 
                    PROF_ID_PROFESOR, PERS_ID_PERSONA, 
                    INSC_ID_INSCRIPCION, CONS_ID_CONSTANCIA
            FROM INSCRIPCION, PROFESOR, PERSONA, CONSTANCIA
            WHERE PROF_ID_PROFESOR = INSC_ID_PROFESOR
                AND PERS_ID_PERSONA = PROF_ID_PERSONA
                AND CONS_ID_CONSTANCIA = INSC_ID_CONSTANCIA
                AND INSC_ACTIVO = TRUE
                AND GRUP_ID_GRUPO = $idGrupo
                AND INSC_ID_INSCRIPCION NOT IN (SELECT DISTINCT INSC_ID_INSCRIPCION
                                                FROM PERSONA, PROFESOR, INSCRIPCION, ASISTENCIA, CONSTANCIA
                                                WHERE PERS_ID_PERSONA = PROF_ID_PERSONA
                                                    AND C.CONS_ID_CONSTANCIAS = INSC_ID_CONSTANCIAS
                                                    AND INSC_ID_PROFESOR = PROF_ID_PROFESOR
                                                    AND INSC_ID_INSCRIPCION = ASIS_ID_INSCRIPCION
                                                    AND INSC_ID_GRUPO = $idGrupo
                                                    AND INSC_ACTIVO = TRUE
                                                    AND PERS_ID_PERSONA NOT IN (SELECT PERS_ID_PERSONA
                                                                                FROM PERSONA, PROFESOR, INSCRIPCION, ASISTENCIA, SESION
                                                                                WHERE PERS_ID_PERSONA = PROF_ID_PERSONA
                                                                                    AND INSC_ID_PROFESOR = PROF_ID_PROFESOR
                                                                                    AND INSC_ID_INSCRIPCION = ASIS_ID_INSCRIPCION
                                                                                    AND SESI_ID_SESION = ASIS_ID_SESIONES
                                                                                    AND INSC_ACTIVO = TRUE
                                                                                    AND INSC_ID_GRUPO = $idGrupo
                                                                                    AND ASIS_PRESENTE = FALSE
                                                                                GROUP BY PERS_ID_PERSONA, 
                                                                                        PERS_NOMBRE, 
                                                                                        PERS_APELLIDO_PATERNO, 
                                                                                        PERS_APELLIDO_MATERNO, 
                                                                                        ASIS_PRESENTE));
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Acreedor_Constancia);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    function buscarAcreedorConstancia($idGrupo){
        $SQL_Acreedor_Constancia =
        "
            SELECT DISTINCT (PERS_APELLIDO_PATERNO || ' ' || PERS_APELLIDO_MATERNO || ' ' || PERS_NOMBRE) AS NOMBRE, 
                    PROF_ID_PROFESOR, PERS_ID_PERSONA, INSC_ID_INSCRIPCION, CONS_ID_CONSTANCIA 
            FROM PERSONA, PROFESOR, INSCRIPCION, ASISTENCIA, CONSTANCIA 
            WHERE PERS_ID_PERSONA = PROF_ID_PERSONA
                AND CONS_ID_CONSTANCIA = INSC_ID_CONSTANCIA
                AND INSC_ID_PROFESOR = PROF_ID_PROFESOR
                AND INSC_ID_INSCRIPCION = ASIS_ID_INSCRIPCION
                AND INSC_ID_GRUPO = $idGrupo
                AND INSC_ACTIVO = TRUE
                AND PERS_ID_PERSONA NOT IN (SELECT PERS_ID_PERSONA
                                        FROM PERSONA, PROFESOR, INSCRIPCION, ASISTENCIA, SESION
                                        WHERE PERS_ID_PERSONA = PROF_ID_PERSONA
                                        AND INSC_ID_PROFESOR = PROF_ID_PROFESOR
                                        AND INSC_ID_INSCRIPCION = ASIS_ID_INSCRIPCION
                                        AND SESI_ID_SESION = ASIS_ID_SESION
                                        AND INSC_ACTIVO = TRUE
                                        AND INSC_ID_GRUPO = $idGrupo
                                        AND ASIS_PRESENTE = FALSE
                                        GROUP BY PERS_ID_PERSONA, PERS_NOMBRE, PERS_APELLIDO_PATERNO, 
                                                PERS_APELLIDO_MATERNO, ASIS_PRESENTE);
		";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Acreedor_Constancia);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros(0));
    }

    //Permite Consultar cualquier tipo de grupo
    function buscarGrupo($id)
    {
        $SQL_Bus_Curso =
        "   
            SELECT GRUP_ID_GRUPO, USUA_ID_USUARIO, PERS_NOMBRE, 
                    PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO, GRUP_ID_CURSO, 
                    CURS_NOMBRE, CURS_TIPO, CURS_NIVEL,  CURS_NUM_SESIONES,
                    GRUP_ID_PLATAFORMA, GRUP_URL, GRUP_ID_ACCESO, GRUP_CLAVE_ACCESO, 
                    GRUP_CUPO, GRUP_PUBLICADO, GRUP_ID_MODALIDAD, GRUP_TIPO, 
                    GRUP_INICIO_INSC, GRUP_FIN_INSC, GRUP_ID_ESTADO,
                        (SELECT PERS_APELLIDO_PATERNO || ' ' || PERS_APELLIDO_MATERNO || ' ' || PERS_NOMBRE
                        FROM PERSONAL_GRUPO, USUARIO, PERSONA
                        WHERE USUA_ID_ROL = 3 
                            AND PEGR_ID_GRUPO = $id
                            AND PEGR_ID_USUARIO = USUA_ID_USUARIO 
                            AND USUA_ID_PERSONA = PERS_ID_PERSONA
                        ) AS MODERADOR
            FROM GRUPO, PERSONAL_GRUPO, USUARIO,PERSONA, CURSO, CALENDARIO 
            WHERE USUA_ID_ROL = 2 
                AND GRUP_ID_GRUPO = PEGR_ID_GRUPO 
                AND PEGR_ID_USUARIO = USUA_ID_USUARIO
                AND USUA_ID_PERSONA = PERS_ID_PERSONA 
                AND GRUP_ID_CURSO = CURS_ID_CURSO 
                AND GRUP_ID_CALENDARIO = CALE_ID_CALENDARIO 
                AND GRUP_ID_GRUPO = $id;
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
    //? Ahora regresa el id de usuario del profesor y no su id de profesor.
    function buscarTodosGrupos()
    {
        $SQL_Bus_Cursos =
        "   
            SELECT DISTINCT GRUP_ID_GRUPO, PEGR_ID_USUARIO, PERS_NOMBRE, 
                    PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO,
                    GRUP_ID_CURSO, CURS_NOMBRE, GRUP_NUM_INSCRITOS,
                    GRUP_ID_PLATAFORMA, GRUP_URL, GRUP_ID_ACCESO, GRUP_CLAVE_ACCESO, 
                    GRUP_CUPO, GRUP_PUBLICADO, MOAP_NOMBRE GRUP_MODALIDAD, GRUP_TIPO,
                    GRUP_INICIO_INSC, GRUP_FIN_INSC, ESTA_NOMBRE GRUP_ESTADO
            FROM GRUPO, PERSONAL_GRUPO, USUARIO, PERSONA, CURSO, 
                CALENDARIO, MODALIDAD_APRENDIZAJE, ESTADO E
            WHERE USUA_ID_ROL = 2 
                AND GRUP_ID_GRUPO = PEGR_ID_GRUPO 
                AND PEGR_ID_USUARIO = USUA_ID_USUARIO
                AND usua_ID_PERSONA = PERS_ID_PERSONA 
                AND GRUP_ID_CURSO = CURS_ID_CURSO 
                AND GRUP_ID_CALENDARIO = CALE_ID_CALENDARIO 
                AND MOAP_ID_MODALIDAD = GRUP_ID_MODALIDAD 
                AND ESTA_ID_ESTADO = GRUP_ID_ESTADO
            ORDER BY GRUP_ID_GRUPO DESC;
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
        "   
            SELECT GRUP_ID_GRUPO, PEGR_ID_USUARIO, PERS_NOMBRE, 
                    PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO,
                    GRUP_ID_CURSO, CURS_NOMBRE, GRUP_NUM_INSCRITOS,
                    GRUP_ID_PLATAFORMA, GRUP_URL, GRUP_ID_ACCESO, 
                    GRUP_CLAVE_ACCESO, GRUP_CUPO, GRUP_PUBLICADO, 
                    MOAP_NOMBRE GRUP_MODALIDAD, GRUP_TIPO, GRUP_INICIO_INSC, 
                    GRUP_FIN_INSC, ESTA_NOMBRE GRUP_ESTADO
            FROM GRUPO, PERSONAL_GRUPO, USUARIO, PERSONA, CURSO, 
                CALENDARIO, MODALIDAD_APRENDIZAJE M, ESTADO E
            WHERE USUA_ID_ROL = 3 
                AND GRUP_ID_GRUPO = PEGR_ID_GRUPO 
                AND PEGR_ID_USUARIO = USUA_ID_USUARIO
                AND USUA_ID_PERSONA = PERS_ID_PERSONA 
                AND GRUP_ID_CURSO = CURS_ID_CURSO 
                AND GRUP_ID_CALENDARIO = CALE_ID_CALENDARIO 
                AND MOAP_ID_MODALIDAD = GRUP_ID_MODALIDAD 
                AND ESTA_ID_ESTADO = GRUP_ID_ESTADO
                AND USUA_ID_USUARIO = $idUsuario
            ORDER BY GRUP_ID_GRUPO DESC;
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
    //? Ahora regresa el id de usuario del profesor y no su id de profesor.
    function buscarGruposProfesores()
    {
        $SQL_Bus_Cursos =
        "
            SELECT GRUP_ID_GRUPO, PEGR_ID_USUARIO, PERS_NOMBRE, PERS_APELLIDO_PATERNO, 
                    PERS_APELLIDO_MATERNO, CURS_NOMBRE, CURS_TIPO, CURS_NIVEL, 
                    CURS_OBJETIVOS, GRUP_CUPO,  GRUP_NUM_INSCRITOS, GRUP_ID_MODALIDAD,
                    MOAP_NOMBRE, TO_CHAR(GRUP_INICIO_INSC, 'DD') DIAINI, 
                    TO_CHAR(TO_TIMESTAMP (TO_CHAR(GRUP_INICIO_INSC, 'MM')::TEXT, 'MM'), 'TMMON') MESINI, 
                    TO_CHAR(GRUP_FIN_INSC, 'DD') DIAFIN, 
                    TO_CHAR(TO_TIMESTAMP (TO_CHAR(GRUP_FIN_INSC, 'MM')::TEXT, 'MM'), 'TMMON') MESFIN
            FROM GRUPO G, PERSONAL_GRUPO P, USUARIO U,PERSONA PR, CURSO C, CALENDARIO CA, 
                MODALIDAD_APRENDIZAJE M, ESTADO E 
            WHERE GRUP_TIPO = 'PÚBLICO' 
                AND GRUP_ID_ESTADO = 3 
                AND GRUP_PUBLICADO = TRUE 
                AND USUA_ID_ROL = 2
                AND GRUP_ID_GRUPO = PEGR_ID_GRUPO 
                AND PEGR_ID_USUARIO = USUA_ID_USUARIO
                AND USUA_ID_PERSONA = PERS_ID_PERSONA 
                AND GRUP_ID_CURSO = CURS_ID_CURSO 
                AND GRUP_ID_CALENDARIO = CALE_ID_CALENDARIO 
                AND MOAP_ID_MODALIDAD = GRUP_ID_MODALIDAD 
                AND ESTA_ID_ESTADO = GRUP_ID_ESTADO
            ORDER BY GRUP_ID_GRUPO ASC;
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
        "   
            UPDATE GRUPO
            SET GRUP_PUBLICADO = $activo
            WHERE GRUP_ID_GRUPO = $id;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Curso);
        $bd->cerrarBD();
    }

    //Permite obtener los grupos a los cuales se ha inscrito un profesor y se encuentran en curso o están por comenzar (Pendientes)
    function gruposInscritosxProfesor($idProfesor)
    {
        $SQL_Act_Curso =
        " 
            SELECT GRUP_ID_GRUPO, GRUP_ID_MODALIDAD, MOAP_NOMBRE, CURS_NOMBRE, 
                    CALE_SEMESTRE, ESTA_NOMBRE, INSC_ACTIVO, CURS_NIVEL, CURS_TIPO
            FROM INSCRIPCION, GRUPO, CURSO, CALENDARIO, MODALIDAD_APRENDIZAJE, ESTADO
            WHERE INSC_ID_PROFESOR = $idProfesor
                AND INSC_ID_GRUPO = GRUP_ID_GRUPO 
                AND GRUP_ID_CURSO = CURS_ID_CURSO  
                AND GRUP_ID_CALENDARIO = CALE_ID_CALENDARIO 
                AND GRUP_ID_MODALIDAD = MOAP_ID_MODALIDAD
                AND ESTA_ID_ESTADO = GRUP_ID_ESTADO
                AND (GRUP_ID_ESTADO = 2 OR GRUP_ID_ESTADO = 3)
            ORDER BY INSC_ID_GRUPO ASC;
        ";
            
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Curso);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Permite obtener los grupos a los cuales se ha inscrito un profesor y ya han finalizado o fueron cancelados
    function gruposInscritosxProfesorHistoricos($idProfesor)
    {
        $SQL_Act_Curso =
        " 
            SELECT GRUP_ID_GRUPO, GRUP_ID_MODALIDAD, MOAP_NOMBRE, 
                    INSC_ID_CONSTANCIA, CURS_NOMBRE, CALE_SEMESTRE, 
                    ESTA_NOMBRE, INSC_ACTIVO, CURS_NIVEL, CURS_TIPO
            FROM INSCRIPCION I, GRUPO G, CURSO C, CALENDARIO CA, 
                MODALIDAD_APRENDIZAJE M, ESTADO E
            WHERE INSC_ID_PROFESOR = $idProfesor
                AND INSC_ID_GRUPO = GRUP_ID_GRUPO 
                AND GRUP_ID_CURSO = CURS_ID_CURSO  
                AND GRUP_ID_CALENDARIO = CALE_ID_CALENDARIO 
                AND GRUP_ID_MODALIDAD = MOAP_ID_MODALIDAD
                AND ESTA_ID_ESTADO = GRUP_ID_ESTADO
                AND (GRUP_ID_ESTADO = 1 OR GRUP_ID_ESTADO = 4)
            ORDER BY INSC_ID_GRUPO ASC;
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
            SELECT INSC_ID_PROFESOR, INSC_ID_GRUPO
            FROM INSCRIPCION, GRUPO, CURSO, CALENDARIO
            WHERE INSC_ID_PROFESOR = $idProfesor
                AND INSC_ID_GRUPO = GRUP_ID_GRUPO 
                AND GRUP_ID_CURSO = CURS_ID_CURSO
                AND GRUP_ID_CALENDARIO = CALE_ID_CALENDARIO 
                AND GRUP_PUBLICADO = TRUE
                AND INSC_ACTIVO = TRUE
            ORDER BY INSC_ID_GRUPO ASC;
        ";
            
        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Curso);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }
        
    //Busca los datos de un grupo autogestivo dado el id del grupo
    function buscarDatosAutogestivo($id)
    {
        $SQL_Bus_Grupo =
        "  
            SELECT GRUP_URL
            FROM GRUPO 
            WHERE GRUP_ID_MODALIDAD = 3  
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

    //? Verifica la modalidad mediante el id
    function buscarDatosEnLinea($id)
    {
        $SQL_Bus_Grupo =
        "  
            SELECT PLAT_NOMBRE, GRUP_URL, GRUP_ID_ACCESO, GRUP_CLAVE_ACCESO
            FROM GRUPO, PLATAFORMA
            WHERE GRUP_ID_PLATAFORMA=PLAT_ID_PLATAFORMA 
                AND GRUP_ID_MODALIDAD = 2  
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

    //?Regresa el id de la modalidad, pero verifica que sea el correspondiente a presencial.
    function buscarDatosPresencial($id)
    {
        $SQL_Bus_Grupo =
        "   
            SELECT GRUP_ID_MODALIDAD, SALO_NOMBRE, EDIF_NOMBRE 
            FROM GRUPO G, SALON S, EDIFICIO E
            WHERE GRUP_ID_SALON=SALO_ID_SALON 
                AND SALO_ID_EDIFICIO = EDIF_ID_EDIFICIO 
                AND GRUP_ID_MODALIDAD = 1 AND G.GRUP_ID_GRUPO=$id;
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
    //?No debe utilizarse esta función
    function eliminarGrupo($grupo)
    {
        $SQL_Eli_Grupo =
        " 
            DELETE FROM GRUPO
            WHERE GRUP_ID_GRUPO = $grupo;
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
        $SQL_Bus_Grupo_Seq =
        "
            SELECT last_value 
            FROM grupo_grup_id_grupo_seq;
        ";
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
    function buscarSoloGrupo($id)
    {
        $SQL_Bus_SoloGrupo =
        "
            SELECT GRUP_ID_GRUPO, GRUP_ID_CURSO, GRUP_ID_SALON, GRUP_ID_PLATAFORMA, 
                    GRUP_ID_CALENDARIO, GRUP_URL, GRUP_ID_ACCESO, GRUP_CLAVE_ACCESO,  
                    GRUP_CUPO, GRUP_ID_ESTADO, GRUP_PUBLICADO, GRUP_ID_MODALIDAD, 
                    GRUP_TIPO, GRUP_INICIO_INSC, GRUP_FIN_INSC, GRUP_NUM_INSCRITOS,
                    PEGR_ID_USUARIO USR_INSTRUCTOR, (SELECT PEGR_ID_USUARIO
                                                    FROM PERSONAL_GRUPO, USUARIO
                                                    WHERE PEGR_ID_GRUPO = $id AND USUA_ID_ROL = 3 
                                                        AND PEGR_ID_USUARIO = USUA_ID_USUARIO) AS USR_MODERADOR
            FROM GRUPO, PERSONAL_GRUPO, USUARIO
            WHERE GRUP_ID_GRUPO = $id 
                AND USUA_ID_ROL = 2
                AND GRUP_ID_GRUPO = PEGR_ID_GRUPO 
                AND PEGR_ID_USUARIO = USUA_ID_USUARIO;
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
        "
            SELECT GRUP_ID_GRUPO, GRUP_ID_CURSO, CURS_NOMBRE, CURS_TIPO, 
                    CURS_NIVEL, CURS_OBJETIVOS, CURS_REQ_TECNICOS, CURS_CONOCIMIENTOS, 
                    GRUP_ID_MODALIDAD, MOAP_NOMBRE, ESTA_NOMBRE, PERS_NOMBRE, 
                    PERS_APELLIDO_PATERNO, PERS_APELLIDO_MATERNO, GRUP_CUPO, 
                    GRUP_NUM_INSCRITOS, GRUP_INICIO_INSC, GRUP_FIN_INSC, GRUP_PUBLICADO, 
                    GRUP_TIPO, GRUP_ID_PLATAFORMA, GRUP_ID_ACCESO, 
                    GRUP_CLAVE_ACCESO, GRUP_ID_CALENDARIO, GRUP_URL, GRUP_ID_ACCESO, 
                    GRUP_CLAVE_ACCESO, GRUP_CUPO, GRUP_NUM_INSCRITOS,
                    
                    (SELECT PLAT_NOMBRE
                    FROM GRUPO, PLATAFORMA
                    WHERE GRUP_ID_PLATAFORMA = PLAT_ID_PLATAFORMA
                        AND GRUP_ID_GRUPO = $id) AS PLAT_NOMBRE,
                
                    (SELECT (SALO_NOMBRE || ' EDIFICIO: ' || EDIF_NOMBRE) AS SALON
                    FROM SALON S, GRUPO G, EDIFICIO E
                    WHERE SALO_ID_SALON = GRUP_ID_SALON
                            AND GRUP_ID_GRUPO = $id
                            AND SALO_ID_EDIFICIO = EDIF_ID_EDIFICIO) AS SALO_NOMBRE,

                    (SELECT COUNT (SESI_ID_SESION)
                    FROM SESION 
                    WHERE GRUP_ID_GRUPO = $id
                    GROUP BY GRUP_ID_GRUPO) AS NUM_SESIONES,

                    (SELECT MOAP_NOMBRE
                    FROM MODALIDAD_APRENDIZAJE, GRUPO
                    WHERE MOAP_ID_MODALIDAD = GRUP_ID_MODALIDAD
                            AND GRUP_ID_GRUPO = $id) AS MOAP_NOMBRE,

                    (SELECT (PERS_NOMBRE || ' ' || PERS_APELLIDO_PATERNO || ' ' || PERS_APELLIDO_MATERNO) AS MODERADOR
                    FROM PERSONAL_GRUPO, USUARIO, PERSONA 
                    WHERE USUA_ID_USUARIO = PEGR_ID_USUARIO AND PERS_ID_PERSONA = USUA_ID_PERSONA 
                        AND USUA_ID_ROL = 3 AND PEGR_ID_GRUPO = $id) AS MODERADOR
                    
            FROM GRUPO G, CURSO C, MODALIDAD_APRENDIZAJE M, ESTADO E, 
                PERSONAL_GRUPO PG, USUARIO U, PERSONA P
            WHERE   GRUP_ID_CURSO = CURS_ID_CURSO 
                AND GRUP_ID_MODALIDAD = MOAP_ID_MODALIDAD
                AND GRUP_ID_ESTADO = ESTA_ID_ESTADO
                AND GRUP_ID_GRUPO = PEGR_ID_GRUPO
                AND PEGR_ID_USUARIO = USUA_ID_USUARIO
                AND USUA_ID_PERSONA = PERS_ID_PERSONA
                AND USUA_ID_ROL = 2
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
    function idUsuarioModeradorGrupo($id)
    {
        $SQL_Bus_Grupo =
        "
            SELECT PEGR_ID_USUARIO
            FROM PERSONAL_GRUPO, USUARIO
            WHERE PEGR_ID_USUARIO = USUA_ID_USUARIO 
                AND USUA_ID_ROL = 3
                AND PEGR_ID_GRUPO = $id
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Grupo);
        $obj_Grupo = $transaccion_1->traerObjeto(0);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Busca los grupos que imparte un profesor y se encuentran activos o a punto de comenzar
    //? Se cambia la logica ahora el id hace referencia al id de usuario del profesor
    function buscarGruposImpartidosxInstructor($id)
    {
        $SQL_Bus_Grupos =
        "
            SELECT GRUP_ID_GRUPO, GRUP_PUBLICADO, MOAP_ID_MODALIDAD, MOAP_NOMBRE,
                    CURS_NOMBRE, CALE_SEMESTRE, GRUP_NUM_INSCRITOS, ESTA_NOMBRE
            FROM PERSONAL_GRUPO P, GRUPO G, CURSO C, MODALIDAD_APRENDIZAJE M, 
                CALENDARIO CA, ESTADO E
            WHERE PEGR_ID_USUARIO = $id
                AND GRUP_ID_CURSO = CURS_ID_CURSO 
                AND GRUP_ID_GRUPO = PEGR_ID_GRUPO
                AND GRUP_ID_MODALIDAD = MOAP_ID_MODALIDAD
                AND GRUP_ID_CALENDARIO = CALE_ID_CALENDARIO
                AND GRUP_ID_ESTADO = ESTA_ID_ESTADO
                AND (GRUP_ID_ESTADO = 2 OR GRUP_ID_ESTADO = 3)
            ORDER BY GRUP_ID_GRUPO ASC;
        ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Bus_Grupos);
            $bd->cerrarBD();
            return ($transaccion_1->traerRegistros());
    }

    //Busca los grupos que imparte un profesor y se encuentran activos o a punto de comenzar
    function buscarGruposImpartidosxInstructorHistoricos($id)
    {
        $SQL_Bus_Grupos =
        "
            SELECT GRUP_ID_GRUPO, GRUP_PUBLICADO, MOAP_ID_MODALIDAD, 
                    MOAP_NOMBRE, CURS_NOMBRE, CALE_SEMESTRE, 
                    GRUP_NUM_INSCRITOS, ESTA_NOMBRE, PEGR_ID_CONSTANCIA
            FROM PERSONAL_GRUPO, GRUPO, CURSO, MODALIDAD_APRENDIZAJE, 
                CALENDARIO, ESTADO
            WHERE PEGR_ID_USUARIO = $id
                AND GRUP_ID_CURSO = CURS_ID_CURSO 
                AND GRUP_ID_GRUPO = PEGR_ID_GRUPO
                AND GRUP_ID_MODALIDAD = MOAP_ID_MODALIDAD
                AND GRUP_ID_CALENDARIO = CALE_ID_CALENDARIO
                AND GRUP_ID_ESTADO = ESTA_ID_ESTADO
                AND (GRUP_ID_ESTADO = 1 OR GRUP_ID_ESTADO = 4)
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
    function buscarInscripcionesxGrupo($ID)
    {
        $SQL_Bus_Cursos =
        "
            SELECT INSC_ID_INSCRIPCION, PERS_APELLIDO_PATERNO, 
                    PERS_APELLIDO_MATERNO, PERS_NOMBRE, PERS_CORREO
            FROM INSCRIPCION, PROFESOR, PERSONA
            WHERE INSC_ID_PROFESOR = PROF_ID_PROFESOR 
                AND PROF_ID_PERSONA = PERS_ID_PERSONA 
                AND INSC_ID_GRUPO = $ID 
                AND INSC_ACTIVO = TRUE
            ORDER BY PERS_APELLIDO_PATERNO ASC;
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Cursos);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Permite consultar el nombre de un curso por el ID del grupo
    /*SELECT curs_nombre, curs_nivel, curs_tipo, mode_id_moderador, prof_id_profesor, plat_id_plataforma, salo_id_salon, grup_modalidad
                FROM Curso C, Grupo G
            WHERE C.curs_id_cursos=G.curs_id_cursos AND grup_id_grupo = $ID;*/
    function buscarNombreCursoxGrupo($ID)
    {
        $SQL_Bus_Curso =
        "   
            SELECT CURS_NOMBRE, CURS_NIVEL, GRUP_ID_ESTADO, CURS_TIPO, 
                    PEGR_ID_USUARIO, GRUP_ID_PLATAFORMA, GRUP_ID_SALON, 
                    MOAP_ID_MODALIDAD, MOAP_NOMBRE, 
                    (SELECT PEGR_ID_USUARIO
                    FROM PERSONAL_GRUPO, USUARIO
                    WHERE PEGR_ID_USUARIO = USUA_ID_USUARIO 
                        AND USUA_ID_ROL = 3 
                        AND PEGR_ID_GRUPO = $ID) AS ID_MODERADOR
            FROM CURSO, GRUPO, PERSONAL_GRUPO, USUARIO, MODALIDAD_APRENDIZAJE
            WHERE CURS_ID_CURSO=GRUP_ID_CURSO 
                AND GRUP_ID_GRUPO = PEGR_ID_GRUPO
                AND PEGR_ID_USUARIO = USUA_ID_USUARIO 
                AND GRUP_ID_MODALIDAD = MOAP_ID_MODALIDAD
                AND USUA_ID_ROL = 2 
                AND GRUP_ID_GRUPO = $ID;
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
