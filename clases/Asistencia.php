<?php
class Asistencia
{
    //? Clase actualizada a las reglas de los prefijos 04/10/21

    //?Agregar sesión
    function agregarAsistencia($idSesion, $inscripcion, $asistio)
    {
        if (!isset($asistio) || $asistio == "") {
            $asistio = "FALSE";
        }
            
        $SQL_Asistencia_Sesion =
        "INSERT INTO Asistencia (asis_id_sesion, asis_id_inscripcion, asis_presente)
			 VALUES ($idSesion, $inscripcion, $asistio);
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Asistencia_Sesion);
        $bd->cerrarBD();
    }

    //? Elimina las asistencias para poder actualizarlas
    function eliminarAsistencia($idGrupo)
    {
        $SQL_Asistencia_Sesion =
        "DELETE FROM Asistencia
			WHERE asis_id_sesion IN (
						SELECT sesi_id_sesion
						FROM Grupo G, Sesion S
						WHERE G.grup_id_grupo = S.sesi_id_grupo AND 
						G.grup_id_grupo = $idGrupo);
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Asistencia_Sesion);
        $bd->cerrarBD();
    }
    //? Busca asistencias brindandole el número de sesion y de inscripcion¿
    function buscarAsistenciaSesion($idSesion, $inscripcion)
    {
        $SQL_Asistencia_Sesion =
        "SELECT *
        FROM Asistencia
        WHERE asis_id_sesion = $idSesion AND asis_id_inscripcion = $inscripcion
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Asistencia_Sesion);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    function buscarAcreedorConstancia($idGrupo)
    {
        $SQL_Asistencia_Sesion =
        "SELECT DISTINCT ( P.pers_apellido_paterno || ' ' || P.pers_apellido_materno || ' ' || P.pers_nombre) AS nombre, Prof.prof_id_profesor,P.pers_id_persona, I.insc_id_inscripcion 
		FROM Persona P, Profesor Prof, Inscripcion I, Asistencia A
		WHERE P.pers_id_persona = Prof.prof_id_persona
		AND I. insc_id_profesor = Prof.prof_id_profesor
		AND I.insc_id_inscripcion = A.asis_id_inscripcion
		AND I.insc_id_grupo = $idGrupo
		AND P.pers_id_persona NOT IN (SELECT P.pers_id_persona
								FROM Persona P, Profesor Prof , Inscripcion I, Asistencia A, Sesion S
								WHERE P.pers_id_persona = Prof.prof_id_persona
								AND I.insc_id_profesor = Prof.prof_id_profesor
								AND I.insc_id_inscripcion = A.asis_id_inscripcion
								AND S.sesi_id_sesion = A.asis_id_sesion
								AND I.insc_activo = TRUE
								AND I.insc_id_grupo = $idGrupo
								AND A.asis_presente = FALSE
								GROUP BY P.pers_id_persona, P.pers_nombre, P.pers_apellido_paterno, P.pers_apellido_materno, 
										A.asis_presente);
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Asistencia_Sesion);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }





    //Buscar los registros de asistencia por el id el grupo
    function buscarAsistenciasGrupo($id_grupo)
    {
        $SQL_Bus_Asistencia =
        "SELECT A.asis_id_sesion, A.asis_id_inscripcion, A.asis_presente, I.insc_id_profesor, S.sesi_id_grupo, S.sesi_fecha,
					S.sesi_hora_inicio, S.sesi_hora_fin
			FROM Asistencia A, Sesion S, Inscripcion I
			WHERE S.sesi_id_sesion = A.asis_id_sesion
			AND A.asis_id_inscripcion = I.insc_id_inscripcion
			AND S.sesi_id_grupo = $id_grupo
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Asistencia);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }

    //Buscar los registros de asistencia por el id el grupo y el id de inscripción
    function buscarAsistenciasInscripcion($id_grupo, $id_inscripcion)
    {
        $SQL_Bus_Asistencia =
        "SELECT I.INSC_ID_INSCRIPCION, ASIS_ID_SESION, ASIS_PRESENTE
        FROM ASISTENCIA A, INSCRIPCION I
        WHERE A.ASIS_ID_INSCRIPCION = I.INSC_ID_INSCRIPCION AND INSC_ID_GRUPO = $id_grupo AND I.INSC_ID_INSCRIPCION = $id_inscripcion            
        ORDER BY ASIS_ID_SESION
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Asistencia);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }
}
