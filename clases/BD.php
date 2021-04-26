<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	class BD
	{
		public $servidor;
		public $usuario;
		public $password;
		public $puerto;
		public $bd;
		public $conexion;
		public $cadena_conexion;
		public $imagen;

		function __construct($strBD = "")
		{
			//    require('../include/Configuracion.php');

			$this->servidor = "localhost";
			$this->usuario  = "postgres";
			$this->password = "postgres";
			$this->puerto   = "5432";
			$this->bd       = ($strBD != "") ? $strBD : "SAPPCDP";
			$this->cadena_conexion = "host=". $this->servidor ." port=". $this->puerto ." dbname=". $this->bd ." user=". $this->usuario ." password=". $this->password;
		}

		function abrirBD()
		{
			if ($this->conexion = pg_connect($this->cadena_conexion))
			{
				return $this->conexion;
			}
			else
			{
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
		public $queryasincrono;
		public $error;
		public $oid;
		public $imagen;

		function __construct($conexion)
		{
			$this->conexion = $conexion;
		}

	  /**************************************************************
	  * Metodo que ejecuta la instruccion DML
	  **************************************************************/
		function enviarQuery($sql)
		{
			//require('../../include/Configuracion.php');
			$this->query = pg_query($this->conexion, $sql);
			//if ($_conf_show_sql == "on") {
				//$handle = fopen($rutainstalacion . "logs/querys.log", "a+");
				//$edoquery1 = pg_result_status($this->query, PGSQL_STATUS_STRING);
				//$edoquery2 = pg_result_status($this->query, PGSQL_STATUS_LONG);
				//$fecsis = date("d M Y, H:i:s");
				//fwrite($handle, $fecsis . " \n" . $sql . "\n" . $edoquery1 . " " . $edoquery2 . " " . $_arr_error_pgsql[$edoquery2] . "\n\n");
				//fclose($handle);
			//}
			if ($this->query)
			{
				$this->oid = pg_last_oid($this->query); // Lalo: ¿Qué es oid?
				return $this->query;
			}
			else
			{
				return false;
			}
		}


	  /**************************************************************
	   * Metodo que envia una serie de querys en forma simultanea,
	   * tipo transaccion en una base de datos.
	  **************************************************************/
		function enviarQueryAsincrono($sqls, $numsqls) // Lalo: ¿Qué es un Query Asincrono?
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
	  /**************************************************************
	   * Metodo que sirve para hacer un commit a un query asincrono.
	   * Y el resultado del primer o n query que se envio.
	  **************************************************************/
		function traerResultadoQueryAsincrono()
		{
			$this->query = pg_get_result($this->conexion);
		}
	  /**************************************************************
	   * Metodo que sirve para mostrar el error generado por un query.
	   * @attribute error se guarda el error que mando el query.
	  **************************************************************/
		function traerErrorQueryAsincrono()
		{
			return  $this->error;
		}

	  /**************************************************************
	   * Metodo que realiza retorna el array con los registros
	   * obtenidos
	  **************************************************************/
		function traerRegistro($i)
		{
			return pg_fetch_array($this->query,$i);
		}

		function traerRegistros()
		{
			return pg_fetch_all($this->query);
		}


	  /**************************************************************
	   * Metodo que retorna el array con los registros
	   * obtenidos en forma de objeto
		**************************************************************/
		function traerObjeto($i)
		{
			return pg_fetch_object($this->query,$i);
		}

	  /**************************************************************
	   * Metodo que realiza retorna el nÃºmero de registros afectados
	   **************************************************************/
		function traerRegistrosAfectados()
		{
			return pg_affected_rows($this->query);
		}

	  /**************************************************************
	   * Metodo que realiza retorna el numero de registros de la
	   * consulta
	   *************************************************************/

		function contarNumeroRegistros()
		{
			return pg_num_rows($this->query);
		}

	  /**************************************************************
	   * Metodo que realiza utiliza el mysql_result() para obtener un
	   * resultado VERIFICAR?
	   **************************************************************/
		function traerCampo($rs, $numero, $campo)
		{
			return pg_fetch_result($rs, $numero, $campo);
		}

	  /**************************************************************
	   * Metodo que permite obtener el resultado de query()
	   **************************************************************/
		function traerQuery()
		{
			return $this->query;
		}
	}
?>
