<?php
  class Ponente
  {
    function agregarPonente($grupo, $ponente, $cargo, $semblanza)
    {
        $SQL_Ins_Ponente = 
        "   INSERT INTO ponente(pone_id_grup, pone_nombre, pone_cargo, pone_descripcion)
            VALUES ($grupo, '$ponente', '$cargo', '$semblanza');
        ";

        $bd = new BD();
        $bd->abrirBD();
        $transaccion_1 = new Transaccion($bd->conexion);
        $transaccion_1->enviarQuery($SQL_Ins_Ponente);
        $bd->cerrarBD();
    }

    function actualizarPonente($id, $ponente, $cargo, $semblanza)
    {
      $SQL_Actua_Ponente =
      " UPDATE ponente
        SET pone_nombre = '$ponente', pone_cargo = '$cargo', pone_descripcion = '$semblanza'
        WHERE pone_id_pone = $id;
      ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Actua_Ponente);
      $bd->cerrarBD();
    }

    function buscarTodosPonentes($id)
    {
      $SQL_Bus_Ponentes =
      " SELECT pone_id_pone, pone_id_grup, pone_nombre, pone_cargo, pone_descripcion
        FROM ponente
        WHERE pone_id_grup = $id;
      ";

      $bd = new BD();
      $bd->abrirBD();
      $transaccion_1 = new Transaccion($bd->conexion);
      $transaccion_1->enviarQuery($SQL_Bus_Ponentes);
      $bd->cerrarBD();
      return ($transaccion_1->traerRegistros());
    }

    function eliminarPonente($ponente)
        {
            $SQL_Eli_Ponente = 
            " DELETE FROM ponente
              WHERE pone_id_pone = $ponente;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Eli_Ponente);
            $bd->cerrarBD();
        }

        function eliminarTodosPonentes($grupo)
        {
            $SQL_Eli_Horarios = 
            " DELETE FROM ponente
              WHERE pone_id_grup = $grupo;
            ";

            $bd = new BD();
            $bd->abrirBD();
            $transaccion_1 = new Transaccion($bd->conexion);
            $transaccion_1->enviarQuery($SQL_Eli_Horarios);
            $bd->cerrarBD();
        }
  }
?>