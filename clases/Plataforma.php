<?php
//? Clase actualizada a las reglas de los prefijos 05/10/21
class Plataforma
{
    //Agregar Plataforma
    function agregarPlataforma($Nombre, $Activo)
    {
        $SQL_Ins_Plataforma =
        "
                INSERT INTO Plataforma(plat_nombre, plat_activo)
                VALUES ('$Nombre', '$Activo');
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Ins_Plataforma);
        $bd->cerrarBD();
    }

    //Actulizar Plataforma
    function actulizarPlataforma($Nombre, $id)
    {
        $SQL_Act_Plataforma =
        "
                UPDATE Plataforma
                SET plat_nombre = '$Nombre'
                WHERE plat_id_plataforma = $id;
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Plataforma);
        $bd->cerrarBD();
    }

    //Cambiar Estado Plataforma
    function cambiarEstatusPlataforma($Activo, $id)
    {
        $SQL_Act_Plataforma =
        "   
                UPDATE Plataforma
                SET plat_activo = '$Activo'
                WHERE plat_id_plataforma = $id;
            ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Act_Plataforma);
        $bd->cerrarBD();
    }

    //Buscar Plataformas por ID
    function buscarPlataforma($id)
    {
        $SQL_Bus_Plataforma =
        "	
                SELECT plat_nombre 
                FROM Plataforma
				WHERE plat_id_plataforma = $id;
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Plataforma);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Buscar Plataformas por Nombre
    function buscarPlataformaNombre($nombre)
    {
        $SQL_Bus_Plataforma =
        "	
				SELECT COUNT(plat_id_plataforma) as numero
				FROM Plataforma
				WHERE LOWER(plat_nombre) = LOWER('$nombre');
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Plataforma);
        $bd->cerrarBD();
        return ($transaccion_1->traerObjeto(0));
    }

    //Buscar Todas las Plataformas
    function buscarTodasPlataformas()
    {
        $SQL_Bus_Plataformas =
        "	
                SELECT plat_id_plataforma, plat_nombre, plat_activo 
                FROM Plataforma;
			";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Bus_Plataformas);
        $bd->cerrarBD();
        return ($transaccion_1->traerRegistros());
    }
}
