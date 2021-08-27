<?php 

// Clases
include('../clases/BD.php');
include('../clases/Curso.php');
include('../clases/Grupo.php');
include('../clases/Sesion.php');
include('../clases/Actualizacion.php');
include('../clases/Constancias.php');

// Objetos
$obj_Actualizacion = new Actualizacion();
$obj_Grupo = new Grupo();
$obj_Constancia = new Constancias();

//Arreglos
$arr_GruposPendientes = $obj_Actualizacion->buscarCursosPendientes();
$arr_GruposEnCurso = $obj_Actualizacion->buscarCursosEnCurso();
$arr_GruposFinalizados = $obj_Actualizacion->buscarCursosFinalizados();
$arr_GruposCancelados = $obj_Actualizacion->buscarCursosCancelados();
$arr_GruposCancelarPresencial = $obj_Actualizacion->buscarCursosPorCancelarPresencial();
$arr_GruposCancelarEnLinea = $obj_Actualizacion->buscarCursosPorCancelarEnLinea();
$arr_GruposCancelarAutogestivos = $obj_Actualizacion->buscarCursosPorCancelarAutogestivos();
$arr_ConstanciasVencidas = $obj_Actualizacion->buscarConstanciasVencidas();


//! Quitarle el numero a origen para que vuelva a funcionar
if($_POST['origen0'] == 'grupos') {
    //? Los grupos Pendientes que ya inició su sesión principal se deben convertir en En curso
    foreach ($arr_GruposPendientes as $iCont => $grupo) {
        $obj_Grupo->cambiarEstadoGrupo($grupo['grup_id_grupo'], 2);
    }

    //? Los grupos En curso cuya sesión final ya ocurrio se deben convertir en Finalizado
    foreach ($arr_GruposEnCurso as $iCont => $grupo) {
        $obj_Grupo->cambiarEstadoGrupo($grupo['grup_id_grupo'], 4);
    }
    
    //? Los grupos que no lleguen al cupo minimo se deben de cancelar
    foreach ($arr_GruposCancelarPresencial as $iCont => $grupo) {
        $obj_Grupo->cambiarEstadoGrupo($grupo['grup_id_grupo'], 1);
    }
    foreach ($arr_GruposCancelarEnLinea as $iCont => $grupo) {
        $obj_Grupo->cambiarEstadoGrupo($grupo['grup_id_grupo'], 1);
    }
    foreach ($arr_GruposCancelarAutogestivos as $iCont => $grupo) {
        $obj_Grupo->cambiarEstadoGrupo($grupo['grup_id_grupo'], 1);
    }
    
    //? Los grupos finalizados no deben de estar publicados
    foreach ($arr_GruposFinalizados as $iCont => $grupo) {
        $obj_Grupo->cambiarEstatus($grupo['grup_id_grupo'], "FALSE");
    }
    //? Los grupos cancelados no deben de estar publicados
    foreach ($arr_GruposCancelados as $iCont => $grupo) {
        $obj_Grupo->cambiarEstatus($grupo['grup_id_grupo'], "FALSE");
    }

    exit("1");

} elseif ($_POST['origen'] == 'constancias') {
    //TODO: Falta consultar como se llevara a cabo la baja de constancias después del año 
    foreach ($arr_ConstanciasVencidas as $iCont => $constancia) {
        $obj_Constancia->desactivarConstancia($constancia['cons_id_constancias']);
    }
} else  {
    exit('2');
}
    
?>