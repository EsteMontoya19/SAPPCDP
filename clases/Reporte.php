<?php
//? Clase actualizada a las reglas de los prefijos 04/10/21
namespace clases;

use BD;
use Transaccion;

class Reporte
{
    //Definition: Esta consulta muestra los registros de todos los profesores que han tomado un curso.
    public function buscarCursosTomados($fechaInicio, $fechaFin)
    {
        $SQL_Asistencia_Sesion =
        "SELECT
            g.grup_id_grupo,
            t.prof_id_profesor,
            (pers_apellido_paterno || ' ' || pers_apellido_materno || ' ' || pers_nombre) AS nombre,
            nomb_descripcion,
            pers_sexo,
            curs_nombre
        FROM profesor t, persona p, nombramiento n, inscripcion i, grupo g, curso c
        WHERE
            t.prof_id_persona = p.pers_id_persona
        AND t.prof_id_nombramiento = n.nomb_id_nombramiento
        AND t.prof_id_profesor = i.insc_id_profesor
        AND i.insc_id_grupo = g.grup_id_grupo
        AND g.grup_id_curso = c.curs_id_curso
        AND g.grup_id_grupo
        IN (SELECT grup_id_grupo FROM sesion
        GROUP BY grup_id_grupo
        HAVING MIN(sesi_fecha) >= '$fechaInicio' AND MAX(sesi_fecha) <= '$fechaFin')
        ORDER BY nombre";

        $bd = new  BD();
        $bd-> abrirBD();
        $transaccion = new Transaccion($bd->conexion);
        $transaccion -> enviarQuery($SQL_Asistencia_Sesion);
        $bd->cerrarBD();
        return ($transaccion ->traerRegistros());
    }

    //Definition: Busca las fechas de inicio y de fin en los cursos que se muestren en buscarCursosTomados()
    public function buscarFechaDeCursos($idGrupo)
    {
        $SQL_Asistencia_Sesion =
        "SELECT
            to_char(sesi_fecha, 'DD') dia,
            to_char(sesi_fecha, 'MM') mes,
            to_char(sesi_fecha, 'YYYY') anio
        FROM sesion
        WHERE sesi_id_sesion IN ((
            SELECT MAX(sesi_id_sesion) sesi_id_sesion
            FROM sesion
            WHERE sesi_id_grupo = $idGrupo),
            (SELECT MIN(sesi_id_sesion) sesi_id_sesion
            FROM sesion
            WHERE sesi_id_grupo = $idGrupo))
        ORDER BY sesi_id_sesion;";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion = new Transaccion($bd->conexion);
        $transaccion -> enviarQuery($SQL_Asistencia_Sesion);
        $bd -> cerrarBD();
        return ($transaccion -> traerRegistros());
    }

    //Definition: Busaca las modalidades que imparte un profesor que se muestre en buscarCursosTomados()
    public function buscarModalidadesImpartidasPorProfesor($idProfesor)
    {
        $SQL_Asistencia_Sesion =
        "SELECT moda_nombre
        FROM profesor_modalidad pm , modalidad m
        WHERE pm.prmo_id_modalidad = m.moda_id_modalidad
        AND prmo_id_profesor = $idProfesor
        ORDER By moda_nombre;";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion = new Transaccion($bd->conexion);
        $transaccion -> enviarQuery($SQL_Asistencia_Sesion);
        $bd -> cerrarBD();
        return ($transaccion -> traerRegistros());
    }
}
