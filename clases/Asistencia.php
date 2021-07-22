<?php
class Asistencia
{
    //Agregar sesión
    function agregarAsistencia($idSesion, $inscripcion, $asistio)
    {
        if (!isset($asistio) || $asistio == "") {
            $asistio = "FALSE";
        }
            
        $SQL_Asistencia_Sesion =
        "INSERT INTO Asistencia (sesi_id_sesiones, insc_id_inscripcion, asis_presente)
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
			WHERE sesi_id_sesiones IN (
						SELECT sesi_id_sesiones
						FROM Grupo G, Sesion S
						WHERE G.grup_id_grupo = S.grup_id_grupo AND 
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
			WHERE sesi_id_sesiones = $idSesion AND insc_id_inscripcion = $inscripcion
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Asistencia_Sesion);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    function buscarAsistenciaSesionLista($idSesion, $inscripcion)
    {
        $SQL_Asistencia_Sesion =
        "SELECT * FROM Asistencia
		WHERE sesi_id_sesiones = 1
		AND insc_id_inscripcion = 5
		AND asis_presente = true
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Asistencia_Sesion);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }





    //Buscar los registros de asistencia por el id el grupo
    function buscarAsistenciasGrupo($id_grupo)
    {
        $SQL_Bus_Asistencia =
        "SELECT A.sesi_id_sesiones, A.insc_id_inscripcion, A.asis_presente, I.prof_id_profesor, S.grup_id_grupo, S.sesi_fecha,
					S.sesi_hora_inicio, S.sesi_hora_fin
			FROM Asistencia A, Sesion S, Inscripcion I
			WHERE S.sesi_id_sesiones = A.sesi_id_sesiones
			AND A.insc_id_inscripcion = I.insc_id_inscripcion
			AND S.grup_id_grupo = $id_grupo
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Asistencia);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }
}
