<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//? Clase actualizada a las reglas de los prefijos 04/10/21

class BD
{
    public $servidor;
    public $usuario;
    public $password;
    public $puerto;
    public $bd;
    public $conexion;
    public $cadena_conexion;

    function __construct($strBD = "")
    {
        //    require('../include/Configuracion.php');

        $this->servidor = "localhost";
        $this->usuario  = "postgres";
        $this->password = "postgres";
        $this->puerto   = "5432";
        $this->bd       = ($strBD != "") ? $strBD : "SAPPCDP2";
        $this->cadena_conexion = "host=". $this->servidor ." port=". $this->puerto ." dbname=". $this->bd ." user=". $this->usuario ." password=". $this->password;
    }

    function abrirBD()
    {
        if ($this->conexion = pg_connect($this->cadena_conexion)) {
            return $this->conexion;
        } else {
            return false;
        }
    }

    function cerrarBD()
    {
        pg_close($this->conexion);
    }
}

class Transaccion
{
    public $conexion;
    public $query;
    public $error;
    public $oid;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    /**************************************************************
      * Método que ejecuta la instrucción DML
      **************************************************************/
    public function enviarQuery($sql)
    {
        //require('../../include/Configuracion.php');
        $this->query = pg_query($this->conexion, $sql);
        //}
        if ($this->query) {
            $this->oid = pg_last_oid($this->query); // Lalo: ¿Qué es oid?
            return $this->query;
        } else {
            return false;
        }
    }


    /**************************************************************
       * Método que envía una serie de querys en forma simultanea,
       * tipo transaccion en una base de datos.
      **************************************************************/
    public function enviarQueryAsincrono($sqls, $numsqls) // Lalo: ¿Qué es un Query Asincrono?
    {
        pg_set_error_verbosity($this->conexion, PGSQL_ERRORS_VERBOSE);
        pg_send_query($this->conexion, $sqls);
        for ($i = 0; $i <= $numsqls; $i++) {
            $this->query = pg_get_result($this->conexion);
            $this->error = pg_result_error($this->query);
            if ($this->error != "") {
                return false;
            }
        }
    }

    public function traerRegistros()
    {
        if (pg_num_rows($this->query) == 0) {
            return null;
        } else {
            return pg_fetch_all($this->query);
        }
    }


    /**************************************************************
       * Método que retorna el array con los registros
       * obtenidos en forma de objeto
        **************************************************************/
    public function traerObjeto($posicion)
    {
        if (pg_num_rows($this->query) == 0) {
            return null;
        } else {
            return pg_fetch_object($this->query, $posicion);
        }
    }

    /**************************************************************
       * Método que realiza retorna el numero de registros de la
       * consulta
       *************************************************************/

    public function contarNumeroRegistros()
    {
        return pg_num_rows($this->query);
    }
}
